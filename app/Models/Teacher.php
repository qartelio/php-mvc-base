<?php

namespace App\Models;

class Teacher {
    private $db;
    
    public function __construct($db) {
        $this->db = $db;
    }
    
    /**
     * Создание нового учителя
     */
    public function create($data) {
        $hashedPassword = password_hash($data['password'], PASSWORD_DEFAULT);
        
        $sql = "INSERT INTO teachers (full_name, phone, email, password) VALUES (?, ?, ?, ?)";
        return $this->db->execute($sql, [
            $data['full_name'],
            $data['phone'],
            $data['email'],
            $hashedPassword
        ]);
    }
    
    /**
     * Поиск учителя по email
     */
    public function findByEmail($email) {
        $sql = "SELECT * FROM teachers WHERE email = ? LIMIT 1";
        return $this->db->query($sql, [$email]);
    }
    
    /**
     * Проверка существования email
     */
    public function emailExists($email) {
        $teacher = $this->findByEmail($email);
        return !empty($teacher);
    }
}
