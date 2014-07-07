<?php

session_start();
include("functions.php");

displayHeader("Votre compte client Imosoweb");

if ((isset($_SESSION['login']))&&(!isset($_SESSION['admin']))){
?>
	<p> CLIENT </p>
<?php
}
else if (!isset($_SESSION['login'])){
	header('Location: index.php');
}
else{
	header('Location: admin.php');
}

displayFooter();
?>