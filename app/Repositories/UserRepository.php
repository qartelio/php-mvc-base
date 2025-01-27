<?php
namespace App\Repositories;

use App\Models\User;

class UserRepository extends BaseRepository {
    protected $table = 'users';

    /**
     * Найти пользователя по email
     */
    public function findByEmail($email) {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE email = :email");
        $stmt->execute(['email' => $email]);
        $data = $stmt->fetch();
        
        return $data ? new User($data) : null;
    }

    /**
     * Переопределяем метод getById для возврата объекта User
     */
    public function getById($id) {
        $data = parent::getById($id);
        return $data ? new User($data) : null;
    }

    /**
     * Переопределяем метод getAll для возврата массива объектов User
     */
    public function getAll() {
        $data = parent::getAll();
        return array_map(fn($item) => new User($item), $data);
    }
}
