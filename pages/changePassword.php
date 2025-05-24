<?php

    $connect = $_SERVER['DOCUMENT_ROOT'] . '/php/connect.php';
    require_once $connect;
    $head = $_SERVER['DOCUMENT_ROOT'] . '/templates/head.html';
    require_once $head;
    $mysqli = getDbConnection();
    if (!empty($_SESSION['id'])) {
        
        $id = $_SESSION['id'];
        $stmt = $mysqli->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        // $query = "SELECT * FROM users WHERE id='$id'";

        $res = $stmt->get_result();
        $user = $res->fetch_assoc();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $hash = $user['password'];
            $oldPassword = $_POST['old_password'];
            $newPassword = $_POST['new_password'];
            $newPasswordConfirm = $_POST['new_password_confirm'];

            if (password_verify($oldPassword, $hash)) {
                if ($newPassword === $newPasswordConfirm) {
                    $newHash = password_hash($newPassword, PASSWORD_BCRYPT);
                    $stmt = $mysqli->prepare("UPDATE users SET password = ? WHERE id = ?");
                    $stmt->bind_param("si", $newHash, $id);
                    $stmt->execute();
                    // $query = "UPDATE users SET password='$newHash' WHERE id='$id'";
                    // mysqli_query($link, $query);
                    session_regenerate_id(true);
                    $_SESSION['flash'] = 'Ваш пароль успешно изменен';
                    header('Location: /index.php');
                    die();
                } else {
                    $errors['password'] = 'Новый пароль и его подтверждение не совпадают!';
                }
            } else {
                $errors['wrong_password'] = 'Старый пароль неверный!';
            }
        }
        ?>

        <body>
            <div class="body">
                <?php if (!empty($errors)): 
                    foreach ($errors as $field => $error) {
                        echo "<div class='error-message'>$error</div>";
                    }?>
                    
                <?php endif; ?>
                <h2 class="login-title">Смена пароля</h2>
                <form action="" method="post" class="login-form">
                    
                    <label for="old_password">Старый пароль</label>
                    <input name="old_password" type="password" required>

                    <label for="new_password">Новый пароль</label>
                    <input name="new_password" type="password" required>

                    <label for="new_password_confirm">Подтверждение пароля</label>
                    <input name="new_password_confirm" type="password" required>
            
                    <button type="submit" class="button">Сменить пароль</button>
                </form>
            </div>
        </body>
<?php }
