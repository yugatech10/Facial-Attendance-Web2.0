<?php
session_start();
//if session exists
if(isset ($_SESSION["username"])) //call this function to check if session exists or not
{ include "Header.php";?>
<!DOCTYPE html>
<html>
<body>
	<h1 style="text-align:center;">All Product Detail</h1>
<?php

	$queryGet = "select * from products order by productID ";
	$resultGet = mysqli_query($link,$queryGet);

	if(!$resultGet)
	{
		die ("Invalid Query - get Items List: ". mysqli_error($link));
	}
	else
	{?>
		<table id="table" style="width: 80%; word-wrap: break-word; text-align:center;" align="center">
		<tr>
			<th>Product Name</th>
			<th>Quantity</th>
			<th>Description</th>
			<th>Price (RM)</th> 
			<th>Username</th>
			<th>Action</th>
		</tr>
<?php
		while($row= mysqli_fetch_array($resultGet, MYSQLI_BOTH))
		{?>
			<form action="Process.php" method="POST">
				<tr>
					<td><?php echo $row['name'];?></td>
					<td><?php echo $row['quantity'];?></td>
					<td><?php echo $row['description'];?></td>
					<td><?php echo $row['price'];?></td>
					<td><?php echo $row['username'];?></td>
					<td><a href="RetailEdit.php?id=<?php echo $row['productID'];?>">
						<img border="0" alt="editB" src="../CSS/btn/editB.png" width="25" height="25"></a>
						<a href="RetailDelete.php?id=<?php echo $row['productID'];?>" onclick="return confirm('Are you sure?')">
						<img border="0" alt="editB" src="../CSS/btn/delB.png" width="25" height="25"></a>
					</td>
				</tr>
	        </form>
			<?php
		}
	}
}
else{
    echo "No session exists or session has expired. Please log in again ";
	echo "Page will be redirect in 5 seconds";
	header('Refresh: 5; ../Auth/Login.php');
	
}

			
?>
</body>
</html>