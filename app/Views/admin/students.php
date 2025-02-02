<?php
ob_start();
?>

<div class="p-4">
    <!-- Заголовок и кнопка добавления -->
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-2xl font-bold text-white">Студенты</h2>
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
                <input type="text" id="search" name="search" value="<?= htmlspecialchars($filters['search'] ?? '') ?>"
                    class="block w-full p-2 ps-10 text-sm border rounded-lg bg-gray-700 border-gray-600 placeholder-gray-400 text-white"
                    placeholder="Поиск по имени или email">
            </div>
        </div>
        <div class="w-full md:w-64">
            <select id="group_filter" name="group_id"
                class="block w-full p-2 text-sm border rounded-lg bg-gray-700 border-gray-600 placeholder-gray-400 text-white">
                <option value="">Все группы</option>
                <?php foreach ($groups as $group): ?>
                <option value="<?= $group['id'] ?>" <?= ($filters['group_id'] ?? '') == $group['id'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($group['name']) ?>
                </option>
                <?php endforeach; ?>
            </select>
        </div>
        <button id="reset_filters" type="button"
            class="px-4 py-2 text-sm font-medium rounded-lg bg-gray-700 border-gray-600 text-white hover:bg-gray-600">
            Сбросить фильтры
        </button>
    </div>

    <!-- Таблица студентов -->
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left text-gray-400">
            <thead class="text-xs uppercase bg-gray-700 text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">Имя</th>
                    <th scope="col" class="px-6 py-3">Email</th>
                    <th scope="col" class="px-6 py-3">Группа</th>
                    <th scope="col" class="px-6 py-3">Баллы</th>
                    <th scope="col" class="px-6 py-3">Статус</th>
                    <th scope="col" class="px-6 py-3">Дата регистрации</th>
                    <th scope="col" class="px-6 py-3">Действия</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($students as $student): ?>
                <tr class="border-b bg-gray-800 border-gray-700">
                    <td class="px-6 py-4 font-medium text-white" data-phone="<?= $student['phone'] ?>">
                        <?= htmlspecialchars($student['name']) ?>
                    </td>
                    <td class="px-6 py-4">
                        <?= htmlspecialchars($student['email']) ?>
                    </td>
                    <td class="px-6 py-4" data-group-id="<?= $student['group_id'] ?>">
                        <?= 'Группа ' . ($student['group_id'] ?? 'Не указана') ?>
                    </td>
                    <td class="px-6 py-4">
                        <?= number_format($student['total_points_cache'] ?? 0) ?>
                    </td>
                    <td class="px-6 py-4">
                        <span class="px-2 py-1 text-xs font-medium rounded-full <?= $student['is_active'] ? 'bg-green-900 text-green-300' : 'bg-red-900 text-red-300' ?>">
                            <?= $student['is_active'] ? 'Активен' : 'Заблокирован' ?>
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <?= date('d.m.Y H:i', strtotime($student['created_at'])) ?>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex gap-2">
                            <button type="button" data-student-id="<?= $student['id'] ?>"
                                class="edit-student text-blue-500 hover:text-blue-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                            </button>
                            <button type="button" data-student-id="<?= $student['id'] ?>"
                                class="toggle-status <?= $student['is_active'] ? 'text-red-500 hover:text-red-400' : 'text-green-500 hover:text-green-400' ?>">
                                <?php if ($student['is_active']): ?>
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                                </svg>
                                <?php else: ?>
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <?php endif; ?>
                            </button>
                            <button type="button" data-student-id="<?= $student['id'] ?>"
                                class="delete-student text-red-500 hover:text-red-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Пагинация -->
    <?php if ($pagination['last_page'] > 1): ?>
    <div class="flex justify-center mt-4">
        <nav class="flex items-center gap-2">
            <?php for ($i = 1; $i <= $pagination['last_page']; $i++): ?>
            <a href="?page=<?= $i ?><?= !empty($filters['group_id']) ? '&group_id=' . $filters['group_id'] : '' ?><?= !empty($filters['search']) ? '&search=' . urlencode($filters['search']) : '' ?>"
                class="px-3 py-1 rounded-lg <?= $i == $pagination['current_page'] ? 'bg-blue-600 text-white' : 'bg-gray-700 text-gray-400 hover:bg-gray-600' ?>">
                <?= $i ?>
            </a>
            <?php endfor; ?>
        </nav>
    </div>
    <?php endif; ?>
</div>

<!-- Модальное окно редактирования -->
<div id="editModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
    <div class="bg-gray-800 p-6 rounded-lg w-full max-w-md">
        <h3 class="text-xl font-bold text-white mb-4">Редактирование студента</h3>
        <form id="editForm" class="space-y-4">
            <input type="hidden" name="id" id="edit_id">
            
            <div>
                <label for="edit_name" class="block text-sm font-medium text-gray-400">Имя</label>
                <input type="text" id="edit_name" name="name" class="mt-1 block w-full rounded-md bg-gray-700 border-gray-600 text-white">
            </div>
            
            <div>
                <label for="edit_email" class="block text-sm font-medium text-gray-400">Email</label>
                <input type="email" id="edit_email" name="email" class="mt-1 block w-full rounded-md bg-gray-700 border-gray-600 text-white">
            </div>
            
            <div>
                <label for="edit_phone" class="block text-sm font-medium text-gray-400">Телефон</label>
                <input type="tel" id="edit_phone" name="phone" class="mt-1 block w-full rounded-md bg-gray-700 border-gray-600 text-white">
            </div>
            
            <div>
                <label for="edit_group" class="block text-sm font-medium text-gray-400">Группа</label>
                <select id="edit_group" name="group_id" class="mt-1 block w-full rounded-md bg-gray-700 border-gray-600 text-white">
                    <option value="">Выберите группу</option>
                    <?php foreach ($groups as $group): ?>
                    <option value="<?= $group['id'] ?>"><?= htmlspecialchars($group['name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <div class="flex justify-end space-x-3 mt-6">
                <button type="button" id="closeEditModal" class="px-4 py-2 text-sm font-medium rounded-lg bg-gray-700 text-white hover:bg-gray-600">
                    Отмена
                </button>
                <button type="submit" class="px-4 py-2 text-sm font-medium rounded-lg bg-blue-600 text-white hover:bg-blue-500">
                    Сохранить
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Модальное окно подтверждения -->
<div id="confirmModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
    <div class="bg-gray-800 p-6 rounded-lg w-full max-w-sm">
        <h3 class="text-xl font-bold text-white mb-4" id="confirmTitle"></h3>
        <p class="text-gray-300 mb-4" id="confirmMessage"></p>
        <div class="flex justify-end gap-2">
            <button type="button" onclick="closeConfirmModal()"
                class="px-4 py-2 text-sm font-medium rounded-lg bg-gray-700 border-gray-600 text-white hover:bg-gray-600">
                Отмена
            </button>
            <button type="button" id="confirmAction"
                class="px-4 py-2 text-sm font-medium rounded-lg bg-red-600 text-white hover:bg-red-700">
                Подтвердить
            </button>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Фильтрация и поиск
    const searchInput = document.getElementById('search');
    const groupFilter = document.getElementById('group_filter');
    const resetFilters = document.getElementById('reset_filters');
    
    function applyFilters() {
        const searchValue = searchInput.value;
        const groupValue = groupFilter.value;
        
        let url = '/admin/students';
        const params = new URLSearchParams();
        
        if (searchValue) params.append('search', searchValue);
        if (groupValue) params.append('group_id', groupValue);
        
        if (params.toString()) {
            url += '?' + params.toString();
        }
        
        window.location.href = url;
    }
    
    searchInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            applyFilters();
        }
    });
    
    groupFilter.addEventListener('change', applyFilters);
    
    resetFilters.addEventListener('click', function() {
        window.location.href = '/admin/students';
    });
    
    // Редактирование студента
    const editModal = document.getElementById('editModal');
    const editForm = document.getElementById('editForm');
    const closeEditModal = document.getElementById('closeEditModal');
    
    document.querySelectorAll('.edit-student').forEach(button => {
        button.addEventListener('click', function() {
            const studentId = this.dataset.studentId;
            const row = this.closest('tr');
            
            // Получаем данные из ячеек таблицы
            const name = row.querySelector('td:nth-child(1)').textContent.trim();
            const email = row.querySelector('td:nth-child(2)').textContent.trim();
            const groupText = row.querySelector('td:nth-child(3)').textContent.trim();
            
            // Заполняем форму
            document.getElementById('edit_id').value = studentId;
            document.getElementById('edit_name').value = name;
            document.getElementById('edit_email').value = email;
            
            // Получаем телефон из атрибута data-phone
            const phone = row.querySelector('td:nth-child(1)').getAttribute('data-phone');
            document.getElementById('edit_phone').value = phone;
            
            // Устанавливаем значение группы
            const groupSelect = document.getElementById('edit_group');
            groupSelect.value = row.querySelector('td:nth-child(3)').getAttribute('data-group-id') || '';
            
            editModal.classList.remove('hidden');
        });
    });
    
    closeEditModal.addEventListener('click', function() {
        editModal.classList.add('hidden');
    });
    
    editForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        
        fetch('/admin/students/update', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                window.location.reload();
            } else {
                alert('Ошибка при обновлении данных: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Ошибка:', error);
            alert('Произошла ошибка при обновлении данных');
        });
    });
    
    // Удаление студента
    document.querySelectorAll('.delete-student').forEach(button => {
        button.addEventListener('click', function() {
            const studentId = this.dataset.studentId;
            
            if (confirm('Вы уверены, что хотите удалить этого студента?')) {
                fetch('/admin/students/delete', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: 'id=' + studentId
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        window.location.reload();
                    } else {
                        alert('Ошибка при удалении: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Ошибка:', error);
                    alert('Произошла ошибка при удалении');
                });
            }
        });
    });
});
</script>

<?php
$content = ob_get_clean();
require_once __DIR__ . '/../admin/layouts/sidebar.php';
?>
