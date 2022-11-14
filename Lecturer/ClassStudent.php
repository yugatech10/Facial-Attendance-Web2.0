<?php
//call this function to check if session exists or not
session_start();

//if session exists
if(isset ($_SESSION["username"])) //session userid gets value from text field named userid, shown in user.php
{	include "Header.php";?>
<!DOCTYPE html>
<html>
<body>
<div class="wrapper">
    <div class="middle">
        <div class="contentnew">
			<center><h1 class="header" style="width:40%">Select Student</h1></center>
			<h3 style="text-align:center;"></h3>
			<?php
			if(isset($_GET['cID'])){
			$class = $_GET['cID'];
			$lecturer = $_GET['LID'];
			$queryGet1 = "select * from class where cID = '$class'";	
			$resultGet1 = mysqli_query($link,$queryGet1);
			if(!$resultGet1)
			{	die ("Invalid Query - get Items List: ". mysqli_error($link));	}
			else{
				$row1= mysqli_fetch_array($resultGet1, MYSQLI_BOTH);
				$queryGet = "select * from users where type_user = 'Student'";	
				$resultGet = mysqli_query($link,$queryGet);
				if(!$resultGet)
				{
					die ("Invalid Query - get Items List: ". mysqli_error($link));
				}
				else
				{	$no=1;?>
			<h3 style="text-align:center;">For <?php echo $row1['name'];?></h3>
			<table id="table" align="center">
				<tr>
					<th>Choose</th>
					<th>Student ID</th>
					<th>Name</th>
					<th>Email</th>
				</tr>
				
				<form action="ClassStudent.php" name="EditForm" method="POST">
					<input type="hidden" name="lecturer" value="<?php echo $lecturer;?>">
					<input type="hidden" name="class" value="<?php echo $class;?>">
<?php
				while($row= mysqli_fetch_array($resultGet, MYSQLI_BOTH))
				{ 
?>
					<tr>
						<td><input type="checkbox" name="user[]" value="<?php echo $row{'username'};?>"></td>
						<td><?php echo $row['id'];?></td>
						<td><?php echo $row['name'];?></td>						 
						<td><?php echo $row['email'];?></td>
					</tr>
<?php
			$no++;}	}	}	}
?>
	</table>
	<br>
	<button style="float:right" type="submit" class="btn" name="classstudent">Choose</button>
	    </form>
    <br>
   </div>
   </div>
   </div>      
</body>
<?php
	if(isset($_POST['classstudent']))
	{
		$username = $_POST['user'];
		$LID = $_POST['lecturer'];
		$cID = $_POST['class'];
		for($i=0;$i<count($username);$i++){
			$query = "INSERT INTO student (id, sID, cID, LID) 
				  VALUES(NULL, '$username[$i]', '$cID', '$LID')";
			$resultInsert = mysqli_query($link, $query);
		}
		if (!$resultInsert)
		{
			die ("Error: ".mysqli_error($link));
		}		
		else {
			echo '<script type="text/javascript">
				window.onload = function () 
				{ 
				alert("Class been Registered...");
				open("Students.php","_top");
				}
				</script>';
		}	
		print_r($username);
		echo count($username);
	}
}
else{
    echo "No session exists or session has expired. Please log in again ";
	echo "Page will be redirect in 2 seconds";
	header('Refresh: 2; ../Auth/Login.php');
}	
?>
</html>

