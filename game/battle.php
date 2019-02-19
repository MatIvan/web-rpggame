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
		<div style="clear: left;"></div>

		<!-- Рассчитать сражение -->
		<?php
			/* Для нападающего */
			$hit_by_war_damage = ( $warrior["attack"] * $warrior["attack"] ) / ( $warrior["attack"] + $apponent["shield"] );
			$hit_by_war_only_fine = ( ( ( $apponent["level"] - $warrior["level"]) / $apponent["level"] ) + 1 );
			$hit_by_war_with_fine = $hit_by_war_damage * $hit_by_war_only_fine;
			if ($hit_by_war_with_fine<0) $hit_by_war_with_fine = 0; //Урон не может быть отрицательным

			/* Для защищающегося */
			$hit_by_app_damage = ( $apponent["attack"] * $apponent["attack"] ) / ( $apponent["attack"] + $warrior["shield"] );
			$hit_by_app_only_fine = ( ( ( $warrior["level"] - $apponent["level"]) / $warrior["level"] ) + 1 );
			if ( $hit_by_app_only_fine<0 ) $hit_by_app_only_fine = -$hit_by_app_only_fine; //Аппоненту ставится только положительный бонус от разницы в уровнях
			$hit_by_app_with_fine = $hit_by_app_damage * $hit_by_app_only_fine;

			/* Длительность сражения */
			$num_hits_war = $hit_by_war_with_fine>0 ? $apponent["hp"] / $hit_by_war_with_fine : 0 ;
			$num_hits_app = $hit_by_app_with_fine>0 ? $warrior["hp"]  / $hit_by_app_with_fine : 0 ;
			$num_hits_war = ceil($num_hits_war);
			$num_hits_app = ceil($num_hits_app);
		?>
		
		<!-- Вывод лога -->
		<div class="battle-form__log">
			<div class="battle-form__log_text battle-form__log_left">
				Нападаешь с уроном <span class="_blue">	<?=round($hit_by_war_damage,2)?> </span> за каждый удар. <br>
				<?=$hit_by_war_only_fine>0?"Бонус":"Штраф"?> разницы уровня <span class=" <?=$hit_by_war_only_fine>0?"_green":"_red"?>"><?=round($hit_by_war_only_fine*100,2)?></span>% <br>
				Защитано дамага <span class="<?=$hit_by_war_with_fine<$hit_by_war_damage?"_red":"_green"?>"><?=round($hit_by_war_with_fine,2)?></span>.<br>
				Количество ударов до победы: <span class="_blue"><?=$num_hits_war?></span>.<br>
			</div>
			<div class="battle-form__log_text battle-form__log_right">
				Защищается с уроном <span class="_blue"> <?=round($hit_by_app_damage,2)?> </span> за каждый удар. <br>
				<?=$hit_by_app_only_fine>0?"Бонус":"Штраф"?> разницы уровня <span class=" <?=$hit_by_app_only_fine>0?"_green":"_red"?>"><?=round($hit_by_app_only_fine*100,2)?></span>% <br>
				Защитано дамага <span class="<?=$hit_by_app_with_fine<$hit_by_app_damage?"_red":"_green"?>"><?=round($hit_by_app_with_fine,2)?></span>.<br>
				Количество ударов до победы: <span class="_blue"><?=$num_hits_app?></span>.<br>
			</div>
		</div>
		
		<div style="clear: both;"></div>
		<div class="all-forms__caption">
			<?php
			if( $num_hits_war == 0 || $num_hits_app == 0  ){
				if ( max( $num_hits_war, $num_hits_app)>10 ){
					echo("Бой больше 10 ударов. Противники устали. <br>");
					if ( $num_hits_war < $num_hits_app ) {
						echo("Нападавший убежал.");
					}else{
						echo("Аппонент убежал.");
					}
				}
			}else{
				echo("Бой закончился. <br>");
				if ( $num_hits_war > $num_hits_app ) {
					echo("<span class='_red'>Ваш боец проиграл.</span>");
				}else{
					echo("<span class='_green'>ВЫ ВЫИГРАЛИ !!!</span>");
				}
			}
			?>
		</div>

		<!-- Записать результаты в БД -->

		<!-- Записать лог боя в БД -->

		<div class="navbar navbar_center">
			<a class="navbar__a" href="/game/select_apponent.php">Найти ещё аппонента</a>
		</div>
		<br><br>
	</div>
</main>

<?php
include('../footer.php');
?>