<?php
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    if (!empty($_SESSION['flash'])) {
        echo $_SESSION['flash'];
        unset($_SESSION['flash']);
    }

    if (!empty($_SESSION['auth'])):
    echo "Login: $_SESSION[login]";
    ?>
    <body>
        <form action="logout.php" method="post">
            <button type="submit" name="logout">Выйти из аккаунта</button>
        </form>
    </body>
    <?php else: ?>
        <form action="register.php" method="post">
            <button type="submit">Register</button>
        </form>
        <form action="login.php" method="post">
            <button type="submit">Login</button>
        </form>
    <?php endif;