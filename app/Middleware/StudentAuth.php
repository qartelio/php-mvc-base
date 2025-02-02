<?php

namespace App\Middleware;

class StudentAuth {
    public function handle() {
        // Проверяем наличие ID студента в сессии
        if (!isset($_SESSION['student_id'])) {
            // Если нет ID в сессии, проверяем remember_token в cookie
            if (isset($_COOKIE['remember_token'])) {
                $studentModel = new \App\Models\Student();
                $student = $studentModel->findByToken($_COOKIE['remember_token']);
                
                if ($student) {
                    $_SESSION['student_id'] = $student['id'];
                    return true;
                }
            }
            
            // Если нет валидного токена, перенаправляем на страницу входа
            header('Location: /student/login');
            exit;
        }
        
        return true;
    }
}
