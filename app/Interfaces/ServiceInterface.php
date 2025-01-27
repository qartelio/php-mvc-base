<?php
namespace App\Interfaces;

interface ServiceInterface {
    /**
     * Получить все записи с применением бизнес-логики
     */
    public function getAll();

    /**
     * Получить запись по ID с применением бизнес-логики
     */
    public function getById($id);

    /**
     * Создать новую запись с валидацией и бизнес-логикой
     */
    public function create(array $data);

    /**
     * Обновить существующую запись с валидацией и бизнес-логикой
     */
    public function update($id, array $data);

    /**
     * Удалить запись с проверкой зависимостей
     */
    public function delete($id);
}
