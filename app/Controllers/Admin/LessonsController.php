<?php

namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Models\Lesson;

class LessonsController extends Controller {
    private $lessonModel;

    public function __construct() {
        parent::__construct();
        $this->lessonModel = new Lesson();
    }

    /**
     * Страница уроков
     */
    public function index() {
        if (!isset($_SESSION['admin_id'])) {
            header('Location: /admin/login');
            exit;
        }
        
        // Получаем список всех уроков с информацией о создателе
        $lessons = $this->lessonModel->getAllWithCreator();
        
        $this->view->render('admin/lessons', [
            'lessons' => $lessons
        ]);
    }

    /**
     * Создание нового урока
     */
    public function create() {
        if (!isset($_SESSION['admin_id'])) {
            echo json_encode(['success' => false, 'message' => 'Не авторизован']);
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $data = [
                    'title' => $_POST['title'] ?? '',
                    'speaker' => $_POST['speaker'] ?? '',
                    'datetime' => $_POST['datetime'] ?? '',
                    'group' => $_POST['group'] ?? '',
                    'zoom_link' => $_POST['zoom_link'] ?? '',
                    'created_by' => $_SESSION['admin_id']
                ];

                // Отладочная информация
                error_log('Данные для создания урока: ' . print_r($data, true));

                // Валидация данных
                if (empty($data['title']) || empty($data['speaker']) || empty($data['datetime']) || 
                    empty($data['group']) || empty($data['zoom_link'])) {
                    echo json_encode(['success' => false, 'message' => 'Все поля обязательны для заполнения']);
                    exit;
                }

                // Преобразование формата datetime
                $data['datetime'] = str_replace('T', ' ', $data['datetime']);

                if ($this->lessonModel->create($data)) {
                    echo json_encode(['success' => true]);
                } else {
                    error_log('Ошибка при создании урока в БД');
                    echo json_encode(['success' => false, 'message' => 'Ошибка при создании урока в базе данных']);
                }
            } catch (\Exception $e) {
                error_log('Ошибка при создании урока: ' . $e->getMessage());
                echo json_encode(['success' => false, 'message' => 'Произошла ошибка: ' . $e->getMessage()]);
            }
            exit;
        }
    }

    /**
     * Обновление урока
     */
    public function update() {
        if (!isset($_SESSION['admin_id'])) {
            echo json_encode(['success' => false, 'message' => 'Не авторизован']);
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $lessonId = $_POST['lesson_id'] ?? null;
            
            if (!$lessonId) {
                echo json_encode(['success' => false, 'message' => 'ID урока не указан']);
                exit;
            }

            $data = [
                'title' => $_POST['title'] ?? '',
                'speaker' => $_POST['speaker'] ?? '',
                'datetime' => $_POST['datetime'] ?? '',
                'group' => $_POST['group'] ?? '',
                'zoom_link' => $_POST['zoom_link'] ?? ''
            ];

            // Валидация данных
            if (empty($data['title']) || empty($data['speaker']) || empty($data['datetime']) || 
                empty($data['group']) || empty($data['zoom_link'])) {
                echo json_encode(['success' => false, 'message' => 'Все поля обязательны для заполнения']);
                exit;
            }

            if ($this->lessonModel->update($lessonId, $data)) {
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Ошибка при обновлении урока']);
            }
            exit;
        }
    }

    /**
     * Удаляет урок по ID
     * 
     * @param array $params Параметры маршрута
     * @return void
     */
    public function delete($params) {
        try {
            // Проверяем авторизацию
            if (!isset($_SESSION['admin_id'])) {
                $this->jsonResponse(false, 'Не авторизован', 401);
                return;
            }

            // Проверяем метод запроса
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                $this->jsonResponse(false, 'Метод не поддерживается', 405);
                return;
            }

            // Проверяем наличие ID
            $lessonId = $params['id'] ?? null;
            if (!$lessonId) {
                $this->jsonResponse(false, 'ID урока не указан', 400);
                return;
            }

            // Удаляем урок
            $result = $this->lessonModel->delete($lessonId);
            
            // Отправляем результат
            $this->jsonResponse(
                $result['success'],
                $result['message'],
                $result['success'] ? 200 : 400
            );

        } catch (\Exception $e) {
            error_log("Ошибка в deleteLesson: " . $e->getMessage());
            $this->jsonResponse(false, 'Внутренняя ошибка сервера', 500);
        }
    }

    /**
     * Отправляет JSON-ответ
     * 
     * @param bool $success Успешность операции
     * @param string $message Сообщение
     * @param int $statusCode HTTP-код ответа
     * @return void
     */
    private function jsonResponse($success, $message, $statusCode = 200) {
        http_response_code($statusCode);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode([
            'success' => $success,
            'message' => $message
        ]);
        exit;
    }
}