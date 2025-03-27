<?php

	require 'connect.php';
	if (!empty($_SESSION['auth'])) {
		$_SESSION['flash'] = 'Вы уже авторизованы';
		header('Location: index.php');
		die();
	}

	function clean_input($data) {
        return htmlspecialchars(trim($data));
    }

	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		if (!empty($_POST['login']) && !empty($_POST['password'])) {
			$password = $_POST['password'];
			$login = $_POST['login'];
				
			$query = "SELECT * FROM users WHERE login='$login'";
			$res = mysqli_query($link, $query);
			$user = mysqli_fetch_assoc($res);
	
			if 	(!empty($user) && password_verify($_POST['password'], $user['password'])) {
				$_SESSION['auth'] = true;
				$_SESSION['id'] = $user['id'];
				$_SESSION['flash'] = 'Авторизация прошла успешно </br>';
				$_SESSION['login'] = $login;
				$_SESSION['status'] = $user['status'];
				 
				header('Location: index.php');
				die();
			} else {
				$error = 'Неправильный логин или пароль!';
			}
		}
	} ?>
	
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Войти</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
	<div class="body">
		<?php if (!empty($error)): ?>
            <div class="error-message">
                <?= $error ?>
            </div>
        <?php endif; ?>
		<?php if (!isset($_SESSION['auth'])):?>
		<h2 class="login-title">Войти</h2>
		<form action="" method="post" class="login-form">
			<label for="login">Логин</label>
			<input type="text" name="login" id="login" value="<?= isset($_POST['login']) ? htmlspecialchars($_POST['login'], ENT_QUOTES, 'UTF-8') : '' ?>" required>
	
			<label for="password">Пароль</label>
			<input type="password" name="password" id="password" required>
	
			<button type="submit" class="button">Войти</button>
		</form>
		
		<div class="separator"></div>
	
		<div class="register-link">
			<p>У вас еще нет учетной записи?</p>
		</div>
		<div class="register-link" style="margin-top: 10px;">
			<a href="register.php">Зарегистрироваться</a>
		</div>		
	</div>
	<?php endif; ?>
</body>
</html>


