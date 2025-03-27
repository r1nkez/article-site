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
                $errors['birthday'] = 'Вам должно быть 18 лет и старше!';
            }
        }

        if (empty($errors)) {
            $query = "SELECT * FROM users WHERE login='$login'";
            $user = mysqli_fetch_assoc(mysqli_query($link, $query));

            if (empty($user)) {
                $date = date('Y-m-d');
                $password = password_hash($password, PASSWORD_BCRYPT);

                $query = "INSERT INTO users (login, password, registration_date, email, birthday, status) 
                        VALUES ('$login', '$password', '$date', '$email', '$birthday', 'user')";
                mysqli_query($link, $query);

                $id = mysqli_insert_id($link);
                $_SESSION['auth'] = true;
                $_SESSION['id'] = $id;
                $_SESSION['login'] = $login;
                $_SESSION['status'] = 'user';
                header('Location: index.php');
                die();
            } else {
                $errors['login'] = 'Такой логин уже занят, придумайте другой!';
            }
        }

        foreach ($errors as $field => $error) {
            echo "<p style='color:red'>$error</p>";
        }
    } ?>

<form action="" method="post">
    <label for="login">login</label>
    <input type="text" name="login" id="login" value="<?= !empty($_POST['login']) ? $_POST['login'] : ''?>" required><br>

    <label for="email">e-mail</label>
    <input type="email" name="email" value="<?= !empty($_POST['email']) ? $_POST['email'] : ''?>" required><br>

    <label for="password">password</label>
    <input type="password" name="password" required><br>

    <label for="confirm">confirm</label>
    <input type="password" name="confirm" required><br>

    <label for="birthday">your birthday</label>
    <input type="date" name="birthday" value="<?= !empty($_POST['birthday']) ? $_POST['birthday'] : ''?>" required>
    <button type="submit">Register</button>
</form>

