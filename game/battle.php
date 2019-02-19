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
		$hit_by_war_damage = ( $warrior["attack"] * $warrior["attack"] ) / ( $warrior["attack"] + $apponent["shield"] );
		$hit_by_war_damage = round($hit_by_war_damage, 0);
		$hit_by_war_with_fine = $hit_by_war_damage * ( ( ( $apponent["level"] - $warrior["level"]) / $apponent["level"] ) +1 );
		$hit_by_war_with_fine = round($hit_by_war_with_fine, 0);
		$hit_by_war_only_fine = $hit_by_war_damage - $hit_by_war_with_fine;
		echo("Нападаешь с уроном ".$hit_by_war_damage." за каждый удар. Штраф разницы уровня ".$hit_by_war_only_fine.". Защитано дамага ".$hit_by_war_with_fine."<br>");
		
		$hit_by_app_damage = ( $apponent["attack"] * $apponent["attack"] ) / ( $apponent["attack"] + $warrior["shield"] );
		$hit_by_app_damage = round($hit_by_app_damage, 0);
		$hit_by_app_with_fine = $hit_by_app_damage * ( ( ( $warrior["level"] - $apponent["level"]) / $warrior["level"] ) +1 );
		$hit_by_app_with_fine = round($hit_by_app_with_fine, 0);
		$hit_by_app_only_fine = $hit_by_app_damage - $hit_by_app_with_fine;
		echo("Защищается с уроном ".$hit_by_app_damage." за каждый удар. Штраф разницы уровня ".$hit_by_app_only_fine.". Защитано дамага ".$hit_by_app_with_fine."<br>");

		$num_hits_war = $apponent["hp"] / $hit_by_war_with_fine;
		$num_hits_app = $warrior["hp"] / $hit_by_app_with_fine;
		$num_hits_war = round($num_hits_war, 0);
		$num_hits_app = round($num_hits_app, 0);

		echo("Количество ударов до смерти аппонента: ".$num_hits_war."<br>");
		echo("Количество ударов до смерти вашего война: ".$num_hits_app."<br>");
		?>

		<!-- Записать результаты в БД -->

		<!-- Записать лог боя в БД -->
	</div>
</main>

<?php
include('../footer.php');
?>