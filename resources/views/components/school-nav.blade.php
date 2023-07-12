<nav class="bg-gray-50 dark:bg-gray-700">
    <div class="max-w-screen-xl px-4 py-3 mx-auto">
        <div class="flex items-center">
            <ul class="flex flex-row font-medium mt-0 mr-6 space-x-8 text-sm">
                <li>
                    <a href="/school"
                        class="{{ request()->is('school') ? 'text-blue-600 dark:text-blue-600' : 'text-gray-900 dark:text-white' }} hover:underline"
                        aria-current="page">Students</a>
                </li>
                <li>
                    <a href="/school/parents"
                        class="{{ request()->is('school/parents') ? 'text-blue-600 dark:text-blue-600' : 'text-gray-900 dark:text-white' }} hover:underline">Parents</a>
                </li>
                <li>
                    <a href="/school/canteen"
                        class="{{ request()->is('school/canteen') ? 'text-blue-600 dark:text-blue-600' : 'text-gray-900 dark:text-white' }} hover:underline">Canteens</a>
                </li>
                <li>
                    <a href="/school/withdraw"
                        class="{{ request()->is('school/withdraw') ? 'text-blue-600 dark:text-blue-600' : 'text-gray-900 dark:text-white' }} hover:underline">Withdraw</a>
                </li>
                <li>
                    <a href="/school/transactions"
                        class="{{ request()->is('school/transactions') ? 'text-blue-600 dark:text-blue-600' : 'text-gray-900 dark:text-white' }} hover:underline">Transactions</a>
                </li>
                <li>
                    <a href="/school/settings"
                        class="{{ request()->is('school/settings') ? 'text-blue-600 dark:text-blue-600' : 'text-gray-900 dark:text-white' }} hover:underline">Settings</a>
                </li>
            </ul>
        </div>
    </div>
</nav>