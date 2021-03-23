<?php
    session_start();
	unset($_SESSION["ID"]);
	$_SESSION["login_session"] = false;
?>