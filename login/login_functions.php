<?php

//Вернет логин и баланс пользователя по id
function get_user_by_id( $user_id ){
	global $link;
	$sql = "SELECT login, balance FROM users WHERE id='$user_id'";
	$result = mysqli_query($link, $sql);
	$user = mysqli_fetch_array($result);
	return $user;
}

//Проверить существует ли пользователь с указанным логином
//Вернет true если пользователя нет
function check_login( $login ){
	global $link;
	$sql = "SELECT id FROM users WHERE login='$login'";
	$result = mysqli_query($link, $sql) or die(mysqli_error());
	if (mysqli_num_rows($result) > 0) {
		return false;
	}
	return true;
}

//Добавить нового пользователя в БД
//Вернёт 0 если добать пользователя не удалось
function add_new_user( $user ){
	global $link;
	$mdPassword = md5($user["password"]);
	$sql = "INSERT INTO users ( login, password, balance ) VALUES ( ?, ?, ? )";
	$stmt  = mysqli_prepare( $link, $sql );
	mysqli_stmt_bind_param($stmt,
		"ssi",
		$user["login"],
		$mdPassword,
		$user["balance"]
	);
	mysqli_stmt_execute($stmt);
	$res = mysqli_stmt_affected_rows($stmt);
	mysqli_stmt_close($stmt);
	return res;
}

//Проверить логин и пароль пользователя.
//Вернет id или 0 (логин и пароль неверны)
function login_user( $login, $password ){
	global $link;
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