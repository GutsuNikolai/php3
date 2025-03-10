<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gallery</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        header {
            background-color: #4CAF50;
            padding: 15px;
            text-align: center;
        }
        header a {
            color: white;
            text-decoration: none;
            margin: 0 20px;
            font-size: 18px;
            
        }
        header a:hover {
            text-decoration: underline;
        }
        section {
            padding: 20px;
            text-align: center;
        }
        footer {
            background-color: #4CAF50;
            color: white;
            text-align: center;
            padding: 0px;
            position: fixed;
            width: 100%;
            bottom: 0;
        }
        footer a {
            color: white;
            text-decoration: none;
        }
        .gallery {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 20px;
            padding: 20px;
            margin-bottom: 60px;
        }
        .gallery img {
            width: 100%;
            height: 130px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>

    <!-- Header Section -->
    <header id = "header"> 
        <a href="#">About Us</a>  <!-- Somewhen will be (maybe) -->
        <a href="#content">Content</a>
        <a href="#">Contacts</a>  <!-- Somewhen will be (maybe) -->
    </header>

    <!-- Content Section -->
    <section id="content">
        <h2>Gallery of Images</h2>

        <?php
        // Задаем путь к папке с изображениями
        $dir = 'image/';
        // Сканируем содержимое директории
        $files = scandir($dir);

        // Если нет ошибок при сканировании
        if ($files !== false) {
            echo "<div class='gallery'>";
            for ($i = 0; $i < count($files); $i++) {
                // Пропускаем текущий каталог и родительский
                if ($files[$i] != "." && $files[$i] != "..") {
                    // Получаем путь к изображению
                    $path = $dir . $files[$i];
                    echo "<div><img src='$path' alt='Image'></div>";
                }
            }
            echo "</div>";
        }
        ?>

    </section>

    <!-- Footer Section -->
    <footer id = "footer" >
        <p>&copy; 2025 Gallery. All rights reserved.</p>
        <p><a href="#header">Back to menu</a></p>

    </footer>

</body>
</html>
