<?php
/**
 * Конфигурация маршрутов
 */

return [
    // Главная страница
    '' => [
        'controller' => 'home',
        'action' => 'index'
    ],

    // Маршруты для студентов
    'student/register' => [
        'controller' => 'student',
        'action' => 'showRegister'
    ],
    'student/store' => [
        'controller' => 'student',
        'action' => 'store'
    ],
    'student/login' => [
        'controller' => 'student',
        'action' => 'showLogin'
    ],
    'student/authenticate' => [
        'controller' => 'student',
        'action' => 'login'
    ],
    'student/dashboard' => [
        'controller' => 'student',
        'action' => 'dashboard'
    ],
    'student/logout' => [
        'controller' => 'student',
        'action' => 'logout'
    ],
    
    // Маршруты для уроков студентов
    'student/lessons' => [
        'controller' => 'student/lessons',
        'action' => 'index',
        'middleware' => ['StudentAuth']
    ],
    'student/lessons/attend' => [
        'controller' => 'student/lessons',
        'action' => 'attend',
        'middleware' => ['StudentAuth']
    ],

    // Профиль студента
    'student/profile' => [
        'controller' => 'student/profile',
        'action' => 'index',
        'middleware' => ['StudentAuth']
    ],
    'student/profile/update' => [
        'controller' => 'student/profile',
        'action' => 'update',
        'middleware' => ['StudentAuth']
    ],
    'student/profile/update-avatar' => [
        'controller' => 'student/profile',
        'action' => 'updateAvatar',
        'middleware' => ['StudentAuth']
    ],
    'student/profile/change-password' => [
        'controller' => 'student/profile',
        'action' => 'changePassword',
        'middleware' => ['StudentAuth']
    ],

    // Маршруты для администраторов
    'admin/register' => [
        'controller' => 'admin',
        'action' => 'showRegister'
    ],
    'admin/register/store' => [
        'controller' => 'admin',
        'action' => 'register'
    ],
    'admin/login' => [
        'controller' => 'admin',
        'action' => 'showLogin'
    ],
    'admin/login/auth' => [
        'controller' => 'admin',
        'action' => 'login'
    ],
    'admin' => [
        'controller' => 'admin',
        'action' => 'dashboard',
        'middleware' => ['AdminAuth']
    ],
    'admin/dashboard' => [
        'controller' => 'admin',
        'action' => 'dashboard',
        'middleware' => ['AdminAuth']
    ],
    'admin/logout' => [
        'controller' => 'admin',
        'action' => 'logout'
    ],

    // Маршруты для управления студентами
    'admin/students' => [
        'controller' => 'admin',
        'action' => 'students',
        'middleware' => ['AdminAuth']
    ],

    // Маршруты для управления уроками
    'admin/lessons' => [
        'controller' => 'admin/lessons',
        'action' => 'index',
        'middleware' => ['AdminAuth']
    ],
    'admin/lessons/create' => [
        'controller' => 'admin/lessons',
        'action' => 'create',
        'middleware' => ['AdminAuth']
    ],
    'admin/lessons/update' => [
        'controller' => 'admin/lessons',
        'action' => 'update',
        'middleware' => ['AdminAuth']
    ],
    'admin/lessons/delete/([0-9]+)' => [
        'controller' => 'admin/lessons',
        'action' => 'delete',
        'middleware' => ['AdminAuth']
    ],

    // Маршруты для управления посещаемостью
    'admin/attendance' => [
        'controller' => 'admin/attendance',
        'action' => 'index',
        'middleware' => ['AdminAuth']
    ],
    'admin/attendance/update' => [
        'controller' => 'admin/attendance',
        'action' => 'updateAttendance',
        'middleware' => ['AdminAuth']
    ],
    'admin/attendance/points' => [
        'controller' => 'admin/attendance',
        'action' => 'managePoints',
        'middleware' => ['AdminAuth']
    ]
];
