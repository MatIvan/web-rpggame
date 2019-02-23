<?php
include('../header.php');
include('../navbar.php');
?>

<main class="main-block">
	<div class="main-block__caption">
	    История моих сражений:
	</div>
	
    <!-- Проверка регистрации -->
    <?php 
    if( empty($_SESSION['user_id']) ){
        echo("<div class='battle-form'>");
        message_box( "Необходимо войти на сайт.", "/index.php", "На главную" ); 
        alarm_exit();
    }
    ?>

    <div class="all-forms all-forms_warriors-form">
        <!-- Получить данные из БД Я нападаю-->
        <div class="battle-form__results">
			<div class="all-forms__caption grid-cap">Я нападал</div>
            <?php 
                $historys = get_user_historys( $_SESSION['user_id'], "_w" );
            ?>
            <?php foreach($historys as $history): ?>
                <?php 
                $warrior = extract_warrior( $history, "_w" );
                $apponent = extract_warrior( $history, "_a" );
                ?>
                <div class="it1 <?= $history["resut"]>=0?"greenfon-right":" ";?>"><?php get_html_warrior_string( $warrior ); ?></div>
                <div class="it1 <?= $history["resut"]<0?"redfon-left":" ";?>"><?php get_html_warrior_string( $apponent ); ?></div>
			<?php endforeach; ?>
		</div>
        <br><br>
    </div>

    <div class="all-forms all-forms_warriors-form">
        <!-- Получить данные из БД Я в защите-->
        <div class="battle-form__results">
			<div class="all-forms__caption grid-cap">Я в защите</div>
            <?php 
                $historys = get_user_historys( $_SESSION['user_id'], "_a" );
            ?>
            <?php foreach($historys as $history): ?>
                <?php 
                $warrior = extract_warrior( $history, "_w" );
                $apponent = extract_warrior( $history, "_a" );
                ?>
                <div class="it1 <?= $history["resut"]>=0?"redfon-right":" ";?>"><?php get_html_warrior_string( $warrior ); ?></div>
                <div class="it1 <?= $history["resut"]<0?"greenfon-left":" ";?>""><?php get_html_warrior_string( $apponent ); ?></div>
			<?php endforeach; ?>
		</div>
        <br><br>
    </div>
    <br><br>

</main>

<?php
include('../footer.php');
?>