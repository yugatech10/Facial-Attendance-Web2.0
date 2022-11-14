<?php
include "../Auth/connection.php";
$cID = $_GET['cid'];
$cSID = $_GET['cSID'];
if(isset($cID)){
	$queryDelete = "DELETE FROM class WHERE cID = '".$cID."'";
	$resultDelete = mysqli_query($link,$queryDelete);
	if (!$resultDelete)
	{
		die ("Error: ".mysqli_error($link));
		}		
	else {
		header("Location: Class.php");
	}
}
if(isset($cSID)){
	$queryDelete = "DELETE FROM class WHERE cID = '".$cID."'";
	$resultDelete = mysqli_query($link,$queryDelete);
	if (!$resultDelete)
	{
		die ("Error: ".mysqli_error($link));
		}		
	else {
		header("Location: Class.php");
	}
}
?>