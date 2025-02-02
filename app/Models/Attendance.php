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
     * Получает все записи о посещаемости для урока
     */
    public function getAttendanceByLesson($lessonId)
    {
        try {
            $sql = "SELECT a.*, s.name as student_name, lap.points as activity_points 
                    FROM {$this->table} a
                    JOIN students s ON a.student_id = s.id
                    LEFT JOIN lesson_activity_points lap ON a.lesson_id = lap.lesson_id AND a.student_id = lap.student_id
                    WHERE a.lesson_id = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$lessonId]);
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            error_log('Ошибка при получении данных о посещаемости: ' . $e->getMessage());
            return [];
        }
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
     * Обновляет статус посещаемости
     */
    public function updateAttendance($lessonId, $studentId, $attended)
    {
        try {
            if ($attended) {
                if (!$this->hasAttended($lessonId, $studentId)) {
                    $sql = "INSERT INTO {$this->table} (lesson_id, student_id, visited_at) VALUES (?, ?, NOW())";
                    $stmt = $this->db->prepare($sql);
                    return $stmt->execute([$lessonId, $studentId]);
                }
                return true;
            } else {
                $sql = "DELETE FROM {$this->table} WHERE lesson_id = ? AND student_id = ?";
                $stmt = $this->db->prepare($sql);
                return $stmt->execute([$lessonId, $studentId]);
            }
        } catch (\PDOException $e) {
            error_log('Ошибка при обновлении посещаемости: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Обновляет или создает баллы за активность
     */
    public function updateActivityPoints($lessonId, $studentId, $points)
    {
        try {
            // Проверяем, существуют ли уже баллы
            $sql = "SELECT id FROM lesson_activity_points WHERE lesson_id = ? AND student_id = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$lessonId, $studentId]);
            
            if ($stmt->fetch()) {
                // Обновляем существующие баллы
                $sql = "UPDATE lesson_activity_points SET points = ? WHERE lesson_id = ? AND student_id = ?";
                $stmt = $this->db->prepare($sql);
                return $stmt->execute([$points, $lessonId, $studentId]);
            } else {
                // Создаем новую запись
                $sql = "INSERT INTO lesson_activity_points (lesson_id, student_id, points) VALUES (?, ?, ?)";
                $stmt = $this->db->prepare($sql);
                return $stmt->execute([$lessonId, $studentId, $points]);
            }
        } catch (\PDOException $e) {
            error_log('Ошибка при обновлении баллов: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Получает баллы за активность
     */
    public function getActivityPoints($lessonId, $studentId)
    {
        try {
            $sql = "SELECT points FROM lesson_activity_points WHERE lesson_id = ? AND student_id = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$lessonId, $studentId]);
            $result = $stmt->fetch(\PDO::FETCH_ASSOC);
            return $result ? $result['points'] : 0;
        } catch (\PDOException $e) {
            error_log('Ошибка при получении баллов: ' . $e->getMessage());
            return 0;
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
