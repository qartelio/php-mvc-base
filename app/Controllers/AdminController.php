<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Administrator;
use App\Models\Lesson;

class AdminController extends Controller {
    private $model;
    private $lessonModel;

    public function __construct() {
        parent::__construct();
        $this->model = new Administrator();
        $this->lessonModel = new Lesson();
    }

    /**
     * Показать форму регистрации
     */
    public function showRegister() {
        $this->view->render('admin/auth/register');
    }

    /**
     * Показать форму входа
     */
    public function showLogin() {
        $this->view->render('admin/auth/login');
    }

    /**
     * Регистрация нового администратора
     */
    public function register() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /admin/register');
            exit;
        }

        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $passwordConfirm = $_POST['password_confirm'] ?? '';

        // Валидация
        if (empty($name) || empty($email) || empty($password)) {
            $_SESSION['error'] = 'Все поля обязательны для заполнения';
            header('Location: /admin/register');
            exit;
        }

        if ($password !== $passwordConfirm) {
            $_SESSION['error'] = 'Пароли не совпадают';
            header('Location: /admin/register');
            exit;
        }

        if ($this->model->findByEmail($email)) {
            $_SESSION['error'] = 'Администратор с таким email уже существует';
            header('Location: /admin/register');
            exit;
        }

        // Создание администратора
        if ($this->model->create([
            'name' => $name,
            'email' => $email,
            'password' => $password
        ])) {
            $this->login(); // Автоматический вход после регистрации
        } else {
            $_SESSION['error'] = 'Ошибка при регистрации';
            header('Location: /admin/register');
            exit;
        }
    }

    /**
     * Авторизация администратора
     */
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';
            $remember = isset($_POST['remember']);

            $admin = $this->model->findByEmail($email);

            if ($admin && password_verify($password, $admin['password'])) {
                $_SESSION['admin_id'] = $admin['id'];
                $_SESSION['admin_name'] = $admin['name'];

                if ($remember) {
                    $token = bin2hex(random_bytes(32));
                    $this->model->updateRememberToken($admin['id'], $token);
                    setcookie('remember_token', $token, time() + (365 * 24 * 60 * 60), '/', '', true, true);
                }

                header('Location: /admin/dashboard');
                exit;
            }

            $_SESSION['error'] = 'Неверный email или пароль';
            header('Location: /admin/login');
            exit;
        }
    }

    /**
     * Выход из системы
     */
    public function logout() {
        unset($_SESSION['admin_id']);
        unset($_SESSION['admin_name']);
        setcookie('remember_token', '', time() - 3600, '/');
        header('Location: /admin/login');
        exit;
    }

    /**
     * Панель управления
     */
    public function dashboard() {
        if (!isset($_SESSION['admin_id'])) {
            header('Location: /admin/login');
            exit;
        }
        $this->view->render('admin/dashboard');
    }

    /**
     * Страница посещаемости
     */
    public function attendance() {
        if (!isset($_SESSION['admin_id'])) {
            header('Location: /admin/login');
            exit;
        }
        $this->view->render('admin/attendance');
    }

    /**
     * Страница уроков
     */
    public function lessons() {
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
    public function createLesson() {
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
    public function updateLesson() {
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
    public function deleteLesson($params) {
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

    /**
     * Страница студентов
     */
    public function students() {
        if (!isset($_SESSION['admin_id'])) {
            header('Location: /admin/login');
            exit;
        }
        $this->view->render('admin/students');
    }
}
