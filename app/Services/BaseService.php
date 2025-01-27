<?php
namespace App\Services;

use App\Interfaces\ServiceInterface;
use App\Interfaces\RepositoryInterface;

abstract class BaseService implements ServiceInterface {
    protected $repository;

    public function __construct(RepositoryInterface $repository) {
        $this->repository = $repository;
    }

    /**
     * Получить все записи
     */
    public function getAll() {
        return $this->repository->getAll();
    }

    /**
     * Получить запись по ID
     */
    public function getById($id) {
        return $this->repository->getById($id);
    }

    /**
     * Создать новую запись
     */
    public function create(array $data) {
        $this->validate($data);
        return $this->repository->create($data);
    }

    /**
     * Обновить существующую запись
     */
    public function update($id, array $data) {
        $this->validate($data);
        return $this->repository->update($id, $data);
    }

    /**
     * Удалить запись
     */
    public function delete($id) {
        return $this->repository->delete($id);
    }

    /**
     * Валидация данных
     */
    abstract protected function validate(array $data);
}
