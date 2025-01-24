<?php
include('func1.php');
$con = mysqli_connect("localhost","root","","myhmsdb");

if(isset($_POST['doctor']) && isset($_POST['date'])) {
    $doctor = mysqli_real_escape_string($con, $_POST['doctor']);
    $date = mysqli_real_escape_string($con, $_POST['date']);
    
    // Get all booked appointments for this doctor and date
    $query = "SELECT apptime FROM appointmenttb 
              WHERE doctor='$doctor' 
              AND appdate='$date' 
              AND userStatus=1 
              AND doctorStatus=1";
              
    $result = mysqli_query($con, $query);
    
    $booked_slots = array();
    if($result) {
        while($row = mysqli_fetch_assoc($result)) {
            $booked_slots[] = $row['apptime'];
        }
    }
    
    // Return JSON array of booked slots
    echo json_encode($booked_slots);
} else {
    echo json_encode(array());
}
?> 