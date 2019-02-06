<?php
include('header.php');
include('navbar.php');
?>

<main>
	<div class="caption">
		Добро пожаловать в игру "RPG web game" !!!
	</div>
	
	<section class="form" id="login_form">
		<?php
		if(empty($login) and empty($user_id)){
			include("login/login_form.php");
		}else{
			include("login/welcome_form.php");
		}
		?>
	</section>
</main>

<?php
include('footer.php');
?>