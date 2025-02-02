<?php

namespace App\Models;

use App\Core\Model;
use App\Core\Database;

class Student extends Model {
    protected $table = 'students';
    protected $db;
    
    public function __construct() {
        parent::__construct();
        $this->db = Database::getInstance()->getConnection();
    }
    
    /**
     * Получение студента по ID
     */
    public function findById($id) {
        try {
            $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE id = ?");
            $stmt->execute([$id]);
            return $stmt->fetch();
        } catch (\PDOException $e) {
            error_log('Ошибка при получении студента по ID: ' . $e->getMessage());
            return null;
        }
    }

    // Алиас для совместимости
    public function getById($id) {
        return $this->findById($id);
    }
    
    /**
     * Создание нового студента
     */
    public function create($data) {
        try {
            $data['password_hash'] = password_hash($data['password'], PASSWORD_DEFAULT);
            unset($data['password']);
            
            $columns = implode(', ', array_keys($data));
            $values = implode(', ', array_fill(0, count($data), '?'));
            
            $sql = "INSERT INTO {$this->table} ({$columns}) VALUES ({$values})";
            $stmt = $this->db->prepare($sql);
            
            if ($stmt->execute(array_values($data))) {
                return $this->db->lastInsertId();
            }
            return false;
        } catch (\PDOException $e) {
            error_log('Ошибка при создании студента: ' . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Обновление данных студента
     */
    public function update($id, $data) {
        try {
            error_log('=== Обновление данных в БД ===');
            error_log('ID: ' . $id);
            error_log('Данные: ' . print_r($data, true));
            
            // Формируем SET часть запроса
            $sets = [];
            $values = [];
            foreach ($data as $key => $value) {
                if ($value !== null) {
                    $sets[] = "`{$key}` = ?";
                    $values[] = $value;
                } else {
                    $sets[] = "`{$key}` = NULL";
                }
            }
            
            // Добавляем ID в конец массива значений
            $values[] = $id;
            
            $sql = "UPDATE {$this->table} SET " . implode(', ', $sets) . " WHERE id = ?";
            error_log('SQL: ' . $sql);
            error_log('Значения: ' . print_r($values, true));
            
            $stmt = $this->db->prepare($sql);
            $result = $stmt->execute($values);
            
            error_log('Результат: ' . ($result ? 'успешно' : 'ошибка'));
            error_log('=== Конец обновления в БД ===');
            
            return $result;
        } catch (\PDOException $e) {
            error_log('Ошибка при обновлении данных студента: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Поиск студента по email
     */
    public function findByEmail($email) {
        try {
            $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE email = ?");
            $stmt->execute([$email]);
            return $stmt->fetch();
        } catch (\PDOException $e) {
            error_log('Ошибка при поиске студента по email: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Поиск студента по телефону
     */
    public function findByPhone($phone) {
        try {
            $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE phone = ?");
            $stmt->execute([$phone]);
            return $stmt->fetch();
        } catch (\PDOException $e) {
            error_log('Ошибка при поиске студента по телефону: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Обновление токена запоминания
     */
    public function updateRememberToken($id, $token) {
        try {
            $stmt = $this->db->prepare("UPDATE {$this->table} SET remember_token = ? WHERE id = ?");
            return $stmt->execute([$token, $id]);
        } catch (\PDOException $e) {
            error_log('Ошибка при обновлении токена: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Поиск студента по токену запоминания
     */
    public function findByToken($token) {
        try {
            $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE remember_token = ?");
            $stmt->execute([$token]);
            return $stmt->fetch();
        } catch (\PDOException $e) {
            error_log('Ошибка при поиске студента по токену: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Получение общего количества баллов студента
     * @param int $studentId ID студента
     * @return int Общее количество баллов
     */
    public function getTotalPoints($studentId) {
        try {
            // Проверяем наличие актуального кэша
            $stmt = $this->db->prepare("
                SELECT total_points_cache, points_cache_updated_at 
                FROM {$this->table} 
                WHERE id = ?
            ");
            $stmt->execute([$studentId]);
            $cacheData = $stmt->fetch();
            
            // Если кэш актуален, возвращаем его
            if ($cacheData['points_cache_updated_at'] !== null && $cacheData['total_points_cache'] !== null) {
                return $cacheData['total_points_cache'];
            }
            
            // Если кэш неактуален, считаем сумму баллов
            $stmt = $this->db->prepare("
                SELECT 
                    COALESCE(
                        (SELECT SUM(points) FROM lesson_activity_points WHERE student_id = :student_id), 
                        0
                    ) +
                    COALESCE(
                        (SELECT SUM(points) FROM lesson_points WHERE student_id = :student_id),
                        0
                    ) as total_points
            ");
            $stmt->execute(['student_id' => $studentId]);
            $result = $stmt->fetch();
            $totalPoints = (int)$result['total_points'];
            
            // Обновляем кэш
            $updateStmt = $this->db->prepare("
                UPDATE {$this->table} 
                SET total_points_cache = ?, points_cache_updated_at = CURRENT_TIMESTAMP
                WHERE id = ?
            ");
            $updateStmt->execute([$totalPoints, $studentId]);
            
            return $totalPoints;
        } catch (\PDOException $e) {
            error_log('Ошибка при получении общего количества баллов: ' . $e->getMessage());
            return 0;
        }
    }

    /**
     * Получение списка студентов с пагинацией, фильтрацией и поиском
     * @param int $page Номер страницы
     * @param int $perPage Количество записей на странице
     * @param array $filters Массив фильтров
     * @return array Массив с данными и общим количеством записей
     */
    public function getStudentsList($page = 1, $perPage = 10, $filters = []) {
        try {
            $offset = ($page - 1) * $perPage;
            $whereConditions = [];
            $params = [];

            // Фильтр по группе
            if (!empty($filters['group_id'])) {
                $whereConditions[] = "group_id = ?";
                $params[] = $filters['group_id'];
            }

            // Поиск по имени или email
            if (!empty($filters['search'])) {
                $searchTerm = "%{$filters['search']}%";
                $whereConditions[] = "(name LIKE ? OR email LIKE ?)";
                $params[] = $searchTerm;
                $params[] = $searchTerm;
            }

            // Формируем WHERE часть запроса
            $whereClause = !empty($whereConditions) ? "WHERE " . implode(" AND ", $whereConditions) : "";

            // Получаем общее количество записей
            $countSql = "SELECT COUNT(*) as total FROM {$this->table} {$whereClause}";
            error_log('SQL подсчета: ' . $countSql);
            error_log('Параметры подсчета: ' . print_r($params, true));
            
            $countStmt = $this->db->prepare($countSql);
            $countStmt->execute($params);
            $total = $countStmt->fetch()['total'];
            error_log('Всего записей: ' . $total);

            // Получаем данные с пагинацией
            $sql = "SELECT *, 1 as is_active FROM students 
                   {$whereClause} 
                   ORDER BY id DESC 
                   LIMIT {$perPage} OFFSET {$offset}";
            
            error_log('SQL выборки: ' . $sql);
            
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            $students = $stmt->fetchAll();
            error_log('Получено студентов: ' . count($students));

            return [
                'data' => $students,
                'total' => $total,
                'last_page' => ceil($total / $perPage)
            ];
        } catch (\PDOException $e) {
            error_log('Ошибка при получении списка студентов: ' . $e->getMessage());
            return ['data' => [], 'total' => 0, 'last_page' => 1];
        }
    }

    /**
     * Блокировка/разблокировка студента
     * @param int $id ID студента
     * @param bool $status Новый статус (true - активный, false - заблокированный)
     * @return bool Результат операции
     */
    public function toggleStatus($id, $status) {
        try {
            $stmt = $this->db->prepare("UPDATE {$this->table} SET is_active = ? WHERE id = ?");
            return $stmt->execute([$status ? 1 : 0, $id]);
        } catch (\PDOException $e) {
            error_log('Ошибка при изменении статуса студента: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Удаление студента
     * @param int $id ID студента
     * @return bool Результат операции
     */
    public function delete($id) {
        try {
            error_log('=== Начало удаления студента ===');
            error_log('ID студента: ' . $id);
            
            // Начинаем транзакцию
            $this->db->beginTransaction();
            
            // Удаляем связанные записи о посещаемости
            $sql = "DELETE FROM attendance WHERE student_id = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$id]);
            error_log('Удалены записи о посещаемости');
            
            // Удаляем связанные записи о баллах за уроки
            $sql = "DELETE FROM lesson_points WHERE student_id = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$id]);
            error_log('Удалены записи о баллах за уроки');
            
            // Удаляем связанные записи о баллах за активность
            $sql = "DELETE FROM lesson_activity_points WHERE student_id = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$id]);
            error_log('Удалены записи о баллах за активность');
            
            // Удаляем самого студента
            $sql = "DELETE FROM {$this->table} WHERE id = ?";
            $stmt = $this->db->prepare($sql);
            $result = $stmt->execute([$id]);
            error_log('Удален студент');
            
            // Если все успешно, фиксируем транзакцию
            $this->db->commit();
            error_log('Транзакция зафиксирована');
            
            error_log('=== Конец удаления студента ===');
            return $result;
            
        } catch (\PDOException $e) {
            // В случае ошибки откатываем все изменения
            $this->db->rollBack();
            error_log('Ошибка при удалении студента: ' . $e->getMessage());
            error_log('Транзакция отменена');
            return false;
        }
    }

    /**
     * Получение списка всех групп
     * @return array Список групп
     */
    public function getAllGroups() {
        return [
            ['id' => 1, 'name' => 'Группа 1'],
            ['id' => 2, 'name' => 'Группа 2'],
            ['id' => 3, 'name' => 'Группа 3'],
            ['id' => 4, 'name' => 'Группа 4'],
            ['id' => 5, 'name' => 'Группа 5'],
            ['id' => 6, 'name' => 'Группа 6']
        ];
    }
}
