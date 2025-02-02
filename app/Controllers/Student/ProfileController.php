<?php

namespace App\Controllers\Student;

use App\Core\Controller;
use App\Models\Student;

class ProfileController extends Controller
{
    private $studentModel;
    
    public function __construct()
    {
        parent::__construct();
        $this->studentModel = new Student();
    }

    // Показ страницы профиля
    public function index()
    {
        // Отладка
        error_log('Session data: ' . print_r($_SESSION, true));
        
        if (!isset($_SESSION['student_id'])) {
            error_log('No student_id in session');
            $this->redirect('/login');
            return;
        }

        $studentId = $_SESSION['student_id'];
        error_log('Looking for student with ID: ' . $studentId);
        
        $student = $this->studentModel->getById($studentId);
        error_log('Student data: ' . print_r($student, true));
        
        if (!$student) {
            error_log('Student not found');
            $_SESSION['error'] = 'Студент не найден';
            $this->redirect('/login');
            return;
        }

        $this->view('student/profile', ['student' => $student]);
    }

    // Обновление профиля
    public function update()
    {
        error_log('ProfileController::update() called');
        error_log('POST data: ' . print_r($_POST, true));
        error_log('SESSION data: ' . print_r($_SESSION, true));

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            error_log('Not a POST request');
            $this->redirect('/student/profile');
            return;
        }

        $studentId = $_SESSION['student_id'] ?? null;
        if (!$studentId) {
            error_log('No student_id in session');
            $this->redirect('/login');
            return;
        }

        // Валидация данных
        $name = htmlspecialchars(trim($_POST['name'] ?? ''));
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        $phone = htmlspecialchars(trim($_POST['phone'] ?? ''));

        error_log('Validated data:');
        error_log('name: ' . $name);
        error_log('email: ' . $email);
        error_log('phone: ' . $phone);

        $errors = [];
        if (empty($name)) $errors['name'] = 'Имя обязательно для заполнения';
        if (empty($email)) $errors['email'] = 'Email обязателен для заполнения';
        if (empty($phone)) $errors['phone'] = 'Телефон обязателен для заполнения';

