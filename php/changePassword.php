<?php 
    $connect = $_SERVER['DOCUMENT_ROOT'] . '/php/connect.php';
    require $connect;
    
    if (!empty($_SESSION['id'])) {

    $id = $_SESSION['id'];
    $query = "SELECT * FROM users WHERE id='$id'";

    $res = mysqli_query($link, $query);
    $user = mysqli_fetch_assoc($res);

    if($_SERVER['REQUEST_METHOD'] === 'POST') {
        $hash = $user['password'];
        $oldPassword = $_POST['old_password'];
        $newPassword = $_POST['new_password'];
        $newPasswordConfirm = $_POST['new_password_confirm'];

        if (password_verify($oldPassword, $hash)) {
            if ($newPassword === $newPasswordConfirm) {
                $newHash = password_hash($newPassword, PASSWORD_BCRYPT);
                $query = "UPDATE users SET password='$newHash' WHERE id='$id'";
                mysqli_query($link, $query);
                $_SESSION['flash'] = 'Ваш пароль успешно изменен';
                header('Location: /index.php');
                die();
            } else {
                echo 'Новый пароль и его подтверждение не совпадают!';
            }
        } else {
            echo 'Старый пароль неверный!';
        }
    }
    ?>
<form action="" method="post">
    <input name="old_password" type="password" required>
    <input name="new_password" type="password" required>
    <input name="new_password_confirm" type="password" required>
    <button type="submit">Сменить пароль</button>
</form>
    <?php }
