<?php
session_start();
//if session exists
if(isset ($_SESSION["username"])) //call this function to check if session exists or not
{
	include "Header.php";?>
<!DOCTYPE html>
<html>


<body>
<?php
	$queryGet = "select * from users where username='".$_SESSION["username"]."'";

	$resultGet = mysqli_query($link,$queryGet);

	if(!$resultGet)
	{
		die ("Invalid Query - get Register List: ". mysqli_error($link));
	}
	else 
	{?>
	<div class="wrapper">
		<div class="middle">
			<div class="contentnew" style="margin-bottom: 50px;">
			<form class = "content" style="position: relative; width: 60%; margin:auto;left:0" action="../Admin/StudentUpdate.php" name="EditForm" method="POST">
				<h1 class="header">My Profile</h1>
				<?php	while($baris= mysqli_fetch_array($resultGet, MYSQLI_BOTH))	{?>
					<div class="input-group">
						<label>Username</label>
						<input type="text" name="username" value="<?php echo $baris['username']; ?>" disabled><br><br>
						<input type="hidden" name="username" value="<?php echo $baris['username']; ?>">
						<input type="hidden" name="from" value="Lecturer">
						<label>Name</label>
						<input type="text" name="name" value="<?php echo $baris['name'] ?>"><br><br>
						<label>Student ID</label>
						<input type="text" name="id" value="<?php echo $baris['id'] ?>"><br><br>
						<label>Email</label>
						<input type="email" name="email" value="<?php echo $baris['email'] ?>"><br><br>
						<label>Contact Number</label>
						<input type="text" name="Hp" value="<?php echo $baris['Hp']; ?>"><br><br>
						<button style="position: relative;left: 80%"; type="submit" class="btn" name="staff">Update</button>
					</div> <?php	}?>
			</form>
			</div>
		</div>
	</div>
	
<?php 
	}	}
else{
    echo "No session exists or session has expired. Please log in again ";
	echo "Page will be redirect in 2 seconds";
	header('Refresh: 2; ../Admin/Login.php');
}				
?>
 
	 
</body>
</html>
