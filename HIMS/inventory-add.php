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
						<label>Select Item By:</label><br>
						<input type="radio" name="select_method" value="id" onclick="toggleItemSelection('id')" checked> ID
						<input type="radio" name="select_method" value="name" onclick="toggleItemSelection('name')"> Name
					</p>
					<div id="id_input" style="display:block;">
						<p>
							<label for="item_id">Item ID:</label><br>
							<input type="number" name="item_id" id="item_id" onchange="updateItemName(this.value)">
						</p>
					</div>
					<div id="name_select" style="display:none;">
						<p>
							<label for="item">Select Item:</label><br>
							<select name="item" id="item_select" onchange="updateItemId(this.value)">
								<option value="">Select an Item</option>
								<?php
								include "config.php";
								$items_sql = "SELECT i.ItemID, i.ItemName, c.CategoryName 
											FROM item i 
											LEFT JOIN category c ON i.CategoryID = c.CategoryID 
											ORDER BY i.ItemName";
								$items_result = $conn->query($items_sql);
								while($item = $items_result->fetch_assoc()) {
									$category = $item['CategoryName'] ? " (" . $item['CategoryName'] . ")" : "";
									echo "<option value='".$item['ItemID']."'>".$item['ItemName'].$category."</option>";
								}
								?>
							</select>
						</p>
					</div>
					<p>
						<label>Selected Item Details:</label><br>
						<span id="selected_item_details">No item selected</span>
					</p>
					<p>
						<button type="button" onclick="showNewItemForm()">+ Add New Item</button>
					</p>
					<div id="new_item_form" style="display:none;">
						<h3>Add New Item</h3>
						<p>
							<label for="new_item_name">Item Name:</label><br>
							<input type="text" id="new_item_name" name="new_item_name">
						</p>
						<p>
							<label for="category">Category:</label><br>
							<select name="category" id="category_select">
								<option value="">Select Category</option>
								<?php
								$cat_sql = "SELECT CategoryID, CategoryName FROM category ORDER BY CategoryName";
								$cat_result = $conn->query($cat_sql);
								while($cat = $cat_result->fetch_assoc()) {
									echo "<option value='".$cat['CategoryID']."'>".$cat['CategoryName']."</option>";
								}
								?>
							</select>
							<button type="button" onclick="showNewCategoryForm()">+ New Category</button>
						</p>
						<div id="new_category_form" style="display:none;">
							<p>
								<label for="new_category">New Category Name:</label><br>
								<input type="text" id="new_category" name="new_category">
								<button type="button" onclick="addNewCategory()">Add</button>
							</p>
						</div>
						<button type="button" onclick="addNewItem()">Add Item</button>
					</div>
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
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
function toggleItemSelection(method) {
    if (method === 'id') {
        document.getElementById('id_input').style.display = 'block';
        document.getElementById('name_select').style.display = 'none';
    } else {
        document.getElementById('id_input').style.display = 'none';
        document.getElementById('name_select').style.display = 'block';
    }
}

function updateItemName(itemId) {
    if (!itemId) {
        document.getElementById('selected_item_details').innerHTML = 'No item selected';
        return;
    }
    
    $.ajax({
        url: 'get_item_details.php',
        type: 'POST',
        data: { item_id: itemId },
        success: function(response) {
            const item = JSON.parse(response);
            if (item) {
                document.getElementById('selected_item_details').innerHTML = 
                    `Name: ${item.ItemName}<br>Category: ${item.CategoryName || 'N/A'}`;
                document.getElementById('item_select').value = itemId;
            } else {
                document.getElementById('selected_item_details').innerHTML = 'Item not found';
            }
        }
    });
}

function updateItemId(itemId) {
    if (!itemId) {
        document.getElementById('selected_item_details').innerHTML = 'No item selected';
        return;
    }
    document.getElementById('item_id').value = itemId;
    updateItemName(itemId);
}

function showNewItemForm() {
    document.getElementById('new_item_form').style.display = 'block';
}

function showNewCategoryForm() {
    document.getElementById('new_category_form').style.display = 'block';
}

function addNewCategory() {
    const categoryName = document.getElementById('new_category').value;
    if (!categoryName) {
        alert('Please enter a category name');
        return;
    }

    $.ajax({
        url: 'add_category.php',
        type: 'POST',
        data: { category_name: categoryName },
        success: function(response) {
            const result = JSON.parse(response);
            if (result.success) {
                const select = document.getElementById('category_select');
                const option = new Option(categoryName, result.category_id);
                select.add(option);
                select.value = result.category_id;
                document.getElementById('new_category_form').style.display = 'none';
                document.getElementById('new_category').value = '';
            } else {
                alert('Error adding category: ' + result.message);
            }
        }
    });
}

function addNewItem() {
    const itemName = document.getElementById('new_item_name').value;
    const categoryId = document.getElementById('category_select').value;

    if (!itemName) {
        alert('Please enter an item name');
        return;
    }

    $.ajax({
        url: 'add_item.php',
        type: 'POST',
        data: { 
            item_name: itemName,
            category_id: categoryId
        },
        success: function(response) {
            const result = JSON.parse(response);
            if (result.success) {
                const select = document.getElementById('item_select');
                const option = new Option(itemName + (result.category_name ? ` (${result.category_name})` : ''), result.item_id);
                select.add(option);
                select.value = result.item_id;
                document.getElementById('new_item_form').style.display = 'none';
                document.getElementById('new_item_name').value = '';
                updateItemName(result.item_id);
            } else {
                alert('Error adding item: ' + result.message);
            }
        }
    });
}

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

