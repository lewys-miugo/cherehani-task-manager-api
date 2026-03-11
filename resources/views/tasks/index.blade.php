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

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Title</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Description</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Due Date</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Completed</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody id="tasksList" class="bg-white divide-y divide-gray-200">
            </tbody>
        </table>
    </div>

    <div id="pagination" class="mt-6 flex justify-center gap-2"></div>
</div>

<!-- Modal -->
<div id="taskModal" class="hidden fixed top-20 right-8 z-50">
    <div class="bg-white p-6 rounded-lg shadow-xl border border-gray-200 w-96">
        <div class="flex justify-between items-center mb-4">
            <h2 id="modalTitle" class="text-xl font-bold">New Task</h2>
            <button onclick="closeModal()" class="text-gray-500 hover:text-gray-700 text-2xl">&times;</button>
        </div>

        <form id="taskForm">
            <input type="hidden" id="taskId">

            <div class="mb-3">
                <label class="block text-sm font-medium mb-1">Title *</label>
                <input type="text" id="title" class="w-full border rounded px-3 py-2" required>
                <span class="text-red-500 text-sm" id="error-title"></span>
            </div>

            <div class="mb-3">
                <label class="block text-sm font-medium mb-1">Description</label>
                <textarea id="description" class="w-full border rounded px-3 py-2" rows="2"></textarea>
            </div>

            <div class="mb-3">
                <label class="block text-sm font-medium mb-1">Due Date *</label>
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
    const token = localStorage.getItem('token');
    if (token) {
        document.getElementById('newTaskBtn').classList.remove('hidden');
    }
</script>
@endsection
