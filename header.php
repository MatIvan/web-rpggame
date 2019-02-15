<?php
	session_start();
	require_once("login/db-connect.php");
	require_once("common-functions.php");
	require_once("login/login_functions.php");
	require_once("game/game_functions.php");
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>RPG web game.</title>
	
	
    <link rel="stylesheet" href="/css/main-style.css">
	<link rel="stylesheet" href="/css/flat-radio-btn.css">
	
	<!-- Подключем css файлы по методике BEM -->
	<link rel="stylesheet" href="/blocks/error-msg/error-msg.css">
	<link rel="stylesheet" href="/blocks/main-header/main-header.css">
	
	<link rel="stylesheet" href="/blocks/main-block/main-block.css">
	<link rel="stylesheet" href="/blocks/main-block/main-block__caption.css">
	
	<link rel="stylesheet" href="/blocks/main-footer/main-footer.css">
	
	<link rel="stylesheet" href="/blocks/all-forms/all-forms.css">
	<link rel="stylesheet" href="/blocks/all-forms/all-forms__caption.css">
	<link rel="stylesheet" href="/blocks/all-forms/all-forms_login-form.css">
	
	<link rel="stylesheet" href="/blocks/all-forms/all-forms__input-text.css">
	<link rel="stylesheet" href="/blocks/all-forms/all-forms__input-text_center.css">
	
	<link rel="stylesheet" href="/blocks/all-forms/all-forms__btn.css">
	<link rel="stylesheet" href="/blocks/all-forms/all-forms__btn_center.css">
	
	<link rel="stylesheet" href="/blocks/navbar/navbar.css">
	<link rel="stylesheet" href="/blocks/navbar/navbar_center.css">
	<link rel="stylesheet" href="/blocks/navbar/navbar__a.css">

	<link rel="stylesheet" href="/blocks/all-forms/all-forms_warriors-form.css">
	
	<link rel="stylesheet" href="/blocks/all-forms/all-forms__table.css">
	<link rel="stylesheet" href="/blocks/all-forms/all-forms__table_center.css">

	<link rel="stylesheet" href="/blocks/warrior-str/warrior-str.css">
	
</head>
<body>
   
	<header class="main-header">
		RPG WEB GAME
	</header>
	