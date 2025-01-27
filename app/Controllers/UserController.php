<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Services\UserService;
use App\Repositories\UserRepository;
use Exception;

class UserController extends Controller {
    private $userService;

    public function __construct() {
        // Инициализируем сервис с репозиторием
        $this->userService = new UserService(new UserRepository());
    }

    /**
     * Страница регистрации
     */
    public function register() {
        $this->view('user/register');
    }

    /**
     * Обработка регистрации
     */
    public function store() {
        try {
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                throw new Exception('Метод не поддерживается');
            }

            $userData = [
                'email' => $_POST['email'] ?? '',
                'password' => $_POST['password'] ?? '',
                'name' => $_POST['name'] ?? ''
            ];

            $userId = $this->userService->register($userData);
            
            // Перенаправляем на страницу входа
            header('Location: /user/login');
            exit;
        } catch (Exception $e) {
            $this->view('user/register', [
                'error' => $e->getMessage(),
                'old' => $userData
            ]);
        }
    }

    /**
     * Страница входа
     */
    public function login() {
        $this->view('user/login');
    }

    /**
     * Обработка входа
     */
    public function authenticate() {
        try {
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                throw new Exception('Метод не поддерживается');
            }

            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';

            $user = $this->userService->authenticate($email, $password);
            
            // Начинаем сессию и сохраняем данные пользователя
            session_start();
            $_SESSION['user'] = $user->toArray();
            
            // Перенаправляем на главную страницу
            header('Location: /');
            exit;
        } catch (Exception $e) {
            $this->view('user/login', [
                'error' => $e->getMessage(),
                'email' => $email
            ]);
        }
    }

    /**
     * Выход из системы
     */
    public function logout() {
        session_start();
        session_destroy();
        header('Location: /');
        exit;
    }

    /**
     * Профиль пользователя
     */
    public function profile() {
        session_start();
        if (!isset($_SESSION['user'])) {
            header('Location: /user/login');
            exit;
        }

        $user = $this->userService->getById($_SESSION['user']['id']);
        $this->view('user/profile', ['user' => $user]);
    }
}
