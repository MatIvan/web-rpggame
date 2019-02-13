<?php
include('../header.php');
include('../navbar.php');
?>

<main class="main-block">
	<div class="main-block__caption">
	Выбор аппонента:
	</div>
	
	<?php if( empty($_SESSION['user_id']) ): ?>
		<section class="form" id="login_error_form">
			Необходимо войти на сайт.";
			<br><br>
			<a href="/index.php">Вернуться на главную</a>
			<br><br>
		</section>
	<?php else: ?>
		<form class="form"  id="selection_form" action="/game/BLABLA.php" method="post" >
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
									<?= $warrior["name"] ?> ( 
									<?= $warrior["level"] ?> /
									<?= $warrior["hp"] ?> / 
									<?= $warrior["attack"] ?> / 
									<?= $warrior["shield"] ?> )
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
									<?= $apponent["name"] ?> ( 
									<?= $apponent["level"] ?> )
								</label>
							</div>
						<?php endforeach; ?>
					<?php endif ?>
				</section>
			<div style="clear: both;">&nbsp;</div>
			<section class="nav-block">
				<input class="btn" type="submit" value="НАЧАТЬ СРАЖЕНИЕ" />
			</section>
		</form>
	<?php endif ?>

	
</main>

<?php
include('../footer.php');
?>