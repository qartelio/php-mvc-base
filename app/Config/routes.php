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
    
    // Маршруты для пользователей
    'user/register' => [
        'controller' => 'user',
        'action' => 'register'
    ],
    'user/store' => [
        'controller' => 'user',
        'action' => 'store'
    ],
    'user/login' => [
        'controller' => 'user',
        'action' => 'login'
    ],
    'user/authenticate' => [
        'controller' => 'user',
        'action' => 'authenticate'
    ],
    'user/profile' => [
        'controller' => 'user',
        'action' => 'profile'
    ],
    'user/logout' => [
        'controller' => 'user',
        'action' => 'logout'
    ],
    
    // Маршруты для учителей
    'teacher/registration' => [
        'controller' => 'teacher',
        'action' => 'showRegistration'
    ],
    'teacher/register' => [
        'controller' => 'teacher',
        'action' => 'register'
    ],
    'teacher/login' => [
        'controller' => 'teacher',
        'action' => 'showLogin'
    ],
    'teacher/authenticate' => [
        'controller' => 'teacher',
        'action' => 'login'
    ],
    'teacher/dashboard' => [
        'controller' => 'teacher',
        'action' => 'dashboard'
    ]
];
