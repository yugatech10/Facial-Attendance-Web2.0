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
	if(isset($_GET['id'])){
		$cID = $_GET['id'];
	
	
	$queryGet = "select * from class where cID='".$cID."'";

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
			<form class = "content" style="position: relative; width: 60%; margin:auto;left:0" action="Edit.php" name="EditForm" method="POST">
				<h1 class="header">Class Update</h1>
				<?php	while($baris= mysqli_fetch_array($resultGet, MYSQLI_BOTH))	{?>
					<div class="input-group">
						<label>Class Name</label>
						<input type="text" name="name" value="<?php echo $baris['name']; ?>"><br><br>
						<input type="hidden" name="id" value="<?php echo $baris['cID']; ?>">
						<input type="hidden" name="from" value="Lecturer">
						<label>Total Students</label>
						<input type="text" name="student" value="<?php echo $baris['student'] ?>"><br><br>
						<label>Time Slot 1</label>
						<input type="time" name="time1" value="<?php echo $baris['timeSlot'] ?>"><br><br>
						<label>Time Slot 2</label>
						<input type="time" name="time2" value="<?php echo $baris['timeSlot2'] ?>"><br><br>
						<button style="position: relative;left: 80%"; type="submit" class="btn" name="classEdit">Update</button>
					</div> <?php	}?>
			</form>
			</div>
		</div>
	</div>
	
<?php 
	}	
	}
	if(isset($_POST["classEdit"])){
		$student = $_POST['student'];
		$name = $_POST['name'];
		$id = $_POST['id'];
		$time1 = $_POST['time1'];
		$time2 = $_POST['time2'];
		
		$queryInsert = "UPDATE class SET
					name = '".$name."', 
					student = '".$student."',
					timeSlot = '".$time1."',
					timeSlot2 = '".$time2."'
					WHERE cID = '$id'";
		$resultInsert = mysqli_query($link,$queryInsert);
		if (!$resultInsert)
		{
			die ("Error: ".mysqli_error($link));
		}		
		else {
			echo '<script type="text/javascript">
					window.onload = function () 
					{ 
					alert("Class been Updated...");
					open("Class.php","_top");
					}
					</script>';
		}	
	}
	}
else{
    echo "No session exists or session has expired. Please log in again ";
	echo "Page will be redirect in 2 seconds";
	header('Refresh: 2; ../Admin/Login.php');
}				
?>
 
	 
</body>
</html>
