<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="min-h-screen bg-gray-900 py-6 flex flex-col justify-center sm:py-12">
    <div class="relative py-3 sm:max-w-xl sm:mx-auto">
        <div class="relative px-4 py-10 bg-gray-800 mx-8 md:mx-0 shadow rounded-3xl sm:p-10">
            <div class="max-w-md mx-auto">
                <div class="flex items-center space-x-5">
                    <div class="block pl-2 font-semibold text-xl self-start text-white">
                        <h2 class="leading-relaxed">Вход для учителей</h2>
                    </div>
                </div>

                <?php if (isset($_SESSION['error']) || isset($_SESSION['success'])): ?>
                    <div class="mt-4 <?php echo isset($_SESSION['error']) ? 'text-red-500' : 'text-green-500'; ?>">
                        <?php 
                        if (isset($_SESSION['error'])) {
                            echo $_SESSION['error'];
                            unset($_SESSION['error']);
                        }
                        if (isset($_SESSION['success'])) {
                            echo $_SESSION['success'];
                            unset($_SESSION['success']);
                        }
                        ?>
                    </div>
                <?php endif; ?>

                <form action="/teacher/login" method="POST">
                    <div class="divide-y divide-gray-700">
                        <div class="py-8 text-base leading-6 space-y-4 text-gray-300 sm:text-lg sm:leading-7">
                            <div class="flex flex-col">
                                <input type="email" name="email" id="email" 
                                    class="px-4 py-2 bg-gray-700 border border-gray-600 rounded-lg text-gray-300 focus:outline-none focus:border-blue-500" 
                                    placeholder="Email" required>
                            </div>
                            
                            <div class="flex flex-col">
                                <input type="password" name="password" id="password" 
                                    class="px-4 py-2 bg-gray-700 border border-gray-600 rounded-lg text-gray-300 focus:outline-none focus:border-blue-500" 
                                    placeholder="Пароль" required>
                            </div>

                            <div class="flex items-center">
                                <input type="checkbox" name="remember" id="remember" 
                                    class="w-4 h-4 text-blue-600 border-gray-600 rounded bg-gray-700 focus:ring-blue-500">
                                <label for="remember" class="ml-2 text-sm text-gray-300">
                                    Запомнить меня
                                </label>
                            </div>
                        </div>
                        
                        <div class="pt-4 flex items-center space-x-4">
                            <button type="submit" 
                                class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Войти
                            </button>
                        </div>
                    </div>
                </form>

                <div class="pt-4 text-center text-gray-400">
                    Нет аккаунта? 
                    <a href="/teacher/registration" class="text-blue-500 hover:text-blue-600">Зарегистрироваться</a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    <?php if (isset($_SESSION['error'])): ?>
        Swal.fire({
            icon: 'error',
            title: 'Ошибка',
            text: '<?php echo $_SESSION['error']; ?>',
            background: '#1F2937',
            color: '#fff'
        });
    <?php endif; ?>
    
    <?php if (isset($_SESSION['success'])): ?>
        Swal.fire({
            icon: 'success',
            title: 'Успешно',
            text: '<?php echo $_SESSION['success']; ?>',
            background: '#1F2937',
            color: '#fff'
        });
    <?php endif; ?>
});
</script>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
