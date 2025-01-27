<?php
// Включаем отображение ошибок в режиме разработки
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Определяем корневую директорию
define('ROOT', dirname(__DIR__) . DIRECTORY_SEPARATOR);

// Подключаем автозагрузчик Composer
require_once ROOT . 'vendor/autoload.php';

// Подключаем хелпер для работы с сессиями
require_once ROOT . 'app/Helpers/session_helper.php';

// Инициализируем сессию до любого вывода
\App\Core\Session::init();

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
