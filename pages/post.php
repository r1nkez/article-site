<?php

    if (empty($_GET['id'])) {
        http_response_code(404);
        die("Ошибка 404: Страница не найдена.");
    }


    $connect = $_SERVER['DOCUMENT_ROOT'] . '/php/connect.php';
    require_once $connect;
    $head = $_SERVER['DOCUMENT_ROOT'] . '/templates/head.html';
    require_once $head;
    $header = $_SERVER['DOCUMENT_ROOT'] . '/templates/header.php';
    require_once $header;
    $mysqli = getDbConnection();
    // echo "<pre>";
    // var_dump($_SESSION);


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

    $stmt = $mysqli->prepare("SELECT comments.*, users.name as commenter_name, users.status
                            FROM comments
                            LEFT JOIN users ON comments.user_id = users.id
                            WHERE comments.post_id = ?
                            ORDER BY comments.created_at ASC");

    $stmt->bind_param("i", $id);

    $stmt->execute();
    $res_comm = $stmt->get_result();

    for ($comments = []; $row = $res_comm->fetch_assoc(); $comments[] = $row);
    // echo "<pre>";
    // var_dump($comments);
    ?>
    
        <?php if (isset($_SESSION['auth'], $_SESSION['status']) && $_SESSION['auth'] && $_SESSION['status'] === 'admin'): 
                if ($_SERVER['REQUEST_METHOD'] === "POST") {
                    $header_post = $_POST['header'];
                    $text = $_POST['text'];
                    $update_id = $_POST['id'];
                    
                    $stmt = $mysqli->prepare("UPDATE posts SET header = ?, text = ? WHERE id = ?");
                    $stmt->bind_param("ssi", $header_post, $text, $id);
                    $stmt->execute();

                    // $query_update = "UPDATE posts SET header='$header_post', text='$text' WHERE id=$id";
                    // mysqli_query($link, $query_update);
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

                <div class="edit-container">
                    <form action="/php/addComment.php" method="post" class="admin-edit-form">
                        <input type="hidden" name="post_id" value="<?= $post['id'] ?>">
                        <textarea name="comment" placeholder="Оставить комментарий" required></textarea>
                        <button type="submit" class="save-button">Отправить</button>
                    </form>

                    <div class="comments-section">
                        <h2 class="article-title-page">Комментарии</h2>

                        <?php if (!empty($comments)): ?>
                            <?php foreach ($comments as $comment): ?>
                                <div class="comment-card">
                                    <div class="comment-meta">
                                        <span class="comment-author <?= $comment['status'] === "admin" ? "span-admin" : ""?>"><?= $comment['status'] === "admin" ? "Админ: " : ""?> <?= htmlspecialchars($comment['commenter_name'] ?? 'Гость') ?></span>
                                        <span class="comment-date"><?= date("d.m.Y H:i", strtotime($comment['created_at'])) ?></span>
                                    </div>
                                    <div class="comment-text">
                                        <?= nl2br(htmlspecialchars($comment['text'])) ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="no-comments">Комментариев пока нет.</div>
                        <?php endif; ?>
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
                <div class="edit-container">
                    <?php if (isset($_SESSION['auth']) && $_SESSION['auth']): ?>
                        <form action="/php/addComment.php" method="post" class="admin-edit-form">
                            <input type="hidden" name="post_id" value="<?= $post['id'] ?>">
                            <textarea name="comment" placeholder="Оставить комментарий" required></textarea>
                            <button type="submit" class="save-button">Отправить</button>
                        </form>
                    <?php else: ?>
                        <p style="text-align:center; color: #888;">Войдите, чтобы оставить комментарий.</p>
                    <?php endif; ?>

                    <div class="comments-section">
                        <h2 class="article-title-page">Комментарии</h2>

                        <?php if (!empty($comments)): ?>
                            <?php foreach ($comments as $comment): ?>
                                <div class="comment-card">
                                    <div class="comment-meta">
                                        <span class="comment-author <?= $comment['status'] === "admin" ? "span-admin" : ""?>"><?= $comment['status'] === "admin" ? "Админ: " : ""?> <?= htmlspecialchars($comment['commenter_name'] ?? 'Гость') ?></span>
                                        <span class="comment-date"><?= date("d.m.Y H:i", strtotime($comment['created_at'])) ?></span>
                                    </div>
                                    <div class="comment-text">
                                        <?= nl2br(htmlspecialchars($comment['text'])) ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="no-comments">Комментариев пока нет.</div>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>