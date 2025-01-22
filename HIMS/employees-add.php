<?php 
include 'common.php';
?>
<!DOCTYPE html>
<html>
<head>
<script src="dropdown.js"></script>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" type="text/css" href="nav2.css">
<link rel="stylesheet" type="text/css" href="form4.css">
<title>
Suppliers
</title>
</head>

<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary fixed-top">
        <a class="navbar-brand" href="#"><i class="fa fa-user-plus"></i>The Care Crew Hospital Inventory </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto" style="margin-inline: 1000px;">
                <li class="nav-item">
                    <a class="nav-link" href="../admin-panel1.php" style="color: rgb(255, 255, 255);"><i class="fa fa-sign-out"></i> Back to Admin</a>
                </li>
            </ul>
        </div>
    </nav>
	<center>
	<div class="head">
	<h2> ADD EMPLOYEE DETAILS</h2>
	</div>
	</center>
	
	<div class="one row">
		
			<form action="<?=$_SERVER['PHP_SELF']?>" method="post">
				<div class="column">
					<p>
						<label for="eid">Employee ID:</label><br>
						<input type="number" name="eid">
					</p>
					<p>
						<label for="ename">Employee Name:</label><br>
						<input type="text" name="ename">
					</p>
					<p>
						<label for="epos">Employee Position:</label><br>
						<input type="text" name="epos">
					</p>
					
					
				</div>
				<div class="column">
					
					<p>
						<label for="ephone">Phone No: </label><br>
						<input type="text" name="ephone">
					</p>
					<label for="addr">Address:</label><br>
						<input type="text" name="addr">
				</div>
				
			
			<input type="submit" name="add" value="Add Employee">
			</form>
		<br>
		
		
	<?php
			include "config.php";
			 
			if(isset($_POST['add']))
			{
			$eid = mysqli_real_escape_string($conn, $_REQUEST['eid']);
			$ename = mysqli_real_escape_string($conn, $_REQUEST['ename']);
			$epos = mysqli_real_escape_string($conn, $_REQUEST['epos']);
			$ephone = mysqli_real_escape_string($conn, $_REQUEST['ephone']);
			$addr = mysqli_real_escape_string($conn, $_REQUEST['addr']);

			 
			$sql = "INSERT INTO employees VALUES ($eid, '$ename','$epos','$addr',$ephone)";
			if(mysqli_query($conn, $sql)){
				echo "<p style='font-size:8;'>Employee details successfully added!</p>";
			} else{
				echo "<p style='font-size:8; color:red;'>Error! Check details.</p>";
			}
			}
			 
			$conn->close();
	?>
	
	</div>		
</body>
</html>
<script>
var dropdown = document.getElementsByClassName("dropdown-btn");
for (var i = 0; i < dropdown.length; i++) {
  dropdown[i].addEventListener("click", function() {
    this.classList.toggle("active");
    var dropdownContent = this.nextElementSibling;
    if (dropdownContent.style.display === "block") {
      dropdownContent.style.display = "none";
    } else {
      dropdownContent.style.display = "block";
    }
  });
}
</script>
