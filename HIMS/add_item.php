<?php
include "config.php";

header('Content-Type: application/json');

if (isset($_POST['item_name'])) {
    $item_name = mysqli_real_escape_string($conn, $_POST['item_name']);
    $category_id = isset($_POST['category_id']) ? mysqli_real_escape_string($conn, $_POST['category_id']) : 'NULL';
    
    // Check if item already exists
    $check_sql = "SELECT ItemID FROM item WHERE ItemName = '$item_name'";
    $check_result = $conn->query($check_sql);
    
    if ($check_result && $check_result->num_rows > 0) {
        echo json_encode([
            'success' => false,
            'message' => 'Item already exists'
        ]);
        exit;
    }
    
    // Get next ItemID
    $id_sql = "SELECT MAX(ItemID) as max_id FROM item";
    $id_result = $conn->query($id_sql);
    $row = $id_result->fetch_assoc();
    $next_id = $row['max_id'] ? $row['max_id'] + 1 : 1;
    
    // Get category name if category_id is provided
    $category_name = '';
    if ($category_id != 'NULL') {
        $cat_sql = "SELECT CategoryName FROM category WHERE CategoryID = $category_id";
        $cat_result = $conn->query($cat_sql);
        if ($cat_result && $cat_result->num_rows > 0) {
            $cat_row = $cat_result->fetch_assoc();
            $category_name = $cat_row['CategoryName'];
        }
    }
    
    // Insert new item
    $sql = "INSERT INTO item (ItemID, ItemName, CategoryID) VALUES ($next_id, '$item_name', $category_id)";
    
    if ($conn->query($sql)) {
        echo json_encode([
            'success' => true,
            'item_id' => $next_id,
            'category_name' => $category_name,
            'message' => 'Item added successfully'
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Error adding item: ' . $conn->error
        ]);
    }
}

$conn->close();
?> 