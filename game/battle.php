<?php
include('../header.php');
include('../navbar.php');
?>

<main class="main-block">
	<div class="main-block__caption">
	Битва:
	</div>
	
	<!-- Проверка регистрации -->
	<?php 
	if( empty($_SESSION['user_id']) ){
		message_box( "Необходимо войти на сайт.", "/index.php", "На главную" ); 
		alarm_exit();
	}
	if ( $_POST['id_warrior']===NULL ){
		message_box( "Не выбран воин для битвы.", "/game/select_apponent.php", "Назад" );
		alarm_exit();
	}
	if( $_POST['id_apponent']===NULL ){
		message_box( "Не выбран аппонент для битвы.", "/game/select_apponent.php", "Назад" );
		alarm_exit();
	}
	?>

	<!-- Получить данные бойцов из БД -->
	<?php
	if ( ! $warrior = get_warrior_by_id( $_POST['id_warrior'] ) ) {
		message_box( "Боец не найден в БД.", "/game/select_apponent.php", "Назад" ); 
		alarm_exit();
	}
	if ( ! $apponent = get_warrior_by_id( $_POST['id_apponent'] ) ) {
		message_box( "Аппонент не найден в БД.", "/game/select_apponent.php", "Назад" ); 
		alarm_exit();
	}
	$warrior_show = $warrior;
	include("warrior_big_form.php");
	
	?>
	<div class="versus">
		<img style="float: left;" src='/img/versus.png' alt="VERSUS">
	</div>

	<?php
		$warrior_show = $apponent;
		include("warrior_big_form.php");
	?>

	<!-- Рассчитать сражение -->

	<!-- Записать результаты в БД -->

	<!-- Записать лог боя в БД -->

</main>

<?php
include('../footer.php');
?>