        // Проверка email на корректность
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Некорректный формат email';
        }

        // Проверка телефона (простая проверка на наличие только цифр и некоторых спецсимволов)
        if (!preg_match('/^[+\-0-9\s()]+$/', $phone)) {
            $errors['phone'] = 'Некорректный формат телефона';
        }

        if (!empty($errors)) {
            error_log('Validation errors: ' . print_r($errors, true));
            $_SESSION['errors'] = $errors;
            $this->redirect('/student/profile');
            return;
        }

        // Обновление данных
        $updateData = [
            'name' => $name,
            'email' => $email,
            'phone' => $phone
        ];

        error_log('Updating student with data: ' . print_r($updateData, true));
        
        if ($this->studentModel->update($studentId, $updateData)) {
            error_log('Profile updated successfully');
            $_SESSION['success'] = 'Профиль успешно обновлен';
        } else {
            error_log('Error updating profile');
            $_SESSION['error'] = 'Ошибка при обновлении профиля';
        }
        
        $this->redirect('/student/profile');
    }

    // Обновление аватара
    public function updateAvatar()
    {
        header('Content-Type: application/json');

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['success' => false, 'error' => 'Метод не разрешен']);
            return;
        }

        $studentId = $_SESSION['student_id'] ?? null;
        if (!$studentId) {
            echo json_encode(['success' => false, 'error' => 'Не авторизован']);
            return;
        }

        // Проверка загруженного файла
        if (!isset($_FILES['avatar']) || $_FILES['avatar']['error'] !== UPLOAD_ERR_OK) {
            echo json_encode(['success' => false, 'error' => 'Ошибка загрузки файла']);
            return;
        }

        $file = $_FILES['avatar'];
        
        // Проверка размера файла (5MB)
        if ($file['size'] > 5 * 1024 * 1024) {
            echo json_encode(['success' => false, 'error' => 'Размер файла не должен превышать 5MB']);
            return;
        }

        // Проверка типа файла
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        if (!in_array($file['type'], $allowedTypes)) {
            echo json_encode(['success' => false, 'error' => 'Неподдерживаемый формат файла']);
            return;
        }

        // Создаем директорию, если её нет
        $uploadDir = 'public/uploads/avatars';
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        // Генерация уникального имени файла
        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $filename = uniqid('avatar_') . '.' . $extension;
        $uploadPath = $uploadDir . '/' . $filename;

        // Сохранение файла
        if (!move_uploaded_file($file['tmp_name'], $uploadPath)) {
            echo json_encode(['success' => false, 'error' => 'Ошибка сохранения файла']);
            return;
        }

        // Обновление пути к аватару в БД
        if ($this->studentModel->update($studentId, ['avatar' => $filename])) {
            echo json_encode([
                'success' => true,
                'avatar' => $filename
            ]);
        } else {
            unlink($uploadPath); // Удаляем файл, если не удалось обновить БД
            echo json_encode(['success' => false, 'error' => 'Ошибка обновления аватара в базе данных']);
        }
    }

    // Смена пароля
    public function changePassword()
    {
        error_log('ProfileController::changePassword() called');
        error_log('POST data: ' . print_r($_POST, true));
        error_log('SESSION data: ' . print_r($_SESSION, true));

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            error_log('Not a POST request');
            $this->redirect('/student/profile');
            return;
        }

        $studentId = $_SESSION['student_id'] ?? null;
        if (!$studentId) {
            error_log('No student_id in session');
            $this->redirect('/login');
            return;
        }

        $currentPassword = $_POST['current_password'] ?? '';
        $newPassword = $_POST['new_password'] ?? '';
        $confirmPassword = $_POST['confirm_password'] ?? '';

        error_log('Validating password change request');

        $errors = [];

        // Проверка наличия всех полей
        if (empty($currentPassword)) {
            $errors['current_password'] = 'Введите текущий пароль';
        }
        if (empty($newPassword)) {
            $errors['new_password'] = 'Введите новый пароль';
        }
        if (empty($confirmPassword)) {
            $errors['confirm_password'] = 'Подтвердите новый пароль';
        }

        // Если все поля заполнены, проводим дополнительные проверки
        if (empty($errors)) {
            // Проверка текущего пароля
            $student = $this->studentModel->findById($studentId);
            if (!$student) {
                error_log('Student not found with ID: ' . $studentId);
                $_SESSION['error'] = 'Ошибка: студент не найден';
                $this->redirect('/student/profile');
                return;
            }

            if (!password_verify($currentPassword, $student['password_hash'])) {
                error_log('Current password verification failed');
                $errors['current_password'] = 'Неверный текущий пароль';
            }

            // Валидация нового пароля
            if (strlen($newPassword) < 6) {
                $errors['new_password'] = 'Новый пароль должен содержать минимум 6 символов';
            } elseif (strlen($newPassword) > 72) {
                $errors['new_password'] = 'Новый пароль не должен превышать 72 символа';
            } elseif (!preg_match('/[A-Za-z]/', $newPassword) || !preg_match('/[0-9]/', $newPassword)) {
                $errors['new_password'] = 'Пароль должен содержать хотя бы одну букву и одну цифру';
            }

            // Проверка совпадения паролей
            if ($newPassword !== $confirmPassword) {
                $errors['confirm_password'] = 'Пароли не совпадают';
            }

            // Проверка, что новый пароль отличается от текущего
            if (!empty($currentPassword) && !empty($newPassword) && 
                password_verify($newPassword, $student['password_hash'])) {
                $errors['new_password'] = 'Новый пароль должен отличаться от текущего';
            }
        }

        if (!empty($errors)) {
            error_log('Password change validation errors: ' . print_r($errors, true));
            $_SESSION['errors'] = $errors;
            $this->redirect('/student/profile');
            return;
        }

        // Обновление пароля
        $passwordHash = password_hash($newPassword, PASSWORD_DEFAULT);
        
        error_log('Attempting to update password for student ID: ' . $studentId);
        
        if ($this->studentModel->update($studentId, ['password_hash' => $passwordHash])) {
            error_log('Password updated successfully');
            $_SESSION['success'] = 'Пароль успешно изменен';
            
            // Дополнительная безопасность: можно сбросить все сессии пользователя
            if (isset($_SESSION['remember_token'])) {
                $this->studentModel->updateRememberToken($studentId, null);
                unset($_SESSION['remember_token']);
            }
        } else {
            error_log('Error updating password');
            $_SESSION['error'] = 'Ошибка при изменении пароля';
        }
        
        $this->redirect('/student/profile');
    }
}
