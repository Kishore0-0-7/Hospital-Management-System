<?php
	include 'common.php';
		include "config.php";
		$row;
		if(isset($_GET['id']))
		{
			$id=$_GET['id'];
			$qry1="SELECT * FROM item WHERE ItemID='$id'";
			$result = $conn->query($qry1);
			$row = $result -> fetch_row();
		}
            if(isset($_POST['update'])) {
                $id = $_POST['iid'];
                $name = $_POST['name'];
                $desc = $_POST['desc'];
                $cid = $_POST['cid'];
                $sid = $_POST['sid'];
                $meas = $_POST['meas'];
                $cost = $_POST['cost'];
                
                $sql="UPDATE item SET ItemName='$name', Description='$desc', CategoryID='$cid', SupplierID='$sid',UnitOfMeasure='$meas',CostPerUnit='$cost' WHERE ItemID='$id'";
                
                if ($conn->query($sql)) {
                    header("location:item-view.php"); 
                } else {
                    echo "<p style='font-size:8; color:red;'>Error! Unable to update.</p>";
                }
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
	<h2> UPDATE ITEM DETAILS</h2>
	</div>
	</center>
	<div class="one">
		<div class="row">
			<form action="<?=$_SERVER['PHP_SELF']?>" method="post">
			<div class="column">
                    <p>
                        <label for="iid">ItemID:</label><br>
                        <input type="number" name="iid" value="<?php echo $row[0]; ?>" readonly>
                    </p>
                    <p>
                        <label for="name">ItemName:</label><br>
                        <input type="text" name="name" value="<?php echo $row[1]; ?>">
                    </p>
                    <p>
                        <label for="desc">Description:</label><br>
                        <input type="text" name="desc" value="<?php echo $row[2]; ?>">
                    </p>
                </div>
                <div class="column">
                    <p>
                        <label for="cid">CategoryID:</label><br>
                        <input type="number" name="cid" value="<?php echo $row[3]; ?>">
                    </p>

                    <p>
                        <label for="sid">SupplierID:</label><br>
                        <input type="number" name="sid" value="<?php echo $row[4]; ?>">
                    </p>
                    <p>
                        <label for="meas">UnitOfMeasure: </label><br>
                        <input type="text" name="meas" value="<?php echo $row[5]; ?>">
                    </p>

                    <p>
                        <label for="cost">CostPerUnit: </label><br>
                        <input type="number" name="cost" value="<?php echo $row[6]; ?>">
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