<?php 

    $connect = $_SERVER['DOCUMENT_ROOT'] . '/php/connect.php';
    require_once $connect;
    $head = $_SERVER['DOCUMENT_ROOT'] . '/templates/head.html';
    require_once $head;
    $mysqli = getDbConnection();
    
    if (empty($_SESSION['auth'])) {
        http_response_code(401);
        die();
    }
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id = $_SESSION['id'];
        $stmt = $mysqli->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->bind_param("i", $id);
        // $query = "SELECT * FROM users WHERE id='$id'";
        $stmt->execute();
        $res = $stmt->get_result();
        $user = $res->fetch_assoc();

        $hash = $user['password'];
        
        if (password_verify($_POST['password'], $hash)) {
            $stmt = $mysqli->prepare("DELETE FROM users WHERE id = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            // $query = "DELETE FROM users WHERE id='$id'";
            // mysqli_query($link, $query);
            $_SESSION = [];
            session_destroy();
            header('Location: /index.php');
            die();
        } else {
            $errors['password'] = 'Пароль неверный!';
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
                <h2 class="login-title">Удаление аккаунта</h2>
                <form action="" method="post" class="login-form">

                    <label for="password">Пароль</label>
                    <input type="password" name="password">

                    <button type="submit" class="button-delete" onclick="return confirm('Вы уверены?')">Удалить аккаунт</button>
                </form>
            </div>
        </body>