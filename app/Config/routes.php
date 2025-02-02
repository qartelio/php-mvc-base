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

    // Маршруты для администраторов
    'admin' => [
        'controller' => 'admin',
        'action' => 'dashboard',
        'middleware' => ['AdminAuth']
    ],
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
    'admin/logout' => [
        'controller' => 'admin',
        'action' => 'logout'
    ],
    'admin/dashboard' => [
        'controller' => 'admin',
        'action' => 'dashboard',
        'middleware' => ['AdminAuth']
    ],
    'admin/attendance' => [
        'controller' => 'admin',
        'action' => 'attendance',
        'middleware' => ['AdminAuth']
    ],

    // Маршруты для уроков
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

    // Маршрут для студентов
    'admin/students' => [
        'controller' => 'admin',
        'action' => 'students',
        'middleware' => ['AdminAuth']
    ],
];
