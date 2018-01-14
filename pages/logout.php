<?php
	require_once '../config.php';
	unset($_SESSION['logged_user']);
	header('Location: /');