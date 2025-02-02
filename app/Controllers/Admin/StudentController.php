<?php

namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Models\Student;
use App\Middleware\AdminAuthMiddleware;

class StudentController extends Controller {
    private $studentModel;
    
    public function __construct() {
        parent::__construct();
        $this->studentModel = new Student();
        
        // Проверяем права доступа администратора
        $middleware = new AdminAuthMiddleware();
        $middleware->handle();
    }
    
    /**
     * Отображение списка студентов
     */
    public function index() {
        $page = $_GET['page'] ?? 1;
        $filters = [
            'group_id' => $_GET['group_id'] ?? null,
            'search' => $_GET['search'] ?? null
        ];
        
        error_log('=== Начало обработки запроса ===');
        error_log('Страница: ' . $page);
        error_log('Фильтры: ' . print_r($filters, true));
        
        $students = $this->studentModel->getStudentsList($page, 10, $filters);
        
        error_log('Результат запроса students: ' . print_r($students, true));
        error_log('Количество студентов: ' . count($students['data']));
        
        $groups = $this->studentModel->getAllGroups();
        
        error_log('Группы: ' . print_r($groups, true));
        
        $viewData = [
            'students' => $students['data'],
            'groups' => $groups,
            'pagination' => [
                'current_page' => $page,
                'last_page' => $students['last_page'],
                'total' => $students['total']
            ],
            'filters' => $filters
        ];
        
        error_log('Данные для представления: ' . print_r($viewData, true));
        error_log('=== Конец обработки запроса ===');
        
        $this->view->render('admin/students', $viewData);
    }
    
    /**
     * Обновление данных студента
     */
    public function update() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->jsonResponse(['success' => false, 'message' => 'Метод не поддерживается']);
            return;
        }
        
        error_log('=== Начало обновления данных студента ===');
        error_log('POST данные: ' . print_r($_POST, true));
        
        $id = $_POST['id'] ?? null;
        if (!$id) {
            error_log('Ошибка: ID студента не указан');
            $this->jsonResponse(['success' => false, 'message' => 'ID студента не указан']);
            return;
        }
        
        $data = [
            'name' => $_POST['name'] ?? '',
            'email' => $_POST['email'] ?? '',
            'phone' => $_POST['phone'] ?? '',
            'group_id' => $_POST['group_id'] ?: null
        ];
        
        error_log('Данные для обновления: ' . print_r($data, true));
        
        if ($this->studentModel->update($id, $data)) {
            error_log('Обновление успешно');
            $this->jsonResponse(['success' => true, 'message' => 'Данные студента обновлены']);
        } else {
            error_log('Ошибка при обновлении');
            $this->jsonResponse(['success' => false, 'message' => 'Ошибка при обновлении данных']);
        }
        
        error_log('=== Конец обновления данных студента ===');
    }
    
    /**
     * Изменение статуса студента (блокировка/разблокировка)
     */
    public function toggleStatus() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->jsonResponse(['success' => false, 'message' => 'Метод не поддерживается']);
            return;
        }
        
        $id = $_POST['id'] ?? null;
        $status = isset($_POST['status']) ? (bool)$_POST['status'] : null;
        
        if (!$id || $status === null) {
            $this->jsonResponse(['success' => false, 'message' => 'Неверные параметры']);
            return;
        }
        
        if ($this->studentModel->toggleStatus($id, $status)) {
            $this->jsonResponse([
                'success' => true,
                'message' => $status ? 'Студент разблокирован' : 'Студент заблокирован'
            ]);
        } else {
            $this->jsonResponse(['success' => false, 'message' => 'Ошибка при изменении статуса']);
        }
    }
    
    /**
     * Удаление студента
     */
    public function delete() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->jsonResponse(['success' => false, 'message' => 'Метод не поддерживается']);
            return;
        }
        
        $id = $_POST['id'] ?? null;
        if (!$id) {
            $this->jsonResponse(['success' => false, 'message' => 'ID студента не указан']);
            return;
        }
        
        if ($this->studentModel->delete($id)) {
            $this->jsonResponse(['success' => true, 'message' => 'Студент удален']);
        } else {
            $this->jsonResponse(['success' => false, 'message' => 'Ошибка при удалении студента']);
        }
    }
    
    /**
     * Вспомогательный метод для отправки JSON-ответа
     */
    private function jsonResponse($data) {
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }
}
