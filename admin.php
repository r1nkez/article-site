<?php 
    require 'connect.php';
    if (!empty($_SESSION['auth'])) {
        $id = $_SESSION['id'];
        $query = "SELECT status FROM users WHERE id='$id'";
        $res = mysqli_query($link, $query);
        $user = mysqli_fetch_assoc($res);

        $_SESSION['status'] = $user['status'];
    }

    if (isset($_SESSION['auth'], $_SESSION['status']) && $_SESSION['auth'] && $_SESSION['status'] === 'admin'): 
        $query = "SELECT id, login, status FROM users";
        $res = mysqli_query($link, $query);
        for ($data = []; $row = mysqli_fetch_assoc($res); $data[] = $row);
    ?>
        <table border="1" style="text-align: center; margin: auto; width: 60%;">
            <tr>
                <th>ID</th>
                <th>Login</th>
                <th>Status</th>
                <th>Change Status</th>
                <th>Delete</th>
            </tr>
            <?php foreach ($data as $user): ?>
                <tr style="background-color: <?php echo ($user['status'] === 'admin') ? '#f22424' : '#37f056'; ?>;">
                    <td><?= $user['id']; ?></td>
                    <td><?= $user['login']; ?></td>
                    <td><?= $user['status']; ?></td>
                    <td>
                        <form action="changeStatus.php" method="post" onsubmit="return confirm('Вы уверены?');">
                            <input type="hidden" name="id" value="<?= $user['id']?>">
                            <input type="hidden" name="status" value="<?= ($user['status'] === 'admin') ? 'user' : 'admin'?>">
                            <button type="submit"><?= ($user['status'] === 'admin') ? 'Сделать юзером' : 'Сделать админом'?></button>
                        </form>  
                    </td>
                    <td>
                        <form action="deleteUser.php" method="post" onsubmit="return confirm('Вы уверены, что хотите удалить пользователя?');">
                            <input type="hidden" name="id" value="<?= $user['id']?>">
                            <button type="submit" class="delete-btn">Delete</button>
                        </form>
                    </td>
                </tr>

            <?php endforeach; ?>
        </table>
    <?php else: 
    header('Location: index.php');
    die();
    endif;
    ?>
    <link rel="stylesheet" href="style.css">