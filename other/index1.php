
<?php echo "hello world"; ?>

<?php
if(isset($_GET['id']))
{
	echo "Hello";
	$hello = $_GET['id'];
	$result = exec('python Test.py');
	echo "<pre>$result</pre>";
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
				<button><a href="index.php?id=21">
					Enroll</a></button>
			</div>
		</div> 	
	</div>    
</body>
</html>
