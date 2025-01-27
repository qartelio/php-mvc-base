<?php
namespace App\Core;

use PDO;
use PDOException;

class Model {
    protected $db;

    public function __construct() {
        try {
            $this->db = new PDO(
                "mysql:host=" . $_ENV['MYSQL_HOST'] . 
                ";dbname=" . $_ENV['MYSQL_DB'] . 
                ";charset=utf8mb4",
                $_ENV['MYSQL_USER'],
                $_ENV['MYSQL_PASSWORD']
            );
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die('Ошибка подключения к базе данных: ' . $e->getMessage());
        }
    }
}
