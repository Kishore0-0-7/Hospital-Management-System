<?php
		include "config.php";
		include 'common.php';
		if(isset($_GET['id']))
		{
			$id=$_GET['id'];
			$qry1="SELECT * FROM employees WHERE EMP_ID='$id'";
			$result = $conn->query($qry1);
			$row = $result -> fetch_row();
		}
?>
<?php
            if(isset($_POST['update'])) {
                $id = $_POST['eid'];
                $name = $_POST['ename'];
				$epos = $_POST['epos'];
				$ephone = $_POST['ephone'];
				$addr = $_POST['addr'];

				         
                $sql="UPDATE employees SET E_NAME='$name',E_POS='$epos',E_PHONE=$ephone,E_ADDRESS='$addr' WHERE EMP_ID='$id'";
                
                if ($conn->query($sql)) {
                    header("location:employees-view.php");
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
<title>
Suppliers
</title>
</head>

<body>
	<center>
	<div class="head">
	<h2> UPDATE EMPLOYEE DETAILS</h2>
	</div>
	</center>
	<div class="one">
		<div class="row">
			<form action="<?=$_SERVER['PHP_SELF']?>" method="post">
			<div class="column">
                    <p>
                        <label for="eid">Employee ID:</label><br>
                        <input type="number" name="eid" value="<?php echo $row[0]; ?>" readonly>
                    </p>
                    <p>
                        <label for="ename">Employee Name:</label><br>
                        <input type="text" name="ename" value="<?php echo $row[1]; ?>">
                    </p>
					<p>
                        <label for="epos">Employee Position:</label><br>
                        <input type="text" name="epos" value="<?php echo $row[2]; ?>">
                    </p>
					<p>
                        <label for="ephone">Phone no:</label><br>
                        <input type="number" name="ephone" value="<?php echo $row[4]; ?>">
                    </p>
					<p>
                        <label for="addr">Address:</label><br>
                        <input type="text" name="addr" value="<?php echo $row[3]; ?>">
                    </p>

					<p>
					<input type="submit" name="update" value="Update">
					</p>	
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
