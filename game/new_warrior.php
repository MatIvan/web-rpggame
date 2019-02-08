<?php
include('../header.php');
include('../navbar.php');
?>

<main>
	<div class="caption">
	Создать нового бойца:
	</div>
	
	<?php if( empty($_SESSION['user_id']) ): ?>
		<section class="form" id="login_error_form">
			Необходимо войти на сайт.";
			<br><br>
			<a href="/index.php">Вернуться на главную</a>
			<br><br>
		</section>
	<?php else: ?>
		<section class="form" id="new_warrior">
			<div class="caption">Укажите характеристики:</div>
			<form action="add_new_warrior.php" method="POST">
				<input type="text" name="name" placeholder="Имя бойца" >
				<input type="text" name="balance" placeholder="Баланс" >
				<input type="text" name="hp" placeholder="Жизнь" >
				<input type="text" name="attack" placeholder="Атака" >
				<input type="text" name="shield" placeholder="Защита" >
				<br><br>
				<input class="btn" type="submit" value="Создать" name="submit" >
			</form>
			<br>
		</section>
	<?php endif ?>
</main>

<?php
include('../footer.php');
?>