<?php
$title = 'Профиль';
$user = $data['user'];
?>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h2>Профиль пользователя</h2>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <strong>Имя:</strong>
                    <?= htmlspecialchars($user->getName()) ?>
                </div>
                
                <div class="mb-3">
                    <strong>Email:</strong>
                    <?= htmlspecialchars($user->getEmail()) ?>
                </div>
                
                <div class="mb-3">
                    <strong>Дата регистрации:</strong>
                    <?= $user->getCreatedAt() ?>
                </div>
            </div>
        </div>
    </div>
</div>
