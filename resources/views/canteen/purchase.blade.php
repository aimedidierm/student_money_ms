@extends('layout')

@section('content')

<x-canteen-nav />

<div class="bg-gray-100 py-6">
    <div class="max-w-2xl mx-auto">
        <h2 class="text-2xl font-bold mb-4">Make purchase</h2>
        <form action="/canteen/buy" method="POST">
            @if($errors->any())
            <span style="color: red;">{{$errors->first()}}</span>
            @endif
            @csrf
            <div class="mb-4">
                <label for="name" class="block font-medium mb-2">Student Reg number:</label>
                <input type="text" id="name" name="regNumber" class="w-full border border-gray-300 rounded px-4 py-2"
                    placeholder="Enter your reg number" required>
            </div>
            <div class="mb-4">
                <label for="email" class="block font-medium mb-2">Amount: </label>
                <input type="number" id="email" name="amount" class="w-full border border-gray-300 rounded px-4 py-2"
                    placeholder="Enter amount" required>
            </div>
            <div class="mb-4">
                <label for="password" class="block font-medium mb-2">Password: </label>
                <input type="password" id="password" name="password"
                    class="w-full border border-gray-300 rounded px-4 py-2" placeholder="Enter your password" required>
            </div>
            <div class="flex justify-end">
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white rounded px-4 py-2">Make
                    transaction</button>
            </div>
        </form>
    </div>
</div>
@stop