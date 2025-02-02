<?php
ob_start();
?>

<div class="p-4">
    <!-- Заголовок -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h2 class="text-2xl font-bold text-white">Посещаемость</h2>
            <p class="mt-1 text-sm text-gray-400">Управление посещаемостью и активностью студентов на уроках</p>
        </div>
    </div>

    <!-- Список уроков и посещений -->
    <div class="space-y-4">
        <?php if (isset($lessons) && is_array($lessons)): ?>
            <?php foreach ($lessons as $lesson): ?>
                <div class="bg-gray-800 rounded-lg shadow-lg overflow-hidden">
                    <!-- Заголовок урока (кликабельный для сворачивания/разворачивания) -->
                    <div class="p-4 bg-gray-700 cursor-pointer hover:bg-gray-600 transition-colors duration-150 flex justify-between items-center lesson-header" 
                         data-lesson-id="<?php echo $lesson['id']; ?>"
                         onclick="toggleLessonDetails(<?php echo $lesson['id']; ?>)">
                        <div class="flex items-center space-x-6 p-4 bg-gradient-to-r from-gray-800 to-gray-700 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300">
                            <!-- Иконка календаря -->
                            <div class="flex-shrink-0 w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center shadow-lg transform hover:scale-105 transition-transform duration-300">
                                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <div class="flex-1">
                                <h3 class="text-xl font-bold text-white mb-2 hover:text-blue-400 transition-colors duration-300"><?php echo htmlspecialchars($lesson['title']); ?></h3>
                                <div class="flex flex-wrap gap-4 text-sm text-gray-300">
                                    <div class="flex items-center bg-gray-700/50 px-3 py-1 rounded-lg hover:bg-gray-700 transition-colors duration-300">
                                        <svg class="w-4 h-4 mr-2 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <?php echo htmlspecialchars($lesson['datetime']); ?>
                                    </div>
                                    <div class="flex items-center bg-gray-700/50 px-3 py-1 rounded-lg hover:bg-gray-700 transition-colors duration-300">
                                        <svg class="w-4 h-4 mr-2 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                        </svg>
                                        Группа: <?php echo htmlspecialchars($lesson['group']); ?>
                                    </div>
                                    <div class="flex items-center bg-gray-700/50 px-3 py-1 rounded-lg hover:bg-gray-700 transition-colors duration-300">
                                        <svg class="w-4 h-4 mr-2 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                        <?php echo htmlspecialchars($lesson['speaker']); ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Иконка стрелки -->
                        <svg class="w-6 h-6 text-gray-400 transform transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </div>

                    <!-- Список студентов (скрытый по умолчанию) -->
                    <div id="lesson-details-<?php echo $lesson['id']; ?>" class="hidden">
                        <div class="p-4">
                            <div class="overflow-x-auto">
                                <table class="w-full text-sm text-left text-gray-400">
                                    <thead class="text-xs uppercase bg-gray-700 text-gray-400">
                                        <tr>
                                            <th scope="col" class="px-6 py-3 rounded-l-lg">Студент</th>
                                            <th scope="col" class="px-6 py-3">Статус</th>
                                            <th scope="col" class="px-6 py-3">Баллы за активность</th>
                                            <th scope="col" class="px-6 py-3 rounded-r-lg">Действия</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (isset($lesson['students']) && is_array($lesson['students'])): ?>
                                            <?php foreach ($lesson['students'] as $student): ?>
                                                <tr class="border-b bg-gray-800 border-gray-700">
                                                    <td class="px-6 py-4 font-medium text-white">
                                                        <?php echo htmlspecialchars($student['name']); ?>
                                                    </td>
                                                    <td class="px-6 py-4">
                                                        <div class="flex items-center">
                                                            <input type="checkbox" 
                                                                   class="w-4 h-4 text-blue-600 rounded focus:ring-blue-600 ring-offset-gray-800 bg-gray-700 border-gray-600"
                                                                   <?php echo isset($student['attended']) && $student['attended'] ? 'checked' : ''; ?>
                                                                   onchange="updateAttendance(event, <?php echo $lesson['id']; ?>, <?php echo $student['id']; ?>, this.checked)">
                                                            <label class="ml-2 text-sm font-medium text-gray-300">
                                                                <?php if (isset($student['attended']) && $student['attended']): ?>
                                                                    <span class="flex items-center text-green-500">
                                                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                                        </svg>
                                                                        Присутствовал
                                                                    </span>
                                                                <?php else: ?>
                                                                    <span class="flex items-center text-red-500">
                                                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                                        </svg>
                                                                        Отсутствовал
                                                                    </span>
                                                                <?php endif; ?>
                                                            </label>
                                                        </div>
                                                    </td>
                                                    <td class="px-6 py-4">
                                                        <div class="flex items-center">
                                                            <svg class="w-4 h-4 mr-1 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                            </svg>
                                                            <?php echo isset($student['activity_points']) ? htmlspecialchars($student['activity_points']) : '0'; ?> баллов
                                                        </div>
                                                    </td>
                                                    <td class="px-6 py-4">
                                                        <button type="button" 
                                                                onclick="openPointsModal(<?php echo $lesson['id']; ?>, <?php echo $student['id']; ?>)"
                                                                class="flex items-center text-blue-500 hover:text-blue-400">
                                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                                            </svg>
                                                            Добавить баллы
                                                        </button>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <tr>
                                                <td colspan="4" class="px-6 py-4 text-center">Нет студентов в группе</td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="text-center text-gray-400 py-8">
                <svg class="mx-auto w-12 h-12 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <p class="text-lg">Нет доступных уроков</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Модальное окно для добавления/редактирования баллов -->
