
<div class="all-forms all-forms_warrior">
    <div class="all-forms__caption">
		<?= $warrior_show["name"] ?>
	</div>
    <div class="warrior-data warrior-data_center">
        <table class="clear-table">
            <tr>
                <td>Уровень</td>
                <td><img src='/img/level32.png'></td>
                <td><?= $warrior_show["level"] ?></td>
            </tr>
            <tr>
                <td>Здоровье</td>
                <td><img src='/img/hp32.png'></td>
                <td><?= $warrior_show["hp"] ?></td>
            </tr>
            <tr>
                <td>Атака</td>
                <td><img src='/img/attack32.png'></td>
                <td><?= $warrior_show["attack"] ?></td>
            </tr>
            <tr>
                <td>Защита</td>
                <td><img src='/img/shield32.png'></td>
                <td><?= $warrior_show["shield"] ?></td>
            </tr>
        </table>
    </div>
</div>


<?php
//$warrior_show
?>