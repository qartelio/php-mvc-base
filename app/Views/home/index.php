<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $data['title'] ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="/">MVC App</a>
        </div>
    </nav>

    <div class="container mt-4">
        <?php
        $title = $data['title'];
        ?>

        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h1>Главная страница</h1>
                    </div>
                    <div class="card-body">
                        <h2><?= htmlspecialchars($data['message']) ?></h2>
                        
                        <?php if (!isset($_SESSION['user'])): ?>
                            <p class="mt-4">
                                Для доступа к полному функционалу, пожалуйста, 
                                <a href="/user/login">войдите</a> или 
                                <a href="/user/register">зарегистрируйтесь</a>.
                            </p>
                        <?php else: ?>
                            <p class="mt-4">
                                Добро пожаловать, <?= htmlspecialchars($_SESSION['user']['name']) ?>!
                                <br>
                                <a href="/user/profile">Перейти в профиль</a>
                            </p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
