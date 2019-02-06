<?php
	session_start();
	$_SESSION['user_id'] = 0;
	require_once("login/db-connect.php");
	require_once("login/login_functions.php");
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>RPG web game.</title>
    <link rel="stylesheet" href="/css/main-style.css">
</head>
<body>
   
	<header>
		RPG WEB GAME
	</header>
	