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
	<h2> ADD Transaction DETAILS</h2>
	</div>
	</center>
	
	<div class="one row">
		
			<form action="<?=$_SERVER['PHP_SELF']?>" method="post">
				<div class="column">
					<p>
						<label for="sid">Transaction ID:</label><br>
						<input type="number" name="sid">
					</p>
					<p>
						<label for="item">Item ID:</label><br>
						<input type="number" name="item">
					</p>
					<p>
						<label for="sname">Transaction Type:</label><br>
						<input type="text" name="sname">
					</p>
					
					
					
				</div>
				<div class="column">
				<p>
						<label for="qty">Quantity:</label><br>
						<input type="number" name="qty">
					</p>
					
					<p>
						<label for="dt">Transaction date: </label><br>
						<input type="date" name="dt">
					</p>
					<label for="emp">Employee ID:</label><br>
						<input type="number" name="emp">
				</div>
				
			
			<input type="submit" name="add" value="Add Transaction">
			</form>
		<br>
		
		
	<?php
			include "config.php";
			 
			if(isset($_POST['add']))
			{
			$id = mysqli_real_escape_string($conn, $_REQUEST['sid']);
			$item = mysqli_real_escape_string($conn, $_REQUEST['item']);
			$sname = mysqli_real_escape_string($conn, $_REQUEST['sname']);
			$qty = mysqli_real_escape_string($conn, $_REQUEST['qty']);
			$dt = mysqli_real_escape_string($conn, $_REQUEST['dt']);
			$emp = mysqli_real_escape_string($conn, $_REQUEST['emp']);
			 
			$sql = "INSERT INTO transaction(Transaction_id,ItemID,Transaction_type,quantity,Transaction_date,E_ID) VALUES ($id, $item,'$sname',$qty,'$dt','$emp')";
			if(mysqli_query($conn, $sql)){
				echo "<p style='font-size:8;'>Transaction details successfully added!</p>";
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
	
	