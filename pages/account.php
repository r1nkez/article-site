<?php
    $connect = $_SERVER['DOCUMENT_ROOT'] . '/php/connect.php';
    require_once $connect;
    $mysqli = getDbConnection();

    if (!empty($_SESSION['id'])) {
        
        $head = $_SERVER['DOCUMENT_ROOT'] . '/templates/head.html';
        require_once $head;
        $header = $_SERVER['DOCUMENT_ROOT'] . '/templates/header.php';
        require_once $header;
       
        $id = $_SESSION['id'];
        $stmt = $mysqli->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $res = $stmt->get_result();
        // $query = "SELECT * FROM users WHERE id='$id'";
        // $res = mysqli_query($link, $query);
        $user = $res->fetch_assoc();
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
                
                $stmt = $mysqli->prepare("UPDATE users SET name = ? WHERE id = ?");
                $stmt->bind_param('si', $name, $id);
                $stmt->execute();
                // $query = "UPDATE users SET name='$name' WHERE id='$id'";
                // mysqli_query($link, $query);
                header('Location: account.php');
                die();
            }
            ?>
            <div class="profile-container">
            <h2 class="h2-profile">Личный кабинет</h2>
            <div class="profile-card">
                <p><strong>Ваш логин:</strong> <?= htmlspecialchars($user['login']) ?></p>
                <p><strong>Ваша почта:</strong> <?= htmlspecialchars($user['email']) ?></p>
                <p><strong>Ваш возраст:</strong> <?= $age ?> <?= $year ?> <i>(<?= $user['birthday'] ?>)</i></p>

                <form action="" method="post" class="profile-form">
                    <input type="text" name="name" value="<?= htmlspecialchars($user['name'] ?? '') ?>" placeholder="Введите имя">
                    <button type="submit" class="profile-button"><?= $user['name'] ? 'Изменить имя' : 'Поставить имя' ?></button>
                </form>

                <div class="profile-links">
                    <a href="/pages/changePassword.php" class="profile-link-button">Сменить пароль</a>
                    <a href="/pages/deleteAccount.php" class="profile-delete-button">Удалить аккаунт</a>
                </div>

                <form action="/pages/logout.php" method="post">
                    <button type="submit" name="logout" class="button profile-logout-button">Выйти</button>
                </form>
            </div>
        </div>
            <?php else: http_response_code(401);
        endif;
    } else {

    }