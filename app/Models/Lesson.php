<?php

namespace App\Models;

use App\Core\Model;
use PDOException;

class Lesson extends Model
{
    public function getAllWithCreator()
    {
        try {
            $sql = "SELECT l.*, a.name as creator_name 
                    FROM lessons l 
                    LEFT JOIN administrators a ON l.created_by = a.id 
                    ORDER BY l.datetime DESC";
            
            return $this->db->query($sql)->fetchAll();
        } catch (PDOException $e) {
            error_log('Ошибка при получении списка уроков: ' . $e->getMessage());
            return [];
        }
    }

    /**
     * Получает список уроков для определенной группы
     */
    public function getLessonsByGroup($groupId)
    {
        try {
            $sql = "SELECT l.*, l.speaker as teacher_name 
                    FROM lessons l 
                    WHERE l.`group` = :group_id 
                    ORDER BY l.datetime DESC";
            
            $stmt = $this->db->prepare($sql);
            $stmt->execute(['group_id' => $groupId]);
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            error_log('Ошибка при получении списка уроков для группы: ' . $e->getMessage());
            return [];
        }
    }

    public function create($data)
    {
        try {
            // Отладочная информация
            error_log('SQL данные для создания урока: ' . print_r($data, true));

            $sql = "INSERT INTO lessons (title, speaker, datetime, `group`, zoom_link, created_by) 
                    VALUES (:title, :speaker, :datetime, :group, :zoom_link, :created_by)";
            
            $stmt = $this->db->prepare($sql);
            $result = $stmt->execute($data);

            if (!$result) {
                error_log('Ошибка при выполнении SQL запроса: ' . print_r($stmt->errorInfo(), true));
                return false;
            }

            return true;
        } catch (PDOException $e) {
            error_log('PDO ошибка при создании урока: ' . $e->getMessage());
            throw $e;
        }
    }

    public function update($id, $data)
    {
        try {
            // Отладочная информация
            error_log('SQL данные для обновления урока: ' . print_r($data, true));
            error_log('ID урока для обновления: ' . $id);

            $sql = "UPDATE lessons 
                    SET title = :title, 
                        speaker = :speaker, 
                        datetime = :datetime, 
                        `group` = :group, 
                        zoom_link = :zoom_link 
                    WHERE id = :id";
            
            // Преобразование формата datetime
            $data['datetime'] = str_replace('T', ' ', $data['datetime']);
            $data['id'] = $id;

            $stmt = $this->db->prepare($sql);
            $result = $stmt->execute($data);

            if (!$result) {
                error_log('Ошибка при выполнении SQL запроса обновления: ' . print_r($stmt->errorInfo(), true));
                return false;
            }

            return true;
        } catch (PDOException $e) {
            error_log('PDO ошибка при обновлении урока: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Получает урок по ID
     */
    public function getById($id)
    {
        try {
            $sql = "SELECT * FROM lessons WHERE id = :id";
            $stmt = $this->db->prepare($sql);
            $stmt->execute(['id' => $id]);
            return $stmt->fetch();
        } catch (PDOException $e) {
            error_log('Ошибка при получении урока по ID: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Удаляет урок по ID
     * 
     * @param int $id ID урока
     * @return array Массив с результатом операции
     */
    public function delete($id) {
        try {
            // Проверяем существование урока
            $checkSql = "SELECT id FROM lessons WHERE id = :id LIMIT 1";
            $checkStmt = $this->db->prepare($checkSql);
            $checkStmt->execute(['id' => $id]);
            
            if (!$checkStmt->fetch()) {
                return [
                    'success' => false,
                    'message' => 'Урок не найден'
                ];
            }

            // Удаляем урок
            $deleteSql = "DELETE FROM lessons WHERE id = :id";
            $deleteStmt = $this->db->prepare($deleteSql);
            
            if (!$deleteStmt->execute(['id' => $id])) {
                $error = $deleteStmt->errorInfo();
                error_log("Ошибка SQL при удалении урока {$id}: " . $error[2]);
                return [
                    'success' => false,
                    'message' => 'Ошибка при удалении урока'
                ];
            }

            return [
                'success' => true,
                'message' => 'Урок успешно удален'
            ];
            
        } catch (\PDOException $e) {
            error_log("PDO ошибка при удалении урока {$id}: " . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Ошибка базы данных при удалении урока'
            ];
        } catch (\Exception $e) {
            error_log("Общая ошибка при удалении урока {$id}: " . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Произошла ошибка при удалении урока'
            ];
        }
    }
}
