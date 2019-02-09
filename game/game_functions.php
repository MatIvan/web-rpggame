<?php

// Вернёт таблицу со всеми бойцами пользователя.
function get_user_warriors( $user_id ){
	global $link;
	$sql = "SELECT id, name, hp, attack, shield FROM warriors WHERE user_id=$user_id";
	$result = mysqli_query($link, $sql);
	$warriors = mysqli_fetch_all($result, MYSQLI_ASSOC);
	return $warriors;
}

//Добавить нового бойца в БД
function add_new_warrior( $new_warrior){
	global $link;
	$stmt  = mysqli_prepare( $link, "INSERT INTO warriors ( name, hp, attack, shield, user_id ) VALUES (?,?,?,?,?)" );
	mysqli_stmt_bind_param($stmt,
		"siiii",
		$new_warrior["name"],
		$new_warrior["hp"],
		$new_warrior["attack"],
		$new_warrior["shield"],
		$new_warrior["user_id"]
	);
	mysqli_stmt_execute($stmt);
	$res = mysqli_stmt_affected_rows($stmt);
	mysqli_stmt_close($stmt);
	return $res;
}

//Вернёт бойца по ID
function get_warrior_by_id( $warrior_id ){
	global $link;
	$sql = "SELECT * FROM warriors WHERE id=".$warrior_id;
	$result = mysqli_query($link, $sql);
	$warrior = mysqli_fetch_array($result, MYSQLI_ASSOC);
	return $warrior;
}

//Изменить бойца в БД
function edit_warrior( $warrior ){
	global $link;
	$stmt  = mysqli_prepare( $link, "UPDATE warriors SET name = ?, hp = ?, attack = ?, shield = ? WHERE warriors.id = ?" );
	mysqli_stmt_bind_param($stmt,
		"siiii",
		$warrior["name"],
		$warrior["hp"],
		$warrior["attack"],
		$warrior["shield"],
		$warrior["id"]
	);
	mysqli_stmt_execute($stmt);
	$res = mysqli_stmt_affected_rows($stmt);
	mysqli_stmt_close($stmt);
	return $res;
}

?>