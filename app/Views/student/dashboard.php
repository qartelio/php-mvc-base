<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Личный кабинет</title>
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
        .nav-card {
            transition: all 0.2s ease;
        }
        .nav-card:active {
            transform: scale(0.98);
            background-color: #f8fafc;
        }
        .profile-card {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
        }
    </style>
</head>
<body class="bg-slate-100">
    <div class="app-container">
        <div class="px-4 py-4">
            <!-- Профиль пользователя -->
            <div class="profile-card rounded-2xl shadow-lg p-4 mb-6">
                <div class="flex items-center gap-4">
                    <!-- Фото -->
                    <div class="relative">
                        <div class="w-20 h-20 rounded-full overflow-hidden ring-2 ring-white/50 shadow-lg">
                        <img id="avatar-preview" class="w-full h-full object-cover" 
                             src="<?= !empty($student['avatar']) ? '/public/uploads/avatars/' . htmlspecialchars($student['avatar']) : 'https://flowbite.com/docs/images/people/profile-picture-1.jpg' ?>" 
                             alt="Фото профиля">
                        </div>
                    </div>
                    
                    <!-- Информация -->
                    <div class="flex-1">
                        <h1 class="text-xl font-bold text-white mb-1"><?= htmlspecialchars($student['name']) ?></h1>
                        <div class="inline-flex items-center px-3 py-1 bg-white/20 text-white rounded-full text-sm mb-2">
                            <?= $student['group_id'] ? htmlspecialchars($student['group_id']) . ' группа' : 'Группа не указана' ?>
                        </div>
                        <div class="flex items-center">
                            <div class="bg-white/10 backdrop-blur-sm rounded-lg px-3 py-1.5 flex items-center">
                                <svg class="w-5 h-5 text-yellow-300 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10 2a1 1 0 011 1v1.323l3.954 1.582 1.599-.8a1 1 0 01.894 1.79l-1.233.616 1.738 5.42a1 1 0 01-.285 1.05A3.989 3.989 0 0115 15a3.989 3.989 0 01-2.667-1.019 1 1 0 01-.285-1.05l1.715-5.349L10 6.477 6.237 7.582l1.715 5.349a1 1 0 01-.285 1.05A3.989 3.989 0 015 15a3.989 3.989 0 01-2.667-1.019 1 1 0 01-.285-1.05l1.738-5.42-1.233-.617a1 1 0 01.894-1.788l1.599.799L9 4.323V3a1 1 0 011-1zm-5 8.274l-.818 2.552c.25.112.526.174.818.174.292 0 .569-.062.818-.174L5 10.274zm10 0l-.818 2.552c.25.112.526.174.818.174.292 0 .569-.062.818-.174L15 10.274z"/>
                                </svg>
                                <span class="text-base font-semibold text-white">200 баллов</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Навигационные кнопки -->
            <div class="space-y-3">
                <!-- Уроки -->
                <a href="/student/lessons" class="nav-card bg-white rounded-xl py-3.5 px-4 shadow-lg hover:shadow-xl flex items-center border border-gray-100">
                    <div class="bg-blue-100 p-2.5 rounded-xl nav-icon">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                    </div>
                    <span class="text-base font-semibold text-gray-800 ml-4">Уроки</span>
                    <svg class="w-5 h-5 text-gray-400 ml-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>

                <!-- Профориентация -->
                <a href="#" class="nav-card bg-white rounded-xl py-3.5 px-4 shadow-lg hover:shadow-xl flex items-center border border-gray-100">
                    <div class="bg-green-100 p-2.5 rounded-xl nav-icon">
                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <span class="text-base font-semibold text-gray-800 ml-4">Профориентация</span>
                    <svg class="w-5 h-5 text-gray-400 ml-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>

                <!-- Университеты -->
                <a href="#" class="nav-card bg-white rounded-xl py-3.5 px-4 shadow-lg hover:shadow-xl flex items-center border border-gray-100">
                    <div class="bg-purple-100 p-2.5 rounded-xl nav-icon">
                        <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                    </div>
                    <span class="text-base font-semibold text-gray-800 ml-4">Университеты</span>
                    <svg class="w-5 h-5 text-gray-400 ml-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>

                <!-- Uzdik AI -->
                <a href="#" class="nav-card bg-white rounded-xl py-3.5 px-4 shadow-lg hover:shadow-xl flex items-center border border-gray-100">
                    <div class="bg-red-100 p-2.5 rounded-xl nav-icon">
                        <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                        </svg>
                    </div>
                    <span class="text-base font-semibold text-gray-800 ml-4">Uzdik AI</span>
                    <svg class="w-5 h-5 text-gray-400 ml-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
                <!-- Мои настройки -->
                <a href="/student/profile" class="nav-card bg-white rounded-xl py-3.5 px-4 shadow-lg hover:shadow-xl flex items-center border border-gray-100">
                    <div class="bg-gray-100 p-2.5 rounded-xl nav-icon">
                        <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                    </div>
                    <span class="text-base font-semibold text-gray-800 ml-4">Мои настройки</span>
                    <svg class="w-5 h-5 text-gray-400 ml-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
                <!-- Кнопка выхода -->
                <a href="/student/logout" class="nav-card bg-red-50 rounded-xl py-3.5 px-4 shadow-lg hover:shadow-xl flex items-center border border-red-100">
                    <div class="bg-red-100 p-2.5 rounded-xl nav-icon">
                        <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                    </svg>
                    </div>
                    <span class="text-base font-semibold text-red-600 ml-4">Выйти</span>
                    <svg class="w-5 h-5 text-red-400 ml-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.js"></script>
</body>
</html>
