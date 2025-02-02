<?php

namespace App\Models;

use App\Core\Model;
use App\Core\Database;

class LessonPoint extends Model
{
    protected $table = 'lesson_points';
    protected $db;

    public function __construct()
    {
        parent::__construct();
        $this->db = Database::getInstance()->getConnection();
    }

    /**
     * Создает запись о баллах за посещение урока
     */
    public function createPoints($lessonId, $studentId)
    {
        try {
            error_log("Создание записи о баллах для урока {$lessonId} и студента {$studentId}");
            
            $sql = "INSERT INTO {$this->table} (lesson_id, student_id, points, created_at) VALUES (?, ?, 1, NOW())";
            error_log("SQL запрос: {$sql}");
            
            $stmt = $this->db->prepare($sql);
            $result = $stmt->execute([$lessonId, $studentId]);
            
            if (!$result) {
                $error = $stmt->errorInfo();
                error_log("Ошибка при выполнении запроса: " . print_r($error, true));
                return false;
            }
            
            error_log("Запись о баллах успешно создана");
            return true;
        } catch (\PDOException $e) {
            error_log('Ошибка при создании записи о баллах: ' . $e->getMessage());
            error_log('SQL состояние: ' . $e->getCode());
            return false;
        }
    }

    /**
     * Получает все баллы студента
     */
    public function getStudentPoints($studentId)
    {
        try {
            $sql = "SELECT SUM(points) as total FROM {$this->table} WHERE student_id = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$studentId]);
            $result = $stmt->fetch();
            return $result['total'] ?? 0;
        } catch (\PDOException $e) {
            error_log('Ошибка при получении баллов студента: ' . $e->getMessage());
            return 0;
        }
    }

    /**
     * Удаляет запись о баллах за посещение урока
     */
    public function deletePoints($lessonId, $studentId)
    {
        try {
            error_log("Удаление записи о баллах для урока {$lessonId} и студента {$studentId}");
            
            $sql = "DELETE FROM {$this->table} WHERE lesson_id = ? AND student_id = ?";
            error_log("SQL запрос: {$sql}");
            
            $stmt = $this->db->prepare($sql);
            $result = $stmt->execute([$lessonId, $studentId]);
            
            if (!$result) {
                $error = $stmt->errorInfo();
                error_log("Ошибка при выполнении запроса: " . print_r($error, true));
                return false;
            }
            
            error_log("Запись о баллах успешно удалена");
            return true;
        } catch (\PDOException $e) {
            error_log('Ошибка при удалении записи о баллах: ' . $e->getMessage());
            error_log('SQL состояние: ' . $e->getCode());
            return false;
        }
    }
}
