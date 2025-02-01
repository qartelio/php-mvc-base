<?php
ob_start();
?>

<div class="p-4">
    <!-- Заголовок и кнопка добавления -->
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-2xl font-bold text-white">Уроки</h2>
        <button type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 focus:outline-none">
            Добавить урок
        </button>
    </div>

    <!-- Фильтры -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
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
            <option selected>Все преподаватели</option>
            <option value="teacher1">Иванов И.И.</option>
            <option value="teacher2">Петров П.П.</option>
            <option value="teacher3">Сидоров С.С.</option>
        </select>
    </div>

    <!-- Календарь уроков -->
    <div class="grid grid-cols-1 md:grid-cols-7 gap-4 mb-4">
        <?php
        $days = ['Понедельник', 'Вторник', 'Среда', 'Четверг', 'Пятница', 'Суббота', 'Воскресенье'];
        foreach ($days as $day) :
        ?>
            <div class="bg-gray-800 rounded-lg p-4">
                <h3 class="text-lg font-semibold text-white mb-3"><?php echo $day; ?></h3>
                <!-- Уроки дня -->
                <div class="space-y-3">
                    <?php if ($day === 'Понедельник') : ?>
                        <div class="bg-gray-700 p-3 rounded-lg">
                            <div class="text-sm text-white font-medium">Математика</div>
                            <div class="text-xs text-gray-400">09:00 - 10:30</div>
                            <div class="text-xs text-gray-400">Группа 1</div>
                            <div class="text-xs text-gray-400">Иванов И.И.</div>
                        </div>
                        <div class="bg-gray-700 p-3 rounded-lg">
                            <div class="text-sm text-white font-medium">Физика</div>
                            <div class="text-xs text-gray-400">11:00 - 12:30</div>
                            <div class="text-xs text-gray-400">Группа 2</div>
                            <div class="text-xs text-gray-400">Петров П.П.</div>
                        </div>
                    <?php elseif ($day === 'Среда') : ?>
                        <div class="bg-gray-700 p-3 rounded-lg">
                            <div class="text-sm text-white font-medium">Химия</div>
                            <div class="text-xs text-gray-400">13:00 - 14:30</div>
                            <div class="text-xs text-gray-400">Группа 3</div>
                            <div class="text-xs text-gray-400">Сидоров С.С.</div>
                        </div>
                    <?php else : ?>
                        <div class="text-sm text-gray-400 text-center">Нет уроков</div>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- Список ближайших уроков -->
    <div class="bg-gray-800 rounded-lg p-4">
        <h3 class="text-xl font-bold text-white mb-4">Ближайшие уроки</h3>
        <div class="relative overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-400">
                <thead class="text-xs uppercase bg-gray-700 text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">Предмет</th>
                        <th scope="col" class="px-6 py-3">Дата и время</th>
                        <th scope="col" class="px-6 py-3">Группа</th>
                        <th scope="col" class="px-6 py-3">Преподаватель</th>
                        <th scope="col" class="px-6 py-3">Статус</th>
                        <th scope="col" class="px-6 py-3">Действия</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="border-b bg-gray-800 border-gray-700">
                        <td class="px-6 py-4">Математика</td>
                        <td class="px-6 py-4">03.02.2025 09:00</td>
                        <td class="px-6 py-4">Группа 1</td>
                        <td class="px-6 py-4">Иванов И.И.</td>
                        <td class="px-6 py-4">
                            <span class="bg-green-900 text-green-300 text-xs font-medium px-2.5 py-0.5 rounded">Запланирован</span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex gap-2">
                                <button type="button" class="font-medium text-blue-500 hover:underline">Изменить</button>
                                <button type="button" class="font-medium text-red-500 hover:underline">Отменить</button>
                            </div>
                        </td>
                    </tr>
                    <tr class="border-b bg-gray-800 border-gray-700">
                        <td class="px-6 py-4">Физика</td>
                        <td class="px-6 py-4">03.02.2025 11:00</td>
                        <td class="px-6 py-4">Группа 2</td>
                        <td class="px-6 py-4">Петров П.П.</td>
                        <td class="px-6 py-4">
                            <span class="bg-yellow-900 text-yellow-300 text-xs font-medium px-2.5 py-0.5 rounded">Требует подтверждения</span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex gap-2">
                                <button type="button" class="font-medium text-blue-500 hover:underline">Изменить</button>
                                <button type="button" class="font-medium text-red-500 hover:underline">Отменить</button>
                            </div>
                        </td>
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
