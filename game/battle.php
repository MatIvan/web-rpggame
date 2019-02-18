<?php
include('../header.php');
include('../navbar.php');
?>

<main class="main-block">
	<div class="main-block__caption">
	Битва:
	</div>
	<div class="battle-form">

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
		<img class="battle-form__versus" src='/img/versus.png' alt="VERSUS">

		<?php
			$warrior_show = $apponent;
			include("warrior_big_form.php");
			echo("</div>");
		?>
		<div style="clear: both;">&nbsp;</div>

		<!-- Рассчитать сражение -->
		<?php
		$max_steps = 10;
		while ( $warrior["hp"]>0 && $apponent["hp"]>0 && $max_steps>0 ) {
			$max_steps--;
			
			$hit_w_a = $warrior["attack"] - ( ($apponent["shield"] * $apponent["shield"] ) / $warrior["attack"] );
			$hit_a_w = $apponent["attack"] - ( ($warrior["shield"] * $warrior["shield"] ) / $apponent["attack"] );
			$hit_w_a = round($hit_w_a, 0);
			$hit_a_w = round($hit_a_w, 0);
			if($hit_w_a<1) $hit_w_a=1;
			if($hit_a_w<1) $hit_a_w=1;
			
			!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
			!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!

			echo("<br> / ".$hit_w_a." / ".$hit_a_w);
		}
		?>

		<!-- Записать результаты в БД -->

		<!-- Записать лог боя в БД -->
	</div>
</main>

<?php
include('../footer.php');
?>