<?php include('DataBase.php') ?>
<html>
<head>
	<title>Student Registration</title>
	<link rel="stylesheet" type="text/css" href="../CSS/topNav.css">
</head>
<body>
	<div class="wrapper">
		<div class="middle">
			<div class="contentnew">
			<form class = "content" style="position:absolute;" method = "post">
				<h1 class="header">Student Registration</h1>
					<div class="input-group">
						<?php include('Errors.php');?><br>
						<label>Username*</label>
						<input type="text" name="username"><br><br>
						<label>Password*</label>
						<input type="password" name="password"><br><br>
						<label>Student ID*</label>
						<input type="text" name="id"><br><br>
						<label>Name*</label>
						<input type="text" name="Name"><br><br>
						<label>Email*</label>
						<input type="email" name="email"><br><br>
						<label>Contact Number*</label>
						<input type="text" name="Hp" placeholder="0123456789"><br><br>
						<p style="margin-top: 0px;float: right;color: red;">* is required to fill</p>
						<input type="hidden" name="type_user" value="Student">
						<button type="submit" class="btn" name="reg_user" style="margin-top: 20px;">Register</button>
						<p>Already a member? <a href="Login.php">Sign in</a></p>
					</div> 
			</form>
			</div>
		</div>
	</div>
	<br><br><br><br>
</body>
</html>