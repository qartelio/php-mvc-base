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
    public function findById($id) {
        try {
            $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE id = ?");
            $stmt->execute([$id]);
            return $stmt->fetch();
        } catch (\PDOException $e) {
            error_log('Ошибка при получении студента по ID: ' . $e->getMessage());
            return null;
        }
    }

    // Алиас для совместимости
    public function getById($id) {
        return $this->findById($id);
    }
    
    /**
     * Создание нового студента
     */
    public function create($data) {
        try {
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
        } catch (\PDOException $e) {
            error_log('Ошибка при создании студента: ' . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Обновление данных студента
     */
    public function update($id, $data) {
        try {
            $setClause = implode('=?, ', array_keys($data)) . '=?';
            $sql = "UPDATE {$this->table} SET {$setClause} WHERE id = ?";
            
            $values = array_values($data);
            $values[] = $id;
            
            $stmt = $this->db->prepare($sql);
            return $stmt->execute($values);
        } catch (\PDOException $e) {
            error_log('Ошибка при обновлении данных студента: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Поиск студента по email
     */
    public function findByEmail($email) {
        try {
            $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE email = ?");
            $stmt->execute([$email]);
            return $stmt->fetch();
        } catch (\PDOException $e) {
            error_log('Ошибка при поиске студента по email: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Поиск студента по телефону
     */
    public function findByPhone($phone) {
        try {
            $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE phone = ?");
            $stmt->execute([$phone]);
            return $stmt->fetch();
        } catch (\PDOException $e) {
            error_log('Ошибка при поиске студента по телефону: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Обновление токена запоминания
     */
    public function updateRememberToken($id, $token) {
        try {
            $stmt = $this->db->prepare("UPDATE {$this->table} SET remember_token = ? WHERE id = ?");
            return $stmt->execute([$token, $id]);
        } catch (\PDOException $e) {
            error_log('Ошибка при обновлении токена: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Поиск студента по токену запоминания
     */
    public function findByToken($token) {
        try {
            $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE remember_token = ?");
            $stmt->execute([$token]);
            return $stmt->fetch();
        } catch (\PDOException $e) {
            error_log('Ошибка при поиске студента по токену: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Получение общего количества баллов студента
     * @param int $studentId ID студента
     * @return int Общее количество баллов
     */
    public function getTotalPoints($studentId) {
        try {
            // Проверяем наличие актуального кэша
            $stmt = $this->db->prepare("
                SELECT total_points_cache, points_cache_updated_at 
                FROM {$this->table} 
                WHERE id = ?
            ");
            $stmt->execute([$studentId]);
            $cacheData = $stmt->fetch();
            
            // Если кэш актуален, возвращаем его
            if ($cacheData['points_cache_updated_at'] !== null && $cacheData['total_points_cache'] !== null) {
                return $cacheData['total_points_cache'];
            }
            
            // Если кэш неактуален, считаем сумму баллов
            $stmt = $this->db->prepare("
                SELECT 
                    COALESCE(
                        (SELECT SUM(points) FROM lesson_activity_points WHERE student_id = :student_id), 
                        0
                    ) +
                    COALESCE(
                        (SELECT SUM(points) FROM lesson_points WHERE student_id = :student_id),
                        0
                    ) as total_points
            ");
            $stmt->execute(['student_id' => $studentId]);
            $result = $stmt->fetch();
            $totalPoints = (int)$result['total_points'];
            
            // Обновляем кэш
            $updateStmt = $this->db->prepare("
                UPDATE {$this->table} 
                SET total_points_cache = ?, points_cache_updated_at = CURRENT_TIMESTAMP
                WHERE id = ?
            ");
            $updateStmt->execute([$totalPoints, $studentId]);
            
            return $totalPoints;
        } catch (\PDOException $e) {
            error_log('Ошибка при получении общего количества баллов: ' . $e->getMessage());
            return 0;
        }
    }
}
