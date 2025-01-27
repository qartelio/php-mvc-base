<?php
namespace App\Core;

class Controller {
    // Загрузка модели
    public function model($model) {
        require_once '../app/Models/' . $model . '.php';
        $model = "\\App\\Models\\" . $model;
        return new $model();
    }

    // Загрузка представления
    public function view($view, $data = []) {
        // Начинаем буферизацию вывода
        ob_start();
        
        // Подключаем файл представления
        if (file_exists('../app/Views/' . $view . '.php')) {
            require_once '../app/Views/' . $view . '.php';
        } else {
            die('Представление не найдено');
        }
        
        // Получаем содержимое буфера
        $content = ob_get_clean();
        
        // Подключаем главный шаблон
        if (file_exists('../app/Views/layouts/main.php')) {
            require_once '../app/Views/layouts/main.php';
        } else {
            echo $content;
        }
    }
}
