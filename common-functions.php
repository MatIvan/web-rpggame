<?php

//Вывести текст ошибки на страницу
function print_error( $str_error ){
	echo "<span class='error-msg'>";
	echo "Server ERROR:";
	echo $str_error;
	echo "</span>";
}

//Вывести форму с сообщением и ссылкой
function message_box( $str_message, $back_url, $back_text ){
    echo "<form class='all-forms all-forms_login-form'>";
    echo "<div class='all-forms__caption'>";
    echo $str_message;
    echo "</div>";
    echo "<div class='navbar navbar_center'>";
    echo "<a class='navbar__a' href='".$back_url."'>".$back_text."</a>";
    echo "</div>";
    echo "</form>";
}

//Завершить страницу
function alarm_exit(){
    echo "</main>";
    include('/footer.php');
}


//всавит html код с характеристиками бойца в виде одной строки с картинками
function get_html_warrior_string( $warrior ){
    echo ("
    <div class='warrior-str'>
    <div class='warrior-str__element warrior-str__element_name warrior-str_left'>".$warrior["name"]."</div>");
    if( isset($warrior["shield"]) ){
        echo ("
        <div class='warrior-str__element warrior-str_right'>
            <img class='warrior-str__element__img' src='/img/shield16.png'>
            <div class='warrior-str__element__txt warrior-str_right'>".$warrior["shield"]."</div>
        </div>
        ");
    }
    if( isset($warrior["attack"]) ){
        echo ("
        <div class='warrior-str__element warrior-str_right'>
            <img class='warrior-str__element__img' src='/img/attack16.png'>
            <div class='warrior-str__element__txt warrior-str_right'>".$warrior["attack"]."</div>
        </div>
        ");
    }

    if( isset($warrior["hp"]) ){
        echo ("
            <div class='warrior-str__element warrior-str_right'>
                <img class='warrior-str__element__img' src='/img/hp16.png'>    
                <div class='warrior-str__element__txt warrior-str_right'>".$warrior["hp"]."</div>
            </div>
        ");
    }
    echo ("
    <div class='warrior-str__element warrior-str_right'>
        <img class='warrior-str__element__img' src='/img/level16.png'>
        <div class='warrior-str__element__txt warrior-str_right'>".$warrior["level"]."</div>
    </div>
    </div>
    ");
}


?>