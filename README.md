# PHP MVC Base

Базовый PHP проект с использованием архитектуры MVC.

## Структура проекта

```
php-mvc-base/
├── app/                    # Основная директория приложения
│   ├── Config/            # Конфигурационные файлы
│   ├── Controllers/       # Контроллеры
│   │   ├── Admin/        # Административные контроллеры
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
│   │   ├── Lesson.php
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

### Модели
- **Administrator** - Модель для работы с администраторами
- **Lesson** - Модель для работы с уроками
- **Student** - Модель для работы с данными студентов

### Дополнительные слои
- **Repositories/** - Слой доступа к данным, реализующий паттерн Repository
- **Services/** - Сервисный слой для бизнес-логики
- **Middleware/** - Промежуточное ПО для обработки запросов
- **Database/** - Классы для работы с базой данных
- **Interfaces/** - Интерфейсы для обеспечения слабой связанности компонентов

## Принципы организации кода

1. **Строгое разделение ответственности (MVC)**
   - Модели отвечают за бизнес-логику и данные
   - Контроллеры обрабатывают запросы
   - Представления отвечают только за отображение

2. **Многоуровневая архитектура**
   - Контроллеры используют сервисы
   - Сервисы работают через репозитории
   - Репозитории взаимодействуют с моделями

3. **Чистый код**
   - Использование интерфейсов для уменьшения связанности
   - Следование принципу единой ответственности
   - Централизованная маршрутизация

4. **Безопасность**
   - Middleware для аутентификации и авторизации
   - Валидация входных данных
   - Защита от SQL-инъекций через слой абстракции базы данных

## Развертывание

Проект использует Docker для упрощения развертывания:
- `docker-compose.yml` - конфигурация сервисов
- `Dockerfile` - сборка PHP-окружения
- `apache.conf` - настройка веб-сервера

## База данных

Структура базы данных находится в файле `database.sql` и включает таблицы для:
- Администраторов
- Студентов
- Уроков
