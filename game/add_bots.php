<?php
include('../header.php');
include('../navbar.php');
?>

<main class="main-block">
	<div class="main-block__caption">
	Создание ботов...
	</div>

	<form class="all-forms all-forms_login-form">
		<div class='all-forms__caption'>
		<?php
		if (isset($_POST['submit'])){
			if(empty($_POST['lvl_min']))  {
				echo "Укажите минимальный уровень ботов!";
			}elseif(empty($_POST['lvl_max'])){
                echo "Укажите максимальный уровень ботов!";
            }elseif(empty($_POST['value'])){
				echo "Укажите количество ботов!";
			}elseif(!is_numeric($_POST['lvl_min'])){
                echo "Значение уровня должно быть числом.";
            }elseif(!is_numeric($_POST['lvl_max'])){
                echo "Значение уровня должно быть числом.";
            }elseif(!is_numeric($_POST['value'])){
                echo "Значение количества должно быть числом.";
			}else{
                
                for ($i=0; $i<$_POST['value']; $i++) {
                    $lvl = rand($_POST['lvl_min'], $_POST['lvl_max']);
                    $new_warrior = generate_bot( "bot".date("W").date("d").$i,$lvl );
                    add_new_warrior( $new_warrior );
                }

                echo("<div class='all-forms__caption'>Боты созданы.</div>");
				
			}
		}
		
		?>
		</div>
		<br><br>
		<div class="navbar navbar_center">
			<a class="navbar__a" href="/game/warriors.php">Вернуться к бойцам</a>
		</div>
	</form>
</main>

<?php
include('../footer.php');
?>