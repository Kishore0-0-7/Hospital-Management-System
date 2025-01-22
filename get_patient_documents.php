<?php
session_start();
$con = mysqli_connect("localhost", "root", "", "myhmsdb");

if (!isset($_GET['pid'])) {
    echo "<p class='text-danger'>Invalid request.</p>";
    exit();
}

$pid = $_GET['pid'];
$doctor = isset($_SESSION['dname']) ? $_SESSION['dname'] : '';
$is_admin = isset($_GET['admin']) && $_GET['admin'] == '1';

// Verify access permissions
if (!$is_admin && $doctor) {
    $access_check = mysqli_query($con, "SELECT 1 FROM appointmenttb WHERE doctor='$doctor' AND pid='$pid' LIMIT 1");
    if (mysqli_num_rows($access_check) == 0) {
        echo "<p class='text-danger'>Access denied.</p>";
        exit();
    }
}

// Fetch patient documents
$docs_query = mysqli_query($con, "
    SELECT d.*, p.fname, p.lname 
    FROM documents d 
    JOIN patreg p ON d.pid = p.pid 
    WHERE d.pid='$pid' 
    ORDER BY d.upload_date DESC");

if (mysqli_num_rows($docs_query) == 0) {
    echo "<p class='text-muted'>No documents found for this patient.</p>";
    exit();
}

// Display documents table
echo "<h5 class='mb-3'>Patient Documents</h5>
<div class='table-responsive'>
    <table class='table table-hover'>
        <thead>
            <tr>
                <th>Patient Name</th>
                <th>Document Name</th>
                <th>Type</th>
                <th>Uploaded By</th>
                <th>Upload Date</th>
                <th>Description</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>";

while($doc = mysqli_fetch_array($docs_query)) {
    $doc_type = explode('/', $doc['document_type'])[1];
    echo "<tr>
        <td>{$doc['fname']} {$doc['lname']}</td>
        <td>{$doc['document_name']}</td>
        <td>{$doc_type}</td>
        <td>{$doc['uploaded_by']}</td>
        <td>" . date('Y-m-d H:i', strtotime($doc['upload_date'])) . "</td>
        <td>{$doc['description']}</td>
        <td>
            <a href='document_handler.php?download={$doc['id']}' class='btn btn-sm btn-info'>Download</a>
            " . ($is_admin || ($doc['uploaded_by'] == 'doctor' && $doc['doctor_id'] == $doctor) ? 
            "<a href='document_handler.php?delete={$doc['id']}' class='btn btn-sm btn-danger' onclick='return confirm(\"Are you sure you want to delete this document?\")'>Delete</a>" 
            : "") . "
        </td>
    </tr>";
}

echo "</tbody></table></div>";
?> 