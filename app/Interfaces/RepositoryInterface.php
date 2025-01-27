<?php
namespace App\Interfaces;

interface RepositoryInterface {
    /**
     * Получить все записи
     */
    public function getAll();

    /**
     * Получить запись по ID
     */
    public function getById($id);

    /**
     * Создать новую запись
     */
    public function create(array $data);

    /**
     * Обновить существующую запись
     */
    public function update($id, array $data);

    /**
     * Удалить запись
     */
    public function delete($id);
}
