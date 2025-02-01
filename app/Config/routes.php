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
    'admin/lessons' => [
        'controller' => 'admin',
        'action' => 'lessons',
        'middleware' => ['AdminAuth']
    ],
    'admin/students' => [
        'controller' => 'admin',
        'action' => 'students',
        'middleware' => ['AdminAuth']
    ],
];
