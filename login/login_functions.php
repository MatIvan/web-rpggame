<?php

//Установить новый баланс пользователя
//True если успех, иначе False
function set_user_balance( $user_id, $new_balance ){
	global $link;
	$stmt  = mysqli_prepare( $link, "UPDATE users SET balance = ? WHERE users.id = ?" );
	mysqli_stmt_bind_param($stmt,
		"ii",
		$new_balance,
		$user_id
	);
	if (!mysqli_stmt_execute($stmt)){
		print_error( " function edit_warrior > Execute Error > ".mysqli_stmt_errno($stmt)." > ".mysqli_stmt_error($stmt) );
		mysqli_stmt_close($stmt);
		return -1;
	}
	mysqli_stmt_close($stmt);
	return true;
}


//Вернет логин и баланс пользователя по id
function get_user_by_id( $user_id ){
	global $link;
	$sql = "SELECT login, balance, status FROM users WHERE id='$user_id'";
	$result = mysqli_query($link, $sql);
	$user = mysqli_fetch_array($result);
	return $user;
}

//Узнать баланс пользователя
//Вернёт баланс или -1 если пользователя нет
function get_user_balance( $user_id ){
	global $link;
	$sql = "SELECT balance FROM users WHERE id='$user_id'";
	$result = mysqli_query($link, $sql);
	if (mysqli_num_rows($result) === 0) {
		print_error( " function get_user_balance > (mysqli_num_rows(result) === 0) " );
		return -1;
	}
	$user = mysqli_fetch_array($result);
	return $user["balance"];
}

//Проверить существует ли пользователь с указанным логином
//Вернет true если пользователя нет
function check_login( $login ){
	global $link;
	$sql = "SELECT id FROM users WHERE login='$login'";
	$result = mysqli_query($link, $sql) or die(mysqli_error());
	if (mysqli_num_rows($result) > 0) {
		print_error( " function check_login > (mysqli_num_rows(result) > 0) " );
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
	if (!mysqli_stmt_execute($stmt)){
		print_error( " function edit_warrior > Execute Error > ".mysqli_stmt_errno($stmt)." > ".mysqli_stmt_error($stmt) );
		mysqli_stmt_close($stmt);
		return 0;
	}
	mysqli_stmt_close($stmt);
	return mysqli_insert_id($link);
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
		//print_error("Не верный логин или пароль.");
		return 0;
	}
	return $users['id'];
}



?>