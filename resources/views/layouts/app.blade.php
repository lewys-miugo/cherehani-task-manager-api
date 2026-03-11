<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Task Manager</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50">
    <nav class="bg-white shadow">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="/tasks" class="text-xl font-bold">Task Manager</a>
                </div>
                <div class="flex items-center gap-4" id="navAuth">
                    <a href="/login" class="text-blue-600">Login</a>
                    <a href="/register" class="text-blue-600">Register</a>
                </div>
            </div>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        @yield('content')
    </main>

    <script>
        // Update nav based on token
        const token = localStorage.getItem('token');
        if (token) {
            document.getElementById('navAuth').innerHTML = `
                <button onclick="logout()" class="text-red-600">Logout</button>
            `;
        }

        window.logout = function() {
            localStorage.removeItem('token');
            window.location.href = '/login';
        }
    </script>
</body>
</html>
