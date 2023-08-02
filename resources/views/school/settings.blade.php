@extends('layout')

@section('content')

<x-school-nav />

<div class="bg-gray-100 py-6">
    <div class="max-w-2xl mx-auto">
        <h2 class="text-2xl font-bold mb-4">Update your details</h2>
        <form action="/school/settings" method="POST">
            @if($errors->any())
            <span style="color: red;">{{$errors->first()}}</span>
            @endif
            @csrf
            <input type="hidden" name="_method" value="PUT">
            <div class="mb-4">
                <label for="name" class="block font-medium mb-2">Name</label>
                <input type="text" id="name" name="name" class="w-full border border-gray-300 rounded px-4 py-2"
                    placeholder="Enter your name" value="{{$data->name}}" disabled>
            </div>
            <div class="mb-4">
                <label for="email" class="block font-medium mb-2">Email</label>
                <input type="email" id="email" name="email" class="w-full border border-gray-300 rounded px-4 py-2"
                    placeholder="Enter your email" value="{{$data->email}}" disabled>
            </div>
            <div class="mb-4">
                <label for="password" class="block font-medium mb-2">Password</label>
                <input type="password" id="password" name="password"
                    class="w-full border border-gray-300 rounded px-4 py-2" placeholder="Enter your password" required>
            </div>
            <div class="mb-4">
                <label for="password" class="block font-medium mb-2">Confim password</label>
                <input type="password" id="password" name="confirmPassword"
                    class="w-full border border-gray-300 rounded px-4 py-2" placeholder="Enter your password" required>
            </div>
            <div class="flex justify-end">
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white rounded px-4 py-2">Update</button>
            </div>
        </form>
    </div>
</div>
@stop