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
        if (file_exists('../app/Views/' . $view . '.php')) {
            require_once '../app/Views/' . $view . '.php';
        } else {
            die('Представление не найдено');
        }
    }
}
