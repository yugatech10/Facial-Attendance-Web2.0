<?php
//call this function to check if session exists or not
session_start();

//if session exists
if(isset ($_SESSION["username"])) //session userid gets value from text field named userid, shown in user.php
{
	include "Header.php";?>
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
	margin-top: 20px;
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
	<h1 align="center"> Lecturer </h1>
	<?php
	$queryGet = "select * from users where type_user = 'Lecturer' order by name";	
	$resultGet = mysqli_query($link,$queryGet);
	if(!$resultGet)
	{	die ("Invalid Query - get Items List: ". mysqli_error($link));	}
	else
	{	$no=1;?>
        <table id="table" align="center">
            <tr>
				<th>No</th>
				<th>Username</th>
				<th>Name</th>
				<th>ID</th>
				<th>Contact Number</th>
				<th>Email</th>
				<th>Action</th>
			</tr>	 
			<form action="Retailer.php" name="EditForm" method="POST">
<?php		while($row= mysqli_fetch_array($resultGet, MYSQLI_BOTH))
			{
			?>
			<tr>
				<td><?php echo $no;?></td>
				<td><?php echo $row['username']?></td>
				<td><?php echo $row['name']?></td>
				<td><?php echo $row['id']?></td>
				<td><?php echo $row['Hp']; ?></td>
				<td><?php echo $row['email'];?></td>
				<td><a href="Edit.php?id=<?php echo $row['username'];?>">
					<img border="0" alt="editB" src="../CSS/btn/editB.png" width="25" height="25"></a>
					<a href="Delete.php?id=<?php echo $row['username'];?>" onclick="return confirm('Are you sure?')">
					<img border="0" alt="editB" src="../CSS/btn/delB.png" width="25" height="25"></a></a>
				</td>
			</tr>
<?php
	$no++;		}?>
			</form>	
		</table>
<?php
		}?>
		
		<div class="mid">
			<form class="content2" action="../Auth/DataBase.php" method="POST">
				<h1 class="header">Staff Registration</h1>
					<div class="input-group2">
						<?php $errors = array();include('../Auth/Errors.php');?><br>
						<label>Username*</label>
						<input type="text" name="username"><br><br>
						<label>Password*</label>
						<input type="password" name="password"><br><br>
						<label>Staff ID*</label>
						<input type="text" name="id"><br><br>
						<label>Name*</label>
						<input type="text" name="Name"><br><br>
						<label>Email*</label>
						<input type="email" name="email"><br><br>
						<label>Contact Number*</label>
						<input type="text" name="Hp" placeholder="0123456789"><br><br>
						<p style="margin-top: 0px;float: right;color: red;">* is required to fill</p>
						<input type="hidden" name="type_user" value="Lecturer">
					</div> 	
					<br><br>
					<button type="submit" class="btn" style="margin-top: 20px;" name="reg_user">Register</button>	
			</form>
	</div>
	<br><br><br><br>
<?php }		
else	{
	echo "No session exists or session has expired. Please log in again ";
	echo "Page will be redirect in 5 seconds";
	header('Refresh: 5; ../Admin/Login.php');
}
if (isset($_POST['updateBTN'])) 
{
	$username =$_POST["username"];
	$verification = "Verified";
	$queryInsert = "UPDATE users SET 
					verification = '".$verification."' 
					WHERE username = '".$username."'";
	 
	$resultInsert = mysqli_query($link,$queryInsert);
	if (!$resultInsert)
	{
		die ("Error: ".mysqli_error($link));
	}
	else 
	{
		echo '<script type="text/javascript">
		            window.onload = function () 
		            { 
					alert("User been verified...");
					open("Retailer.php","_top");
					}
					</script>';

	}
}
	?>
</body>
</html>
