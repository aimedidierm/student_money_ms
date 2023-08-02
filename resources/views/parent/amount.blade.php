@extends('layout')

@section('content')

<x-parent-nav />

<div class="bg-gray-100 py-6">
    <div class="max-w-2xl mx-auto">
        @if ($data->students != null)
        <h2 class="text-2xl font-bold mb-4">Send money to student</h2>
        <form action="/parent/student" method="POST">
            @if($errors->any())
            <span style="color: red;">{{$errors->first()}}</span>
            @endif
            @csrf
            <div class="mb-4">
                <label for="name" class="block font-medium mb-2">Student name:</label>
                <input type="hidden" name="student" value="{{$data->students->id}}">
                <input type="text" id="name" class="w-full border border-gray-300 rounded px-4 py-2"
                    placeholder="Enter your name" value="{{$data->students->name}}" disabled>
            </div>
            <div class="mb-4">
                <label for="email" class="block font-medium mb-2">Amount / Day: </label>
                <input type="number" id="number" name="amount" class="w-full border border-gray-300 rounded px-4 py-2"
                    placeholder="Enter amount to be send" value="{{$amount->amount}}" required>
            </div>
            <div class="flex justify-end">
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white rounded px-4 py-2">Send
                    update</button>
            </div>
        </form>
        @else
        <h2 class="text-2xl font-bold mb-4">Your are not connected to any student</h2>
        @endif
    </div>
</div>
@stop