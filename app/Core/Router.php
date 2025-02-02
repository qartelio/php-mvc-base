<?php
namespace App\Core;

use App\Core\Database;

class Router {
    private $routes = [];
    private $params = [];

    /**
     * Добавить маршрут
     */
    public function add($route, $params = []) {
        // Преобразуем маршрут в регулярное выражение
        $route = preg_replace('/\//', '\\/', $route);
        
        // Поддержка числовых параметров
        $route = preg_replace('/\(([0-9]+)\)/', '(\d+)', $route);
        
        // Поддержка именованных параметров
        $route = preg_replace('/\{([a-z]+)\}/', '(?P<\1>[^\/]+)', $route);
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
                // Добавляем числовые параметры
                foreach ($matches as $key => $match) {
                    if (is_string($key)) {
                        $params[$key] = $match;
                    } elseif (is_numeric($key) && $key > 0) {
                        // Добавляем числовой параметр в params
                        $params['id'] = $match;
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
                // Получаем соединение с базой данных
                $db = Database::getInstance()->getConnection();
                $controller_object = new $controller($db);

                $action = $this->params['action'] ?? 'index';
                $action = $this->convertToCamelCase($action);

                if (method_exists($controller_object, $action)) {
                    // Передаем параметры в метод контроллера
                    return $controller_object->$action($this->params);
                }
            }
        }
        
        // Проверяем, является ли запрос AJAX
        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && 
            strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            header('Content-Type: application/json');
            http_response_code(404);
            echo json_encode([
                'success' => false,
                'message' => 'Маршрут не найден'
            ]);
        } else {
            // Для обычных запросов показываем HTML страницу 404
            header("HTTP/1.0 404 Not Found");
            echo "Страница не найдена";
        }
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
