const token = localStorage.getItem('token');
if (token) {
    axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;
}

let currentPage = 1;

async function loadTasks(page = 1) {
    const status = document.getElementById('statusFilter')?.value;
    const overdue = document.getElementById('overdueFilter')?.checked;

    const params = new URLSearchParams();
    if (status) params.append('status', status);
    if (overdue) params.append('overdue', '1');
    params.append('page', page);

    try {
        const response = await axios.get(`/api/tasks?${params}`);
        renderTasks(response.data.data);
        renderPagination(response.data);
        currentPage = page;
    } catch (error) {
        console.error('Error loading tasks:', error);
    }
}

function renderTasks(tasks) {
    const container = document.getElementById('tasksList');

    if (tasks.length === 0) {
        container.innerHTML = '<p class="text-gray-500 text-center py-8">No tasks found</p>';
        return;
    }

    container.innerHTML = tasks.map(task => `
        <div class="bg-white p-4 rounded-lg shadow">
            <div class="flex justify-between items-start mb-2">
                <h3 class="text-lg font-semibold">${task.title}</h3>
                <span class="px-2 py-1 text-xs rounded ${task.status === 'completed' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800'}">
                    ${task.status}
                </span>
            </div>

            ${task.description ? `<p class="text-gray-600 mb-2">${task.description}</p>` : ''}

            <div class="text-sm text-gray-500 mb-3">
                Due: ${task.due_date}
            </div>

            ${token ? `
                <div class="flex gap-2">
                    <button onclick="editTask(${task.id})" class="text-blue-600 hover:text-blue-800">Edit</button>
                    <button onclick="deleteTask(${task.id})" class="text-red-600 hover:text-red-800">Delete</button>
                </div>
            ` : ''}
        </div>
    `).join('');
}

function renderPagination(data) {
    const container = document.getElementById('pagination');

    if (!data || !data.meta) {
        container.innerHTML = '';
        return;
    }

    const { current_page, last_page } = data.meta;

    if (last_page <= 1) {
        container.innerHTML = '';
        return;
    }

    let html = '';

    if (current_page > 1) {
        html += `<button onclick="loadTasks(${current_page - 1})" class="px-3 py-1 border rounded hover:bg-gray-100">Previous</button>`;
    }

    html += `<span class="px-3 py-1">Page ${current_page} of ${last_page}</span>`;

    if (current_page < last_page) {
        html += `<button onclick="loadTasks(${current_page + 1})" class="px-3 py-1 border rounded hover:bg-gray-100">Next</button>`;
    }

    container.innerHTML = html;
}

window.openModal = function(taskId = null) {
    document.getElementById('taskModal').classList.remove('hidden');
    document.getElementById('taskForm').reset();
    document.getElementById('taskId').value = '';
    document.getElementById('modalTitle').textContent = 'New Task';

    // Clear errors
    document.querySelectorAll('[id^="error-"]').forEach(el => el.textContent = '');

    if (taskId) {
        loadTaskForEdit(taskId);
    }
}

window.closeModal = function() {
    document.getElementById('taskModal').classList.add('hidden');
}

async function loadTaskForEdit(id) {
    try {
        const response = await axios.get(`/api/tasks/${id}`);
        const task = response.data.data;

        document.getElementById('taskId').value = task.id;
        document.getElementById('title').value = task.title;
        document.getElementById('description').value = task.description || '';
        document.getElementById('status').value = task.status;
        document.getElementById('due_date').value = task.due_date;
        document.getElementById('modalTitle').textContent = 'Edit Task';
    } catch (error) {
        alert('Error loading task');
    }
}

window.editTask = function(id) {
    openModal(id);
}

window.deleteTask = async function(id) {
    if (!confirm('Are you sure you want to delete this task?')) return;

    try {
        await axios.delete(`/api/tasks/${id}`);
        loadTasks(currentPage);
    } catch (error) {
        alert('Error deleting task');
    }
}

document.getElementById('taskForm')?.addEventListener('submit', async (e) => {
    e.preventDefault();

    const taskId = document.getElementById('taskId').value;
    const data = {
        title: document.getElementById('title').value,
        description: document.getElementById('description').value,
        status: document.getElementById('status').value,
        due_date: document.getElementById('due_date').value,
    };

    // Clear previous errors
    document.querySelectorAll('[id^="error-"]').forEach(el => el.textContent = '');

    try {
        if (taskId) {
            await axios.put(`/api/tasks/${taskId}`, data);
        } else {
            await axios.post('/api/tasks', data);
        }

        closeModal();
        loadTasks(currentPage);
    } catch (error) {
        if (error.response?.data?.errors) {
            Object.keys(error.response.data.errors).forEach(key => {
                const errorEl = document.getElementById(`error-${key}`);
                if (errorEl) {
                    errorEl.textContent = error.response.data.errors[key][0];
                }
            });
        } else {
            alert('Error saving task');
        }
    }
});

document.getElementById('statusFilter')?.addEventListener('change', () => loadTasks(1));
document.getElementById('overdueFilter')?.addEventListener('change', () => loadTasks(1));

if (document.getElementById('tasksList')) {
    loadTasks();
}
