<?php

// Вернёт таблицу со всеми бойцами пользователя.
function get_user_warriors( $user_id ){
	global $link;
	$sql = "SELECT id, name, balance, hp, attack, shield FROM warriors WHERE user_id=$user_id";
	$result = mysqli_query($link, $sql);
	$warriors = mysqli_fetch_all($result, MYSQLI_ASSOC);
	return $warriors;
}

//Добавить нового бойца в БД
function add_new_warrior( $new_warrior){
	global $link;
	$stmt  = mysqli_prepare( $link, "INSERT INTO warriors ( name, balance, hp, attack, shield, user_id ) VALUES (?,?,?,?,?,?)" );
	mysqli_stmt_bind_param($stmt,
		"siiiii",
		$new_warrior["name"],
		$new_warrior["balance"],
		$new_warrior["hp"],
		$new_warrior["attack"],
		$new_warrior["shield"],
		$new_warrior["user_id"]
	);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_close($stmt);
}

?>