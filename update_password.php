<?php
require_once('connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pid = $_POST['pid'] ?? '';
    $password = $_POST['password'] ?? '';

    if (!$pid || !$password) {
        http_response_code(400);
        echo 'Missing required parameters';
        exit;
    }

    // Update password in patreg table
    $query = "UPDATE patreg SET password = ? WHERE pid = ?";
    $stmt = mysqli_prepare($con, $query);
    mysqli_stmt_bind_param($stmt, 'si', $password, $pid);
    
    if (mysqli_stmt_execute($stmt)) {
        echo 'Password updated successfully';
    } else {
        http_response_code(500);
        echo 'Error updating password';
    }
} else {
    http_response_code(405);
    echo 'Method not allowed';
}
?> 