<?php
    $connect = $_SERVER['DOCUMENT_ROOT'] . '/php/connect.php';
    require_once $connect;
    $mysqli = getDbConnection();

    if ($_SERVER['REQUEST_METHOD'] === "POST") {
        if (isset($_SESSION['auth'], $_SESSION['status']) && $_SESSION['auth'] && $_SESSION['status'] === 'admin') {
            $id = $_POST['post_id'];
            // $query_img = "SELECT img as img_name FROM posts WHERE id=$id";
            $stmt = $mysqli->prepare("SELECT img as img_name FROM posts WHERE id = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $res = $stmt->get_result();
            $img = $res->fetch_assoc();
            // $img = mysqli_fetch_assoc(mysqli_query($link, $query_img));

            if (!empty($img)) {
                $imgPath = $_SERVER['DOCUMENT_ROOT'] . "/uploads/" . $img['img_name'];
                if (file_exists($imgPath)) {
                    unlink($imgPath);
                }
            }
            
            $stmt = $mysqli->prepare("DELETE FROM posts WHERE id = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            // $query_del = "DELETE FROM posts WHERE id=$id";

            // mysqli_query($link, $query_del);

            header('Location: /index.php');
            die();
        }
    }