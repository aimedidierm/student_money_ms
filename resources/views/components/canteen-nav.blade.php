<nav class="bg-gray-50 dark:bg-gray-700">
    <div class="max-w-screen-xl px-4 py-3 mx-auto">
        <div class="flex items-center">
            <ul class="flex flex-row font-medium mt-0 mr-6 space-x-8 text-sm">
                <li>
                    <a href="/canteen"
                        class="{{ request()->is('canteen') ? 'text-blue-600 dark:text-blue-600' : 'text-gray-900 dark:text-white' }} hover:underline"
                        aria-current="page">Purchase</a>
                </li>
                <li>
                    <a href="/canteen/withdraw"
                        class="{{ request()->is('canteen/withdraw') ? 'text-blue-600 dark:text-blue-600' : 'text-gray-900 dark:text-white' }} hover:underline">Withdraw</a>
                </li>
                <li>
                    <a href="/canteen/transactions"
                        class="{{ request()->is('canteen/transactions') ? 'text-blue-600 dark:text-blue-600' : 'text-gray-900 dark:text-white' }} hover:underline">Transactions</a>
                </li>
                <li>
                    <a href="/canteen/settings"
                        class="{{ request()->is('canteen/settings') ? 'text-blue-600 dark:text-blue-600' : 'text-gray-900 dark:text-white' }} hover:underline">Settings</a>
                </li>
            </ul>
        </div>
    </div>
</nav>