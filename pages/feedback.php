<?php   
    require_once "../config.php";
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <title><?php echo $title;?></title>

<!-- Custom style-->
    <link rel="stylesheet" type="text/css" href="/style/style.css">

<!-- Homepage-->
    <link rel="home" title="Лучшие новости" href="index.php">

<!-- Bootstrap-->
<!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">-->
</head>
<body>
    <div id="container">
	<?php require_once("header.php") ;?>

<!-- Формируем левую колонку -->

        <div class="left_column">
            <div>
                <div>
                <h3> 
                    Обратная связь 
                    <hr>
                </h3>
                    <div>
                        <div id="comment-add-form">
                            <div>
                                <form class="form" method="POST" action="/pages/feedback.php?id=<?php echo $art['id'];?>#comment-add-form">
                                <?php 
                                    if( isset($_POST['do_post']) )
                                    {
                                      $errors = array();

                                    if ($_POST['theme'] == '' )
                                    {
                                            $errors[] = 'Введите тему!';
                                    }       

                                    if ($_POST['email'] == '' )
                                    {
                                            $errors[] = 'Введите Ваш email!';
                                    } 

                                    if ($_POST['text'] == '' )
                                    {
                                            $errors[] = 'Введите сообщение!';
                                    }

                                    if(empty($errors) )
                                    {

//Добавляем комменты для обратной связи
/*Старый mysqli код
                                    $theme = mysqli_real_escape_string($mysqli, $_POST['theme']);
                                    $email = mysqli_real_escape_string($mysqli, $_POST['email']);
                                    $text = mysqli_real_escape_string($mysqli, $_POST['text']); 
                                    $theme = htmlspecialchars($theme);
                                    $email = htmlspecialchars($email);
                                    $text = htmlspecialchars($text);
                                    mysqli_query($mysqli, "INSERT INTO `feedback` (`theme`, `email`, `text`, `pubdate`) VALUES ('" . $theme . "', '" . $email . "', '" . $text . "', NOW())") or die(mysqli_error());*/

                                    $add_feedback = $pdo->prepare('INSERT INTO `feedback` (`theme`, `email`, `text`, `pubdate`) VALUES (:theme,  :email, :text, NOW())');
                                    $add_feedback->execute(array(':theme' => $_POST['theme'], ':email' => $_POST['email'], ':text' => $_POST['text']));

                                    echo '<span style="color: green; font-weight: bold; margin-bottom: 20px; display: block; ">Комментарий добавлен</span>';
                                    } else{
//Проверяем ошибки

                                    echo '<span style="color: red; font-weight: bold; margin-bottom: 10px; display: block; ">'. $errors['0'] . '</span>';
                                    }
                                    }
                                ?>
                                <div>
                                    <div>
                                        <div>
                                            Укажите тему обращения:<br>
                                            <input type="text" name="theme" class="form__control" placeholder="Тема" value="<?php echo $_POST['theme'];?>">
                                        </div>
                                        <div>
                                            <br>Укажите Ваш адрес электронной почты:<br>
                                            <input type="text" name="email" class="form__control" placeholder="Email" value="<?php echo $_POST['email'];?>">
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <br>Текст Вашего сообщения:<br>
                                    <textarea class="form__control" name="text" placeholder="..."><?php echo $_POST['text'];?></textarea>
                                </div>
                                <div>
                                    <input type="submit" name="do_post" value="Добавить" class="form__control">
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>	
            </div>
        </div>

<!-- Формируем правую колонку -->

    <aside>
        <div class="adv_block">
            <img src="/images/sky_right_column.jpg" class="img_aside">
            <p>Реклама</p>
            <p></p>
            <p></p>
        </div>
    </aside>

<!-- Очищаем макет для размещения подвала -->

    <div class="clear"></div>
    <?php require_once("footer.php") ;?>
    </div>
</body>
</html>

