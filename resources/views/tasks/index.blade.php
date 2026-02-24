@extends('layouts.app')

@section('content')
<div class="px-4">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">Tasks</h1>
        <button id="newTaskBtn" class="hidden bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700" onclick="openModal()">
            New Task
        </button>
    </div>

    <div class="mb-4 flex gap-4">
        <select id="statusFilter" class="border rounded px-3 py-2">
            <option value="">All Status</option>
            <option value="pending">Pending</option>
            <option value="completed">Completed</option>
        </select>
        <label class="flex items-center gap-2">
            <input type="checkbox" id="overdueFilter">
            <span>Overdue Only</span>
        </label>
    </div>

    <div id="tasksList" class="grid gap-4"></div>

    <div id="pagination" class="mt-6 flex justify-center gap-2"></div>
</div>

<!-- Modal -->
<div id="taskModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white p-8 rounded-lg max-w-md w-full mx-4">
        <div class="flex justify-between items-center mb-4">
            <h2 id="modalTitle" class="text-2xl font-bold">New Task</h2>
            <button onclick="closeModal()" class="text-gray-500 hover:text-gray-700 text-2xl">&times;</button>
        </div>

        <form id="taskForm">
            <input type="hidden" id="taskId">

            <div class="mb-4">
                <label class="block text-sm font-medium mb-2">Title *</label>
                <input type="text" id="title" class="w-full border rounded px-3 py-2" required>
                <span class="text-red-500 text-sm" id="error-title"></span>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium mb-2">Description</label>
                <textarea id="description" class="w-full border rounded px-3 py-2" rows="3"></textarea>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium mb-2">Status</label>
                <select id="status" class="w-full border rounded px-3 py-2">
                    <option value="pending">Pending</option>
                    <option value="completed">Completed</option>
                </select>
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium mb-2">Due Date *</label>
                <input type="date" id="due_date" class="w-full border rounded px-3 py-2" required>
                <span class="text-red-500 text-sm" id="error-due_date"></span>
            </div>

            <div class="flex gap-2">
                <button type="submit" class="flex-1 bg-blue-600 text-white py-2 rounded hover:bg-blue-700">
                    Save
                </button>
                <button type="button" onclick="closeModal()" class="flex-1 bg-gray-300 text-gray-700 py-2 rounded hover:bg-gray-400">
                    Cancel
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    // Show New Task button if logged in
    const token = localStorage.getItem('token');
    if (token) {
        document.getElementById('newTaskBtn').classList.remove('hidden');
    }
</script>
@endsection
