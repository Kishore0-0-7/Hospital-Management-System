<?php 
include 'common.php';
?>
<!DOCTYPE html>
<html>
<head>
<script src="dropdown.js"></script>
<link rel="stylesheet" type="text/css" href="nav2.css">
<link rel="stylesheet" type="text/css" href="form4.css">
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
	<h2> ADD CATEGORY DETAILS</h2>
	</div>
	</center>
	
	
	<br><br><br><br><br><br><br><br>
	
	
	<div class="one row">
		
			<form action="<?=$_SERVER['PHP_SELF']?>" method="post">
				<div class="column">
					<p>
						<label for="sid">Category ID:</label><br>
						<input type="number" name="sid">
					</p>
					<p>
						<label for="sname">Category Name:</label><br>
						<input type="text" name="sname">
					</p>
					<p>
						<label for="ssid">SupplierID:</label><br>
						<input type="number" name="ssid">
					</p>
				</div>
				<div class='column'>
					<p>
						<label for="stat">status:</label><br>
						<input type="text" name="stat">
					</p>
					<p>
						<label for="cd">Created Date:</label><br>
						<input type="date" name="cd">
					</p>
					<p>
					<input type="submit" name="add" value="Add Category">
					</p>
				</div>
			</form>
		<br>
	<?php
			include "config.php";
			 
			if(isset($_POST['add']))
			{
			$id = mysqli_real_escape_string($conn, $_REQUEST['sid']);
			$name = mysqli_real_escape_string($conn, $_REQUEST['sname']);
			$ssid = mysqli_real_escape_string($conn, $_REQUEST['ssid']);
			$stat = mysqli_real_escape_string($conn, $_REQUEST['stat']);
			$cd = mysqli_real_escape_string($conn, $_REQUEST['cd']);
			 
			$sql = "INSERT INTO category VALUES ($id, '$name',$ssid,'$stat','$cd')";
			if(mysqli_query($conn, $sql)){
				echo "<p style='font-size:8;'>Category details successfully added!</p>";
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