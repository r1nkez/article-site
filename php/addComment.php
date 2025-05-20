    <?php
        $connect = $_SERVER['DOCUMENT_ROOT'] . '/php/connect.php';
        require $connect;
        $mysqli = getDbConnection();
        
        if ($_SERVER['REQUEST_METHOD'] === "POST") {

            if (empty($_POST['post_id'])) {
                header("Location: /index.php");
                die();
            } else {
                $post_id = $_POST['post_id'];
            }

            if (!isset($_SESSION['auth'], $_SESSION['status'], $_SESSION['id']) || $_SESSION['auth'] !== true) {
                $_SESSION['flash'][] = "Ошибка, нет авторизации";
                header("Location: /pages/post.php?id=$post_id");
                die();
            }

        

            if (empty(trim($_POST['comment']))) {
                $_SESSION['flash'][] = "Ошибка, комментарий не может быть пустым полем";
                header("Location: /pages/post.php?id=$post_id");
                die();
            }

            $user_id = $_SESSION['id'];

            $stmt = $mysqli->prepare("SELECT * FROM posts WHERE id = ?");
            $stmt->bind_param("i", $post_id);
            $stmt->execute();

            $res = $stmt->get_result();
            $post = $res->fetch_assoc();

            if (!$post) {
                $_SESSION['flash'][] = "Ошибка, пост не найден";
                header("Location: /pages/post.php?id=$post_id");
                die();
            }

            $comment = trim($_POST['comment']);

            $stmt = $mysqli->prepare("INSERT INTO comments (post_id, user_id, text) VALUES (?, ?, ?)");
            $stmt->bind_param("iis", $post_id, $user_id, $comment);
            $stmt->execute();

            if ($mysqli->affected_rows > 0) {
                $_SESSION['flash'][] = "Комментарий успешно добавлен";
            } else {
                $_SESSION['flash'][] = "Ошибка при добавлении комментария";
            }

            header("Location: /pages/post.php?id=$post_id");
            die();
            
        }