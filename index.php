<?php
    $connect = $_SERVER['DOCUMENT_ROOT'] . '/php/connect.php';
    require $connect;
    ?>
<!DOCTYPE html>
<html lang="ru">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="css/style.css">
        <title>Главная</title>
    </head>
    <body>
        <header>
            <nav class="nav-container">
                <div class="logo">ЛОГО</div>
                <ul class="top-menu">
                    <li><a href="">Главная</a></li>
                    <li><a href="#">Статьи</a></li>
                    <li><a href="#">Новости</a></li>
                    <li><a href="#">Контакты</a></li>
                </ul>
                <div class="user-buttons">
                    <?php if (!empty($_SESSION['auth']) && !empty($_SESSION['status']) && $_SESSION['status'] === 'admin'): ?>
                        <div class="admin-button">
                            <a href="pages/admin.php">Админ панель</a>
                        </div>
                    <?php endif; ?>
                    <?php if (!empty($_SESSION['auth'])): ?>
                        <div class="login-button">
                            <a href="pages/account.php">Профиль</a>
                        </div>
                    <?php else: ?>
                        <a href="pages/register.php" style="color: white; text-decoration: none; font-size: 16px; font-family: 'Segoe UI'; font-weight: 500;">Зарегистрироваться</a>
                        <div class="login-button">
                            <a href="pages/login.php">Войти</a>
                        </div>
                    <?php endif; ?>
                </div>
            </nav>
        </header>
        <section class="articles">
            <h2 class="section-title"><img class="icon" src="img/fire.png" alt=""> Популярные статьи</h2>
            <div class="articles-grid">
                <article class="article-card">
                    <img src="img/image1.jfif" alt="Превью статьи">
                    <div class="article-info">
                        <div class="article-meta">
                            <span class="author">Автор статьи</span>
                            <span class="views">👁️ 10,000</span>
                            <span class="time">1 месяц назад</span>
                        </div>
                        <h3 class="article-title">Заголовок статьи</h3>
                        <p class="article-description">Разнообразный и богатый опыт реализация намеченных плановых заданий требуют...</p>
                    </div>
                </article>
        
                <article class="article-card">
                    <img src="img/image2.jfif" alt="Превью статьи">
                    <div class="article-info">
                        <div class="article-meta">
                            <span class="author">Автор статьи</span>
                            <span class="views">👁️ 10,000</span>
                            <span class="time">1 месяц назад</span>
                        </div>
                        <h3 class="article-title">Заголовок статьи</h3>
                        <p class="article-description">Разнообразный и богатый опыт реализация намеченных плановых заданий требуют...</p>
                    </div>
                </article>

                <article class="article-card">
                    <img src="img/image3.png" alt="Превью статьи">
                    <div class="article-info">
                        <div class="article-meta">
                            <span class="author">Автор статьи</span>
                            <span class="views">👁️ 10,000</span>
                            <span class="time">1 месяц назад</span>
                        </div>
                        <h3 class="article-title">Заголовок статьи</h3>
                        <p class="article-description">Разнообразный и богатый опыт реализация намеченных плановых заданий требуют...</p>
                    </div>
                </article>
        
                <article class="article-card">
                    <img src="img/image4.jfif" alt="Превью статьи">
                    <div class="article-info">
                        <div class="article-meta">
                            <span class="author">Автор статьи</span>
                            <span class="views">👁️ 10,000</span>
                            <span class="time">1 месяц назад</span>
                        </div>
                        <h3 class="article-title">Заголовок статьи</h3>
                        <p class="article-description">Разнообразный и богатый опыт реализация намеченных плановых заданий требуют...</p>
                    </div>
                </article>
        
                <article class="article-card">
                    <img src="img/image5.jpeg" alt="Превью статьи">
                    <div class="article-info">
                        <div class="article-meta">
                            <span class="author">Автор статьи</span>
                            <span class="views">👁️ 10,000</span>
                            <span class="time">1 месяц назад</span>
                        </div>
                        <h3 class="article-title">Заголовок статьи</h3>
                        <p class="article-description">Разнообразный и богатый опыт реализация намеченных плановых заданий требуют...</p>
                    </div>
                </article>

                <article class="article-card">
                    <img src="img/image6.jfif" alt="Превью статьи">
                    <div class="article-info">
                        <div class="article-meta">
                            <span class="author">Автор статьи</span>
                            <span class="views">👁️ 10,000</span>
                            <span class="time">1 месяц назад</span>
                        </div>
                        <h3 class="article-title">Заголовок статьи</h3>
                        <p class="article-description">Разнообразный и богатый опыт реализация намеченных плановых заданий требуют...</p>
                    </div>
                </article>
            </div>
        </section>
        <section class="news">
            <h2 class="section-title-news">
                <img class="icon" src="img/news.png" alt=""> Новости
            </h2>
            <ul class="news-list">
                <li>Платформа ArtSport будет автоматически выявлять использование чужой ЭЦП</li>
                <li>Почему парад в честь 80-летия Победы в Астане проведут 7 мая, а не 9-го</li>
                <li>Акимат Астаны хочет изменить рабочий график</li>
                <li>Судья по делу Бишимбаева выиграла спортивные соревнования</li>
            </ul>
        </section>
        
    </body>
</html>