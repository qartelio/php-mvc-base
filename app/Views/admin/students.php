<?php
ob_start();
?>

<div class="p-4">
    <!-- Заголовок и кнопка добавления -->
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-2xl font-bold text-white">Студенты</h2>
        <button type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 focus:outline-none">
            Добавить студента
        </button>
    </div>

    <!-- Фильтры и поиск -->
    <div class="flex flex-col md:flex-row gap-4 mb-4">
        <div class="flex-1">
            <label for="search" class="sr-only">Поиск</label>
            <div class="relative">
                <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                    <svg class="w-4 h-4 text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                    </svg>
                </div>
                <input type="search" id="search" class="block w-full p-2.5 ps-10 text-sm border rounded-lg bg-gray-700 border-gray-600 placeholder-gray-400 text-white focus:ring-blue-500 focus:border-blue-500" placeholder="Поиск студентов...">
            </div>
        </div>
        <select class="bg-gray-700 border border-gray-600 text-white text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5">
            <option selected>Все группы</option>
            <option value="group1">Группа 1</option>
            <option value="group2">Группа 2</option>
            <option value="group3">Группа 3</option>
        </select>
    </div>

    <!-- Таблица студентов -->
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left text-gray-400">
            <thead class="text-xs uppercase bg-gray-700 text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        ФИО
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Группа
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Email
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Телефон
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Статус
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Действия
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr class="border-b bg-gray-800 border-gray-700">
                    <th scope="row" class="px-6 py-4 font-medium whitespace-nowrap text-white">
                        Иванов Иван Иванович
                    </th>
                    <td class="px-6 py-4">
                        Группа 1
                    </td>
                    <td class="px-6 py-4">
                        ivanov@example.com
                    </td>
                    <td class="px-6 py-4">
                        +7 (999) 123-45-67
                    </td>
                    <td class="px-6 py-4">
                        <span class="bg-green-900 text-green-300 text-xs font-medium px-2.5 py-0.5 rounded">Активный</span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex gap-2">
                            <button type="button" class="font-medium text-blue-500 hover:underline">Изменить</button>
                            <button type="button" class="font-medium text-red-500 hover:underline">Удалить</button>
                        </div>
                    </td>
                </tr>
                <tr class="border-b bg-gray-800 border-gray-700">
                    <th scope="row" class="px-6 py-4 font-medium whitespace-nowrap text-white">
                        Петров Петр Петрович
                    </th>
                    <td class="px-6 py-4">
                        Группа 2
                    </td>
                    <td class="px-6 py-4">
                        petrov@example.com
                    </td>
                    <td class="px-6 py-4">
                        +7 (999) 234-56-78
                    </td>
                    <td class="px-6 py-4">
                        <span class="bg-yellow-900 text-yellow-300 text-xs font-medium px-2.5 py-0.5 rounded">На паузе</span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex gap-2">
                            <button type="button" class="font-medium text-blue-500 hover:underline">Изменить</button>
                            <button type="button" class="font-medium text-red-500 hover:underline">Удалить</button>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Пагинация -->
    <div class="flex justify-center mt-4">
        <nav aria-label="Page navigation">
            <ul class="inline-flex -space-x-px text-sm">
                <li>
                    <a href="#" class="flex items-center justify-center px-3 h-8 leading-tight border rounded-s-lg bg-gray-800 border-gray-700 text-gray-400 hover:bg-gray-700 hover:text-white">Предыдущая</a>
                </li>
                <li>
                    <a href="#" class="flex items-center justify-center px-3 h-8 leading-tight border bg-gray-800 border-gray-700 text-gray-400 hover:bg-gray-700 hover:text-white">1</a>
                </li>
                <li>
                    <a href="#" class="flex items-center justify-center px-3 h-8 text-blue-600 border border-gray-700 bg-blue-900 hover:bg-blue-800 hover:text-white">2</a>
                </li>
                <li>
                    <a href="#" class="flex items-center justify-center px-3 h-8 leading-tight border bg-gray-800 border-gray-700 text-gray-400 hover:bg-gray-700 hover:text-white">3</a>
                </li>
                <li>
                    <a href="#" class="flex items-center justify-center px-3 h-8 leading-tight border rounded-e-lg bg-gray-800 border-gray-700 text-gray-400 hover:bg-gray-700 hover:text-white">Следующая</a>
                </li>
            </ul>
        </nav>
    </div>
</div>

<?php
$content = ob_get_clean();
require_once __DIR__ . '/../admin/layouts/sidebar.php';
?>
