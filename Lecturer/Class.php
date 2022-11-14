<?php
//call this function to check if session exists or not
session_start();

//if session exists
if(isset ($_SESSION["username"])) //session userid gets value from text field named userid, shown in user.php
{	include "Header.php";
	$user = $_SESSION["username"];
	?>
<!DOCTYPE html>
<html>
<head>
<style>
.mid{
	margin: auto;
	width: 50%;
	padding: 10px;
	
}
.content2 {
	margin: auto;
	width: 100%;
	padding: 20px; 
	border: 1px solid #483235;
	background: white;
	border-radius: 10px 10px 10px 10px;
}
.input-group2 {
  margin: 10px 0px 10px 0px;
}
.input-group2 label {
	display: inline-flex;  
    margin-bottom: 10px;
	text-align: left;
	margin: 3px;
}
.input-group2 input {
	display: inline;
	float: right;
	height: 30px;
	width: 50%;
	padding: 5px 10px;
	font-size: 16px;
	border-radius: 5px;
	border: 1px solid gray;
}
.input-group2 textarea {
	display: inline;
	float: right;
	width: 50%;
	padding: 5px 10px;
	font-size: 16px;
	border-radius: 5px;
	border: 1px solid gray;
}
.content button{
	display: block;
	float: right;
	
}
</style>
</head>
<body>
	<h1 align="center"> My Classes</h1>
<?php
	$queryGet = "select * from class where lecturer='$user'";	
	$resultGet = mysqli_query($link,$queryGet);
	if(!$resultGet)
	{
		die ("Invalid Query - get Items List: ". mysqli_error($link));
	}
	else
	{?>
	<table id="table" border="1" align="center">
		<tr>
			<th>No</th>
			<th>Name</th>
			<th>Total Student</th>
			<th>Time Slot 1</th>
			<th>Time Slot 2</th>
			<th>Action</th>
		</tr>	 
		<form>
<?php	$no=1;
		if(mysqli_num_rows($resultGet)>0){
		while($row= mysqli_fetch_array($resultGet, MYSQLI_BOTH))
		{	
			
			?>
			<tr>
				<td><?php echo $no;?></td>
				<td><?php echo $row['name']?></td>
				<td><?php echo $row['student']?></td>
				<td><?php echo $row['timeSlot']?></td>
				<td><?php echo $row['timeSlot2']?></td>
				<td><a href="Edit.php?id=<?php echo $row['cID'];?>">
					<img border="0" alt="editB" src="../CSS/btn/editB.png" width="25" height="25"></a>
					<a href="Delete.php?cid=<?php echo $row['cID'];?>" onclick="return confirm('Are you sure?')">
					<img border="0" alt="editB" src="../CSS/btn/delB.png" width="25" height="25"></a></a>
				</td>
			</tr>
		<?php	$no++;}}
		else{
?>
			<tr>
				<td colspan="6">No Data</td>
			</tr>
		<?php	}?>
		</form>	
	</table>
	<div class="mid">
		<form class="content2" action="" method="POST">
			<h1 class="header">Class Registration</h1>
				<div class="input-group2">
					<label>Name</label>
					<input type="text" name="name"><br><br>
					<label>Total Student</label>
					<input type="text" name="student"><br><br>
					<label>Time Slot 1</label>
					<input type="time" name="time1"><br><br>
					<label>Time Slot 2</label>
					<input type="time" name="time2"><br><br>
				</div> 	
				<br><br>
				<button type="submit" class="btn" style="margin-top: -25px;" name="register">Register</button>	
		</form>
	</div>
	<br><br><br><br>
<?php
	}
	if(isset($_POST["register"])){
		$lecturer = $user;
		$student = $_POST['student'];
		$name = $_POST['name'];
		$time1 = $_POST['time1'];
		$time2 = $_POST['time2'];
		
		$user_check_query = "SELECT * FROM class WHERE name='$name' LIMIT 1";
		$result = mysqli_query($link, $user_check_query);
		$user = mysqli_fetch_assoc($result);

			//encrypt the password before saving in the database$password = md5($password)
			$query = "INSERT INTO class (cID, name, lecturer, student, timeSlot, timeSlot2) 
				  VALUES(NULL, '$name', '$lecturer', '$student', '$time1', '$time2')";
			$resultInsert = mysqli_query($link, $query);
			if (!$resultInsert)
			{
				die ("Error: ".mysqli_error($link));
			}		
			else {
				echo '<script type="text/javascript">
					window.onload = function () 
					{ 
					alert("Class been Registered...");
					open("Class.php","_top");
					}
					</script>';
			}	
	}
}		
else	{
	echo "No session exists or session has expired. Please log in again ";
	echo "Page will be redirect in 5 seconds";
	header('Refresh: 5; ../Auth/Login.php');
}
?>
</body>
</html>
