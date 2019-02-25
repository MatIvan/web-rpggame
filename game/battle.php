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
			message_box( "Не выбран оппонент для битвы.", "/game/select_apponent.php", "Назад" );
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
			message_box( "оппонент не найден в БД.", "/game/select_apponent.php", "Назад" ); 
			alarm_exit();
		}

		if ( $warrior["hp"]==0 || $apponent["hp"]==0 ){
			message_box( "Один из боёцов уже мертв (Здоровье = 0)", "/game/select_apponent.php", "Назад" ); 
			alarm_exit();
		}

		$warrior_history = $warrior;
		$apponent_history = $apponent;
		
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
			$hit_by_war_damage = (( $warrior["attack"] * $warrior["attack"] ) / ( $warrior["attack"] + $apponent["shield"] ))/10;
			$hit_by_war_only_fine = ( ( ( $apponent["level"] - $warrior["level"]) / $apponent["level"] )  );
			$hit_by_war_with_fine = $hit_by_war_damage + $hit_by_war_damage * $hit_by_war_only_fine;
			if ($hit_by_war_with_fine<0) $hit_by_war_with_fine = 0; //Урон не может быть отрицательным

			/* Для защищающегося */
			$hit_by_app_damage = (( $apponent["attack"] * $apponent["attack"] ) / ( $apponent["attack"] + $warrior["shield"] ))/10;
			$hit_by_app_only_fine = ( ( ( $warrior["level"] - $apponent["level"]) / $warrior["level"] )  );
			if ( $hit_by_app_only_fine<0 ) $hit_by_app_only_fine = -$hit_by_app_only_fine; //оппоненту ставится только положительный бонус от разницы в уровнях
			$hit_by_app_with_fine = $hit_by_app_damage + $hit_by_app_damage * $hit_by_app_only_fine;

			/* Длительность сражения */
			$num_hits_war = $hit_by_war_with_fine>0 ? $apponent["hp"] / $hit_by_war_with_fine : 99999 ; //99999 - бить может бесконечно (нет урона)
			$num_hits_app = $hit_by_app_with_fine>0 ? $warrior["hp"]  / $hit_by_app_with_fine : 99999 ;
			$num_hits_war = ceil($num_hits_war);
			$num_hits_app = ceil($num_hits_app);
		?>
		
		<!-- Вывод лога -->
		<div class="battle-form__log">
			<div class="battle-form__log_text battle-form__log_left">
				Нападаешь с уроном <span class="_blue">	<?=round($hit_by_war_damage,2)?> </span> за каждый удар. <br>
				<?=$hit_by_war_only_fine>0?"Бонус":"Штраф"?> разницы уровня <span class=" <?=$hit_by_war_only_fine>0?"_green":"_red"?>"><?=round($hit_by_war_only_fine*100,2)?></span>% <br>
				Защитано дамага <span class="<?=$hit_by_war_with_fine<$hit_by_war_damage?"_red":"_green"?>"><?=round($hit_by_war_with_fine,2)?></span>.<br>
				Количество ударов до победы: 
				<?php if($num_hits_war==99999):?>
					<span class="_red">нет урона</span>.<br>
				<?php else: ?>
					<span class="_blue"><?=$num_hits_war?></span>.<br>
				<?php endif ?>
				
			</div>
			<div class="battle-form__log_text battle-form__log_right">
				Защищается с уроном <span class="_blue"> <?=round($hit_by_app_damage,2)?> </span> за каждый удар. <br>
				<?=$hit_by_app_only_fine>0?"Бонус":"Штраф"?> разницы уровня в защите<span class=" <?=$hit_by_app_only_fine>0?"_green":"_red"?>"><?=round($hit_by_app_only_fine*100,2)?></span>% <br>
				Защитано дамага <span class="<?=$hit_by_app_with_fine<$hit_by_app_damage?"_red":"_green"?>"><?=round($hit_by_app_with_fine,2)?></span>.<br>
				Количество ударов до победы:
				<?php if($num_hits_app==99999):?>
					<span class="_red">нет урона</span>.<br>
				<?php else: ?>
					<span class="_blue"><?=$num_hits_app?></span>.<br>
				<?php endif ?>
			</div>
		</div>
		
		<div style="clear: both;"></div>
		<div class="all-forms__caption">
			<?php
			if( ( $num_hits_war==99999 || $num_hits_app==99999 ) && min( $num_hits_war, $num_hits_app)>10 ){
				echo("Бой больше 10 ударов. Противники устали. <br>");
				if ( $num_hits_war < $num_hits_app ) {
					echo("<br>Нападавший убежал."); //Ты убежал
				}else{
					echo("<br>Оппонент убежал."); //Противник убежал
				}
				$result_history = 0;
			}else{
				echo("Бой закончился. <br>");
				if ( $num_hits_war >= $num_hits_app ) {
					echo("<span class='_red'>Ваш боец проиграл.</span>");    //Ты проиграл
					$score=round($warrior["hp"]/3,0);
					$apponent = increase_warrior($apponent, $score);
					if ( edit_warrior( $apponent )>=0 ){
						echo("<br><span style='font-size:50%; font-weight: normal;'>".$apponent["name"]." забирает себе ".$score."очков.</span>");
					}else{
						echo("<br>Ошибка обновления бойца: ".$apponent["name"].".");
					}
					$result_history = -$score;
					$warrior["hp"] -= $score;
					if ( edit_warrior( $warrior )>=0 ){
						// 
					}else{
						echo("<br>Ошибка обновления бойца: ".$warrior["name"].".");
					}
				}else{
					echo("<span class='_green'>ВЫ ВЫИГРАЛИ !!!</span>"); //Ты выиграл
					$score=round($apponent["hp"]/3,0);
					$result_history = $score;
					$warrior = increase_warrior($warrior, $score);
					if ( edit_warrior( $warrior )>=0 ){
						echo("<br><span style='font-size:50%; font-weight: normal;'>".$warrior["name"]." забирает себе ".$score." очков.</span>");
					}else{
						echo("<br>Ошибка обновления бойца: ".$warrior["name"].".");
					}
					$apponent["hp"] -= $score;
					if ( edit_warrior( $apponent )>=0 ){
						//echo("<br>Данные бойца ".$apponent["name"]." обновлены.");
					}else{
						echo("<br>Ошибка обновления бойца: ".$apponent["name"].".");
					}
				}
			}
			?>
		</div>

		<?php
		$n_warrior = get_warrior_by_id( $_POST['id_warrior'] );
		$n_apponent = get_warrior_by_id( $_POST['id_apponent'] );
		?>

		<div class="battle-form__results">
			<div class="all-forms__caption grid-cap">Бойцы после сражения:</div>
			<div class="all-forms it1"><?php get_html_warrior_string( $n_warrior ); ?></div>
			<div class="all-forms it1"><?php get_html_warrior_string( $n_apponent ); ?></div>
		</div>

		<!-- Записать лог боя в БД -->
		<?php save_history( $warrior_history, $apponent_history, $result_history ); ?>

		<div class="navbar navbar_center">
			<a class="navbar__a" href="/game/select_apponent.php">Найти ещё оппонента</a>
		</div>
		<br><br>
	</div>
</main>

<?php
include('../footer.php');
?>