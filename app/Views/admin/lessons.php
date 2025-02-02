<?php
ob_start();
?>

<div class="p-4">
    <!-- Заголовок и кнопка добавления -->
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-2xl font-bold text-white">Уроки</h2>
        <button type="button" onclick="openModal('createLessonModal')" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 focus:outline-none">
            Создать урок
        </button>
    </div>

    <!-- Список уроков -->
    <div class="bg-gray-800 rounded-lg p-4">
        <div class="relative overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-400">
                <thead class="text-xs uppercase bg-gray-700 text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">Тема урока</th>
                        <th scope="col" class="px-6 py-3">Спикер</th>
                        <th scope="col" class="px-6 py-3">Дата и время</th>
                        <th scope="col" class="px-6 py-3">Группа</th>
                        <th scope="col" class="px-6 py-3">Ссылка на ZOOM</th>
                        <th scope="col" class="px-6 py-3">Кем создано</th>
                        <th scope="col" class="px-6 py-3">Действия</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (isset($lessons) && is_array($lessons)): ?>
                        <?php foreach ($lessons as $lesson): ?>
                            <tr class="border-b bg-gray-800 border-gray-700">
                                <td class="px-6 py-4"><?php echo htmlspecialchars($lesson['title']); ?></td>
                                <td class="px-6 py-4"><?php echo htmlspecialchars($lesson['speaker']); ?></td>
                                <td class="px-6 py-4"><?php echo htmlspecialchars($lesson['datetime']); ?></td>
                                <td class="px-6 py-4"><?php echo htmlspecialchars($lesson['group']); ?> группа</td>
                                <td class="px-6 py-4">
                                    <a href="<?php echo htmlspecialchars($lesson['zoom_link']); ?>" target="_blank" class="text-blue-500 hover:underline">Ссылка</a>
                                </td>
                                <td class="px-6 py-4"><?php echo htmlspecialchars($lesson['creator_name'] ?? 'Не указано'); ?></td>
                                <td class="px-6 py-4">
                                    <div class="flex gap-2">
                                        <button type="button" onclick='editLesson(<?php echo json_encode($lesson); ?>)' class="font-medium text-blue-500 hover:underline">Изменить</button>
                                        <button type="button" onclick="deleteLesson(<?php echo $lesson['id']; ?>)" class="font-medium text-red-500 hover:underline">Удалить</button>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="px-6 py-4 text-center">Нет доступных уроков</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Модальное окно создания урока -->
    <div id="createLessonModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-gray-800">
            <div class="mt-3">
                <h3 class="text-lg leading-6 font-medium text-white mb-4">Создание урока</h3>
                <form id="createLessonForm" onsubmit="createLesson(event)">
                    <div class="mb-4">
                        <label class="block text-white text-sm font-bold mb-2" for="title">
                            Тема урока
                        </label>
                        <input type="text" id="title" name="title" required
                            class="bg-gray-700 border border-gray-600 text-white text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                    </div>
                    
                    <div class="mb-4">
                        <label class="block text-white text-sm font-bold mb-2" for="speaker">
                            Спикер
                        </label>
                        <input type="text" id="speaker" name="speaker" required
                            class="bg-gray-700 border border-gray-600 text-white text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                    </div>
                    
                    <div class="mb-4">
                        <label class="block text-white text-sm font-bold mb-2" for="datetime">
                            Дата и время урока
                        </label>
                        <input type="datetime-local" id="datetime" name="datetime" required
                            value="<?php echo date('Y-m-d\TH:i'); ?>"
                            class="bg-gray-700 border border-gray-600 text-white text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                    </div>
                    
                    <div class="mb-4">
                        <label class="block text-white text-sm font-bold mb-2" for="group">
                            Группа
                        </label>
                        <select id="group" name="group" required
                            class="bg-gray-700 border border-gray-600 text-white text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                            <?php for($i = 1; $i <= 6; $i++): ?>
                                <option value="<?php echo $i; ?>"><?php echo $i; ?> группа</option>
                            <?php endfor; ?>
                        </select>
                    </div>
                    
                    <div class="mb-4">
                        <label class="block text-white text-sm font-bold mb-2" for="zoom_link">
                            Ссылка на ZOOM
                        </label>
                        <input type="url" id="zoom_link" name="zoom_link" required
                            class="bg-gray-700 border border-gray-600 text-white text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                    </div>

                    <div class="flex justify-end gap-3">
                        <button type="button" onclick="closeModal('createLessonModal')"
                            class="text-white bg-gray-600 hover:bg-gray-700 focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 focus:outline-none">
                            Отмена
                        </button>
                        <button type="submit"
                            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 focus:outline-none">
                            Создать
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Модальное окно редактирования урока -->
    <div id="editLessonModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-gray-800">
            <div class="mt-3">
                <h3 class="text-lg leading-6 font-medium text-white mb-4">Редактирование урока</h3>
                <form id="editLessonForm" onsubmit="updateLesson(event)">
                    <input type="hidden" id="edit_lesson_id" name="lesson_id">
                    <div class="mb-4">
                        <label class="block text-white text-sm font-bold mb-2" for="edit_title">
                            Тема урока
                        </label>
                        <input type="text" id="edit_title" name="title" required
                            class="bg-gray-700 border border-gray-600 text-white text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                    </div>
                    
                    <div class="mb-4">
                        <label class="block text-white text-sm font-bold mb-2" for="edit_speaker">
                            Спикер
                        </label>
                        <input type="text" id="edit_speaker" name="speaker" required
                            class="bg-gray-700 border border-gray-600 text-white text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                    </div>
                    
                    <div class="mb-4">
                        <label class="block text-white text-sm font-bold mb-2" for="edit_datetime">
                            Дата и время урока
                        </label>
                        <input type="datetime-local" id="edit_datetime" name="datetime" required
                            class="bg-gray-700 border border-gray-600 text-white text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                    </div>
                    
                    <div class="mb-4">
                        <label class="block text-white text-sm font-bold mb-2" for="edit_group">
                            Группа
                        </label>
                        <select id="edit_group" name="group" required
                            class="bg-gray-700 border border-gray-600 text-white text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                            <?php for($i = 1; $i <= 6; $i++): ?>
                                <option value="<?php echo $i; ?>"><?php echo $i; ?> группа</option>
                            <?php endfor; ?>
                        </select>
                    </div>
                    
                    <div class="mb-4">
                        <label class="block text-white text-sm font-bold mb-2" for="edit_zoom_link">
                            Ссылка на ZOOM
                        </label>
                        <input type="url" id="edit_zoom_link" name="zoom_link" required
                            class="bg-gray-700 border border-gray-600 text-white text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                    </div>

                    <div class="flex justify-end gap-3">
                        <button type="button" onclick="closeModal('editLessonModal')"
                            class="text-white bg-gray-600 hover:bg-gray-700 focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 focus:outline-none">
                            Отмена
                        </button>
                        <button type="submit"
                            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 focus:outline-none">
                            Сохранить
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
// Функции для работы с модальными окнами
function openModal(modalId) {
    document.getElementById(modalId).classList.remove('hidden');
}

