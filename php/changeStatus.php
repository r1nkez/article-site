<?php
    $connect = $_SERVER['DOCUMENT_ROOT'] . '/php/connect.php';
    require $connect;
    $mysqli = getDbConnection();

    if (isset($_SESSION['auth'], $_SESSION['status']) && $_SESSION['auth'] && $_SESSION['status'] === 'admin') {
        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            $id = $_POST['id'];
            if ($id == $_SESSION['id']) {
                die('Вы не можете изменять свой статус!');
            }

            $status = $_POST['status'];
            $stmt = $mysqli->prepare("UPDATE users SET status = ? WHERE id = ?");
            $stmt->bind_param("si", $status, $id);
            $stmt->execute();
            // $query = "UPDATE users SET status='$status' WHERE id='$id'";
            // mysqli_query($link, $query);
            header('Location: /admin/users.php');
            die();
        } 
    } else {
        header('Location: /index.php');
        die();
    }