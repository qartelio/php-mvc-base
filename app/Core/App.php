<?php
namespace App\Core;

class App {
    protected $controller = 'HomeController';
    protected $method = 'index';
    protected $params = [];

    public function __construct() {
        $url = $this->parseUrl();

        // Проверяем существование контроллера
        if (isset($url[0])) {
            $controllerName = ucfirst($url[0]) . 'Controller';
            if (file_exists('../app/Controllers/' . $controllerName . '.php')) {
                $this->controller = $controllerName;
                unset($url[0]);
            }
        }

        // Подключаем контроллер
        require_once '../app/Controllers/' . $this->controller . '.php';
        $this->controller = "\\App\\Controllers\\" . $this->controller;
        $this->controller = new $this->controller;

        // Проверяем метод
        if (isset($url[1])) {
            if (method_exists($this->controller, $url[1])) {
                $this->method = $url[1];
                unset($url[1]);
            }
        }

        // Получаем параметры
        $this->params = $url ? array_values($url) : [];

        // Вызываем метод контроллера с параметрами
        call_user_func_array([$this->controller, $this->method], $this->params);
    }

    // Разбор URL
    public function parseUrl() {
        if (isset($_GET['url'])) {
            return explode('/', filter_var(rtrim($_GET['url'], '/'), FILTER_SANITIZE_URL));
        }
        return [];
    }
}
