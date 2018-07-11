<?php
session_start();

if (empty($_SESSION)) {
	header('Location: index.php');
	exit;
}

session_destroy();
header('Location: index.php');
?>