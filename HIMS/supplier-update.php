<?php
		include 'common.php';
		include "config.php";
	
		if(isset($_GET['id']))
		{
			$id=$_GET['id'];
			$qry1="SELECT * FROM supplier WHERE SupplierId='$id'";
			$result = $conn->query($qry1);
			$row = $result -> fetch_row();
		}
            if(isset($_POST['update'])) {
                $id = $_POST['sid'];
                $name = $_POST['sname'];
                $add = $_POST['sadd'];
                $payment = $_POST['spayment'];
                $email = $_POST['semail'];
                $sql="UPDATE supplier SET SupplierName='$name', Address='$add', PaymentTerms='$payment', ContactInformation='$email' WHERE SupplierID='$id'";
                if ($conn->query($sql)) {
                    header("location:supplier-view.php");
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
	<h2> UPDATE SUPPLIER DETAILS</h2>
	</div>
	</center>


	<div class="one">
		<div class="row">
			<form action="<?=$_SERVER['PHP_SELF']?>" method="post">
			<div class="column">
                    <p>
                        <label for="sid">Supplier ID:</label><br>
                        <input type="number" name="sid" value="<?php echo $row[0]; ?>" readonly>
                    </p>
                    <p>
                        <label for="sname">Supplier Name:</label><br>
                        <input type="text" name="sname" value="<?php echo $row[1]; ?>">
                    </p>
                    <p>
                        <label for="sadd">Email Address:</label><br>
                        <input type="text" name="semail" value="<?php echo $row[2]; ?>">
                    </p>
        </div>
        <div class="column">
                    <p>
                        <label for="spayment">Address:</label><br>
                        <input type="text" name="sadd" value="<?php echo $row[3]; ?>">
                    </p>
                    <p>
                        <label for="semail">Payment Terms: </label><br>
                        <input type="text" name="spayment" value="<?php echo $row[4]; ?>">
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