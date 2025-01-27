<?php
// Включаем отображение ошибок в режиме разработки
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Определяем корневую директорию
define('ROOT', dirname(__DIR__) . DIRECTORY_SEPARATOR);

// Подключаем автозагрузчик Composer
require_once ROOT . 'vendor/autoload.php';

// Запускаем приложение
use App\Core\App;
$app = new App();
?>
