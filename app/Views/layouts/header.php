<?php
session_start();
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Система управления обучением</title>
    <!-- Подключаем Tailwind CSS через CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-900 text-white">
    <nav class="bg-gray-800 shadow-lg">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between h-16">
                <div class="flex">
                    <div class="flex-shrink-0 flex items-center">
                        <a href="/" class="text-xl font-bold">LMS</a>
                    </div>
                    <div class="hidden md:ml-6 md:flex md:space-x-8">
                        <a href="/" class="inline-flex items-center px-1 pt-1 text-sm font-medium text-white">Главная</a>
                        <?php if (!isset($_SESSION['teacher_id'])): ?>
                            <a href="/teacher/login" class="inline-flex items-center px-1 pt-1 text-sm font-medium text-gray-300 hover:text-white">Вход</a>
                            <a href="/teacher/registration" class="inline-flex items-center px-1 pt-1 text-sm font-medium text-gray-300 hover:text-white">Регистрация</a>
                        <?php else: ?>
                            <a href="/teacher/dashboard" class="inline-flex items-center px-1 pt-1 text-sm font-medium text-gray-300 hover:text-white">Панель управления</a>
                            <a href="/teacher/logout" class="inline-flex items-center px-1 pt-1 text-sm font-medium text-gray-300 hover:text-white">Выход</a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </nav>
