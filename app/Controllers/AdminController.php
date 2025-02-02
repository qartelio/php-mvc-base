<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Administrator;

class AdminController extends Controller {
    private $model;

    public function __construct() {
        parent::__construct();
        $this->model = new Administrator();
    }

    /**
     * Показать форму регистрации
     */
    public function showRegister() {
        $this->view->render('admin/auth/register');
    }

    /**
     * Показать форму входа
     */
    public function showLogin() {
        $this->view->render('admin/auth/login');
    }

    /**
     * Регистрация нового администратора
     */
    public function register() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /admin/register');
            exit;
        }

        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $passwordConfirm = $_POST['password_confirm'] ?? '';

        // Валидация
        if (empty($name) || empty($email) || empty($password)) {
            $_SESSION['error'] = 'Все поля обязательны для заполнения';
            header('Location: /admin/register');
            exit;
        }

        if ($password !== $passwordConfirm) {
            $_SESSION['error'] = 'Пароли не совпадают';
            header('Location: /admin/register');
            exit;
        }

        if ($this->model->findByEmail($email)) {
            $_SESSION['error'] = 'Администратор с таким email уже существует';
            header('Location: /admin/register');
            exit;
        }

        // Создание администратора
        if ($this->model->create([
            'name' => $name,
            'email' => $email,
            'password' => $password
        ])) {
            $this->login(); // Автоматический вход после регистрации
        } else {
            $_SESSION['error'] = 'Ошибка при регистрации';
            header('Location: /admin/register');
            exit;
        }
    }

    /**
     * Авторизация администратора
     */
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';
            $remember = isset($_POST['remember']);

            $admin = $this->model->findByEmail($email);

            if ($admin && password_verify($password, $admin['password'])) {
                $_SESSION['admin_id'] = $admin['id'];
                $_SESSION['admin_name'] = $admin['name'];

                if ($remember) {
                    $token = bin2hex(random_bytes(32));
                    $this->model->updateRememberToken($admin['id'], $token);
                    setcookie('remember_token', $token, time() + (365 * 24 * 60 * 60), '/', '', true, true);
                }

                header('Location: /admin/dashboard');
                exit;
            }

            $_SESSION['error'] = 'Неверный email или пароль';
            header('Location: /admin/login');
            exit;
        }
    }

    /**
     * Выход из системы
     */
    public function logout() {
        unset($_SESSION['admin_id']);
        unset($_SESSION['admin_name']);
        setcookie('remember_token', '', time() - 3600, '/');
        header('Location: /admin/login');
        exit;
    }

    /**
     * Панель управления
     */
    public function dashboard() {
        if (!isset($_SESSION['admin_id'])) {
            header('Location: /admin/login');
            exit;
        }
        $this->view->render('admin/dashboard');
    }

    /**
     * Страница посещаемости
     */
    public function attendance() {
        if (!isset($_SESSION['admin_id'])) {
            header('Location: /admin/login');
            exit;
        }
        $this->view->render('admin/attendance');
    }

    /**
     * Страница студентов
     */
    public function students() {
        if (!isset($_SESSION['admin_id'])) {
            header('Location: /admin/login');
            exit;
        }
        $this->view->render('admin/students');
    }
}
