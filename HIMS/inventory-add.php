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
	<h2> ADD to Inventory</h2>
	</div>
	</center>
	
	
	<br><br><br><br><br><br><br><br>
	
	
	<div class="one">
		<div class="row">
			<form action="<?=$_SERVER['PHP_SELF']?>" method="post">
				<div class="column">
					<p>
						<label for="invid">Inventory ID:</label><br>
						<input type="number" name="invid">
					</p>
					<p>
						<label for="item">Item Id:</label><br>
						<input type="number" name="item">
					</p>
					<p>
						<label for="qty">Current Stock:</label><br>
						<input type="number" name="qty">
					</p>
					
				</div>
				<div class="column">
					
					<p>
						<label for="rl">Reorder Level:</label><br>
						<input type="text" name="rl">
					</p>
					<p>
					<label for="dt">Expiry Date::</label><br>
					<input type="date" name="dt" value="<?php echo $row[3]; ?>">
				</p>
				</div>
				
			
			<input type="submit" name="add" value="Add to Inventory">
			</form>
		<br>
		
		
	<?php
	
		include "config.php";
		 
		if(isset($_POST['add']))
		{
		$id = mysqli_real_escape_string($conn, $_REQUEST['invid']);
		$item = mysqli_real_escape_string($conn, $_REQUEST['item']);
		$qty = mysqli_real_escape_string($conn, $_REQUEST['qty']);
		$rl = mysqli_real_escape_string($conn, $_REQUEST['rl']);
		$dt = mysqli_real_escape_string($conn, $_REQUEST['dt']);
		  
		 
		$sql = "INSERT INTO inventory VALUES ($id, '$item', $qty,'$rl','$dt')";
		if(mysqli_query($conn, $sql)){
			echo "<p style='font-size:8;'>Inventory details successfully added!</p>";
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

