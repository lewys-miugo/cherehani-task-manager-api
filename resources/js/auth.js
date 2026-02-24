function updateNav() {
    const token = localStorage.getItem('token');
    const navAuth = document.getElementById('navAuth');

    if (navAuth) {
        if (token) {
            navAuth.innerHTML = `
                <button onclick="logout()" class="text-red-600">Logout</button>
            `;
        } else {
            navAuth.innerHTML = `
                <a href="/login" class="text-blue-600">Login</a>
                <a href="/register" class="text-blue-600">Register</a>
            `;
        }
    }
}

document.getElementById('registerForm')?.addEventListener('submit', async (e) => {
    e.preventDefault();
    const formData = new FormData(e.target);

    document.querySelectorAll('[id^="error-"]').forEach(el => el.textContent = '');

    try {
        const response = await axios.post('/api/register', Object.fromEntries(formData));
        localStorage.setItem('token', response.data.token);
        window.location.href = '/tasks';
    } catch (error) {
        if (error.response?.data?.errors) {
            Object.keys(error.response.data.errors).forEach(key => {
                const errorEl = document.getElementById(`error-${key}`);
                if (errorEl) {
                    errorEl.textContent = error.response.data.errors[key][0];
                }
            });
        } else {
            alert('Registration failed');
        }
    }
});

document.getElementById('loginForm')?.addEventListener('submit', async (e) => {
    e.preventDefault();
    const formData = new FormData(e.target);

    document.querySelectorAll('[id^="error-"]').forEach(el => el.textContent = '');

    try {
        const response = await axios.post('/api/login', Object.fromEntries(formData));
        localStorage.setItem('token', response.data.token);
        window.location.href = '/tasks';
    } catch (error) {
        if (error.response?.data?.errors) {
            Object.keys(error.response.data.errors).forEach(key => {
                const errorEl = document.getElementById(`error-${key}`);
                if (errorEl) {
                    errorEl.textContent = error.response.data.errors[key][0];
                }
            });
        } else if (error.response?.status === 401) {
            alert('Invalid credentials');
        } else {
            alert('Login failed');
        }
    }
});

window.logout = async function() {
    const token = localStorage.getItem('token');

    if (token) {
        try {
            await axios.post('/api/logout', {}, {
                headers: { 'Authorization': `Bearer ${token}` }
            });
        } catch (error) {
            console.error('Logout error:', error);
        }
    }

    localStorage.removeItem('token');
    window.location.href = '/login';
}

// Update nav on page load
updateNav();
