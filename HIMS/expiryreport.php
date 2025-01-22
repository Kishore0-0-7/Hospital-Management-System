<?php 
include 'common.php';
?>
<!DOCTYPE html>
<html>
<head>
<script src="dropdown.js"></script>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
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
	<h2> EXPIRING WITHIN 6 MONTHS</h2>
	</div>
	</center>
	
	<table align="right" id="table1" style="margin-right:100px;">
		<tr>
			<th>Inventory ID</th>
			<th>Item Name</th>
			<th>Supplier Name</th>
			<th>Cost per unit</th>
			<th>Existing Stock</th>
			<th>Expiry Date</th>
		</tr>
		
	<?php
	
		include "config.php";
		$six_months_from_now = date('Y-m-d', strtotime('+6 months'));
$query = "SELECT 
inventory.InventoryID, 
item.ItemName, 
supplier.SupplierName, 
item.CostPerUnit, 
inventory.CurrentStock, 
inventory.ExpiryDate
FROM 
inventory 
JOIN 
item ON inventory.ItemID = item.ItemID
JOIN 
category ON item.CategoryID = category.CategoryID
JOIN 
supplier ON category.SupplierID = supplier.SupplierID
WHERE 
inventory.ExpiryDate <= DATE_ADD(CURDATE(), INTERVAL 6 MONTH)";
$result = mysqli_query($conn, $query);

	if ($result->num_rows > 0) { 
    	while($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["InventoryID"]. "</td>";
        echo "<td>" . $row["ItemName"]. "</td>";
        echo "<td>" . $row["SupplierName"]. "</td>";
        echo "<td>" . $row["CostPerUnit"]. "</td>";
        echo "<td>" . $row["CurrentStock"]. "</td>";
        echo "<td style='color:red;'>" . $row["ExpiryDate"]. "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "<tr><td colspan='9'>No items expiring within 6 months.</td></tr>";
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