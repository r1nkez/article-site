<?php

	$connect = $_SERVER['DOCUMENT_ROOT'] . '/php/connect.php';
	require $connect;
	$head = $_SERVER['DOCUMENT_ROOT'] . '/templates/head.html';
    require $head;
	$mysqli = getDbConnection();

	if (!empty($_SESSION['auth'])) {
		$_SESSION['flash'] = 'Вы уже авторизованы';
		header('Location: /index.php');
		die();
	}

	function clean_input($data) {
        return htmlspecialchars(trim($data));
    }

	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		if (!empty($_POST['login']) && !empty($_POST['password'])) {
			$password = $_POST['password'];
			$login = $_POST['login'];
			
			$stmt = $mysqli->prepare("SELECT * FROM users WHERE login = ?");
			$stmt->bind_param("s", $login);
			$stmt->execute();
			$res = $stmt->get_result();
			$user = $res->fetch_assoc();
	
			if 	(!empty($user) && password_verify($_POST['password'], $user['password'])) {
				session_regenerate_id(true);
                unset($_SESSION['flash']);
				$_SESSION['auth'] = true;
				$_SESSION['id'] = $user['id'];
				$_SESSION['login'] = $login;
				$_SESSION['status'] = $user['status'];
				 
				header('Location: /pages/account.php');
				die();
			} else {
				$errors['password'] = 'Неправильный логин или пароль!';
			}
		}
	} ?>
	
<body>
	<div class="body">
		<?php if (!empty($errors)): 
			foreach ($errors as $field => $error) {
				echo "<div class='error-message'>$error</div>";
			}?>
                    
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


