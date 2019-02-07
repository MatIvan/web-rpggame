<?php

function get_user_login( $link, $user_id ){
	$sql = "SELECT login FROM users WHERE id='$user_id'";
	$result = mysqli_query($link, $sql);
	$login = mysqli_fetch_array($result);
	return $login['login'];
}

?>