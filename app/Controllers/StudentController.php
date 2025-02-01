<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Student;

class StudentController extends Controller {
    private $studentModel;
    
    public function __construct($db = null) {
        parent::__construct($db);
        $this->studentModel = new Student($db);
    }
    
    /**
     * Показ формы регистрации
     */
    public function showRegister() {
        $this->view->render('student/register');
    }
    
    /**
     * Обработка регистрации
     */
    public function store() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /student/register');
            exit;
        }
        
        // Проверка паролей
        if ($_POST['password'] !== $_POST['password_confirmation']) {
            $_SESSION['error'] = 'Пароли не совпадают';
            header('Location: /student/register');
            exit;
        }
        
        $data = [
            'name' => $_POST['name'],
            'phone' => $_POST['phone'],
            'email' => $_POST['email'],
            'group_id' => $_POST['group'] ?? null,
            'password' => $_POST['password']
        ];
        
        // Проверка существующего email или телефона
        if ($this->studentModel->findByEmail($data['email'])) {
            $_SESSION['error'] = 'Email уже зарегистрирован';
            header('Location: /student/register');
            exit;
        }
        
        if ($this->studentModel->findByPhone($data['phone'])) {
            $_SESSION['error'] = 'Телефон уже зарегистрирован';
            header('Location: /student/register');
            exit;
        }
        
        // Создание студента
        $studentId = $this->studentModel->create($data);
        
        if ($studentId) {
            // Генерация токена для запоминания
            $token = bin2hex(random_bytes(32));
            $this->studentModel->updateRememberToken($studentId, $token);
            
            // Установка cookie на 365 дней
            setcookie('remember_token', $token, time() + (86400 * 365), '/');
            
            // Устанавливаем сессию
            $_SESSION['student_id'] = $studentId;
            
            // Перенаправляем на дашборд
            header('Location: /student/dashboard');
        } else {
            $_SESSION['error'] = 'Ошибка при регистрации';
            header('Location: /student/register');
        }
        exit;
    }
    
    /**
     * Показ формы входа
     */
    public function showLogin() {
        $this->view->render('student/login');
    }
    
    /**
     * Обработка входа
     */
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /student/login');
            exit;
        }
        
        $email = $_POST['email'];
        $password = $_POST['password'];
        $remember = isset($_POST['remember']);
        
        $student = $this->studentModel->findByEmail($email);
        
        if ($student && password_verify($password, $student['password_hash'])) {
            $_SESSION['student_id'] = $student['id'];
            
            if ($remember) {
                $token = bin2hex(random_bytes(32));
                $this->studentModel->updateRememberToken($student['id'], $token);
                setcookie('remember_token', $token, time() + (86400 * 365), '/');
            }
            
            header('Location: /student/dashboard');
        } else {
            $_SESSION['error'] = 'Неверный email или пароль';
            header('Location: /student/login');
        }
        exit;
    }
    
    /**
     * Личный кабинет студента
     */
    public function dashboard() {
        if (!isset($_SESSION['student_id'])) {
            header('Location: /student/login');
            exit;
        }
        
        $student = $this->studentModel->findById($_SESSION['student_id']);
        if (!$student) {
            session_destroy();
            header('Location: /student/login');
            exit;
        }
        
        $this->view->render('student/dashboard', ['student' => $student]);
    }
    
    /**
     * Выход из системы
     */
    public function logout() {
        session_destroy();
        setcookie('remember_token', '', time() - 3600, '/');
        header('Location: /student/login');
        exit;
    }
}
