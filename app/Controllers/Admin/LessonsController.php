<?php

namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Models\Lesson;
use App\Models\User;

class LessonsController extends Controller
{
    private $lessonModel;
    private $userModel;

    public function __construct()
    {
        parent::__construct();
        $this->lessonModel = new Lesson();
        $this->userModel = new User();
    }

    public function index()
    {
        // Получаем все уроки с информацией о создателе
        $lessons = $this->lessonModel->getAllWithCreator();
        
        $this->view->render('admin/lessons', [
            'lessons' => $lessons
        ]);
    }

    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $adminId = $_SESSION['user_id'] ?? null;
            
            if (!$adminId) {
                echo json_encode(['success' => false, 'message' => 'Не авторизован']);
                return;
            }

            $data = [
                'title' => $_POST['title'],
                'speaker' => $_POST['speaker'],
                'datetime' => $_POST['datetime'],
                'group' => $_POST['group'],
                'zoom_link' => $_POST['zoom_link'],
                'created_by' => $adminId
            ];

            $result = $this->lessonModel->create($data);

            if ($result) {
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Ошибка при создании урока']);
            }
        }
    }

    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $lessonId = $_POST['lesson_id'] ?? null;
            
            if (!$lessonId) {
                echo json_encode(['success' => false, 'message' => 'ID урока не указан']);
                return;
            }

            $data = [
                'title' => $_POST['title'],
                'speaker' => $_POST['speaker'],
                'datetime' => $_POST['datetime'],
                'group' => $_POST['group'],
                'zoom_link' => $_POST['zoom_link']
            ];

            $result = $this->lessonModel->update($lessonId, $data);

            if ($result) {
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Ошибка при обновлении урока']);
            }
        }
    }

    public function delete($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $result = $this->lessonModel->delete($id);

            if ($result) {
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Ошибка при удалении урока']);
            }
        }
    }
}
