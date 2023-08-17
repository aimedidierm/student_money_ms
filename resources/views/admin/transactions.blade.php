@extends('layout')

@section('content')

<x-admin-nav />

<button data-drawer-target="sidebar-multi-level-sidebar" data-drawer-toggle="sidebar-multi-level-sidebar"
    aria-controls="sidebar-multi-level-sidebar" type="button"
    class="inline-flex items-center p-2 mt-2 ml-3 text-sm text-gray-500 rounded-lg sm:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600">
    <span class="sr-only">Open sidebar</span>
    <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
        <path clip-rule="evenodd" fill-rule="evenodd"
            d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z">
        </path>
    </svg>
</button>


<div class="p-4 sm:ml-2">
    <div class="p-4 border-gray-200 rounded-lg dark:border-gray-700">
        <br>

        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3 bg-gray-50 dark:bg-gray-800">
                            Status
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Amount
                        </th>
                        <th scope="col" class="px-6 py-3 bg-gray-50 dark:bg-gray-800">
                            Student
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Canteen
                        </th>
                        <th scope="col" class="px-6 py-3 bg-gray-50 dark:bg-gray-800">
                            Guardian
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Time
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @if ($data->isEmpty())
                    <tr class="border-b border-gray-200 dark:border-gray-700">
                        <th scope="row" colspan="6"
                            class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap bg-gray-50 dark:text-white dark:bg-gray-800">
                            No data found
                        </th>
                    </tr>
                    @else
                    @foreach ($data as $item)
                    <tr>
                        <th scope="row"
                            class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap bg-gray-50 dark:text-white dark:bg-gray-800">
                            @if ($item->status == 'debit')
                            Credited
                            @else
                            Debited
                            @endif
                        </th>
                        <td class="px-6 py-4">
                            {{$item->amount}} Rwf
                        </td>
                        <td class="px-2 py-2 bg-gray-50 dark:bg-gray-800">
                            @if ($item->students != null)
                            {{$item->students->name}}
                            @endif
                        <td class="px-6 py-4">
                            @if ($item->canteens != null)
                            {{$item->canteens->name}}
                            @endif
                        </td>
                        <td class="px-2 py-2 bg-gray-50 dark:bg-gray-800">
                            @if ($item->guardians != null)
                            {{$item->guardians->name}}
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            {{$item->created_at}}
                        </td>
                    </tr>
                    @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
@stop