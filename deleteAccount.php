<?php 

    require 'connect.php';
    if (empty($_SESSION['auth'])) {
        http_response_code(401);
        die();
    }
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id = $_SESSION['id'];
        $query = "SELECT * FROM users WHERE id='$id'";
        $res = mysqli_query($link, $query);
        $user = mysqli_fetch_assoc($res);

        $hash = $user['password'];
        
        if (password_verify($_POST['password'], $hash)) {
            $query = "DELETE FROM users WHERE id='$id'";
            mysqli_query($link, $query);
            $_SESSION = [];
            session_destroy();
        } else {
            echo 'Пароль неверный';
        }
    }
?>
    <form action="" method="post">
        <label for="password"></label>
        <input type="password" name="password">
        <button type="submit">Удалить</button>
    </form>