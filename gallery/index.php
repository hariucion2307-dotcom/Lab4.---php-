<?php
declare(strict_types=1);
/**
 * Получает список JPG-изображений из директории.
 * @param string $directory Путь к директории. 
 * @return array Массив имён изображений.
 */ 
function getImages(string $directory): array 
{
    if (!is_dir($directory)) {
        return [];
    }
    $files = scandir ($directory);
    if ($files === false) {
        return [];
    }
    $images = [];
    foreach ($files as $file) {
        $path = $directory .DIRECTORY_SEPARATOR . $file;
        if (
            is_file($path) && 
             strtolower(pathinfo($file, PATHINFO_EXTENSION)) === "jpg"
        ) {
            $images[] = $file;
        } 
    } 
    return $images;
} 
$directory = "image";
$images = getImages($directory);
?> 
<!DOCTYPE html>
<html lang="ru">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Галерея изображений</title> 
        <style>
            * {
                box-sizing: border-box;
            } 
            body {
                margin: 0;
                font-family: Arial, sans-serif;
                background: #f4f6f9;
                color: #222;
            }
            header {
                background: #243b53;
                color: white;
                text-align: center;
                padding: 25px;
            } 
            nav {
                 background: #334e68;
                 padding: 15px;
                 text-align: center;
            } 
            nav a {
                color: white;
                text-decoration: none;
                margin: 0 15px;
            } 
            main {
                padding: 25px;
                min-height: 400px;
            } 
            .gallery {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
                gap: 20px;
            } 
            .gallery img {
                width: 100%;
                height: 200px;
                object-fit: cover;
                border-radius: 8px;
            } 
            footer {
                background: #243b53;
                color: white;
                text-align: center;
                padding: 20px;
            }
            </style>
            </head>
            <body>
                <header>
                    <h1>Моя галерея изображений</h1>
                    <p>Лабораторная работа №4 по PHP</p>
</header>
<nav>
    <a href="index.php">Банковские транзакции</a>
    <a href="gallery.php">Галерея</a>
</nav>
<main>
    <h2>Галерея изображений</h2>
    <?php if (count($images) > 0): ?>
        <div class="gallery">
            <?php foreach ($images as $image): ?>
                <img src="<?=htmlspecialchars($directory . "/" . $image) ?>"
                alt="<?=htmlspecialchars($image) ?>"
                loading="lazy"
                >
                <?php endforeach; ?>
            </div>
            <?php else: ?>
                <p>
                    Изображения не найдены.
                    Добавьте JPG-файлы в папку image.
            </p>
            <?php endif; ?>
            </main>
            <footer>
                <p>Лабораторная работа №4 - Массивы и функции PHP</p>
            </footer>
            </body>
            </html>


            
