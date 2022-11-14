<?php
if(isset($_GET['id']))
{
	$hello = $_GET['id'];
	$result = shell_exec('workon cv && python3 /Desktop/Face/01_face_dataset.py ' . $hello);
}
?>
<html>
<head>
	<title> Login Page </title>
	<link rel="stylesheet" type="text/css" href="../CSS/topNav.css"> </link>
</head>
<body>
	<div class="wrapper">
		<div class="middle">
			<div class="contentnew">
				<button><a href="Enroll.php?id=21">
					Enroll</a></button>
			</div>
		</div> 	
	</div>    
</body>
</html>








