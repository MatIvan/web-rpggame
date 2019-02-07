<?php
include('../header.php');
include('../navbar.php');
?>

<main>
	<div class="caption">
	Бойцы:
	</div>
	
	<?php if( empty($_SESSION['user_id']) ): ?>
		<section class="form" id="login_error_form">
			Необходимо войти на сайт.";
			<br><br>
			<a href="/index.php">Вернуться на главную</a>
			<br><br>
		</section>
	<?php else: ?>
		<section class="form" id="warriors_form">
			<?php 
				$warriors = get_user_warriors( $link, $_SESSION['user_id'] );
			?>
			<?php if( count($warriors) === 0): ?>
				Ещё не создано ни одного бойца.
			<?php else: ?>
				<?php foreach($warriors as $warrior): ?>
					<?= $warrior["id"] ?> / 
					<?= $warrior["name"] ?> / 
					<?= $warrior["balance"] ?> / 
					<?= $warrior["hp"] ?> / 
					<?= $warrior["attack"] ?> / 
					<?= $warrior["shield"] ?>
					<br><br>
				<?php endforeach; ?>
			<?php endif ?>
			<form action="/game/new_warrior.php" method="post">
				<input type="submit" value="Создать нового бойца" />
			</form>
		</section>
	<?php endif ?>

	
</main>

<?php
include('../footer.php');
?>