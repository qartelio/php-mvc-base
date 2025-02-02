<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Редактирование профиля</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>
    <style>
        body {
            background: #f1f5f9;
            max-width: 100%;
            overflow-x: hidden;
            min-height: 100vh;
        }
        .app-container {
            max-width: 480px;
            margin: 0 auto;
            background: #ffffff;
            min-height: 100vh;
            position: relative;
        }
        .profile-header {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
        }

        /* Модальное окно для обрезки */
        .modal-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.75);
            z-index: 50;
        }
        .modal-container {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: white;
            padding: 1.5rem;
            border-radius: 0.5rem;
            width: 90%;
            max-width: 500px;
            z-index: 51;
        }
        .crop-container {
            width: 100%;
            height: 300px;
            margin: 1rem 0;
            background: #f8f9fa;
            overflow: hidden;
        }
        #crop-image {
            max-width: 100%;
            max-height: 300px;
        }
    </style>
</head>
<body>
    <div class="app-container">
        <!-- Заголовок -->
        <div class="profile-header p-4 text-white mb-6">
            <div class="flex items-center gap-4">
                <a href="/student/dashboard" class="text-white">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </a>
                <h1 class="text-xl font-bold">Редактирование профиля</h1>
            </div>
        </div>

        <div class="px-4">
            <!-- Аватар -->
            <div class="flex flex-col items-center mb-6">
                <div class="relative mb-4">
                    <div class="w-24 h-24 rounded-full overflow-hidden ring-4 ring-blue-100">
                        <img id="avatar-preview" class="w-full h-full object-cover" 
                             src="<?= !empty($student['avatar']) ? '/public/uploads/avatars/' . htmlspecialchars($student['avatar']) : 'https://flowbite.com/docs/images/people/profile-picture-1.jpg' ?>" 
                             alt="Фото профиля">
                    </div>
                    <label for="avatar-upload" class="absolute bottom-0 right-0 bg-blue-500 text-white p-2 rounded-full cursor-pointer hover:bg-blue-600">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                    </label>
                    <input type="file" id="avatar-upload" class="hidden" accept="image/*">
                </div>
                <p class="text-sm text-gray-500">Нажмите на иконку для загрузки фото</p>
            </div>

            <!-- Форма редактирования профиля -->
            <form id="profile-form" action="/student/profile/update" method="POST" class="space-y-6">
                <!-- Имя -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Имя</label>
                    <input type="text" id="name" name="name" 
                           value="<?= htmlspecialchars($student['name']) ?>"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                           required>
                </div>

                <!-- Телефон -->
                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-700">Телефон</label>
                    <input type="tel" id="phone" name="phone" 
                           value="<?= htmlspecialchars($student['phone']) ?>"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                           required>
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" id="email" name="email" 
                           value="<?= htmlspecialchars($student['email']) ?>"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                           required>
                </div>

                <button type="submit" class="w-full bg-blue-500 text-white py-2 px-4 rounded-md hover:bg-blue-600">
                    Сохранить изменения
                </button>
            </form>

            <!-- Форма смены пароля -->
            <div class="mt-8 pt-8 pb-12 border-t border-gray-200">
                <h2 class="text-lg font-medium text-gray-900 mb-6">Смена пароля</h2>
                
                <?php if (isset($_SESSION['success'])): ?>
                    <div class="mb-4 p-4 text-sm text-green-700 bg-green-100 rounded-lg">
                        <?= htmlspecialchars($_SESSION['success']) ?>
                        <?php unset($_SESSION['success']); ?>
                    </div>
                <?php endif; ?>

                <?php if (isset($_SESSION['error'])): ?>
                    <div class="mb-4 p-4 text-sm text-red-700 bg-red-100 rounded-lg">
                        <?= htmlspecialchars($_SESSION['error']) ?>
                        <?php unset($_SESSION['error']); ?>
                    </div>
                <?php endif; ?>

                <form id="password-form" action="/student/profile/change-password" method="POST" class="space-y-6">
                    <!-- Текущий пароль -->
                    <div>
                        <label for="current_password" class="block text-sm font-medium text-gray-700">Текущий пароль</label>
                        <input type="password" id="current_password" name="current_password" 
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 <?= isset($_SESSION['errors']['current_password']) ? 'border-red-500' : '' ?>"
                               required>
                        <?php if (isset($_SESSION['errors']['current_password'])): ?>
                            <p class="mt-1 text-sm text-red-600">
                                <?= htmlspecialchars($_SESSION['errors']['current_password']) ?>
                            </p>
                        <?php endif; ?>
                    </div>

                    <!-- Новый пароль -->
                    <div>
                        <label for="new_password" class="block text-sm font-medium text-gray-700">Новый пароль</label>
                        <input type="password" id="new_password" name="new_password" 
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 <?= isset($_SESSION['errors']['new_password']) ? 'border-red-500' : '' ?>"
                               required>
                        <?php if (isset($_SESSION['errors']['new_password'])): ?>
                            <p class="mt-1 text-sm text-red-600">
                                <?= htmlspecialchars($_SESSION['errors']['new_password']) ?>
                            </p>
                        <?php endif; ?>
                        <p class="mt-1 text-sm text-gray-500">
                            Минимум 6 символов, должен содержать хотя бы одну букву и одну цифру
                        </p>
                    </div>

                    <!-- Подтверждение пароля -->
                    <div>
                        <label for="confirm_password" class="block text-sm font-medium text-gray-700">Подтвердите пароль</label>
                        <input type="password" id="confirm_password" name="confirm_password" 
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 <?= isset($_SESSION['errors']['confirm_password']) ? 'border-red-500' : '' ?>"
                               required>
                        <?php if (isset($_SESSION['errors']['confirm_password'])): ?>
                            <p class="mt-1 text-sm text-red-600">
                                <?= htmlspecialchars($_SESSION['errors']['confirm_password']) ?>
                            </p>
                        <?php endif; ?>
                    </div>

                    <button type="submit" class="w-full bg-blue-500 text-white py-2 px-4 rounded-md hover:bg-blue-600">
                        Изменить пароль
                    </button>
                </form>
                <?php 
                    // Очищаем ошибки после отображения
                    if (isset($_SESSION['errors'])) {
                        unset($_SESSION['errors']);
                    }
                ?>
            </div>
        </div>
    </div>

    <!-- Модальное окно для обрезки фото -->
    <div id="crop-modal" class="modal-overlay">
        <div class="modal-container">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-medium text-gray-900">Обрезка фотографии</h3>
                <button type="button" id="close-crop" class="text-gray-400 hover:text-gray-500">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <div class="crop-container">
                <img id="crop-image" src="" alt="Фото для обрезки">
            </div>
            <div class="flex justify-end gap-4 mt-4">
                <button type="button" id="cancel-crop" 
                        class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-md hover:bg-gray-200">
                    Отмена
                </button>
                <button type="button" id="save-crop" 
                        class="px-4 py-2 text-sm font-medium text-white bg-blue-500 rounded-md hover:bg-blue-600">
                    Сохранить
                </button>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.js"></script>
    <script>
        // Основные элементы
        const avatarUpload = document.getElementById('avatar-upload');
        const cropModal = document.getElementById('crop-modal');
        const cropImage = document.getElementById('crop-image');
        const closeCropBtn = document.getElementById('close-crop');
        const cancelCropBtn = document.getElementById('cancel-crop');
        const saveCropBtn = document.getElementById('save-crop');
        const avatarPreview = document.getElementById('avatar-preview');

        let cropper = null;

        // Функция для открытия модального окна
        function openModal() {
            cropModal.style.display = 'block';
            document.body.style.overflow = 'hidden';
        }

        // Функция для закрытия модального окна
        function closeModal() {
            cropModal.style.display = 'none';
            document.body.style.overflow = '';
            if (cropper) {
                cropper.destroy();
                cropper = null;
            }
            avatarUpload.value = '';
        }

        // Обработчик выбора файла
        avatarUpload.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (!file) return;

            // Проверка типа файла
            if (!file.type.match('image.*')) {
                alert('Пожалуйста, выберите изображение');
                return;
            }

            // Проверка размера файла (5MB)
            if (file.size > 5 * 1024 * 1024) {
                alert('Размер файла не должен превышать 5MB');
                return;
            }

            // Создаем URL для предпросмотра
            const imageUrl = URL.createObjectURL(file);
            cropImage.src = imageUrl;

            // Открываем модальное окно
            openModal();

            // Инициализируем Cropper после загрузки изображения
            cropImage.onload = function() {
                if (cropper) {
                    cropper.destroy();
                }
                cropper = new Cropper(cropImage, {
                    aspectRatio: 1,
                    viewMode: 1,
                    autoCropArea: 0.8,
                    responsive: true,
                    restore: false,
                    guides: true,
                    center: true,
                    highlight: false,
                    cropBoxMovable: true,
                    cropBoxResizable: true,
                    toggleDragModeOnDblclick: false
                });
            };
        });

        // Обработчики закрытия модального окна
        closeCropBtn.addEventListener('click', closeModal);
        cancelCropBtn.addEventListener('click', closeModal);

        // Сохранение обрезанного изображения
        saveCropBtn.addEventListener('click', function() {
            if (!cropper) return;

            // Показываем индикатор загрузки
            saveCropBtn.disabled = true;
            saveCropBtn.innerHTML = `
                <svg class="animate-spin h-5 w-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Сохранение...
            `;

            cropper.getCroppedCanvas({
                width: 300,
                height: 300,
                fillColor: '#fff',
                imageSmoothingEnabled: true,
                imageSmoothingQuality: 'high'
            }).toBlob(function(blob) {
                const formData = new FormData();
                formData.append('avatar', blob, 'avatar.jpg');

                fetch('/student/profile/update-avatar', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Обновляем превью аватара
                        avatarPreview.src = '/public/uploads/avatars/' + data.avatar + '?t=' + new Date().getTime();
                        closeModal();
                    } else {
                        throw new Error(data.error || 'Произошла ошибка при загрузке аватара');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert(error.message || 'Произошла ошибка при загрузке аватара');
                })
                .finally(() => {
                    // Возвращаем кнопку в исходное состояние
                    saveCropBtn.disabled = false;
                    saveCropBtn.innerHTML = 'Сохранить';
                });
            }, 'image/jpeg', 0.9);
        });

        // Предотвращаем закрытие модального окна при клике на его содержимое
        document.querySelector('.modal-container').addEventListener('click', function(e) {
            e.stopPropagation();
        });

        // Закрываем модальное окно при клике на оверлей
        cropModal.addEventListener('click', closeModal);
    </script>
</body>
</html>
