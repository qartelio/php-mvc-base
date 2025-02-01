<?php
namespace App\Core;

class View {
    public function render($view, $data = []) {
        // Начинаем буферизацию вывода
        ob_start();
        
        // Извлекаем данные в переменные
        extract($data);
        
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
