<?php
session_start();
if (isset($_SESSION["username"]))
	{
		session_destroy();
		echo "You have successfully logged out.";
		header('location: Login.php');
	}
else
	echo " No session exists or session is expired. Please log in again <a href='Login.php'> here </a>";
?>

