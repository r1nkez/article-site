<?php

    $connect = $_SERVER['DOCUMENT_ROOT'] . '/php/connect.php';
    require $connect;
    
    if (!empty($_SESSION['auth'])): ?>
        <!DOCTYPE html>
        <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Document</title>
            </head>
            <body>
               <ul>
                    <li>Пост 1</li>
                    <li>Пост 2</li>
                    <li>Пост 3</li>
               </ul>
            </body>
        </html>
    <?php else:?>
        <!DOCTYPE html>
        <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Document</title>
            </head>
            <body>
               Для просмотра постов пожалуйста авторизуйтесь
            </body>
        </html>
        <?php endif; 