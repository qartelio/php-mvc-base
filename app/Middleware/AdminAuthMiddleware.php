<?php

namespace App\Middleware;

use App\Models\Administrator;

class AdminAuthMiddleware {
    public function handle() {
        // Если администратор уже авторизован через сессию
        if (isset($_SESSION['admin_id'])) {
            return true;
        }

        // Проверка remember_token
        $token = $_COOKIE['remember_token'] ?? null;
        if ($token) {
            $model = new Administrator();
            $admin = $model->findByToken($token);
            
            if ($admin) {
                $_SESSION['admin_id'] = $admin['id'];
                $_SESSION['admin_name'] = $admin['name'];
                return true;
            }
        }

        header('Location: /admin/login');
        exit;
    }
}
