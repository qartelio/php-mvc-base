<?php

namespace App\Models;

use PDO;

class Administrator {
    private $db;

    public function __construct() {
        $this->db = \App\Core\Database::getInstance()->getConnection();
    }

    /**
     * Создание нового администратора
     */
    public function create(array $data): bool {
        $sql = "INSERT INTO administrators (name, email, password, created_at, updated_at) 
                VALUES (:name, :email, :password, NOW(), NOW())";
        
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => password_hash($data['password'], PASSWORD_DEFAULT)
        ]);
    }

    /**
     * Поиск администратора по email
     */
    public function findByEmail(string $email) {
        $sql = "SELECT * FROM administrators WHERE email = :email LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['email' => $email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Поиск администратора по токену
     */
    public function findByToken(string $token) {
        $sql = "SELECT * FROM administrators WHERE remember_token = :token LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['token' => $token]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Обновление токена для запоминания
     */
    public function updateRememberToken(int $id, string $token): bool {
        $sql = "UPDATE administrators SET remember_token = :token, updated_at = NOW() 
                WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            'id' => $id,
            'token' => $token
        ]);
    }
}
