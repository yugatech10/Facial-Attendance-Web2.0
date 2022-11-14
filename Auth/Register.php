<?php include('DataBase.php') ?>
<html>
<head>
	<title>Customer Registration</title>
	<link rel="stylesheet" type="text/css" href="../CSS/topNav.css">
</head>
<body>
	<div class="wrapper">
		<div class="middle">
			<div class="contentnew">
			<form class = "content"  method = "post">
				<h1 class="header">Customer Registration</h1>
					<div class="input-group">
						<?php include('Errors.php');?><br>
						<label>Username</label>
						<input type="text" name="username" value="<?php echo $username; ?>"><br><br>
						<label>Email</label>
						<input type="email" name="email" value="<?php echo $email; ?>"><br><br>
						<label>Password</label>
						<input type="password" name="password"><br><br>
						<label>Contact Number</label>
						<input type="text" name="Hp" placeholder="0123456789"><br><br>
						
						<input type="hidden" name="cName" value="NULL">
						<input type="hidden" name="type_user" value="Customer">
						<input type="hidden" name="verify" value="Verified">
						<button type="submit" class="btn" name="reg_user">Register</button>
						<p>Already a member? <a href="Login.php">Sign in</a></p>
					</div> 
			</form>
			</div>
		</div> 	
	</div>
</body>
</html>