<?php
	include "../Auth/connection.php";
	$name = $_POST["name"];
	$id = $_POST["id"];
	$email = $_POST["email"];
	$Hp = $_POST["Hp"];
	$uID = $_POST["username"];
	$queryInsert = "UPDATE users SET
	   name = '".$name."', 
	   id = '".$id."', 
	   email = '".$email."',
	   Hp = '".$Hp."'
	   WHERE username = '$uID'";
	 
	$resultInsert = mysqli_query($link,$queryInsert);
	if (!$resultInsert)
	{
		die ("Error: ".mysqli_error($link));
	}		
	else {
		echo '<script type="text/javascript">
				window.onload = function () 
				{ 
				alert("Staff Detail has been Updated...");
				open("Lecturer.php","_top");
				}
				</script>';

	}
?>