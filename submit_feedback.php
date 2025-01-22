<?php
session_start();
include('func1.php');
$con = mysqli_connect("localhost", "root", "", "myhmsdb");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $patient_id = $_POST['patient_id'];
    $doctor_id = $_POST['doctor_id'];
    $appointment_id = $_POST['appointment_id'];
    $rating = $_POST['rating'];
    $comments = mysqli_real_escape_string($con, $_POST['comments']);
    $anonymous = isset($_POST['anonymous']) ? 1 : 0;

    $query = "INSERT INTO feedback (patient_id, doctor_id, appointment_id, rating, comments, anonymous) 
              VALUES ('$patient_id', '$doctor_id', '$appointment_id', '$rating', '$comments', '$anonymous')";

    if (mysqli_query($con, $query)) {
        $_SESSION['feedback_success'] = "Thank you for your feedback!";
    } else {
        $_SESSION['feedback_error'] = "Error submitting feedback. Please try again.";
    }
}

header("Location: " . $_SERVER['HTTP_REFERER']);
exit();
?> 