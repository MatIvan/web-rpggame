<?php

// Вернёт таблицу со всеми бойцами пользователя.
function get_user_warriors( $user_id ){
	global $link;
	$sql = "SELECT id, name, hp, attack, shield, level FROM warriors WHERE user_id=$user_id";
	$result = mysqli_query($link, $sql);
	$warriors = mysqli_fetch_all($result, MYSQLI_ASSOC);
	return $warriors;
}

// Вернёт таблицу со всеми возможными аппонентами.
function get_user_apponents( $user_id ){
	global $link;
	$sql = "SELECT id, name, level FROM warriors WHERE user_id<>$user_id AND hp<>0";
	$result = mysqli_query($link, $sql);
	$apponents = mysqli_fetch_all($result, MYSQLI_ASSOC);
	return $apponents;
}

//Добавить нового бойца в БД
//вернёт ID бойца или -1
function add_new_warrior( $new_warrior){
	global $link;
	$new_level = ( $new_warrior["hp"] + $new_warrior["attack"] + $new_warrior["shield"] );
	$stmt  = mysqli_prepare( $link, "INSERT INTO warriors ( name, hp, attack, shield, user_id, level ) VALUES (?,?,?,?,?,?)" );
	mysqli_stmt_bind_param($stmt,
		"siiiii",
		$new_warrior["name"],
		$new_warrior["hp"],
		$new_warrior["attack"],
		$new_warrior["shield"],
		$new_warrior["user_id"],
		$new_level
	);
	if (!mysqli_stmt_execute($stmt)){
		print_error( " function edit_warrior > Execute Error > ".mysqli_stmt_errno($stmt)." > ".mysqli_stmt_error($stmt) );
		mysqli_stmt_close($stmt);
		return -1;
	}
	mysqli_stmt_close($stmt);

	//получить ID созданного бойца
	return mysqli_insert_id($link);
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

	$new_lvl = ( $warrior["hp"] + $warrior["attack"] + $warrior["shield"] );
	$sqlstr = "UPDATE warriors SET name = ?, hp = ?, attack = ?, shield = ?, level = ? WHERE id = ?";
	$stmt  = mysqli_prepare( $link, $sqlstr );
	if (!mysqli_stmt_bind_param($stmt,
		"siiiii",
		$warrior["name"],
		$warrior["hp"],
		$warrior["attack"],
		$warrior["shield"],
		$new_lvl,
		$warrior["id"]
	) ){
		print_error( " function edit_warrior > Bind Error > ".mysqli_stmt_errno($stmt)." > ".mysqli_stmt_error($stmt) );
		mysqli_stmt_close($stmt);
		return -1;
	}
	if (!mysqli_stmt_execute($stmt)){
		print_error( " function edit_warrior > Execute Error > ".mysqli_stmt_errno($stmt)." > ".mysqli_stmt_error($stmt) );
		mysqli_stmt_close($stmt);
		return -1;
	}

	if ( mysqli_stmt_errno($stmt)!=0 ){
		print_error( " function edit_warrior > ".mysqli_stmt_errno($stmt)." > ".mysqli_stmt_error($stmt) );
		mysqli_stmt_close($stmt);
		return -1;
	}
	mysqli_stmt_close($stmt);
	
	return $warrior["id"];
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

//Улучшить аппонента
function increase_warrior($warrior, $value){
	if ($value==0) return $warrior;
	$one_part = intval($value/3);
	$remain = $value % 3;
	$warrior["attack"] += $one_part;
	$warrior["shield"] += $one_part;
	$warrior["hp"] += $one_part;
	if ($remain>0) $warrior["hp"] += $remain;

	return $warrior;
}


?>