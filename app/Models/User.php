<?php
namespace App\Models;

class User {
    private $id;
    private $email;
    private $password;
    private $name;
    private $createdAt;

    public function __construct(array $data = []) {
        $this->id = $data['id'] ?? null;
        $this->email = $data['email'] ?? '';
        $this->password = $data['password'] ?? '';
        $this->name = $data['name'] ?? '';
        $this->createdAt = $data['created_at'] ?? null;
    }

    // Геттеры
    public function getId() {
        return $this->id;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getName() {
        return $this->name;
    }

    public function getCreatedAt() {
        return $this->createdAt;
    }

    // Сеттеры
    public function setEmail($email) {
        $this->email = $email;
    }

    public function setPassword($password) {
        $this->password = password_hash($password, PASSWORD_DEFAULT);
    }

    public function setName($name) {
        $this->name = $name;
    }

    // Методы
    public function verifyPassword($password) {
        return password_verify($password, $this->password);
    }

    public function toArray() {
        return [
            'id' => $this->id,
            'email' => $this->email,
            'name' => $this->name,
            'created_at' => $this->createdAt
        ];
    }
}
