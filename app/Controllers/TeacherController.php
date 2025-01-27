<?php

namespace App\Controllers;

use App\Models\Teacher;

class TeacherController {
    private $teacherModel;
    
    public function __construct($db) {
        $this->teacherModel = new Teacher($db);
    }
    
    /**
     * Отображение формы регистрации
     */
    public function showRegistration() {
        require_once __DIR__ . '/../Views/teacher/registration.php';
    }
    
    /**
     * Обработка регистрации
     */
    public function register() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /teacher/registration');
            exit;
        }
        
        $data = [
            'full_name' => trim($_POST['full_name']),
            'phone' => trim($_POST['phone']),
            'email' => trim($_POST['email']),
            'password' => $_POST['password'],
            'password_confirm' => $_POST['password_confirm']
        ];
        
        // Валидация
        if (empty($data['full_name']) || empty($data['phone']) || 
            empty($data['email']) || empty($data['password'])) {
            $_SESSION['error'] = 'Пожалуйста, заполните все поля';
            header('Location: /teacher/registration');
            exit;
        }
        
        if ($data['password'] !== $data['password_confirm']) {
            $_SESSION['error'] = 'Пароли не совпадают';
            header('Location: /teacher/registration');
            exit;
        }
        
        if ($this->teacherModel->emailExists($data['email'])) {
            $_SESSION['error'] = 'Email уже зарегистрирован';
            header('Location: /teacher/registration');
            exit;
        }
        
        if ($this->teacherModel->create($data)) {
            $_SESSION['success'] = 'Регистрация успешна';
            header('Location: /teacher/login');
        } else {
            $_SESSION['error'] = 'Что-то пошло не так';
            header('Location: /teacher/registration');
        }
        exit;
    }
    
    /**
     * Отображение формы входа
     */
    public function showLogin() {
        require_once __DIR__ . '/../Views/teacher/login.php';
    }
    
    /**
     * Обработка входа
     */
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /teacher/login');
            exit;
        }
        
        $email = trim($_POST['email']);
        $password = $_POST['password'];
        
        $teacher = $this->teacherModel->findByEmail($email);
        
        if ($teacher && password_verify($password, $teacher['password'])) {
            $_SESSION['teacher_id'] = $teacher['id'];
            $_SESSION['teacher_email'] = $teacher['email'];
            
            // Установка cookie на 365 дней
            if (isset($_POST['remember'])) {
                $token = bin2hex(random_bytes(32));
                setcookie('teacher_remember', $token, time() + (86400 * 365), '/', '', true, true);
                // Здесь можно сохранить токен в базе данных
            }
            
            header('Location: /teacher/dashboard');
        } else {
            $_SESSION['error'] = 'Неверный email или пароль';
            header('Location: /teacher/login');
        }
        exit;
    }
    
    /**
     * Панель управления учителя
     */
    public function dashboard() {
        if (!isset($_SESSION['teacher_id'])) {
            header('Location: /teacher/login');
            exit;
        }
        
        require_once __DIR__ . '/../Views/teacher/dashboard.php';
    }
}
