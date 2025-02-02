<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Уроки</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.css" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            background: #f1f5f9;
            max-width: 100%;
            overflow-x: hidden;
        }
        .app-container {
            max-width: 480px;
            margin: 0 auto;
            background: #ffffff;
            min-height: 100vh;
            position: relative;
        }
        .lesson-card {
            transition: all 0.2s ease;
        }
        .lesson-card:hover {
            transform: translateY(-2px);
        }
    </style>
</head>
<body class="bg-slate-100">
    <div class="app-container">
        <div class="px-4 py-6">
            <!-- Расписание -->
            <div class="mb-8">
                <h2 class="text-xl font-bold text-gray-800 mb-4">Расписание занятий</h2>
                <div class="grid grid-cols-2 gap-4">
                    <!-- Вторник -->
                    <div class="bg-blue-50 rounded-xl p-4 border border-blue-100">
                        <div class="flex items-center mb-2">
                            <svg class="w-5 h-5 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span class="font-semibold text-gray-800">Вторник</span>
                        </div>
                        <p class="text-blue-600 font-bold">20:00</p>
                    </div>
                    <!-- Пятница -->
                    <div class="bg-blue-50 rounded-xl p-4 border border-blue-100">
                        <div class="flex items-center mb-2">
                            <svg class="w-5 h-5 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span class="font-semibold text-gray-800">Пятница</span>
                        </div>
                        <p class="text-blue-600 font-bold">20:00</p>
                    </div>
                </div>
            </div>

            <!-- Список уроков -->
            <h2 class="text-xl font-bold text-gray-800 mb-4">Ближайшие уроки</h2>
            <div class="space-y-4">
                <?php if (!empty($lessons)): ?>
                    <?php foreach ($lessons as $lesson): ?>
                        <!-- Карточка урока -->
                        <div class="lesson-card bg-white rounded-xl p-4 shadow-lg border border-gray-100">
                            <div class="mb-4">
                                <h3 class="text-lg font-bold text-gray-800 mb-2"><?= htmlspecialchars($lesson['title'] ?? 'Без названия') ?></h3>
                                <div class="flex items-center text-gray-600 mb-2">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                    <span><?= htmlspecialchars($lesson['teacher_name'] ?? 'Преподаватель не указан') ?></span>
                                </div>
                                <div class="flex items-center text-gray-600">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    <span><?= $lesson['datetime'] ? date('d.m.Y H:i', strtotime($lesson['datetime'])) : 'Время не указано' ?></span>
                                </div>
                            </div>
                            <?php if (!$lesson['is_active']): ?>
                                <button disabled class="inline-flex items-center justify-center w-full px-4 py-2 bg-gray-400 text-white font-medium rounded-lg cursor-not-allowed">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    Урок пройден
                                </button>
                            <?php else: ?>
                                <button 
                                    onclick="attendLesson(<?= $lesson['id'] ?>, this)"
                                    class="inline-flex items-center justify-center w-full px-4 py-2 <?= $lesson['attended'] ? 'bg-green-600' : 'bg-blue-600' ?> text-white font-medium rounded-lg hover:<?= $lesson['attended'] ? 'bg-green-700' : 'bg-blue-700' ?> transition-colors"
                                    <?= $lesson['attended'] ? 'data-attended="true"' : '' ?>
                                >
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <?php if ($lesson['attended']): ?>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        <?php else: ?>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                        <?php endif; ?>
                                    </svg>
                                    <?= $lesson['attended'] ? 'Зайти повторно' : 'Зайти на урок' ?>
                                </button>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="text-center text-gray-500 py-8">
                        <p>Уроков пока нет</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.js"></script>
    <script>
        function attendLesson(lessonId, button) {
            fetch('/student/lessons/attend', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'lesson_id=' + lessonId
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    if (!button.dataset.attended) {
                        button.classList.remove('bg-blue-600', 'hover:bg-blue-700');
                        button.classList.add('bg-green-600', 'hover:bg-green-700');
                        button.dataset.attended = 'true';
                        
                        // Обновляем иконку
                        const svg = button.querySelector('svg');
                        svg.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>';
                        
                        // Обновляем текст
                        button.lastChild.textContent = 'Зайти повторно';
                    }
                    
                    // Если есть zoom_link, перенаправляем на него
                    if (data.zoom_link) {
                        window.open(data.zoom_link, '_blank');
                    }
                }
                // Показываем сообщение пользователю только если нет zoom_link
                if (!data.zoom_link) {
                    alert(data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Произошла ошибка при записи посещения');
            });
        }
    </script>
</body>
</html>
