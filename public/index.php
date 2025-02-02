<?php
// Проверяем, является ли запрос AJAX
$isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && 
          strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';

// Настраиваем отображение ошибок
error_reporting(E_ALL);
if ($isAjax) {
    // Для AJAX-запросов отключаем отображение ошибок
    ini_set('display_errors', 0);
} else {
    // Для обычных запросов включаем в режиме разработки
    ini_set('display_errors', 1);
}

// Запускаем сессию
session_start();

// Определяем корневую директорию
define('ROOT', dirname(__DIR__) . DIRECTORY_SEPARATOR);

// Подключаем автозагрузчик Composer
require_once ROOT . 'vendor/autoload.php';

// Создаем экземпляр маршрутизатора
$router = new \App\Core\Router();

// Загружаем маршруты
$routes = require ROOT . 'app/Config/routes.php';
foreach ($routes as $route => $params) {
    $router->add($route, $params);
}

// Запускаем маршрутизацию
$router->dispatch($_SERVER['REQUEST_URI']);
?>
