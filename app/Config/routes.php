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
    ]
];
