<?php
	session_start();
	if (isset($_SESSION['usuario'])) {	
		$_SESSION = array();
		setcookie(session_name(),'',time()-100, '/');
		session_destroy(); 
	}
	header("Location: login.php");
?>