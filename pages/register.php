<?php
    $connect = $_SERVER['DOCUMENT_ROOT'] . '/php/connect.php';
    require_once $connect;
    $head = $_SERVER['DOCUMENT_ROOT'] . '/templates/head.html';
    require_once $head;
    $mysqli = getDbConnection();

    if (!empty($_SESSION['auth'])) {
		$_SESSION['flash'] = 'Вы уже авторизованы';
		header('Location: /index.php');
		die();
	}
    function clean_input($data) {
        return htmlspecialchars(trim($data));
    }

    if ($_SERVER['REQUEST_METHOD'] === "POST") {
        $errors = [];
        
        $login = isset($_POST['login']) ? clean_input($_POST['login']) : '';
        $password = isset($_POST['password']) ? clean_input($_POST['password']) : '';
        $confirm = isset($_POST['confirm']) ? clean_input($_POST['confirm']) : '';
        $email = isset($_POST['email']) ? clean_input($_POST['email']) : '';
        $birthday = isset($_POST['birthday']) ? clean_input($_POST['birthday']) : '';

        if (empty($login)) {
            $errors['login'] = 'Логин обязателен!';
        } elseif (!preg_match('/^[a-zA-Z0-9]{4,10}$/', $login)) {
            $errors['login'] = 'Логин должен содержать только латинские буквы и цифры (4-10 символов).';
        }

        if (empty($password)) {
            $errors['password'] = 'Пароль обязателен!';
        } elseif (!preg_match('/^[a-zA-Z0-9]{6,12}$/', $password)) {
            $errors['password'] = 'Пароль должен содержать только латинские буквы и цифры (6-12 символов).';
        } elseif ($password !== $confirm) {
            $errors['confirm'] = 'Пароли не совпадают!';
        }

        if (empty($email)) {
            $errors['email'] = 'Email обязателен!';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Некорректный формат email!';
        }


        if (empty($birthday)) {
            $errors['birthday'] = 'Дата рождения обязательна!';
        } else {
            $birthDate = DateTime::createFromFormat('Y-m-d', $birthday);
            $now = new DateTime();
            $age = $now->diff($birthDate)->y;
            if ($age < 18) {
                $errors['birthday'] = 'Вам должно быть больше 18 лет!';
            }
        }

        if (empty($errors)) {
            $stmt = $mysqli->prepare("SELECT * FROM users WHERE login = ?");
            $stmt->bind_param("s", $login);
            $stmt->execute();
            // $query = "SELECT * FROM users WHERE login='$login'";
            $res = $stmt->get_result();
            $user = $res->fetch_assoc();

            if (empty($user)) {
                $date = date('Y-m-d');
                $password = password_hash($password, PASSWORD_BCRYPT);

                $stmt = $mysqli->prepare("INSERT INTO users (login, password, registration_date, email, birthday, status) 
                        VALUES (?, ?, ?, ?, ?, 'user')");
                $stmt->bind_param("sssss", $login, $password, $date, $email, $birthday);
                $stmt->execute();
                // $query = "INSERT INTO users (login, password, registration_date, email, birthday, status) 
                //         VALUES ('$login', '$password', '$date', '$email', '$birthday', 'user')";
                // mysqli_query($link, $query);
                session_regenerate_id(true);
                unset($_SESSION['flash']);
                $id = $mysqli->insert_id;
                $_SESSION['auth'] = true;
                $_SESSION['id'] = $id;
                $_SESSION['login'] = $login;
                $_SESSION['status'] = 'user';
                header('Location: /pages/account.php');
                die();
            } else {
                $errors['login'] = 'Такой логин уже занят, придумайте другой!';
            }
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
		<?php if (!isset($_SESSION['auth'])):?>
		<h2 class="register-title">Зарегестрироваться</h2>
		<form action="" method="post" class="login-form">
			<label for="login">Логин</label>
			<input type="text" name="login" id="login" value="<?= isset($_POST['login']) ? htmlspecialchars($_POST['login'], ENT_QUOTES, 'UTF-8') : '' ?>" required>

            <label for="email">E-mail</label>
            <input type="email" name="email" value="<?= !empty($_POST['email']) ? $_POST['email'] : ''?>" required>
	
			<label for="password">Пароль</label>
			<input type="password" name="password" id="password" required>

            <label for="confirm">Подтверждение пароля</label>
            <input type="password" name="confirm" required>

            <label for="birthday">Дата</label>
            <input type="date" name="birthday" value="<?= !empty($_POST['birthday']) ? $_POST['birthday'] : ''?>" required>

			<button type="submit" class="button">Зарегестрироваться</button>
		</form>
		
		<div class="separator"></div>
	
		<div class="register-link">
			<p>Уже есть учетная запись?</p>
		</div>
		<div class="register-link" style="margin-top: 10px;">
			<a href="login.php">Войти</a>
		</div>		
	</div>
	<?php endif; ?>
</body>
</html>

