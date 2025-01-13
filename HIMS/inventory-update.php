<?php
	include "config.php";
	include "common.php";
	if(isset($_GET['id']))
	{
		$id=$_GET['id'];
		$qry1="SELECT * FROM inventory WHERE InventoryID='$id'";
		$result = $conn->query($qry1);
		$row = $result -> fetch_row();
	}

    if(isset($_POST['item']) && isset($_POST['qty']) && isset($_POST['rl']) && isset($_POST['dt'])) {
        $id = $_POST['invid'];
        $item = $_POST['item'];
        $qty = $_POST['qty'];
        $rl = $_POST['rl'];
        $dt = $_POST['dt'];
             
        $sql = "UPDATE inventory SET itemID=$item, CurrentStock='$qty', ReorderLevel='$rl', ExpiryDate='$dt' WHERE InventoryID='$id'";
        if ($conn->query($sql)) {
            header("Location: inventory-view.php");
            exit();
        } else {
            echo "<p style='font-size:8;color:red;'>Error! Unable to update.</p>";
        }
    }

    if(isset($_GET['id'])) {
        $id = $_GET['id'];
        $qry1 = "SELECT * FROM inventory WHERE InventoryID='$id'";
        $result = $conn->query($qry1);
        $row = $result->fetch_row();
    }
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
	<center>
	<div class="head">
	<h2> UPDATE Inventory DETAILS</h2>
	</div>
	</center>

	<div class="one">
		<div class="row">
			<form action="<?=$_SERVER['PHP_SELF']?>" method="post">
				<div class="column">
				<p>
					<label for="invid">Inventory ID:</label><br>
					<input type="number" name="invid" value="<?php echo $row[0]; ?>" readonly>
				</p>
				<p>
					<label for="item">Item ID:</label><br>
					<input type="number" name="item" value="<?php echo $row[1]; ?>">
				</p>
				<p>
					<label for="qty">Current Stock:</label><br>
					<input type="number" name="qty" value="<?php echo $row[2]; ?>">
				</p>
				
				</div>
				
				<div class="column">
				<p>
					<label for="rl">Reorder Level:</label><br>
					<input type="number" name="rl" value="<?php echo $row[3]; ?>">
				</p>
				<p>
					<label for="dt">Expiry Date::</label><br>
					<input type="date" name="dt" value="<?php echo $row[4]; ?>">
				</p>
				</div>
		
				<input type="submit" name="update" value="Update">
				</form>		
				
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