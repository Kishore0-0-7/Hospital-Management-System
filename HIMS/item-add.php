<?php 
include 'common.php';
?>
<!DOCTYPE html>
<html>
<head>
<script src="dropdown.js"></script>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
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
	<h2> ADD ITEM DETAILS</h2>
	</div>
	</center>
	<br><br><br><br><br><br><br><br>
	<div class="one">
		<div class="row">
			<form action="<?=$_SERVER['PHP_SELF']?>" method="post">
				<div class="column">
					<p>
						<label for="iid">Item ID:</label><br>
						<input type="number" name="iid">
					</p>
					<p>
						<label for="name">Item Name</label><br>
						<input type="text" name="name">
					</p>

					<p>
						<label for="desc">Description:</label><br>
						<input type="text" name="desc">
					</p>
					<p>
						<label for="cid">CategoryID:</label><br>
						<input type="number" name="cid">
					</p>
				</div>
				<div class="column">
					<p>
						<label for="sid">SupplierID:</label><br>
						<input type="number" name="sid">
					</p>
				<p>
						<label for="meas">UnitOfMeasure:</label><br>
						<input type="text" name="meas">
					</p>

					<p>
						<label for="cost">CostPerUnit:</label><br>
						<input type="number" name="cost">
					</p>
				</div>
			<input type="submit" name="add" value="Add Item">
			</form>
		<br>
			<?php
			include "config.php";
			if(isset($_POST['add']))
			{
			$iid = mysqli_real_escape_string($conn, $_REQUEST['iid']);
			$name = mysqli_real_escape_string($conn, $_REQUEST['name']);
			$desc = mysqli_real_escape_string($conn, $_REQUEST['desc']);
			$cid = mysqli_real_escape_string($conn, $_REQUEST['cid']);
			$sid = mysqli_real_escape_string($conn, $_REQUEST['sid']);
			$meas = mysqli_real_escape_string($conn, $_REQUEST['meas']);
			$cost = mysqli_real_escape_string($conn, $_REQUEST['cost']);
			$sql = "INSERT INTO item VALUES ($iid, '$name', '$desc',$cid,$sid,'$meas', $cost)";
			if(mysqli_query($conn, $sql)){
				echo "<p style='font-size:8;'>Item successfully added!</p>";
			} else{
				echo "<p style='font-size:8; color:red;'>Error! Check details.</p>";
			}
			}
			$conn->close();
			?>
		</div>
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