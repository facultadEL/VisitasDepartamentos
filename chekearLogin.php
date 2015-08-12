<?php
	if (!$_SESSION["usuario"]) { 
		require("login.php"); 
		exit; 
	}
?>