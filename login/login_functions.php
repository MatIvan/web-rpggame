<?php

//Вернет логин пользователя по id
function get_user_login( $link, $user_id ){
	$sql = "SELECT login FROM users WHERE id='$user_id'";
	$result = mysqli_query($link, $sql);
	$login = mysqli_fetch_array($result);
	return $login['login'];
}

//Проверить существует ли пользователь с указанным логином
//Вернет true если пользователя нет
function check_login( $link, $login ){
	$sql = "SELECT id FROM users WHERE login='$login'";
	$result = mysqli_query($link, $sql) or die(mysqli_error());
	if (mysqli_num_rows($result) > 0) {
		return false;
	}
	return true;
}

//Добавить нового пользователя в БД
//Ни чего не возвращает
function add_new_user( $link, $login, $password){
	$mdPassword = md5($password);
	$sql = "INSERT INTO users ( login, password ) VALUES ('$login', '$mdPassword' )";
    $result = mysqli_query($link, $sql) or die(mysqli_error());
}

//Проверить логин и пароль пользователя.
//Вернет id или 0 (логин и пароль неверны)
function login_user($link, $login, $password){
	$login = stripslashes($login);
	$login = htmlspecialchars($login);
	$login = trim($login);

	$password = stripslashes($password);
	$password = htmlspecialchars($password);
	$password = trim($password);
	$password = md5($password);//шифруем пароль
	
	$sql = "SELECT id FROM users WHERE login='$login' AND password='$password'";
	$result = mysqli_query($link, $sql);
	$users = mysqli_fetch_array($result);
	if (empty($users['id'])){
		return 0;
	}
	return $users['id'];
}

?>