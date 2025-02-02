<?php

namespace App\Controllers\Student;

use App\Core\Controller;
use App\Models\Lesson;
use App\Models\Attendance;
use App\Models\LessonPoint;
use App\Models\Student;

class LessonsController extends Controller
{
    private $lessonModel;
    private $attendanceModel;
    private $lessonPointModel;
    private $studentModel;

    public function __construct()
    {
        parent::__construct();
        $this->lessonModel = new Lesson();
        $this->attendanceModel = new Attendance();
        $this->lessonPointModel = new LessonPoint();
        $this->studentModel = new Student();
    }

    /**
     * Отображает список уроков для студента
     */
    public function index()
    {
        // Получаем данные студента
        $studentId = $_SESSION['student_id'] ?? 0;
        $student = $this->studentModel->getById($studentId);
        
        if (!$student) {
            header('Location: /student/login');
            exit;
        }

        // Получаем все уроки для группы студента
        $lessons = $this->lessonModel->getLessonsByGroup($student['group_id']);

        // Для каждого урока проверяем статус посещения
        foreach ($lessons as &$lesson) {
            $lesson['attended'] = $this->attendanceModel->hasAttended($lesson['id'], $studentId);
            $lesson['is_active'] = $this->isLessonActive($lesson['datetime']);
        }

        $this->view->render('student/lessons', ['lessons' => $lessons]);
    }

    /**
     * Обрабатывает посещение урока
     */
    public function attend()
    {
        $studentId = $_SESSION['student_id'] ?? 0;
        
        if (!$studentId) {
            echo json_encode(['success' => false, 'message' => 'Необходимо авторизоваться']);
            return;
        }

        if (!isset($_POST['lesson_id'])) {
            echo json_encode(['success' => false, 'message' => 'Не указан ID урока']);
            return;
        }

        $lessonId = $_POST['lesson_id'];

        // Получаем информацию об уроке
        $lesson = $this->lessonModel->getById($lessonId);
        if (!$lesson) {
            echo json_encode(['success' => false, 'message' => 'Урок не найден']);
            return;
        }

        // Проверяем, активен ли урок
        if (!$this->isLessonActive($lesson['datetime'])) {
            echo json_encode(['success' => false, 'message' => 'Урок уже завершен']);
            return;
        }

        // Проверяем, не посещал ли студент уже этот урок
        if ($this->attendanceModel->hasAttended($lessonId, $studentId)) {
            echo json_encode([
                'success' => true, 
                'attended' => true, 
                'message' => 'Вы уже посетили этот урок',
                'zoom_link' => $lesson['zoom_link']
            ]);
            return;
        }

        // Создаем запись о посещении
        $attendanceCreated = $this->attendanceModel->createAttendance($lessonId, $studentId);
        
        // Начисляем балл за посещение
        $pointsCreated = $this->lessonPointModel->createPoints($lessonId, $studentId);

        if ($attendanceCreated && $pointsCreated) {
            echo json_encode([
                'success' => true, 
                'attended' => true, 
                'message' => 'Посещение урока зафиксировано',
                'zoom_link' => $lesson['zoom_link']
            ]);
        } else {
            echo json_encode([
                'success' => false, 
                'message' => 'Произошла ошибка при записи посещения'
            ]);
        }
    }

    /**
     * Проверяет, активен ли урок (прошло ли менее 2 часов с начала)
     */
    private function isLessonActive($startTime)
    {
        $lessonStart = strtotime($startTime);
        $currentTime = time();
        $twoHoursInSeconds = 2 * 60 * 60;

        return ($currentTime - $lessonStart) < $twoHoursInSeconds;
    }
}
