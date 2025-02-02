-- Таблица для хранения баллов за посещение уроков
CREATE TABLE IF NOT EXISTS lesson_points (
    id INT PRIMARY KEY AUTO_INCREMENT,
    lesson_id INT NOT NULL,
    student_id INT NOT NULL,
    points INT DEFAULT 1,
    created_at DATETIME NOT NULL,
    FOREIGN KEY (lesson_id) REFERENCES lessons(id),
    FOREIGN KEY (student_id) REFERENCES students(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
