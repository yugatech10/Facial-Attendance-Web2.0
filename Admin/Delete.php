<?php
	include "../Auth/connection.php";
	$uID = $_GET['id'];
	$sID = $_GET['sid'];
	
	if(isset($uID)){
		$queryDelete = "DELETE FROM users WHERE username = '".$uID."'";
		$resultDelete = mysqli_query($link,$queryDelete);
		if (!$resultDelete)
		{
			die ("Error: ".mysqli_error($link));
		}		
		else {
			header("Location: Lecturer.php");
		}
	}
	if(isset($sID)){
		$queryDelete = "DELETE FROM users WHERE username = '".$sID."'";
		$resultDelete = mysqli_query($link,$queryDelete);
		if (!$resultDelete)
		{
			die ("Error: ".mysqli_error($link));
		}		
		else {
			header("Location: Student.php");
		}
	}
?>