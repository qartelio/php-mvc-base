<?php
namespace App\Repositories;

use App\Core\Model;
use App\Interfaces\RepositoryInterface;
use PDO;

abstract class BaseRepository extends Model implements RepositoryInterface {
    protected $table;
    
    /**
     * Получить все записи
     */
    public function getAll() {
        $stmt = $this->db->query("SELECT * FROM {$this->table}");
        return $stmt->fetchAll();
    }

    /**
     * Получить запись по ID
     */
    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    /**
     * Создать новую запись
     */
    public function create(array $data) {
        $fields = array_keys($data);
        $values = array_map(fn($field) => ":$field", $fields);
        
        $sql = "INSERT INTO {$this->table} (" . implode(', ', $fields) . ") 
                VALUES (" . implode(', ', $values) . ")";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute($data);
        
        return $this->db->lastInsertId();
    }

    /**
     * Обновить существующую запись
     */
    public function update($id, array $data) {
        $fields = array_map(fn($field) => "$field = :$field", array_keys($data));
        
        $sql = "UPDATE {$this->table} SET " . implode(', ', $fields) . " WHERE id = :id";
        
        $data['id'] = $id;
        $stmt = $this->db->prepare($sql);
        
        return $stmt->execute($data);
    }

    /**
     * Удалить запись
     */
    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM {$this->table} WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }
}
