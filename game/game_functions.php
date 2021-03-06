<?php

// Вернёт таблицу со всеми бойцами пользователя.
function get_user_warriors( $user_id ){
	global $link;
	$sql = "SELECT id, name, hp, attack, shield, level FROM warriors WHERE user_id=$user_id";
	$result = mysqli_query($link, $sql);
	$warriors = mysqli_fetch_all($result, MYSQLI_ASSOC);
	return $warriors;
}

// Вернёт таблицу со всеми возможными оппонентами.
function get_user_apponents( $user_id ){
	global $link;
	$sql = "SELECT id, name, level FROM warriors WHERE user_id<>$user_id AND hp<>0 ORDER BY level";
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
	settype($new_balance,"integer");
	return $new_balance;
}

//Улучшить оппонента
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

//Занести параметры боя в таблицус историей
//Вернёт ID сохранённой записи или -1 в случае ошибки
function save_history( $warrior, $apponent, $battle_result ){
	global $link;
	$stmt  = mysqli_prepare( $link, "INSERT INTO history ( datetime, user_id_w, name_w, hp_w, attack_w, shield_w, user_id_a, name_a, hp_a, attack_a, shield_a, resut ) VALUES (NOW(),?,?,?,?,?,?,?,?,?,?,?)" );
	if ($stmt === false){
		print_error( " function save_history > Prepare Error > ".htmlspecialchars( mysqli_error($link) ) );
		return -1;
	}
	
	if (!mysqli_stmt_bind_param($stmt,
		"isiiiisiiii",
		$warrior["user_id"],
		$warrior["name"],
		$warrior["hp"],
		$warrior["attack"],
		$warrior["shield"],
		$apponent["user_id"],
		$apponent["name"],
		$apponent["hp"],
		$apponent["attack"],
		$apponent["shield"],
		$battle_result
	) ){
		print_error( " function save_history > Bind Error > ".mysqli_stmt_errno($stmt)." > ".mysqli_stmt_error($stmt)." > ".htmlspecialchars($mysqli->error) );
		mysqli_stmt_close($stmt);
		return -1;
	}

	if (!mysqli_stmt_execute($stmt)){
		print_error( " function save_history > Execute Error > ".mysqli_stmt_errno($stmt)." > ".mysqli_stmt_error($stmt)." > ".htmlspecialchars($mysqli->error) );
		mysqli_stmt_close($stmt);
		return -1;
	}
	mysqli_stmt_close($stmt);

	//получить ID созданного бойца
	return mysqli_insert_id($link);
}

//Вернёт атакующего бойца из записи истории
function extract_warrior( $history, $prefix ){
	/* $prefix 
		_w нападающий
		_a защищающийся
	*/
	$level = ( $history["hp".$prefix] + $history["attack".$prefix] + $history["shield".$prefix] );
	$warrior = array (
		"hp" => $history["hp".$prefix],
		"attack" => $history["attack".$prefix],
		"shield" => $history["shield".$prefix],
		"level" => $level,
		"user_id" => $history["user_id".$prefix],
		"name" => $history["name".$prefix]
	);

	return $warrior;
}

//Вернёт историю боёв пользователя
function get_user_historys( $user_id, $prefix ){
	/* $prefix 
		_w нападающий
		_a защищающийся
	*/
	global $link;
	$sql = "SELECT * FROM history WHERE user_id".$prefix."=$user_id ORDER BY datetime DESC";
	$result = mysqli_query($link, $sql);
	$historys = mysqli_fetch_all($result, MYSQLI_ASSOC);
	return $historys;
}

//Вернет бойца со случайными характеристиками по указанному уровню
function generate_bot( $name, $lvl ){
	$score=$lvl;
	$new_hp = rand(1, $score/3*2);
	$score-=$new_hp;
	$new_shield = rand(1, $score/4*3);
	$score-=$new_shield;
	$new_attack = $lvl-$new_hp-$new_shield;

	$new_warrior = array(
		'name' => $name,
		'hp' => $new_hp,
		'attack' => $new_attack,
		'shield' => $new_shield,
		'user_id' => $_SESSION['user_id']
	);
	return $new_warrior;
}

function decrease_warrior($warrior, $value){
	if ($value==0) return $warrior;
	$one_part = intval($value/3);
	$remain = $value % 3;
	$warrior["attack"] -= $one_part;
	$warrior["shield"] -= $one_part;
	$warrior["hp"] -= $one_part;
	if ($remain>0) $warrior["hp"] -= $remain;
	if ($warrior["hp"]<0) $warrior["hp"]="0";

	return $warrior;
}

?>