function closeModal(modalId) {
    document.getElementById(modalId).classList.add('hidden');
}

// Создание урока
async function createLesson(event) {
    event.preventDefault();
    const form = event.target;
    const formData = new FormData(form);

    try {
        const response = await fetch('/admin/lessons/create', {
            method: 'POST',
            body: formData
        });

        const result = await response.json();
        if (result.success) {
            closeModal('createLessonModal');
            window.location.reload();
        } else {
            alert(result.message || 'Произошла ошибка при создании урока');
        }
    } catch (error) {
        console.error('Ошибка:', error);
        alert('Произошла ошибка при создании урока');
    }
}

// Редактирование урока
function editLesson(lesson) {
    // Отладочная информация
    console.log('Данные урока для редактирования:', lesson);
    
    document.getElementById('edit_lesson_id').value = lesson.id;
    document.getElementById('edit_title').value = lesson.title;
    document.getElementById('edit_speaker').value = lesson.speaker;
    
    // Преобразование формата datetime для input
    const datetime = lesson.datetime.replace(' ', 'T');
    document.getElementById('edit_datetime').value = datetime;
    
    document.getElementById('edit_group').value = lesson.group;
    document.getElementById('edit_zoom_link').value = lesson.zoom_link;
    
    openModal('editLessonModal');
}

// Обновление урока
async function updateLesson(event) {
    event.preventDefault();
    const form = event.target;
    const formData = new FormData(form);

    // Отладочная информация
    console.log('Данные для обновления урока:');
    for (let pair of formData.entries()) {
        console.log(pair[0] + ': ' + pair[1]);
    }

    try {
        const response = await fetch('/admin/lessons/update', {
            method: 'POST',
            body: formData
        });

        const result = await response.json();
        if (result.success) {
            closeModal('editLessonModal');
            window.location.reload();
        } else {
            alert(result.message || 'Произошла ошибка при обновлении урока');
        }
    } catch (error) {
        console.error('Ошибка:', error);
        alert('Произошла ошибка при обновлении урока');
    }
}

/**
 * Удаляет урок по ID
 * @param {number} lessonId ID урока
 */
async function deleteLesson(lessonId) {
    if (!confirm('Вы действительно хотите удалить этот урок?')) {
        return;
    }

    try {
        const response = await fetch(`/admin/lessons/delete/${lessonId}`, {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        });

        const result = await response.json();
        
        if (result.success) {
            // Перезагружаем страницу при успешном удалении
            window.location.reload();
        } else {
            // Показываем ошибку
            alert(result.message || 'Произошла ошибка при удалении урока');
        }
    } catch (error) {
        console.error('Ошибка при удалении урока:', error);
        alert('Произошла ошибка при удалении урока');
    }
}

// Закрытие модального окна при клике вне его области
window.onclick = function(event) {
    const modals = ['createLessonModal', 'editLessonModal'];
    modals.forEach(modalId => {
        const modal = document.getElementById(modalId);
        if (event.target === modal) {
            closeModal(modalId);
        }
    });
}
</script>

<?php
$content = ob_get_clean();
require_once __DIR__ . '/../admin/layouts/sidebar.php';
?>
