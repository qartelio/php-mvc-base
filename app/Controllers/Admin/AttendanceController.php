<?php

namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Models\Attendance;
use App\Models\Lesson;

class AttendanceController extends Controller {
    private $attendanceModel;
    private $lessonModel;

    public function __construct() {
        parent::__construct();
        $this->attendanceModel = new Attendance();
        $this->lessonModel = new Lesson();
    }

    /**
     * Страница посещаемости
     */
    public function index() {
        if (!isset($_SESSION['admin_id'])) {
            header('Location: /admin/login');
            exit;
        }
        
        // Получаем список всех уроков с информацией о студентах и их посещаемости
        $lessons = $this->lessonModel->getAllWithAttendance();
        
        $this->view->render('admin/attendance', [
            'lessons' => $lessons
        ]);
    }

    /**
     * Обновление статуса посещаемости
     */
    public function updateAttendance() {
        if (!isset($_SESSION['admin_id'])) {
            echo json_encode(['success' => false, 'message' => 'Не авторизован']);
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = json_decode(file_get_contents('php://input'), true);
            
            try {
                $lessonId = $data['lessonId'] ?? null;
                $studentId = $data['studentId'] ?? null;
                $attended = $data['attended'] ?? false;

                if (!$lessonId || !$studentId) {
                    throw new \Exception('Отсутствуют обязательные параметры');
                }

                // Проверяем существование урока и студента
                if (!$this->lessonModel->exists($lessonId)) {
                    throw new \Exception('Урок не найден');
                }

                $result = $this->attendanceModel->updateAttendance($lessonId, $studentId, $attended);
                
                if ($result) {
                    echo json_encode(['success' => true]);
                } else {
                    echo json_encode(['success' => false, 'message' => 'Не удалось обновить статус посещаемости']);
                }
            } catch (\Exception $e) {
                error_log('Ошибка при обновлении посещаемости: ' . $e->getMessage());
                echo json_encode(['success' => false, 'message' => $e->getMessage()]);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Неверный метод запроса']);
        }
    }

    /**
     * Управление баллами за активность
     */
    public function managePoints() {
        if (!isset($_SESSION['admin_id'])) {
            echo json_encode(['success' => false, 'message' => 'Не авторизован']);
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = json_decode(file_get_contents('php://input'), true);
            
            try {
                $lessonId = $data['lessonId'] ?? null;
                $studentId = $data['studentId'] ?? null;
                $points = $data['points'] ?? null;

                if (!$lessonId || !$studentId || !is_numeric($points)) {
                    throw new \Exception('Отсутствуют обязательные параметры');
                }

                $result = $this->attendanceModel->updateActivityPoints($lessonId, $studentId, $points);
                
                echo json_encode(['success' => true]);
            } catch (\Exception $e) {
                echo json_encode(['success' => false, 'message' => $e->getMessage()]);
            }
        }
    }
}
