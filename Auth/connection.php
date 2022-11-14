<?php
$link=mysqli_connect("localhost","root","sudo","attendance");
// Check connection
if (mysqli_connect_errno())
{
      echo "Failed to connect to MySQL: " . mysqli_connect_error();
      die();
}
?>
