-- Таблица для отслеживания посещений уроков
CREATE TABLE IF NOT EXISTS attendance (
    id INT PRIMARY KEY AUTO_INCREMENT,
    lesson_id INT NOT NULL,
    student_id INT NOT NULL,
    visited_at DATETIME NOT NULL,
    FOREIGN KEY (lesson_id) REFERENCES lessons(id),
    FOREIGN KEY (student_id) REFERENCES students(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
