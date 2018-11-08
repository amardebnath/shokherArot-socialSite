<?php
session_start();
if (isset($_SESSION['success'])){
	header('Location: home.php');
} else {
	header('Location: signin.php');
}

?>