# PHP MVC Base

Базовый PHP проект с использованием архитектуры MVC.

## Структура проекта

```
php-mvc-base/
├── app/                    # Основная директория приложения
│   ├── Config/            # Конфигурационные файлы
│   ├── Controllers/       # Контроллеры
│   │   ├── Admin/        # Административные контроллеры
│   │   ├── Student/      # Контроллеры для студентов
│   │   ├── AdminController.php
│   │   ├── HomeController.php
│   │   └── StudentController.php
│   ├── Core/             # Ядро фреймворка
│   ├── Database/         # Классы для работы с базой данных
│   ├── Helpers/          # Вспомогательные функции
│   ├── Interfaces/       # Интерфейсы
│   ├── Middleware/       # Промежуточное ПО
│   ├── Models/           # Модели
│   │   ├── Administrator.php
│   │   ├── Attendance.php
│   │   ├── Lesson.php
│   │   ├── LessonPoint.php
│   │   └── Student.php
│   ├── Repositories/     # Репозитории для работы с данными
│   ├── Services/         # Сервисы для бизнес-логики
│   └── Views/            # Представления
├── database/             # Файлы базы данных
├── public/               # Публичная директория
│   └── index.php         # Точка входа в приложение
├── vendor/               # Зависимости Composer
├── .git/                 # Git репозиторий
├── composer.json         # Конфигурация Composer
├── composer.lock         # Зафиксированные версии зависимостей
├── database.sql          # SQL-скрипт базы данных
├── Dockerfile           # Конфигурация Docker
├── docker-compose.yml   # Конфигурация Docker Compose
└── apache.conf          # Конфигурация Apache
```

## Основные компоненты

### Контроллеры
- **HomeController** - Главная страница
- **AdminController** - Управление административной частью
- **StudentController** - Управление студентами
- **Admin/LessonsController** - Управление уроками в административной части
- **Admin/AttendanceController** - Управление посещаемостью и активностью
- **Student/LessonsController** - Управление уроками для студентов

### Модели
- **Administrator** - Модель для работы с администраторами
- **Lesson** - Модель для работы с уроками
- **Student** - Модель для работы с данными студентов
- **Attendance** - Модель для отслеживания посещений и активности на уроках
- **LessonPoint** - Модель для учета баллов за активность

