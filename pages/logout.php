<?php
    session_start();
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['logout'])) {
            unset($_SESSION['auth']);
            $_SESSION['flash'] = 'Вы успешно вышли из аккаунта!';

            header("Location: /index.php");
            die();
        }
    }