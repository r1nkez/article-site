<?php 
    require 'connect.php';

    if (!empty($_SESSION['id'])) {
        $id = $_SESSION['id'];
        $query = "SELECT * FROM users WHERE id='$id'";
        $res = mysqli_query($link, $query);
        $user = mysqli_fetch_assoc($res);
        $birthDate = DateTime::createFromFormat('Y-m-d', $user['birthday']);
        $now = new DateTime();
        $age = $now->diff($birthDate)->y;
        if ($age >= 5 && $age <= 20) {
            $year = 'лет';
        } elseif ($age % 10 == 1 && $age % 100 != 11) {
            $year = 'год';
        } elseif ($age % 10 >= 2 && $age % 10 <= 4 && ($age % 100 < 10 || $age % 100 >= 20)) {
            $year = 'года';
        } else {
            $year = 'лет';
        }
        if (!empty($user)): 
        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            $name = $_POST['name'];
            $query = "UPDATE users SET name='$name' WHERE id='$id'";
            mysqli_query($link, $query);
            header('Location: account.php');
            die();
        }
        ?>
        <form action="logout.php" method="post">
            <button type="submit" name="logout">Выйти из аккаунта</button>
        </form>
        <p>Ваш логин: <?= $user['login']?></p>
        <p>Ваша почта: <?= $user['email']?></p>
        <p>Ваш возраст: <?= $age ?> <?= $year?><i> (<?= $user['birthday']?>)</i></p>
        <form action="" method="post">
            <input type="text" name="name" value="<?= $user['name'] ? $user['name'] : ''?>">
            <?php if ($user['name']): ?>
                <button type="submit">Изменить имя</button>
            <?php else: ?>
                <button type="submit">Поставить имя</button>
            <?php endif; ?>
        </form>
        <a href="changePassword.php">Сменить пароль</a>
        <a href="deleteAccount.php">Удалить аккаунт</a>
            <?php else: http_response_code(401);
            endif;
    }   