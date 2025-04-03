<?php
    $connect = $_SERVER['DOCUMENT_ROOT'] . '/php/connect.php';
    require $connect;

    if ($_SERVER['REQUEST_METHOD'] === "POST") {
        if (isset($_SESSION['auth'], $_SESSION['status']) && $_SESSION['auth'] && $_SESSION['status'] === 'admin') {
            $id = $_POST['post_id'];
            $query_img = "SELECT img as img_name FROM posts WHERE id=$id";
            $img = mysqli_fetch_assoc(mysqli_query($link, $query_img));

            if (!empty($img)) {
                $imgPath = $_SERVER['DOCUMENT_ROOT'] . "/uploads/" . $img['img_name'];
                if (file_exists($imgPath)) {
                    unlink($imgPath);
                }
            }

            $query_del = "DELETE FROM posts WHERE id=$id";

            mysqli_query($link, $query_del);

            header('Location: /index.php');
            die();
        }
    }