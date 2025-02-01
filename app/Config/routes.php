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
    ]
];
