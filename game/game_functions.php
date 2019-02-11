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
//True если успех, иначе False
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
	if ( $res != 1 ) {
		print_error( " function add_new_warrior > ( res != 1 ) " );
		return false;
	}
	return set_user_balance( $new_warrior["user_id"], $new_warrior["new_balance"] );
}

//Вернёт бойца по ID
function get_warrior_by_id( $warrior_id ){
	global $link;
	$sql = "SELECT * FROM warriors WHERE id=".$warrior_id;
	$result = mysqli_query($link, $sql);
	if (mysqli_num_rows($result) != 1) {
		print_error( " function get_warrior_by_id > (mysqli_num_rows($result) != 1) " );
		return false;
	}
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
	if ( $res != 1 ) {
		print_error( " function edit_warrior > ( res != 1 ) " );
		return false;
	}
	return set_user_balance( $warrior["user_id"], $warrior["new_balance"] );
}

//Проверит сумма параметров бойца с остатком на балансе.
//Вернет новый баланс пользователя 
//или -99999 если ошибка
function calculate_balance($new_warrior){
	
	//Запрос баланса из БД
	$old_balance = get_user_balance($new_warrior["user_id"]);
	settype($old_balance, "integer");
	if ( $old_balance < 0 ) {
		print_error( " function calculate_balance > ( old_balance < 0 ) " );
		return -99999;
	}
	
	//Запрос текущих характеристик бойца
	if( $new_warrior['id']==="0" ){
		//Создфётся новый боец
		$old_warrior = $new_warrior;
		$old_warrior['hp'] =  "0";
		$old_warrior['attack'] =  "0";
		$old_warrior['shield'] =  "0";
	}else{
		//Изменяется существующий боец
		$old_warrior = get_warrior_by_id( $new_warrior["id"] );
		if( !$old_warrior ){
			print_error( " function calculate_balance > ( !old_warrior ) " );
			return -99999;
		}
	}
	
	//Веполнить проверку параметров
	$old_balance = $old_balance + ( $old_warrior['hp'] +$old_warrior['attack'] + $old_warrior['shield'] );
	$new_balance = $old_balance - ( $new_warrior['hp'] +$new_warrior['attack'] + $new_warrior['shield'] );
	return $new_balance;
}

?>