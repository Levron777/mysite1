<?php
    require_once '../config.php';
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <title><?php echo $title;?></title>

<!-- Custom style-->
    <link rel="stylesheet" type="text/css" href="/style/style_login.css">

<!-- Homepage-->
    <link rel="home" title="Лучшие новости" href="index.php">

<!-- Bootstrap-->
<!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">-->
</head>
<body>
<?php

    if (isset($_POST['do_publish'])) {
        $errors = array();
        if (trim($_POST['title']) == '') {
            $errors[] = 'Введите название!';
        }
        
        if (trim($_POST['content']) == '') {
            $errors[] = 'Введите контент!';
        }
        
        if (trim($_POST['category']) == '') {
            $errors[] = 'Введите название категории!';
        }

        if (empty($errors)) {
            $publish = $pdo->prepare('INSERT INTO `articles`(`title`, `content`, `date`, `category`) VALUES(:title, :content, NOW(), :category)');
            $publish->execute(array(':title' => $_POST['title'], ':content' => $_POST['content'], ':category' => $_POST['category']));
                
                echo '<span style="color: green; font-weight: bold; margin-bottom: 20px; display: block; ">Информация успешно добавлена! Можете войти на <a href="/">главную</a> страницу. Либо продолжить ввод <a href="/pages/admin.php">новой</a> информации.</span>';
            }else {
                echo '<div style="color:red;">' . array_shift($errors) . '</div><hr>';
            }
        }
?>
<div class="container">
<form action="admin.php" method="POST">
    <div class="dws_input">
        <p>
            <p><strong>Добавление контента на сайт</strong></p>
            <p><strong>Название статьи:</strong></p>
            <input type="text" name="title" placeholder="Название" value="<?php echo @$_POST['title']; ?>">
        </p>
        <p>
            <p><strong>Содержание:</strong></p>
            <textarea type="text" name="content" placeholder="Содержание" value="<?php echo @$_POST['content']; ?>"></textarea>
        </p>
        <p>
            <p><strong>Категория статьи:</strong></p>
            <input type="text" name="category" placeholder="Категория статьи" value="<?php echo @$_POST['category']; ?>">
        </p>
        <p>
            <input type="submit" class="dws_submit" name="do_publish" value="Опубликовать">
        </p>
    </div>
</form>
</div>
<div class="clear"></div>
    <?php require_once("footer.php") ;?>
</div>