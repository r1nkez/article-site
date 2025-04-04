<?php
    $connect = $_SERVER['DOCUMENT_ROOT'] . '/php/connect.php';
    require $connect;
    $head = $_SERVER['DOCUMENT_ROOT'] . '/templates/head.html';
    require $head;
    $header = $_SERVER['DOCUMENT_ROOT'] . '/templates/header.php';
    require $header; 
    ?>

    <body>
        <section class="news">
            <h2 class="section-title-news">
                <img class="icon" src="/img/news.png" alt=""> Новости
            </h2>
            <ul class="news-list">
                <li>Платформа ArtSport будет автоматически выявлять использование чужой ЭЦП</li>
                <li>Почему парад в честь 80-летия Победы в Астане проведут 7 мая, а не 9-го</li>
                <li>Акимат Астаны хочет изменить рабочий график</li>
                <li>Судья по делу Бишимбаева выиграла спортивные соревнования</li>
            </ul>
        </section>
    </body>
