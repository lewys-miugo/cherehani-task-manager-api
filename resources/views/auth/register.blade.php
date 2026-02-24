@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto bg-white p-8 rounded-lg shadow">
    <h2 class="text-2xl font-bold mb-6">Register</h2>
    
    <form id="registerForm">
        @csrf
        <div class="mb-4">
            <label class="block text-sm font-medium mb-2">Name</label>
            <input type="text" name="name" class="w-full border rounded px-3 py-2" required>
            <span class="text-red-500 text-sm" id="error-name"></span>
        </div>
        
        <div class="mb-4">
            <label class="block text-sm font-medium mb-2">Email</label>
            <input type="email" name="email" class="w-full border rounded px-3 py-2" required>
            <span class="text-red-500 text-sm" id="error-email"></span>
        </div>
        
        <div class="mb-4">
            <label class="block text-sm font-medium mb-2">Password</label>
            <input type="password" name="password" class="w-full border rounded px-3 py-2" required>
            <span class="text-red-500 text-sm" id="error-password"></span>
        </div>
        
        <div class="mb-6">
            <label class="block text-sm font-medium mb-2">Confirm Password</label>
            <input type="password" name="password_confirmation" class="w-full border rounded px-3 py-2" required>
        </div>
        
        <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700">
            Register
        </button>
    </form>
</div>
@endsection