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

            if (empty($header) || empty($text)) {
                die("Ошибка: Заполните все поля!");
            }

            $uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/uploads/';

            if (!empty($_FILES['file']['name'])) {
            
                $allowedTypes = ["image/jpeg", "image/png", "image/gif", "image/webp"];
                $maxSize = 5 * 1024 * 1024;

                $fileTmpPath = $_FILES["file"]["tmp_name"];
                $fileName = basename($_FILES["file"]["name"]);
                $fileSize = $_FILES["file"]["size"];
                $fileType = mime_content_type($fileTmpPath);

                if (!in_array($fileType, $allowedTypes)) {
                    die("Ошибка: Неверный формат файла.");
                }
        
                if ($fileSize > $maxSize) {
                    die("Ошибка: Файл слишком большой.");
                }
        
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }

                $newFileName = uniqid("img_") . "." . pathinfo($fileName, PATHINFO_EXTENSION);
                $uploadedFile = $uploadDir . $newFileName;

                if (!move_uploaded_file($fileTmpPath, $uploadedFile)) {
                    die("Ошибка при загрузке изображения.");
                }
            }

            $author_id = $_SESSION['id'];
            
            $query = "INSERT INTO posts (header, text, author_id, created_at, img) VALUES ('$header', '$text', $author_id, NOW(), '$newFileName')";

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
		<form action="" method="post" class="login-form" enctype="multipart/form-data">
			
			<label for="header">Заголовок статьи</label>
			<input type="text" name="header" id="header" required>

            <label for="file">Выберите изображение:</label>
            <input type="file" name="file" id="file" accept="image/*" required>

			<label for="text">Текст статьи</label>
            <textarea name="text" required></textarea>
	
			<button type="submit" class="button">Опубликовать</button>
		</form>
            
	</div>
	    <?php
    endif;?>
    