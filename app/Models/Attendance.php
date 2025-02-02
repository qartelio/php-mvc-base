<?php

namespace App\Models;

use App\Core\Model;
use App\Core\Database;

class Attendance extends Model
{
    protected $table = 'attendance';
    protected $db;

    public function __construct()
    {
        parent::__construct();
        $this->db = Database::getInstance()->getConnection();
    }

    /**
     * Проверяет, посещал ли студент урок
     */
    public function hasAttended($lessonId, $studentId)
    {
        try {
            $sql = "SELECT id FROM {$this->table} WHERE lesson_id = ? AND student_id = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$lessonId, $studentId]);
            return $stmt->fetch() !== false;
        } catch (\PDOException $e) {
            error_log('Ошибка при проверке посещения: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Создает запись о посещении урока
     */
    public function createAttendance($lessonId, $studentId)
    {
        try {
            error_log("Создание записи о посещении для урока {$lessonId} и студента {$studentId}");
            
            $sql = "INSERT INTO {$this->table} (lesson_id, student_id, visited_at) VALUES (?, ?, NOW())";
            error_log("SQL запрос: {$sql}");
            
            $stmt = $this->db->prepare($sql);
            $result = $stmt->execute([$lessonId, $studentId]);
            
            if (!$result) {
                $error = $stmt->errorInfo();
                error_log("Ошибка при выполнении запроса: " . print_r($error, true));
                return false;
            }
            
            error_log("Запись о посещении успешно создана");
            return true;
        } catch (\PDOException $e) {
            error_log('Ошибка при создании записи о посещении: ' . $e->getMessage());
            error_log('SQL состояние: ' . $e->getCode());
            return false;
        }
    }
}
