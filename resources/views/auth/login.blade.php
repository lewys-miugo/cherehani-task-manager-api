@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto bg-white p-8 rounded-lg shadow">
    <h2 class="text-2xl font-bold mb-6">Login</h2>
    
    <form id="loginForm">
        @csrf
        <div class="mb-4">
            <label class="block text-sm font-medium mb-2">Email</label>
            <input type="email" name="email" class="w-full border rounded px-3 py-2" required>
            <span class="text-red-500 text-sm" id="error-email"></span>
        </div>
        
        <div class="mb-6">
            <label class="block text-sm font-medium mb-2">Password</label>
            <input type="password" name="password" class="w-full border rounded px-3 py-2" required>
            <span class="text-red-500 text-sm" id="error-password"></span>
        </div>
        
        <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700">
            Login
        </button>
    </form>
</div>
@endsection