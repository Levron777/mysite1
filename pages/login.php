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

<!-- Homepage
    <link rel="home" title="Лучшие новости" href="index.php">-->

<!-- Bootstrap-->
<!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">-->
</head>
<body>
    <?php 
    
    if (isset($_POST['do_login'])){
    	$errors = array();
        $login = $pdo->prepare('SELECT * FROM `user` WHERE `login` =  :login');
        $login->execute(array(':login' => $_POST['login']));
        $login_inn = $login->fetch();
    	if ($login_inn){
    		
    		if (password_verify($_POST['password'], $login_inn['password'])) {
                $_SESSION['logged_user'] = $login_inn;
                echo '<span style="color: #fff; text-align: center; font-size: 16px; font-weight: bold; margin-bottom: 20px; display: block; ">Вы успешно авторизованы! Можете войти на <a href="/">главную</a> страницу.</span>';
    		}else {
    			$errors[] = 'Пароль неверно введен!';
    		}
    	}else {
    		$errors[] = 'Пользователь с таким логином не найден!';
    	}

    	if (!empty($errors)) {
            echo '<div style="color:red; text-align: center;">' . array_shift($errors) . '</div><hr>';
        }
    }
?>
<div class="container">
<form action="login.php" method="POST">
    <div class="dws_input">
    	<p>
            <p><strong>Логин:</strong></p>
            <input type="text" name="login" placeholder="Введите логин" value="<?php echo @$_POST['login']; ?>">
        </p>

        <p>
            <p><strong>Пароль:</strong></p>
            <input type="password" name="password" placeholder="Введите пароль" value="<?php echo @$_POST['password']; ?>">
        </p>

        <p>
            <input type="submit" class="dws_submit" name="do_login" value="Войти">
        </p>
        <br />
        <a href="#">Восстановить пароль</a>
        <br/><br>
        <span style="color: #fff; font-weight: bold; margin-bottom: 20px; display: block; ">На <a href="/">главную</a> страницу.</span>
    </div>
</form>
</div>
