<?php
/* Подключаем layout с боковой панелью */
ob_start();
?>

<div class="p-4">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-4">
        <!-- Карточка со статистикой студентов -->
        <div class="bg-gray-800 rounded-lg p-4 text-white">
            <div class="flex items-center">
                <div class="inline-flex flex-shrink-0 justify-center items-center w-12 h-12 rounded-lg bg-blue-900 text-blue-500">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 18">
                        <path d="M14 2a3.963 3.963 0 0 0-1.4.267 6.439 6.439 0 0 1-1.331 6.638A4 4 0 1 0 14 2Zm1 9h-1.264A6.957 6.957 0 0 1 15 15v2a2.97 2.97 0 0 1-.184 1H19a1 1 0 0 0 1-1v-1a5.006 5.006 0 0 0-5-5ZM6.5 9a4.5 4.5 0 1 0 0-9 4.5 4.5 0 0 0 0 9ZM8 10H5a5.006 5.006 0 0 0-5 5v2a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-2a5.006 5.006 0 0 0-5-5Z"/>
                    </svg>
                </div>
                <div class="ms-4">
                    <h3 class="text-xl font-bold">256</h3>
                    <p class="text-gray-400">Всего студентов</p>
                </div>
            </div>
        </div>
        <!-- Карточка со статистикой уроков -->
        <div class="bg-gray-800 rounded-lg p-4 text-white">
            <div class="flex items-center">
                <div class="inline-flex flex-shrink-0 justify-center items-center w-12 h-12 rounded-lg bg-purple-900 text-purple-500">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 18">
                        <path d="M9 1.334C7.06.594 1.646-.84.293.653a1.158 1.158 0 0 0-.293.77v13.973c0 .193.046.383.134.55.088.167.214.306.366.403a.932.932 0 0 0 .5.147c.176 0 .348-.05.5-.147 1.059-.32 6.265.851 7.5 1.65V1.334ZM19.707.653C18.353-.84 12.94.593 11 1.333V18c1.234-.799 6.436-1.968 7.5-1.65a.931.931 0 0 0 .5.147.931.931 0 0 0 .5-.148c.152-.096.279-.235.366-.403.088-.167.134-.357.134-.55V1.423a1.158 1.158 0 0 0-.293-.77Z"/>
                    </svg>
                </div>
                <div class="ms-4">
                    <h3 class="text-xl font-bold">48</h3>
                    <p class="text-gray-400">Активных курсов</p>
                </div>
            </div>
        </div>
        <!-- Карточка с посещаемостью -->
        <div class="bg-gray-800 rounded-lg p-4 text-white">
            <div class="flex items-center">
                <div class="inline-flex flex-shrink-0 justify-center items-center w-12 h-12 rounded-lg bg-yellow-900 text-yellow-500">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm14-7.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1Zm0 4a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1Zm-5-4a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1Zm0 4a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1Zm-5-4a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1Zm0 4a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1ZM20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4Z"/>
                    </svg>
                </div>
                <div class="ms-4">
                    <h3 class="text-xl font-bold">89%</h3>
                    <p class="text-gray-400">Посещаемость</p>
                </div>
            </div>
        </div>
        <!-- Карточка с успеваемостью -->
        <div class="bg-gray-800 rounded-lg p-4 text-white">
            <div class="flex items-center">
                <div class="inline-flex flex-shrink-0 justify-center items-center w-12 h-12 rounded-lg bg-green-900 text-green-500">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M15.988 16.625c-1.604-.146-3.118-.525-4.488-1.625-1.925-1.275-3.025-2.725-4.038-4.375C6.475 9 5.938 7.525 5.375 6c-.125-.275-.225-.575-.375-.875-.263-.513-.688-.988-1.375-.988-.438 0-.85.25-1.113.588C1.825 5.562 1.5 6.7 1.5 8c0 5.513 4.488 10 10 10 1.3 0 2.438-.325 3.275-1.013.338-.262.588-.674.588-1.112 0-.688-.475-1.113-.988-1.375-.3-.15-.6-.25-.875-.375-.525-.188-1.025-.375-1.513-.5z"/>
                        <path d="M11.5 0C5.988 0 1.5 4.488 1.5 10c0 1.3.325 2.438 1.013 3.275.262.338.674.588 1.112.588.688 0 1.113-.475 1.375-.988.15-.3.25-.6.375-.875.188-.525.375-1.025.5-1.513.146-1.604.525-3.118 1.625-4.488 1.275-1.925 2.725-3.025 4.375-4.038C13.5 1.475 15 .938 16.5.375c.275-.125.575-.225.875-.375C17.888-.263 18.363-.688 18.363-1.375c0-.438-.25-.85-.588-1.113C16.938-.175 15.8-.5 14.5-.5 13.2-.5 12.062-.175 11.225.325c-.338.262-.588.674-.588 1.112 0 .688.475 1.113.988 1.375.3.15.6.25.875.375.525.188 1.025.375 1.513.5 1.604.146 3.118.525 4.488 1.625 1.925 1.275 3.025 2.725 4.038 4.375.988 1.625 1.525 3.1 2.088 4.625.125.275.225.575.375.875.263.513.688.988 1.375.988.438 0 .85-.25 1.113-.588.688-.838 1.013-1.975 1.013-3.275 0-5.513-4.488-10-10-10z"/>
                    </svg>
                </div>
                <div class="ms-4">
                    <h3 class="text-xl font-bold">78%</h3>
                    <p class="text-gray-400">Успеваемость</p>
                </div>
            </div>
        </div>
    </div>

    <!-- График активности -->
    <div class="bg-gray-800 rounded-lg p-4 mb-4">
        <h2 class="text-xl font-bold text-white mb-4">Активность за последние 7 дней</h2>
        <div class="relative h-64">
            <!-- Здесь можно добавить график с помощью JavaScript библиотеки -->
            <div class="absolute bottom-0 left-0 w-full h-full flex items-end justify-between">
                <div class="w-1/7 h-[30%] bg-blue-600 rounded-t mx-1"></div>
                <div class="w-1/7 h-[45%] bg-blue-600 rounded-t mx-1"></div>
                <div class="w-1/7 h-[60%] bg-blue-600 rounded-t mx-1"></div>
                <div class="w-1/7 h-[80%] bg-blue-600 rounded-t mx-1"></div>
                <div class="w-1/7 h-[70%] bg-blue-600 rounded-t mx-1"></div>
                <div class="w-1/7 h-[40%] bg-blue-600 rounded-t mx-1"></div>
                <div class="w-1/7 h-[55%] bg-blue-600 rounded-t mx-1"></div>
            </div>
        </div>
    </div>

    <!-- Последние действия -->
    <div class="bg-gray-800 rounded-lg p-4">
        <h2 class="text-xl font-bold text-white mb-4">Последние действия</h2>
        <div class="relative overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-400">
                <thead class="text-xs uppercase bg-gray-700 text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">Действие</th>
                        <th scope="col" class="px-6 py-3">Пользователь</th>
                        <th scope="col" class="px-6 py-3">Время</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="border-b bg-gray-800 border-gray-700">
                        <td class="px-6 py-4">Добавлен новый студент</td>
                        <td class="px-6 py-4">Администратор</td>
                        <td class="px-6 py-4">2 часа назад</td>
                    </tr>
                    <tr class="border-b bg-gray-800 border-gray-700">
                        <td class="px-6 py-4">Создан новый урок</td>
                        <td class="px-6 py-4">Преподаватель</td>
                        <td class="px-6 py-4">5 часов назад</td>
                    </tr>
                    <tr class="bg-gray-800">
                        <td class="px-6 py-4">Отмечено посещение</td>
                        <td class="px-6 py-4">Система</td>
                        <td class="px-6 py-4">8 часов назад</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
require_once __DIR__ . '/../admin/layouts/sidebar.php';
?>
