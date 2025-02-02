<?php

namespace App\Models;

use App\Core\Model;
use App\Core\Database;

class Student extends Model {
    protected $table = 'students';
    protected $db;
    
    public function __construct() {
        parent::__construct();
        $this->db = Database::getInstance()->getConnection();
    }
    
    /**
     * Получение студента по ID
     */
    public function getById($id) {
        try {
            $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE id = ?");
            $stmt->execute([$id]);
            return $stmt->fetch();
        } catch (\PDOException $e) {
            error_log('Ошибка при получении студента по ID: ' . $e->getMessage());
            return null;
        }
    }
    
    /**
     * Создание нового студента
     */
    public function create($data) {
        $data['password_hash'] = password_hash($data['password'], PASSWORD_DEFAULT);
        unset($data['password']);
        
        $columns = implode(', ', array_keys($data));
        $values = implode(', ', array_fill(0, count($data), '?'));
        
        $sql = "INSERT INTO {$this->table} ({$columns}) VALUES ({$values})";
        $stmt = $this->db->prepare($sql);
        
        if ($stmt->execute(array_values($data))) {
            return $this->db->lastInsertId();
        }
        return false;
    }
    
    /**
     * Поиск студента по email
     */
    public function findByEmail($email) {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch();
    }
    
    /**
     * Поиск студента по телефону
     */
    public function findByPhone($phone) {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE phone = ?");
        $stmt->execute([$phone]);
        return $stmt->fetch();
    }
    
    /**
     * Поиск студента по токену
     */
    public function findByToken($token) {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE remember_token = ?");
        $stmt->execute([$token]);
        return $stmt->fetch();
    }
    
    /**
     * Обновление токена для запоминания
     */
    public function updateRememberToken($id, $token) {
        $stmt = $this->db->prepare("UPDATE {$this->table} SET remember_token = ? WHERE id = ?");
        return $stmt->execute([$token, $id]);
    }
    
    /**
     * Поиск студента по ID
     */
    public function findById($id) {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
}