<div id="pointsModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-gray-800">
        <div class="mt-3">
            <h3 class="text-lg leading-6 font-medium text-white mb-4">Управление баллами</h3>
            <form id="pointsForm" onsubmit="savePoints(event)">
                <input type="hidden" id="lessonId" name="lessonId">
                <input type="hidden" id="studentId" name="studentId">
                
                <div class="mb-4">
                    <label class="block text-white text-sm font-bold mb-2" for="points">
                        Количество баллов
                    </label>
                    <input type="number" 
                           id="points" 
                           name="points" 
                           min="0" 
                           max="100" 
                           required
                           class="bg-gray-700 border border-gray-600 text-white text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                </div>

                <div class="flex justify-end gap-2">
                    <button type="button" 
                            onclick="closePointsModal()"
                            class="text-gray-300 bg-gray-700 hover:bg-gray-600 focus:ring-4 focus:ring-gray-600 rounded-lg text-sm px-5 py-2.5">
                        Отмена
                    </button>
                    <button type="submit" 
                            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 rounded-lg text-sm px-5 py-2.5">
                        Сохранить
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Функция для сворачивания/разворачивания деталей урока
function toggleLessonDetails(lessonId) {
    const detailsElement = document.getElementById(`lesson-details-${lessonId}`);
    const headerElement = document.querySelector(`[data-lesson-id="${lessonId}"]`);
    const arrowIcon = headerElement.querySelector('svg');
    
    if (detailsElement.classList.contains('hidden')) {
        detailsElement.classList.remove('hidden');
        arrowIcon.classList.add('rotate-180');
    } else {
        detailsElement.classList.add('hidden');
        arrowIcon.classList.remove('rotate-180');
    }
}

// Функция для обновления статуса посещаемости
function updateAttendance(event, lessonId, studentId, attended) {
    fetch('/admin/attendance/update', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            lessonId: lessonId,
            studentId: studentId,
            attended: attended
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Обновляем текст статуса
            const label = event.target.nextElementSibling;
            if (attended) {
                label.innerHTML = `
                    <span class="flex items-center text-green-500">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Присутствовал
                    </span>`;
            } else {
                label.innerHTML = `
                    <span class="flex items-center text-red-500">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                        Отсутствовал
                    </span>`;
            }
        } else {
            alert(data.message || 'Произошла ошибка при обновлении статуса');
            // Возвращаем чекбокс в предыдущее состояние
            event.target.checked = !attended;
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Произошла ошибка при обновлении статуса');
        // Возвращаем чекбокс в предыдущее состояние
        event.target.checked = !attended;
    });
}

// Функции для работы с модальным окном баллов
function openPointsModal(lessonId, studentId) {
    document.getElementById('lessonId').value = lessonId;
    document.getElementById('studentId').value = studentId;
    document.getElementById('pointsModal').classList.remove('hidden');
}

function closePointsModal() {
    document.getElementById('pointsModal').classList.add('hidden');
    document.getElementById('pointsForm').reset();
}

// Функция сохранения баллов
function savePoints(event) {
    event.preventDefault();
    
    const formData = {
        lessonId: document.getElementById('lessonId').value,
        studentId: document.getElementById('studentId').value,
        points: document.getElementById('points').value
    };

    fetch('/admin/attendance/points', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(formData)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            closePointsModal();
            // Перезагружаем страницу для обновления данных
            location.reload();
        } else {
            alert(data.message || 'Произошла ошибка при сохранении баллов');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Произошла ошибка при сохранении баллов');
    });
}
</script>

<?php
$content = ob_get_clean();
require_once __DIR__ . '/layouts/sidebar.php';
?>