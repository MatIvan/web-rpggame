<?php
$link = mysqli_connect ("127.0.0.1","root","","web-rpg-game");

if(mysqli_connect_errno()){
	echo "Ошибка подключений к базе данных (".mysqli_connect_errno()."): ".mysqli_connect_error();
	exit();
}

?>
