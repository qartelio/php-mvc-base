<?php
namespace App\Core;

class Controller {
    protected $db;
    protected $view;

    public function __construct($db = null) {
        $this->db = $db;
        $this->view = new View();
    }

    // Загрузка модели
    public function model($model) {
        require_once '../app/Models/' . $model . '.php';
        $model = "\\App\\Models\\" . $model;
        return new $model();
    }

    // Загрузка представления
    public function view($view, $data = []) {
        // Отладочная информация
        error_log('Loading view: ' . $view);
        error_log('Data passed to view: ' . print_r($data, true));
        
        // Начинаем буферизацию вывода
        ob_start();
        
        // Извлекаем переменные из массива данных
        if (!empty($data)) {
            extract($data);
            error_log('Extracted variables: ' . implode(', ', array_keys($data)));
        }
        
        // Подключаем файл представления
        $viewPath = '../app/Views/' . $view . '.php';
        error_log('View path: ' . $viewPath);
        
        if (file_exists($viewPath)) {
            require_once $viewPath;
        } else {
            error_log('View not found: ' . $viewPath);
            die('Представление не найдено');
        }
        
        // Получаем содержимое буфера
        $content = ob_get_clean();
        
        // Подключаем главный шаблон
        $layoutPath = '../app/Views/layouts/main.php';
        if (file_exists($layoutPath)) {
            require_once $layoutPath;
        } else {
            echo $content;
        }
    }

    // Перенаправление
    public function redirect($url) {
        header('Location: ' . $url);
        exit();
    }
}
