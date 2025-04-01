<header>
    <nav class="nav-container">
        <div class="logo">ЛОГО</div>
        <ul class="top-menu">
            <li><a href="/index.php">Главная</a></li>
            <li><a href="#">Статьи</a></li>
            <li><a href="#">Новости</a></li>
            <li><a href="#">Контакты</a></li>
        </ul>
        <div class="user-buttons">
            <?php if (!empty($_SESSION['auth']) && !empty($_SESSION['status']) && $_SESSION['status'] === 'admin'): ?>
                <div class="admin-button">
                    <a href="/admin/users.php">Админ панель</a>
                </div>
            <?php endif; ?>
            <?php if (!empty($_SESSION['auth'])):?>
                <div class="login-button">
                    <a href="/pages/addPost.php">Добавить статью</a>
                </div>
                <div class="login-button">
                    <a href="/pages/account.php">Профиль</a>
                </div>
            <?php else: ?>
                <a href="/pages/register.php" style="color: white; text-decoration: none; font-size: 16px; font-family: 'Segoe UI'; font-weight: 500;">Зарегистрироваться</a>
                <div class="login-button">
                    <a href="/pages/login.php">Войти</a>
                </div>
            <?php endif; ?>
        </div>
    </nav>
</header>