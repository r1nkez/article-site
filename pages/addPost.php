<?php 
    $connect = $_SERVER['DOCUMENT_ROOT'] . '/php/connect.php';
    require $connect;
    $head = $_SERVER['DOCUMENT_ROOT'] . '/templates/head.html';
    require $head;
    $header = $_SERVER['DOCUMENT_ROOT'] . '/templates/header.php';
    require $header;

    function clean_input($data) {
        return htmlspecialchars(trim($data));
    }

    if (!empty($_SESSION['auth'])): 
        
        if ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['text'], $_POST['header'])) {
            $header = clean_input($_POST['header']);
            $text = clean_input($_POST['text']);

            $id = $_SESSION['id'];
            
            $query = "INSERT INTO posts (header, text, author_id, created_at) VALUES ('$header', '$text', '$id', NOW())";

            mysqli_query($link, $query);
            header('Location: /index.php');
            die();
        }

    ?>
        <div class="body">
		<?php if (!empty($errors)): 
			foreach ($errors as $field => $error) {
				echo "<div class='error-message'>$error</div>";
			}?>
                    
            <?php endif; ?>
		<h2 class="login-title">Добавить статью</h2>
		<form action="" method="post" class="login-form">
			
			<label for="header">Заголовок статьи</label>
			<input type="text" name="header" id="header" required>
	
			<label for="text">Текст статьи</label>
            <textarea name="text"></textarea>
	
			<button type="submit" class="button">Опубликовать</button>
		</form>
            
	</div>
	    <?php
    endif;?>
    