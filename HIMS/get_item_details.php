<?php
include "config.php";

if (isset($_POST['item_id'])) {
    $item_id = mysqli_real_escape_string($conn, $_POST['item_id']);
    
    $sql = "SELECT i.*, c.CategoryName 
            FROM item i 
            LEFT JOIN category c ON i.CategoryID = c.CategoryID 
            WHERE i.ItemID = '$item_id'";
    
    $result = $conn->query($sql);
    
    if ($result && $result->num_rows > 0) {
        $item = $result->fetch_assoc();
        echo json_encode($item);
    } else {
        echo json_encode(null);
    }
}

$conn->close();
?> 