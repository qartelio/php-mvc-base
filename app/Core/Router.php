<?php
namespace App\Core;

class Router {
    private $routes = [];
    private $params = [];

    /**
     * Добавить маршрут
     */
    public function add($route, $params = []) {
        // Преобразуем маршрут в регулярное выражение
        $route = preg_replace('/\//', '\\/', $route);
        $route = preg_replace('/\{([a-z]+)\}/', '(?P<\1>[a-z-]+)', $route);
        $route = preg_replace('/\{([a-z]+):([^\}]+)\}/', '(?P<\1>\2)', $route);
        $route = '/^' . $route . '$/i';

        $this->routes[$route] = $params;
    }

    /**
     * Найти совпадающий маршрут
     */
    public function match($url) {
        foreach ($this->routes as $route => $params) {
            if (preg_match($route, $url, $matches)) {
                foreach ($matches as $key => $match) {
                    if (is_string($key)) {
                        $params[$key] = $match;
                    }
                }
                $this->params = $params;
                return true;
            }
        }
        return false;
    }

    /**
     * Получить параметры текущего маршрута
     */
    public function getParams() {
        return $this->params;
    }

    /**
     * Разобрать URL
     */
    public function parseUrl() {
        if (isset($_GET['url'])) {
            return rtrim($_GET['url'], '/');
        }
        return '';
    }

    /**
     * Диспетчер маршрутов
     */
    public function dispatch($url) {
        $url = $this->parseUrl();
        
        if ($this->match($url)) {
            $controller = $this->params['controller'];
            $controller = $this->convertToStudlyCaps($controller);
            $controller = "App\\Controllers\\{$controller}Controller";

            if (class_exists($controller)) {
                $controller_object = new $controller();

                $action = $this->params['action'] ?? 'index';
                $action = $this->convertToCamelCase($action);

                if (method_exists($controller_object, $action)) {
                    return $controller_object->$action();
                }
            }
        }
        
        // Если маршрут не найден, показываем 404
        header("HTTP/1.0 404 Not Found");
        echo "Страница не найдена";
    }

    /**
     * Преобразовать строку в StudlyCaps
     * например: post-authors => PostAuthors
     */
    private function convertToStudlyCaps($string) {
        return str_replace(' ', '', ucwords(str_replace('-', ' ', $string)));
    }

    /**
     * Преобразовать строку в camelCase
     * например: add-new => addNew
     */
    private function convertToCamelCase($string) {
        return lcfirst($this->convertToStudlyCaps($string));
    }
}
