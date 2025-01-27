<?php

// Информация о PHP
phpinfo();

// Проверка подключения к MySQL
try {
    $dsn = "mysql:host=mysql;dbname=myapp;charset=utf8mb4";
    $username = "root";
    $password = "rootpassword";
    
    $pdo = new PDO($dsn, $username, $password);
    echo "<h2>Подключение к MySQL успешно!</h2>";
} catch (PDOException $e) {
    echo "<h2>Ошибка подключения к MySQL: " . $e->getMessage() . "</h2>";
}
