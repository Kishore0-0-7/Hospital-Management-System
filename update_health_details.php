<?php
session_start();
$con=mysqli_connect("localhost","root","","myhmsdb");

if(isset($_POST['update_health_details'])) {
    $pid = $_SESSION['pid'];
    $age = mysqli_real_escape_string($con, $_POST['age']);
    $blood_group = mysqli_real_escape_string($con, $_POST['blood_group']);
    $weight = mysqli_real_escape_string($con, $_POST['weight']);
    $height = mysqli_real_escape_string($con, $_POST['height']);
    $medical_conditions = mysqli_real_escape_string($con, $_POST['medical_conditions']);
    $allergies = mysqli_real_escape_string($con, $_POST['allergies']);
    $current_medications = mysqli_real_escape_string($con, $_POST['current_medications']);
    $family_history = mysqli_real_escape_string($con, $_POST['family_history']);
    $emergency_contact = mysqli_real_escape_string($con, $_POST['emergency_contact']);
    $emergency_contact_phone = mysqli_real_escape_string($con, $_POST['emergency_contact_phone']);

    // Check if record exists
    $check_query = "SELECT pid FROM patient_health_details WHERE pid = '$pid'";
    $check_result = mysqli_query($con, $check_query);

    if(mysqli_num_rows($check_result) > 0) {
        // Update existing record
        $query = "UPDATE patient_health_details SET 
            age='$age',
            blood_group='$blood_group',
            weight='$weight',
            height='$height',
            medical_conditions='$medical_conditions',
            allergies='$allergies',
            current_medications='$current_medications',
            family_history='$family_history',
            emergency_contact='$emergency_contact',
            emergency_contact_phone='$emergency_contact_phone'
            WHERE pid='$pid'";
    } else {
        // Insert new record
        $query = "INSERT INTO patient_health_details 
            (pid, age, blood_group, weight, height, medical_conditions, allergies, 
             current_medications, family_history, emergency_contact, emergency_contact_phone)
            VALUES 
            ('$pid', '$age', '$blood_group', '$weight', '$height', '$medical_conditions', 
             '$allergies', '$current_medications', '$family_history', '$emergency_contact', 
             '$emergency_contact_phone')";
    }

    $result = mysqli_query($con, $query);
    if($result) {
        echo "<script>alert('Health details updated successfully!');
        window.location.href = 'admin-panel.php';</script>";
    } else {
        echo "<script>alert('Error updating health details: " . mysqli_error($con) . "');
        window.location.href = 'admin-panel.php';</script>";
    }
}
?>
