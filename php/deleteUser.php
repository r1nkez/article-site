<?php
    $connect = $_SERVER['DOCUMENT_ROOT'] . '/php/connect.php';
    require_once $connect;
    $mysqli = getDbConnection();
    
    if (isset($_SESSION['auth'], $_SESSION['status']) && $_SESSION['auth'] && $_SESSION['status'] === 'admin') {
        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            if (isset($_POST['id'])) {
                $id = intval($_POST['id']);

                if ($id == $_SESSION['id']) {
                    die('Вы не можете удалить свой аккаунт!');
                }
                $stmt = $mysqli->prepare("DELETE FROM users WHERE id = ?");
                $stmt->bind_param("i", $id);
                $stmt->execute();
                // $query = "DELETE FROM users WHERE id='$id'";
                // mysqli_query($link, $query);
                
                header('Location: /admin/users.php');
                die();
            }
        }
    }