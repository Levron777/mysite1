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
    //$data = $_POST;
    if (isset($_POST['do_signup'])) {
        $errors = array();
        if (trim($_POST['login']) == '') {
            $errors[] = 'Введите логин!';
        }
        
        if (trim($_POST['email']) == '') {
            $errors[] = 'Введите email!';
        }
        
        if ($_POST['password'] == '') {
            $errors[] = 'Введите пароль!';
        }
        
        if ($_POST['password_2'] !== $_POST['password']) {
            $errors[] = 'Проверочный пароль введен неверно!';
        }

        $count_login = $pdo->prepare('SELECT * FROM `user` WHERE `login` =  :login');
        $count_login->execute(array(':login' => $_POST['login']));
        $count_reg_login = $count_login->rowCount();
        if ($count_reg_login > 0) {
            $errors[] = 'Пользователь с таким логином уже зарегистрирован!';
        }

        $count_email = $pdo->prepare('SELECT * FROM `user` WHERE `email` = :email');
        $count_email->execute(array(':email' => $_POST['email']));
        $count_reg_email = $count_email->rowCount();
        if ($count_reg_email > 0) {
            $errors[] = 'Пользователь с таким email уже зарегистрирован!';
        }
     
        if (empty($errors)) {
/*Старый mysqli код
            $login = mysqli_real_escape_string($mysqli, $data['login']);
            $email = mysqli_real_escape_string($mysqli, $data['email']);
            $password = password_hash($data['password'], PASSWORD_DEFAULT);
            $password_2 = mysqli_real_escape_string($mysqli, $data['password_2']);
            $login = htmlentities($login);
            $email = htmlentities($email);
            $password = htmlentities($password);
            $password_2 = htmlentities($password_2);
            mysqli_query($mysqli, "INSERT INTO `user`(`login`, `email`, `password`, `pubdate`) VALUES('" . $login . "', '" . $email . "', '" . $password . "', NOW())") or die(mysqli_error($mysqli));*/

            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $signup = $pdo->prepare('INSERT INTO `user`(`login`, `email`, `password`, `pubdate`) VALUES(:login, :email, :password, NOW())');
            $signup->execute(array(':login' => $_POST['login'], ':email' => $_POST['email'], ':password' => $password));
            
            echo '<span style="color: green; text-align: center; font-weight: bold; margin-bottom: 20px; display: block; ">Вы успешно зарегистрированы! Можете войти на <a href="/">главную</a> страницу.</span>';
        }else {
            echo '<div style="color:red; text-align: center;">' . array_shift($errors) . '</div><hr>';
        }
    }
?>
<div class="container">
<form action="signup.php" method="POST">
    <div class="dws_input">
        <p>
            <p><strong>Ваш логин:</strong></p>
            <input type="text" name="login" placeholder="Ваш логин" value="<?php echo @$_POST['login']; ?>">
        </p>
        <p>
            <p><strong>Ваш Email:</strong></p>
            <input type="email" name="email" placeholder="Ваш Email" value="<?php echo @$_POST['email']; ?>">
        </p>
        <p>
            <p><strong>Ваш пароль:</strong></p>
            <input type="password" name="password" placeholder="Ваш пароль" value="<?php echo @$_POST['password']; ?>">
        </p>
        <p>
            <p><strong>Подтвердите пароль:</strong></p>
            <input type="password" name="password_2" placeholder="Подтвердите пароль" value="<?php echo @$_POST['password_2']; ?>">
        </p>
        <p>
            <input type="submit" class="dws_submit" name="do_signup" value="Зарегистрироваться">
        </p>
    </div>
</form>
</div>
<div class="clear"></div>
    <?php require_once("footer.php") ;?>
</div>