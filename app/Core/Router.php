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
            $controllerPath = $this->params['controller'];
            $controllerParts = explode('/', $controllerPath);
            
            // Преобразуем каждую часть пути в StudlyCaps
            $controllerParts = array_map([$this, 'convertToStudlyCaps'], $controllerParts);
            
            // Последняя часть - это имя контроллера
            $controllerName = array_pop($controllerParts) . 'Controller';
            
            // Если есть подпапки, добавляем их к пространству имен
            $namespace = 'App\\Controllers\\' . implode('\\', $controllerParts);
            if (!empty($controllerParts)) {
                $namespace .= '\\';
            }
            
            $controller = $namespace . $controllerName;

            if (class_exists($controller)) {
                // Получаем соединение с базой данных
                $db = Database::getInstance()->getConnection();
                $controller_object = new $controller($db);

                $action = $this->params['action'] ?? 'index';
                $action = $this->convertToCamelCase($action);

                if (method_exists($controller_object, $action)) {
                    // Передаем параметры в метод контроллера
                    return $controller_object->$action($this->params);
                } else {
                    // Метод не найден
                    if ($this->isAjaxRequest()) {
                        $this->sendJsonResponse(false, 'Метод не найден', 404);
                    } else {
                        $this->show404();
                    }
                }
            } else {
                // Контроллер не найден
                if ($this->isAjaxRequest()) {
                    $this->sendJsonResponse(false, 'Контроллер не найден', 404);
                } else {
                    $this->show404();
                }
            }
        } else {
            // Маршрут не найден
            if ($this->isAjaxRequest()) {
                $this->sendJsonResponse(false, 'Маршрут не найден', 404);
            } else {
                $this->show404();
            }
        }
    }

    /**
     * Проверяет, является ли запрос AJAX
     */
    private function isAjaxRequest() {
        return !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && 
               strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
    }

    /**
     * Отправляет JSON-ответ
     */
    private function sendJsonResponse($success, $message, $statusCode = 200) {
        header('Content-Type: application/json');
        http_response_code($statusCode);
        echo json_encode([
            'success' => $success,
            'message' => $message
        ]);
        exit;
    }

    /**
     * Показывает страницу 404
     */
    private function show404() {
        header("HTTP/1.0 404 Not Found");
        echo "Страница не найдена";
        exit;
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
