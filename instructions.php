<?php
include('header.php');
include('navbar.php');
?>

<main class="main-block">

<div class="all-forms all-forms_warriors-form">
	<div class="main-block__caption">
	    Правила игры:
	</div>
	<div class="instruction">

        <h2>Введение</h2>
        <p>
        Игра очень простая. Каждому новому пользователю выдаётся 100 очков.
        Игрок может создать любое количество бойцов и потратить свои очки на их параметры.
        Все бойцы, у которых ЖИЗНЬ больше нуля, автоматически начиют ждать нападения на них и будут защищаться.
        </p>
        <p>
        Игрок может сам нападать на бойцов других игроков.
        Победитель забирает себе 30% жизни соперника.
        </p>
        <br>
        <h2>Распределение очков и уровень война</h2>
        <p>
        В любой момент можно создать нового или изменить старого бойца.
        Очки, потраценные на параметры (характеристики) бойца будут вычитаться с баланса пользователя.
        Если параметр бойца уменьшить, то эти очки вернуться на баланс и их можно будет потратить на другого воина.
        </p>
        <p>
        Уровень бойца равен сумме очков всех его параметров. Учтите, что в бою разница в уровне бойцов накладывает штрафы на результат.
        </p>
        <p>
        <ul>
            <li>
            Жизнь - Этот параметр указывает как долго боец может прожить в бою.
            </li>
            <li>
            Атака - Влияет на то, как много жизнь сможет отнять у врага боец.
            </li>
            <li>
            Защита - Влияет расчет того, как сильно снизится урон от врага.
            </li>
        </ul>
        </p>
        <h2>Сражения</h2>
        <p>
            Пользователь выбирает каким бойцом и на кого он будет нападать.
            Разница в уровне бойцов сильно влияет на сражение: Сильный хуже бъёт по слабому.
            Но в защите у сильно приимущество: его штрафы превращаются в бонусы.
            Надо стараться нападать на равных себе.
        </p>
        <p>
            Штрафы или Бонусы в бою расчитываются в виде %. 
            Т.е. насколько процентов изменится расчетные значения урона.
        </p>
        <p>
            Формулы: <br>
            для атакующего:<br> <span class="formula">( ( ( УровеньЗащитника - УровеньНападающего) / УровеньЗащитника )  )</span><br>
            для защитника:<br>  <span class="formula">( ( ( УровеньНападающего - УровеньЗащитника) / УровеньНападающего )  )</span><br>
        </p>
        <p>
            <b>Важно в защите боец или в атаке!!!</b> 
        </p>
        <p>
            Вычисление победителя проихоит так:<br>
            <ol>
                <li>Вычисляется сколько бойцы могут нанести друг другу урона.</li>
                <li>Расчитывается процент изменения урона от разницы уровней. (Для защитника всегда положительный)</li>
                <li>Расчитывается сколько ударов необхоимо, что бы закончилось здоровье противника.</li>
            </ol>
           
        </p>
        <p>
            Выигрывает тот у кого меньше ударов.
        </p>
        <p>
            Бывают ситуации, когда урон равен нулю, т.е. противник не может пробить защиту оппонента или слишком велик штраф от разницы уровней.
            В этой ситуации победа засчитается, только если враг успеет убить за 10 ударов. Иначе бует ничья.
        </p>
        <p>
            <b> Формула расчета чистого урона (без штрафов и бонусов):</b><br>
            <span class="formula">(( Атака * Атака ) / ( Атака + Защита ))/10</span><br>
            где, Атака - количество очков в атаке бьющего, Защита - очки защиты обороняющегося.
        </p>
        <h2>Победа</h2>
        <p>
            <b>Победитель</b> получает 30% от очков Здоровья врага. Эти очки равномерно распределяются по всем параметрам бойца. Т.е. он становится сильнее во всех характеристиках.
        </p>
        <p>
            Остаток от распределённых очков начисляется дополнительно к Здоровью. 
        </p>
        <p>
            <b>Проигравший</b> теряет 30% очков от своего Здоровья.
        </p>
    </div>
    <br><br>
</div>
<br><br>
</main>

<?php
include('footer.php');
?>