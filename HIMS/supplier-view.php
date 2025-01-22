<?php 
include 'common.php';
?>
<!DOCTYPE html>
<html>
<head>
<script src="dropdown.js"></script>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" type="text/css" href="table1.css">
<link rel="stylesheet" type="text/css" href="nav2.css">
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
	<h2> SUPPLIERS LIST</h2>
	</div>
	</center>
	
	<table align="right" id="table1" style="margin-right:100px;">
		<tr>
			<th>Supplier ID</th>
			<th>Supplier Name</th>
			<th>Email Address</th>
			<th>Address</th>
			<th>Payment Terms</th>
			<th>Action</th>
</tr>
	<?php
	include "config.php";
	$sql = "SELECT SupplierID,SupplierName,ContactInformation,Address,PaymentTerms FROM supplier";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
	while($row = $result->fetch_assoc()) {
	echo "<tr>";
		echo "<td>" . $row["SupplierID"]. "</td>";
		echo "<td>" . $row["SupplierName"] . "</td>";
		echo "<td>" . $row["ContactInformation"]. "</td>";
		echo "<td>" . $row["Address"]. "</td>";
		echo "<td>" . $row["PaymentTerms"]. "</td>";
		echo "<td align=center>";
		echo "<a class='button1 edit-btn' href=supplier-update.php?id=".$row['SupplierID'].">Edit</a>";
		echo "<a class='button1 del-btn' href=supplier-delete.php?id=".$row['SupplierID'].">Delete</a>";
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