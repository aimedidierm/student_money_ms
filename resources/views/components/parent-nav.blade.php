<nav class="bg-gray-50 dark:bg-gray-700">
    <div class="max-w-screen-xl px-4 py-3 mx-auto">
        <div class="flex items-center">
            <ul class="flex flex-row font-medium mt-0 mr-6 space-x-8 text-sm">
                <li>
                    <a href="/parent"
                        class="{{ request()->is('parent') ? 'text-blue-600 dark:text-blue-600' : 'text-gray-900 dark:text-white' }} hover:underline"
                        aria-current="page">Send money</a>
                </li>
                <li>
                    <a href="/parent/student"
                        class="{{ request()->is('parent/student') ? 'text-blue-600 dark:text-blue-600' : 'text-gray-900 dark:text-white' }} hover:underline">Student
                        manager</a>
                </li>
                <li>
                    <a href="/parent/settings"
                        class="{{ request()->is('parent/settings') ? 'text-blue-600 dark:text-blue-600' : 'text-gray-900 dark:text-white' }} hover:underline">Settings</a>
                </li>
            </ul>
        </div>
    </div>
</nav>