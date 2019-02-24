<?php
include('../header.php');
include('../navbar.php');
?>

<main class="main-block">
	<div class="main-block__caption">
	Выбор аппонента:
	</div>
	
	<?php if( empty($_SESSION['user_id']) ): ?>
		<form class="all-forms all-forms_login-form">
			<div class="all-forms__caption">
				Необходимо войти на сайт.
			</div>
			<div class="navbar navbar_center">
				<a class="navbar__a" href="/index.php">Вернуться на главную</a>
			</div>
		</form>
	<?php else: ?>
		<form class="all-forms all-forms_warriors-form" action="/game/battle.php" method="post">
			<section class="list_warriors_form"  id="my_warriors_form">
				<h2>Мои бойцы:</h2>
				<?php 
					$warriors = get_user_warriors( $_SESSION['user_id'] );
				?>
				<?php if( count($warriors) === 0): ?>
					Ещё не создано ни одного бойца.
				<?php else: ?>
					<?php foreach($warriors as $warrior): ?>
						<div class="inputGroup">
							<input class="radio-btn" id="warrior<?= $warrior["id"] ?>" name="id_warrior" type="radio" value="<?= $warrior["id"] ?>"/>
							<label for="warrior<?= $warrior["id"] ?>">
							<?= get_html_warrior_string( $warrior ) ?>
							</label>
						</div>
					<?php endforeach; ?>
				<?php endif ?>
			</section>
			<section class="list_warriors_form" id="apponents_form">
				<h2>Аппоненты:</h2>
				<?php 
					$apponents = get_user_apponents( $_SESSION['user_id'] );
				?>
				<?php if( count($apponents) === 0): ?>
					Нет подходящих аппонентов.
				<?php else: ?>
					<?php foreach($apponents as $apponent): ?>
						<div class="inputGroup">
							<input class="radio-btn" id="apponent<?= $apponent["id"] ?>" name="id_apponent" type="radio" value="<?= $apponent["id"] ?>"/>
							<label for="apponent<?= $apponent["id"] ?>">
								<?= get_html_warrior_string( $apponent ) ?>
<!-- 								<?= $apponent["name"] ?> ( 
								<?= $apponent["level"] ?> ) -->
							</label>
						</div>
					<?php endforeach; ?>
				<?php endif ?>
			</section>
			<div style="clear: both;">&nbsp;</div>
			<input class="all-forms__btn all-forms__btn_center" type="submit" value="НАЧАТЬ СРАЖЕНИЕ" />
		</form>
	<?php endif ?>
	<br><br>
	
</main>

<?php
include('../footer.php');
?>