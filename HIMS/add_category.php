<?php
include "config.php";

header('Content-Type: application/json');

if (isset($_POST['category_name'])) {
    $category_name = mysqli_real_escape_string($conn, $_POST['category_name']);
    
    // Check if category already exists
    $check_sql = "SELECT CategoryID FROM category WHERE CategoryName = '$category_name'";
    $check_result = $conn->query($check_sql);
    
    if ($check_result && $check_result->num_rows > 0) {
        echo json_encode([
            'success' => false,
            'message' => 'Category already exists'
        ]);
        exit;
    }
    
    // Get next CategoryID
    $id_sql = "SELECT MAX(CategoryID) as max_id FROM category";
    $id_result = $conn->query($id_sql);
    $row = $id_result->fetch_assoc();
    $next_id = $row['max_id'] ? $row['max_id'] + 1 : 1;
    
    // Insert new category
    $sql = "INSERT INTO category (CategoryID, CategoryName) VALUES ($next_id, '$category_name')";
    
    if ($conn->query($sql)) {
        echo json_encode([
            'success' => true,
            'category_id' => $next_id,
            'message' => 'Category added successfully'
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Error adding category: ' . $conn->error
        ]);
    }
}

$conn->close();
?> 