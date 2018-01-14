<?php
	$title = "Новости дня";

	define('SERVER', "localhost");
	define('USER', "root");
	define('PASSWORD', "");
	define('DATABASE', "news");
	define('CHARSET', "utf8");

    $dsn = 'mysql:host=' . SERVER . ';dbname=' . DATABASE . ';charset=' . CHARSET;
    $opt = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];
    $pdo = new PDO($dsn, USER, PASSWORD, $opt);

    session_start();

/*Первоначально все работало через mysqli

	define(SERVER, "localhost");
	define(USER, "root");
	define(PASSWORD, "");
	define(DATABASE, "news");

	$mysqli = mysqli_connect(SERVER, USER, PASSWORD, DATABASE);
	if (!$mysqli) {
		echo "Извините, не удалось подключиться к базе данных!";
		echo mysqli_connect_error;
		exit();
	}*/
