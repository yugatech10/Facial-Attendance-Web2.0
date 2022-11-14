<?php
//call this function to check if session exists or not
session_start();

//if session exists
if(isset ($_SESSION["username"])) //session userid gets value from text field named userid, shown in user.php
{	include "Header.php";?>
<!DOCTYPE html>
<html>
<body>
	<h1 align="center"> Student Users </h1>
<?php
	$queryGet = "select * from users where type_user = 'Student'";	
	$resultGet = mysqli_query($link,$queryGet);
	if(!$resultGet)
	{
		die ("Invalid Query - get Items List: ". mysqli_error($link));
	}
	else
	{?>
	<table id="table" border="1" align="center">
		<tr>
			<th>Username</th>
			<th>Student ID</th>
			<th>Name</th>
			<th>Email</th>
			<th>Contact Number</th>
			<th>Facial Enrollment</th>
			<th>Action</th>
		</tr>	 
		
<?php	while($row= mysqli_fetch_array($resultGet, MYSQLI_BOTH))
		{	?>
			<tr>
				<td><?php echo $row['username']?></td>
				<td><?php echo $row['id'];?></td>
				<td><?php echo $row['name']; ?></td>
				<td><?php echo $row['email']; ?></td>
				<td><?php echo $row['Hp']; ?></td>
				<td><?php if($row['facial']==1) echo "Enrolled"; else echo "Haven't Enrolled";?></td>
				<td><a href="StudentEdit.php?id=<?php echo $row['username'];?>">
					<img border="0" alt="editB" src="../CSS/btn/editB.png" width="25" height="25"></a>
					<a href="Delete.php?sid=<?php echo $row['username'];?>" onclick="return confirm('Are you sure?')">
					<img border="0" alt="editB" src="../CSS/btn/delB.png" width="25" height="25"></a></a>
				</td>
			</tr>
<?php	}?>
		
	</table>
<?php
	}
}		
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
