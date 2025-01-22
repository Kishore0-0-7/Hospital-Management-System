<?php
		include "config.php";
		include 'common.php';

		if(isset($_GET['id']))
		{
			$id=$_GET['id'];
			$qry1="SELECT * FROM transaction WHERE Transaction_id='$id'";
			$result = $conn->query($qry1);
			$row = $result -> fetch_row();
		}
		if(isset($_POST['update'])) {
			$id = $_POST['sid'];
			$item = $_POST['item'];
			$sname = $_POST['sname'];
			$qty = $_POST['qty'];
			$dt = $_POST['dt'];
			$emp = $_POST['emp'];
			$sql="UPDATE transaction SET itemID='$item', Transaction_Type='$sname', quantity='$qty', Transaction_Date='$dt',E_ID='$emp' WHERE Transaction_id='$id'";
			if ($conn->query($sql)) {
				header("location:transaction-view.php");
			} else {
				echo "<p style='font-size:8; color:red;'>Error! Unable to update.</p>";
			}
		}
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

		
	<center>
	<div class="head">
	<h2> UPDATE TRANSACTION DETAILS</h2>
	</div>
	</center>

	<div class="one">
		<div class="row">
			<form action="<?=$_SERVER['PHP_SELF']?>" method="post">
			<div class="column">
			<p>
                        <label for="sid">Transaction ID:</label><br>
                        <input type="number" name="sid" value="<?php echo $row[0]; ?>" readonly>
                    </p>
                    <p>
                        <label for="item">Item ID:</label><br>
                        <input type="number" name="item" value="<?php echo $row[1]; ?>">
                    </p>
                    <p>
                        <label for="sname">Transaction Type:</label><br>
                        <input type="text" name="sname" value="<?php echo $row[2]; ?>">
                    </p>
	</div>
	<div class="column">
                    <p>
                        <label for="qty">Quantity:</label><br>
                        <input type="text" name="qty" value="<?php echo $row[3]; ?>">
                    </p>
                    <p>
                        <label for="dt">Transaction date: </label><br>
                        <input type="date" name="dt" value="<?php echo $row[4]; ?>">
                    </p>
					<p>
                        <label for="emp">Employee ID: </label><br>
                        <input type="text" name="emp" value="<?php echo $row[5]; ?>">
                    </p>
					<p>
					<input type="submit" name="update" value="Update"></p>
				</div>
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