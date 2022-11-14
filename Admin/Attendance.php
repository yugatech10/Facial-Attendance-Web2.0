<?php
session_start();
//if session exists
if(isset ($_SESSION["username"])) //call this function to check if session exists or not
{
	include "Header.php";
	$user = $_SESSION['username'];
	?>
<!DOCTYPE html>
<html>
<head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<style>
  .output{display:none}
  .output2{display:none}
.row {
  display: -ms-flexbox; /* IE10 */
  display: flex;
  -ms-flex-wrap: wrap; /* IE10 */
  flex-wrap: wrap;
  margin: 0 0px;
}

.col-25 {
  -ms-flex: 25%; /* IE10 */
  flex: 30%;
}

.col-50 {
  -ms-flex: 50%; /* IE10 */
  flex: 50%;
}

.col-75 {
  -ms-flex: 75%; /* IE10 */
  flex: 70%;
}

.col-25,
.col-50,
.col-75 {
  padding: 0 16px;
}

.container {
  background-color: #f2f2f2;
  padding: 5px 20px 15px 20px;
  border: 1px solid lightgrey;
  border-radius: 3px;
}

input[type=date] {
  width: 100%;
  margin-bottom: 20px;
  padding: 12px;
  border: 1px solid #ccc;
  border-radius: 3px;
}
input[type=text] {
  width: 100%;
  margin-bottom: 20px;
  padding: 12px;
  border: 1px solid #ccc;
  border-radius: 3px;
}
select {
  width: 100%;
  margin-bottom: 20px;
  padding: 12px;
  border: 1px solid #ccc;
  border-radius: 3px;
}
label {
  margin-bottom: 10px;
  display: block;
}

.icon-container {
  margin-bottom: 20px;
  padding: 7px 0;
  font-size: 24px;
}

.btn {
  background-color: #4CAF50;
  color: white;
  padding: 12px;
  margin: 10px 0;
  border: none;
  width: 100%;
  border-radius: 3px;
  cursor: pointer;
  font-size: 17px;
}

.btn:hover {
  background-color: #45a049;
}
.btn_add{
    padding: 15px;
    font-size: 15px;
    background: #1D96D1;
    border-style: outset;
    border-radius: 10px;
    cursor: pointer;
  color: white;
  width: 15%;
	float: right;
}

.btn_add:hover {
  background-color: darkgrey;
}

span.price {
  float: right;
  color: grey;
}

/* Responsive layout - when the screen is less than 800px wide, make the two columns stack on top of each other instead of next to each other (and change the direction - make the "cart" column go on top) */
@media (max-width: 800px) {
  .row {
    flex-direction: column-reverse;
  }
  .col-25 {
    margin-bottom: 20px;
  }
}

.tooltip {
    position: relative;
    display: inline-block;
    border-bottom: 1px dotted black;
}

.tooltip .tooltiptext {
    visibility: hidden;
    width: 120px;
    color: #fff;
    text-align: center;
    border-radius: 6px;
    padding: 5px 0;
	top: -70px;
    left: 150px;
    /* Position the tooltip */
    position: absolute;
    z-index: 1;
}
.tooltip .tooltiptext img{
	width: 120px;
	height:120px;
}

.tooltip:hover .tooltiptext {
    visibility: visible;
}
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
	display: inline;  
    margin-bottom: 10px;
	text-align: left;
	margin: 3px;
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
.input-group2 select {
	display: inline;
	float: right;
	width: 50%;
	padding: 5px 10px;
	font-size: 16px;
	border-radius: 5px;
	border: 1px solid gray;
	margin-bottom: 0px;
}
input[type=text] {
	margin-bottom: 0px;
}
.content button{
	display: block;
	float: right;	
}
.txt-center {
	text-align: center;
	display: inline;
    left: 50%;
    position: absolute;
}
</style>
</head>

<body>
<?php
$queryGet = "select * from attendance ORDER BY date DESC";	
$resultGet = mysqli_query($link,$queryGet);
if(!$resultGet)
{	die ("Invalid Query - get Items List: ". mysqli_error($link));	}
else{	?>
	<center><h3>Attendance List</h3></center>
	<table id="table" border="1" align="center">
		<tr>
			<th>No</th>
			<th>Class</th>
			<th>Time</th>
			<th>Date</th>
			<th>Student</th>
		</tr>
<?php				if(mysqli_num_rows($resultGet)<=0){	?>
		<tr>
			<td colspan="4">No Student Registered</td>
		</tr><?php	}
		else{
			$no=1;
			while($row1= mysqli_fetch_array($resultGet, MYSQLI_BOTH))
			{	
				$queryGe1 = "select * from users where username = '".$row1['usrID']."'";	
				$resultGe1 = mysqli_query($link,$queryGe1);
				
				if(!$resultGe1)
				{	die ("Invalid Query - get Items List: ". mysqli_error($link));	}
				else{	
					$resultGet1 = mysqli_query($link,"select * from class where cID = '".$row1['cID']."'");
					$row= mysqli_fetch_array($resultGet1, MYSQLI_BOTH);
					
					while($ro1= mysqli_fetch_array($resultGe1, MYSQLI_BOTH)){
		?>
		<tr>
			<td><?php echo $no;?></td>
			<td><?php echo $row['name'];?></td>
			<td><?php echo $row1['time'];?></td>
			<td><?php echo $row1['date'];$no++;?></td>
			<td><?php echo $row1['usrID'];?></td>
		</tr><?php	}	}	}	}?>
	</table>
<?php	}?>
	<script>
		$("#class").on("change", function(){
		  var package = $(this).val();
		  $(".output").hide().prop("disabled", true)
		  $("#" + package).show().prop("disabled", false);
		});

	</script>
	<?php	
}
else{
    echo "No session exists or session has expired. Please log in again ";
	echo "Page will be redirect in 2 seconds";
	header('Refresh: 2; ../Auth/Login.php');
}	?>	 
</body>
</html>
