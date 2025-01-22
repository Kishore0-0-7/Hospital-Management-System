<?php
include('func1.php');
$con = mysqli_connect("localhost","root","","myhmsdb");

if(isset($_POST['doctor']) && isset($_POST['date'])) {
    $doctor = $_POST['doctor'];
    $date = $_POST['date'];
    
    // Get day of week (0 = Sunday, 6 = Saturday)
    $day_of_week = date('w', strtotime($date));
    
    // Get doctor's schedule for this day
    $schedule_query = mysqli_query($con, "SELECT * FROM doctor_schedule 
                                        WHERE doctor='$doctor' 
                                        AND day_of_week='$day_of_week' 
                                        AND is_available=1");
    
    if($schedule = mysqli_fetch_assoc($schedule_query)) {
        $start_time = strtotime($schedule['start_time']);
        $end_time = strtotime($schedule['end_time']);
        $slot_duration = $schedule['slot_duration'] * 60; // Convert minutes to seconds
        
        // Get existing appointments
        $appointments_query = mysqli_query($con, "SELECT apptime 
                                                FROM appointmenttb 
                                                WHERE doctor='$doctor' 
                                                AND appdate='$date'
                                                AND userStatus=1 
                                                AND doctorStatus=1");
        
        $booked_slots = array();
        while($appointment = mysqli_fetch_assoc($appointments_query)) {
            $booked_slots[] = $appointment['apptime'];
        }
        
        // Generate time slots
        echo '<option value="" disabled selected>Select Time</option>';
        
        // Only show future time slots for today
        $min_time = ($date == date('Y-m-d')) ? time() : $start_time;
        
        for($time = $start_time; $time < $end_time; $time += $slot_duration) {
            $slot_time = date('H:i:s', $time);
            $display_time = date('h:i A', $time);
            
            // Skip past time slots for today
            if($date == date('Y-m-d') && $time < $min_time) {
                continue;
            }
            
            if(!in_array($slot_time, $booked_slots)) {
                echo "<option value='$slot_time'>$display_time</option>";
            }
        }
    } else {
        echo '<option value="" disabled selected>Doctor not available on this day</option>';
    }
} else {
    echo '<option value="" disabled selected>Select a doctor and date first</option>';
}
?> 