<?php
session_start();
$con = mysqli_connect("localhost", "root", "", "myhmsdb");

// Create uploads directory if it doesn't exist
$upload_dir = "uploads/";
if (!file_exists($upload_dir)) {
    mkdir($upload_dir, 0777, true);
}

// Handle file upload
if (isset($_POST['upload_document'])) {
    $pid = $_POST['pid'];
    $doctor_id = isset($_POST['doctor_id']) ? $_POST['doctor_id'] : null;
    $description = $_POST['description'];
    $uploaded_by = $_POST['uploaded_by'];
    
    $file = $_FILES['document'];
    $file_name = $file['name'];
    $file_tmp = $file['tmp_name'];
    $file_type = $file['type'];
    
    // Generate unique filename
    $unique_name = uniqid() . '_' . $file_name;
    $file_path = $upload_dir . $unique_name;
    
    // Check file type
    $allowed_types = array('application/pdf', 'image/jpeg', 'image/png', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document');
    if (!in_array($file_type, $allowed_types)) {
        echo "<script>alert('Invalid file type. Only PDF, JPEG, PNG, and DOC files are allowed.');</script>";
        exit();
    }

    if ($uploaded_by === 'admin') {
        // Additional logging for admin uploads
        $admin_log_query = "INSERT INTO admin_logs (action, description, performed_by) 
                           VALUES ('document_upload', ?, 'admin')";
        $log_stmt = mysqli_prepare($con, $admin_log_query);
        mysqli_stmt_bind_param($log_stmt, "s", "Uploaded document: $file_name for patient ID: $pid");
        mysqli_stmt_execute($log_stmt);
    }
    
    // Move uploaded file
    if (move_uploaded_file($file_tmp, $file_path)) {
        $query = "INSERT INTO documents (pid, doctor_id, document_name, document_type, file_path, uploaded_by, description) 
                 VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($con, $query);
        mysqli_stmt_bind_param($stmt, "issssss", $pid, $doctor_id, $file_name, $file_type, $file_path, $uploaded_by, $description);
        
        if (mysqli_stmt_execute($stmt)) {
            echo "<script>alert('Document uploaded successfully!'); window.history.back();</script>";
        } else {
            echo "<script>alert('Error uploading document.'); window.history.back();</script>";
        }
    } else {
        echo "<script>alert('Error moving uploaded file.'); window.history.back();</script>";
    }
}

// Handle file download
if (isset($_GET['download'])) {
    $document_id = $_GET['download'];
    
    $query = "SELECT * FROM documents WHERE id = ?";
    $stmt = mysqli_prepare($con, $query);
    mysqli_stmt_bind_param($stmt, "i", $document_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    if ($document = mysqli_fetch_assoc($result)) {
        $file_path = $document['file_path'];
        
        if (file_exists($file_path)) {
            header('Content-Type: ' . $document['document_type']);
            header('Content-Disposition: attachment; filename="' . $document['document_name'] . '"');
            readfile($file_path);
            exit();
        } else {
            echo "<script>alert('File not found.'); window.history.back();</script>";
        }
    } else {
        echo "<script>alert('Document not found.'); window.history.back();</script>";
    }
}

// Handle file deletion
if (isset($_GET['delete'])) {
    $document_id = $_GET['delete'];
    
    $query = "SELECT file_path FROM documents WHERE id = ?";
    $stmt = mysqli_prepare($con, $query);
    mysqli_stmt_bind_param($stmt, "i", $document_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    if ($document = mysqli_fetch_assoc($result)) {
        $file_path = $document['file_path'];
        
        // Delete file from filesystem
        if (file_exists($file_path)) {
            unlink($file_path);
        }
        
        // Delete record from database
        $delete_query = "DELETE FROM documents WHERE id = ?";
        $stmt = mysqli_prepare($con, $delete_query);
        mysqli_stmt_bind_param($stmt, "i", $document_id);
        
        if (mysqli_stmt_execute($stmt)) {
            echo "<script>alert('Document deleted successfully!'); window.history.back();</script>";
        } else {
            echo "<script>alert('Error deleting document.'); window.history.back();</script>";
        }
    }
}
?>