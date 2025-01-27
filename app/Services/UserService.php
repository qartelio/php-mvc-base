<?php
namespace App\Services;

use App\Models\User;
use App\Repositories\UserRepository;
use Exception;

class UserService extends BaseService {
    private $userRepository;

    public function __construct(UserRepository $repository) {
        parent::__construct($repository);
        $this->userRepository = $repository;
    }

    /**
     * Регистрация нового пользователя
     */
    public function register(array $data) {
        // Проверяем, не существует ли уже пользователь с таким email
        if ($this->userRepository->findByEmail($data['email'])) {
            throw new Exception('Пользователь с таким email уже существует');
        }

        // Создаем нового пользователя
        $user = new User($data);
        $user->setPassword($data['password']);

        return $this->userRepository->create($user->toArray());
    }

    /**
     * Аутентификация пользователя
     */
    public function authenticate($email, $password) {
        $user = $this->userRepository->findByEmail($email);
        
        if (!$user || !$user->verifyPassword($password)) {
            throw new Exception('Неверный email или пароль');
        }

        return $user;
    }

    /**
     * Валидация данных пользователя
     */
    protected function validate(array $data) {
        $errors = [];

        if (empty($data['email']) || !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Неверный формат email';
        }

        if (isset($data['password']) && strlen($data['password']) < 6) {
            $errors['password'] = 'Пароль должен содержать минимум 6 символов';
        }

        if (!empty($errors)) {
            throw new Exception(json_encode($errors));
        }
    }
}
