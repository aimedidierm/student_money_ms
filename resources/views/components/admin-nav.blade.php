<nav class="bg-gray-50 dark:bg-gray-700">
    <div class="max-w-screen-xl px-4 py-3 mx-auto">
        <div class="flex items-center">
            <ul class="flex flex-row font-medium mt-0 mr-6 space-x-8 text-sm">
                {{-- <li>
                    <a href="/admin"
                        class="{{ request()->is('admin') ? 'text-blue-600 dark:text-blue-600' : 'text-gray-900 dark:text-white' }} hover:underline"
                        aria-current="page">Schools</a>
                </li> --}}
                <li>
                    <a href="/admin/canteen"
                        class="{{ request()->is('admin/canteen') ? 'text-blue-600 dark:text-blue-600' : 'text-gray-900 dark:text-white' }} hover:underline">Canteen</a>
                </li>
                <li>
                    <a href="/admin/students"
                        class="{{ request()->is('admin/students') ? 'text-blue-600 dark:text-blue-600' : 'text-gray-900 dark:text-white' }} hover:underline">Students</a>
                </li>
                <li>
                    <a href="/admin/parents"
                        class="{{ request()->is('admin/parents') ? 'text-blue-600 dark:text-blue-600' : 'text-gray-900 dark:text-white' }} hover:underline">Parents</a>
                </li>
                <li>
                    <a href="/admin/transactions"
                        class="{{ request()->is('admin/transactions') ? 'text-blue-600 dark:text-blue-600' : 'text-gray-900 dark:text-white' }} hover:underline">Transactions</a>
                </li>
                <li>
                    <a href="/admin/settings"
                        class="{{ request()->is('admin/settings') ? 'text-blue-600 dark:text-blue-600' : 'text-gray-900 dark:text-white' }} hover:underline">Settings</a>
                </li>
            </ul>
        </div>
    </div>
</nav>