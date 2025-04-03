<?php
    $connect = $_SERVER['DOCUMENT_ROOT'] . '/php/connect.php';
    require $connect;
    $head = $_SERVER['DOCUMENT_ROOT'] . '/templates/head.html';
    require $head;
    ?>

    <body>
        <?php
            function timeAgo($date_from_db) {
                $date = new DateTime($date_from_db);
                $now = new DateTime();
                $diff = $date->diff($now);
            
                if ($diff->y > 0) {
                    return $diff->y . ' ' . getWord($diff->y, 'год', 'года', 'лет') . ' назад';
                }
                if ($diff->m > 0) {
                    return $diff->m . ' ' . getWord($diff->m, 'месяц', 'месяца', 'месяцев') . ' назад';
                }
                if ($diff->d > 0) {
                    return $diff->d . ' ' . getWord($diff->d, 'день', 'дня', 'дней') . ' назад';
                }
                if ($diff->h > 0) {
                    return $diff->h . ' ' . getWord($diff->h, 'час', 'часа', 'часов') . ' назад';
                }
                if ($diff->i > 0) {
                    return $diff->i . ' ' . getWord($diff->i, 'минута', 'минуты', 'минут') . ' назад';
                }
                return 'только что';
            }
            
            function getWord($number, $form1, $form2, $form5) {
                $n = abs($number) % 100;
                if ($n >= 11 && $n <= 19) {
                    return $form5;
                }
                $n = $n % 10;
                if ($n == 1) {
                    return $form1;
                }
                if ($n >= 2 && $n <= 4) {
                    return $form2;
                }
                return $form5;
            }
            
            $header = $_SERVER['DOCUMENT_ROOT'] . '/templates/header.php';
            require $header; 
            
            $query = "SELECT posts.id, posts.header, posts.text, posts.created_at, posts.img as img_name, users.name as username FROM posts LEFT JOIN users ON posts.author_id=users.id";
            $res = mysqli_query($link, $query);
            
            for ($data = []; $row = mysqli_fetch_assoc($res); $data[] = $row);
            ?>
        <section class="articles">
            <h2 class="section-title"><img class="icon" src="/img/fire.png" alt=""> Популярные статьи</h2>
            <div class="articles-grid">
                <?php 
                    foreach ($data as $post): ?>
                <article class="article-card">
                <a href="/pages/post.php?id=<?= $post['id']?>" style="text-decoration: none;"></a>
                    <img src="/uploads/<?= $post['img_name']?>" alt="Превью статьи">
                    <div class="article-info">
                        <div class="article-meta">
                            <span class="author"><?= $post['username']?></span>
                            <span class="views">👁️ 10,000</span>
                            <span class="time"><?= timeAgo($post['created_at'])?></span>
                        </div>
                        <h3 class="article-title"><?= $post['header']?></h3>
                        <p class="article-description"><?= mb_substr($post['text'], 0, 107)?>...</p>
                    </div>
                </article>
                <?php endforeach;
                die(); ?>
        
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