### Дополнительные слои
- **Repositories/** - Слой доступа к данным, реализующий паттерн Repository
- **Services/** - Сервисный слой для бизнес-логики
- **Middleware/** - Промежуточное ПО для обработки запросов
- **Database/** - Классы для работы с базой данных
- **Interfaces/** - Интерфейсы для обеспечения слабой связанности компонентов

## Функциональность

### Система уроков
1. **Управление уроками**
   - Создание и редактирование уроков
   - Назначение спикеров
   - Привязка к группам студентов
   - Добавление Zoom-ссылок для онлайн занятий

2. **Посещение и активность на уроках**
   - Отслеживание посещаемости студентов
   - Автоматическая фиксация времени посещения
   - Система баллов за активность на уроках
   - Управление статусами присутствия (присутствовал/отсутствовал)
   - Начисление и редактирование баллов за активность
   - Современный интерфейс управления посещаемостью
   - Автоматическое начисление баллов за посещение
   - Система кэширования баллов для оптимизации производительности
   - Автоматический подсчет общего количества баллов студента
   - Отображение баллов в реальном времени на дашборде

3. **Система учета баллов**
   - Автоматическое кэширование для быстрого доступа к данным
   - Раздельный учет баллов за посещение и активность
   - Триггеры базы данных для автоматического обновления кэша
   - Оптимизированные SQL-запросы для подсчета баллов
   - Защита от потери данных при параллельных обновлениях
   - Интеграция с профилем и дашбордом студента

3. **Статусы уроков**
   - Активные уроки (доступные для посещения)
   - Завершенные уроки (прошло более 2 часов)
   - История посещений для каждого студента
   - Детальная информация о посещаемости и активности

### Управление студентами
   - Просмотр списка студентов с пагинацией
   - Фильтрация студентов по группам
   - Поиск студентов по имени и другим параметрам
   - Редактирование профиля студента (имя, email, телефон, группа)
   - Блокировка/разблокировка учетных записей студентов
   - Удаление студентов с автоматическим удалением связанных данных
   - Кэширование баллов студентов для оптимизации производительности
   - Защита от дублирования email и телефонных номеров
   - Система логирования действий для отслеживания изменений

### Управление посещаемостью
1. **Интерфейс администратора**
   - Удобный список всех уроков с детальной информацией
   - Быстрое переключение статуса посещаемости
   - Управление баллами за активность через модальное окно
   - Визуальные индикаторы статуса присутствия
   - Группировка информации по урокам с возможностью сворачивания

2. **Система баллов**
   - Начисление баллов за активность на уроках
   - История баллов для каждого студента
   - Возможность редактирования баллов
   - Визуальное отображение баллов с иконками

3. **Аналитика**
   - Отображение статистики посещаемости
   - Учет активности студентов
   - История изменений статусов и баллов

### Управление профилем студента
   - Редактирование личной информации
   - Загрузка и обновление фотографии профиля
   - Обрезка изображения перед загрузкой с помощью Cropper.js
   - Валидация загружаемых изображений (тип файла, размер)
   - Безопасное хранение файлов в директории public/uploads/avatars
   - Автоматическое обновление аватара на всех страницах после загрузки
   - Изменение пароля с проверкой текущего пароля

### Безопасность
- **Аутентификация**
  - Отдельная авторизация для студентов и администраторов
  - Middleware для проверки прав доступа
  - Защита маршрутов от неавторизованного доступа

- **Валидация данных**
  - Проверка входных данных
  - Безопасная работа с базой данных через PDO
  - Защита от SQL-инъекций
  - Валидация данных при обновлении статусов и баллов

## Технологии

### Frontend
- HTML5, CSS3, JavaScript
- Tailwind CSS для стилизации
- Alpine.js для интерактивности
- Cropper.js для обработки изображений

### Backend
- PHP 8.0+
- MySQL/MariaDB
- MVC архитектура
- PDO для работы с базой данных

### Инфраструктура
- Docker и Docker Compose
- Apache веб-сервер
- Git для версионного контроля

## Развертывание

Проект использует Docker для упрощения развертывания:
- `docker-compose.yml` - конфигурация сервисов (PHP, MySQL, phpMyAdmin)
- `Dockerfile` - сборка PHP-окружения
- `apache.conf` - настройка веб-сервера

### Запуск проекта
1. Клонировать репозиторий
2. Выполнить `docker-compose up -d`
3. Импортировать структуру базы данных из `database/migrations/`
4. Приложение будет доступно по адресу `http://localhost:8085`
5. phpMyAdmin доступен по адресу `http://localhost:8086`

## База данных

### Основные таблицы
- `administrators` - Администраторы системы
- `students` - Студенты (включая кэш баллов)
- `lessons` - Уроки и учебные материалы
- `attendance` - Посещения уроков
- `lesson_points` - Баллы за посещение уроков
- `lesson_activity_points` - Баллы за активность на уроках

### Поля таблиц

#### students
- `id` - Уникальный идентификатор
- `name` - Имя студента
- `email` - Email для входа
- `phone` - Телефон
- `password_hash` - Хэш пароля
- `group_id` - ID группы
- `total_points_cache` - Кэш общего количества баллов
- `points_cache_updated_at` - Время последнего обновления кэша
- `created_at` - Дата создания
- `updated_at` - Дата обновления

#### lesson_points
- `id` - Уникальный идентификатор
- `lesson_id` - ID урока
- `student_id` - ID студента
- `points` - Количество баллов за посещение
- `created_at` - Дата начисления

#### lesson_activity_points
- `id` - Уникальный идентификатор
- `lesson_id` - ID урока
- `student_id` - ID студента
- `points` - Количество баллов за активность
- `created_at` - Дата начисления
- `updated_at` - Дата обновления

### Триггеры
- `update_points_cache_after_activity_insert` - Сброс кэша при добавлении баллов за активность
- `update_points_cache_after_activity_update` - Сброс кэша при обновлении баллов за активность
- `update_points_cache_after_lesson_points_insert` - Сброс кэша при добавлении баллов за посещение
- `update_points_cache_after_lesson_points_update` - Сброс кэша при обновлении баллов за посещение
