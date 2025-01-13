<?php 
include 'common.php';
?>
<!DOCTYPE html>
<html>
<head>
<script src="dropdown.js"></script>
<link rel="stylesheet" type="text/css" href="nav2.css">
<link rel="stylesheet" type="text/css" href="table1.css">
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
	<h2> ITEM LIST</h2>
	</div>
	</center>
	<table align="right" id="table1" style="margin-right:100px;">
		<tr>
			<th>Item ID</th>
			<th>Item Name</th>
			<th>Description</th>
			<th>CategoryID</th>
			<th>SupplierID</th>
			<th>UnitOfMeasure</th>
			<th>CostPerUnit</th>
			<th>Action</th>
			
		</tr>
	<?php
	include "config.php";
	$sql = "SELECT ItemID,ItemName,Description,CategoryID,SupplierID,UnitOfMeasure,CostPerUnit FROM item";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
		echo "<tr>";
			echo "<td>" . $row["ItemID"]. "</td>";
			echo "<td>" . $row["ItemName"] . "</td>";
			echo "<td>" . $row["Description"]. "</td>";
			echo "<td>" . $row["CategoryID"]. "</td>";
			echo "<td>" . $row["SupplierID"] . "</td>";
			echo "<td>" . $row["UnitOfMeasure"]. "</td>";
			echo "<td>" . $row["CostPerUnit"]. "</td>";
			echo "<td align=center>";
				echo "<a class='button1 edit-btn' href=item-update.php?id=".$row['ItemID'].">Edit</a>";
				echo "<a class='button1 del-btn' href=item-delete.php?id=".$row['ItemID'].">Delete</a>";
			echo "</td>";
		echo "</tr>";
		}
	echo "</table>";
	} 
	$conn->close();
	?>
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