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


    $id = htmlspecialchars($_GET['id']);
    $query = "SELECT posts.id, posts.header, posts.text, posts.created_at, users.name as username FROM posts LEFT JOIN users ON posts.author_id=users.id WHERE posts.id=$id";
    
    $res = mysqli_query($link, $query);
    $post = mysqli_fetch_assoc($res);
    
    if (!$post) {
        http_response_code(404);
        die("Ошибка 404: Страница не найдена.");
    }
    ?>
    
        <?php if (isset($_SESSION['auth'], $_SESSION['status']) && $_SESSION['auth'] && $_SESSION['status'] === 'admin'): 
            if ($_SERVER['REQUEST_METHOD'] === "POST") {
                $header = $_POST['header'];
                $text = $_POST['text'];
                $update_id = $_POST['id'];
                $query_update = "UPDATE posts SET header='$header', text='$text' WHERE id=$id";
                mysqli_query($link, $query_update);
                header("Location: /pages/post.php?id=$update_id");
                die();
            }
            ?>
            <!-- Форма редактирования для администратора -->
            <div class="edit-container">
                <form action="" method="post" class="admin-edit-form" onsubmit="return confirm('Вы уверены, что хотите внести изменения?');">
                    <input type="hidden" name="id" value="<?= $post['id'] ?>">
                    
                    <label for="header">Заголовок:</label>
                    <input type="text" id="header" name="header" value="<?= htmlspecialchars($post['header']) ?>" required>

                    <label for="text">Содержимое:</label>
                    <textarea id="text" name="text" required><?= htmlspecialchars($post['text']) ?></textarea>

                    <button type="submit" class="save-button">Сохранить изменения</button>
                    <a href="/index.php" class="back-button-page">← Назад</a>
                </form>
            </div>
        <?php else: ?>
            <div class="article-container-page">
            <!-- Обычный просмотр статьи для пользователей -->
                <h1 class="article-title-page"><?= htmlspecialchars($post['header']) ?></h1>
        
                <div class="article-meta-page">
                    <span class="article-author-page">Автор: <?= htmlspecialchars($post['username']) ?></span>
                    <span class="article-time-page"><?= date("d.m.Y H:i", strtotime($post['created_at'])) ?></span>
                </div>
        
                <div class="article-content-page">
                    <p><?= nl2br(htmlspecialchars($post['text'])) ?></p>
                </div>
                <a href="/index.php" class="back-button-page">← Назад</a>
            </div>
        <?php endif; ?>
    
        
        


