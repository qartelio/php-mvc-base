<?php
ob_start();
?>

<div class="p-4">
    <!-- Заголовок -->
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-2xl font-bold text-white">Посещение уроков</h2>
    </div>

    <!-- Фильтры -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-4">
        <select class="bg-gray-700 border border-gray-600 text-white text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
            <option selected>Все предметы</option>
            <option value="math">Математика</option>
            <option value="physics">Физика</option>
            <option value="chemistry">Химия</option>
        </select>
        <select class="bg-gray-700 border border-gray-600 text-white text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
            <option selected>Все группы</option>
            <option value="group1">Группа 1</option>
            <option value="group2">Группа 2</option>
            <option value="group3">Группа 3</option>
        </select>
        <select class="bg-gray-700 border border-gray-600 text-white text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
            <option selected>Все студенты</option>
            <option value="student1">Иванов И.И.</option>
            <option value="student2">Петров П.П.</option>
            <option value="student3">Сидоров С.С.</option>
        </select>
        <input type="date" class="bg-gray-700 border border-gray-600 text-white text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
    </div>

    <!-- Статистика посещаемости -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
        <div class="bg-gray-800 rounded-lg p-4">
            <div class="flex items-center">
                <div class="inline-flex flex-shrink-0 justify-center items-center w-12 h-12 rounded-lg bg-green-900 text-green-500">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"></path>
                    </svg>
                </div>
                <div class="ms-4">
                    <h3 class="text-xl font-bold text-white">85%</h3>
                    <p class="text-gray-400">Присутствовали</p>
                </div>
            </div>
        </div>
        <div class="bg-gray-800 rounded-lg p-4">
            <div class="flex items-center">
                <div class="inline-flex flex-shrink-0 justify-center items-center w-12 h-12 rounded-lg bg-yellow-900 text-yellow-500">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 18a8 8 0 100-16 8 8 0 000 16zM7 9a1 1 0 000 2h6a1 1 0 100-2H7z"></path>
                    </svg>
                </div>
                <div class="ms-4">
                    <h3 class="text-xl font-bold text-white">10%</h3>
                    <p class="text-gray-400">Отсутствовали по уважительной причине</p>
                </div>
            </div>
        </div>
        <div class="bg-gray-800 rounded-lg p-4">
            <div class="flex items-center">
                <div class="inline-flex flex-shrink-0 justify-center items-center w-12 h-12 rounded-lg bg-red-900 text-red-500">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"></path>
                    </svg>
                </div>
                <div class="ms-4">
                    <h3 class="text-xl font-bold text-white">5%</h3>
                    <p class="text-gray-400">Пропуски без причины</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Таблица посещаемости -->
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left text-gray-400">
            <thead class="text-xs uppercase bg-gray-700 text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">Дата</th>
                    <th scope="col" class="px-6 py-3">Предмет</th>
                    <th scope="col" class="px-6 py-3">Группа</th>
                    <th scope="col" class="px-6 py-3">Студент</th>
                    <th scope="col" class="px-6 py-3">Статус</th>
                    <th scope="col" class="px-6 py-3">Комментарий</th>
                    <th scope="col" class="px-6 py-3">Действия</th>
                </tr>
            </thead>
            <tbody>
                <tr class="border-b bg-gray-800 border-gray-700">
                    <td class="px-6 py-4">02.02.2025</td>
                    <td class="px-6 py-4">Математика</td>
                    <td class="px-6 py-4">Группа 1</td>
                    <td class="px-6 py-4">Иванов И.И.</td>
                    <td class="px-6 py-4">
                        <span class="bg-green-900 text-green-300 text-xs font-medium px-2.5 py-0.5 rounded">Присутствовал</span>
                    </td>
                    <td class="px-6 py-4">-</td>
                    <td class="px-6 py-4">
                        <button type="button" class="font-medium text-blue-500 hover:underline">Изменить</button>
                    </td>
                </tr>
                <tr class="border-b bg-gray-800 border-gray-700">
                    <td class="px-6 py-4">02.02.2025</td>
                    <td class="px-6 py-4">Физика</td>
                    <td class="px-6 py-4">Группа 2</td>
                    <td class="px-6 py-4">Петров П.П.</td>
                    <td class="px-6 py-4">
                        <span class="bg-yellow-900 text-yellow-300 text-xs font-medium px-2.5 py-0.5 rounded">Уважительная причина</span>
                    </td>
                    <td class="px-6 py-4">Болезнь</td>
                    <td class="px-6 py-4">
                        <button type="button" class="font-medium text-blue-500 hover:underline">Изменить</button>
                    </td>
                </tr>
                <tr class="bg-gray-800">
                    <td class="px-6 py-4">02.02.2025</td>
                    <td class="px-6 py-4">Химия</td>
                    <td class="px-6 py-4">Группа 3</td>
                    <td class="px-6 py-4">Сидоров С.С.</td>
                    <td class="px-6 py-4">
                        <span class="bg-red-900 text-red-300 text-xs font-medium px-2.5 py-0.5 rounded">Пропуск</span>
                    </td>
                    <td class="px-6 py-4">Без уважительной причины</td>
                    <td class="px-6 py-4">
                        <button type="button" class="font-medium text-blue-500 hover:underline">Изменить</button>
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
