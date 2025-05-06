<?php

    if (empty($_GET['id'])) {
        http_response_code(404);
        die("Ошибка 404: Страница не найдена.");
    }


    $connect = $_SERVER['DOCUMENT_ROOT'] . '/php/connect.php';
    require $connect;
    $head = $_SERVER['DOCUMENT_ROOT'] . '/templates/head.html';
    require $head;
    $header = $_SERVER['DOCUMENT_ROOT'] . '/templates/header.php';
    require $header;
    $mysqli = getDbConnection();


    $id = htmlspecialchars($_GET['id']);
    
    $stmt = $mysqli->prepare("SELECT posts.id, posts.header, posts.text, posts.img as img_name, posts.created_at, users.name as username FROM posts LEFT JOIN users ON posts.author_id=users.id WHERE posts.id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $res = $stmt->get_result();

    // $query = "SELECT posts.id, posts.header, posts.text, posts.img as img_name, posts.created_at, users.name as username FROM posts LEFT JOIN users ON posts.author_id=users.id WHERE posts.id=$id";
    
    // $res = mysqli_query($link, $query);
    $post = $res->fetch_assoc();
    

    if (!$post) {
        http_response_code(404);
        die("Ошибка 404: Страница не найдена.");
    }
    ?>
    
        <?php if (isset($_SESSION['auth'], $_SESSION['status']) && $_SESSION['auth'] && $_SESSION['status'] === 'admin'): 
            if ($_SERVER['REQUEST_METHOD'] === "POST") {
                $header_post = $_POST['header'];
                $text = $_POST['text'];
                $update_id = $_POST['id'];
                
                $stmt = $mysqli->prepare("UPDATE posts SET header = ?, text = ? WHERE id = ?");
                $stmt->bind_param("ssi", $header_post, $text, $id);

                $query_update = "UPDATE posts SET header='$header_post', text='$text' WHERE id=$id";
                mysqli_query($link, $query_update);
                header("Location: /pages/post.php?id=$update_id");
                die();
            }
            ?>
            
            <div class="edit-container">
                <form action="" method="post" class="admin-edit-form" onsubmit="return confirm('Вы уверены, что хотите внести изменения?');">
                    <input type="hidden" name="id" value="<?= $post['id'] ?>">
                    
                    <img src="/uploads/<?= $post['img_name']?>" alt="" style="width: 100%;">
                    <label for="header">Заголовок:</label>
                    <input type="text" id="header" name="header" value="<?= htmlspecialchars($post['header']) ?>" required>

                    <label for="text">Содержимое:</label>
                    <textarea id="text" name="text" required><?= htmlspecialchars($post['text']) ?></textarea>

                    <button type="submit" class="save-button">Сохранить изменения</button>
                </form>
                <a href="/index.php" class="back-button-page">← Назад</a>
                <form action="/php/deletePost.php" method="post" class="admin-edit-form" onsubmit="return confirm('Вы уверены, что удалить пост?');">
                    <input type="hidden" name="post_id" value="<?= $post['id'] ?>">
                    <button type="submit" class="cancel-button">Удалить</button>
                </form>
            </div>
        <?php else: ?>
            <div class="article-container-page">
                <h1 class="article-title-page"><?= htmlspecialchars($post['header']) ?></h1>
        
                <div class="article-meta-page">
                    <span class="article-author-page">Автор: <?= htmlspecialchars($post['username']) ?></span>
                    <span class="article-time-page"><?= date("d.m.Y H:i", strtotime($post['created_at'])) ?></span>
                </div>
                
                <div class="article-content-page">
                    <img src="/uploads/<?= $post['img_name']?>" alt="" style="width: 100%;">
                    <p><?= nl2br(htmlspecialchars($post['text'])) ?></p>
                </div>
                <a href="/index.php" class="back-button-page">← Назад</a>
            </div>
        <?php endif; ?>
    
        
        


