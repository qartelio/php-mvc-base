<?php

namespace App\Middleware;

use App\Models\Student;

class StudentAuthMiddleware {
    /**
     * Проверка аутентификации студента
     */
    public static function authenticate() {
        // Если сессия уже существует
        if (isset($_SESSION['student_id'])) {
            return true;
        }
        
        // Проверка remember_token в cookie
        if (isset($_COOKIE['remember_token'])) {
            $studentModel = new Student();
            $student = $studentModel->findByToken($_COOKIE['remember_token']);
            
            if ($student) {
                $_SESSION['student_id'] = $student['id'];
                return true;
            }
            
            // Удаляем невалидный токен
            setcookie('remember_token', '', time() - 3600, '/');
        }
        
        header('Location: /student/login');
        exit;
    }
    
    /**
     * Проверка что пользователь НЕ аутентифицирован
     */
    public static function guest() {
        if (isset($_SESSION['student_id'])) {
            header('Location: /student/dashboard');
            exit;
        }
        
        return true;
    }
}
