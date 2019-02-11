<div class="caption">
	Привет, <?= $_SESSION['user_login'] ?> !!!
</div>
<span>
	<br>
	У вас на балансе: <strong> <?= $_SESSION['user_balance'] ?> </strong> очков.
	<br><br>
		<a href="/game/warriors.php">Показать моих бойцов</a>
	<br><br>
</span>
