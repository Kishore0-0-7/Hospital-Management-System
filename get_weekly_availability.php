<?php
include('func1.php');
$con = mysqli_connect("localhost","root","","myhmsdb");

if(isset($_POST['doctor']) && isset($_POST['week'])) {
    $doctor = $_POST['doctor'];
    $week = $_POST['week'];
    
    // Parse year and week number
    list($year, $week_num) = explode('-W', $week);
    
    // Get the date of Monday for this week
    $monday = new DateTime();
    $monday->setISODate($year, $week_num);
    
    // Generate time slots from 8 AM to 8 PM
    $start_hour = 8;
    $end_hour = 20;
    $slot_duration = 30; // minutes
    
    // First get all schedules for this doctor
    $all_schedules = array();
    $schedule_query = mysqli_query($con, "SELECT * FROM doctor_schedule WHERE doctor='$doctor'");
    while($schedule = mysqli_fetch_assoc($schedule_query)) {
        $all_schedules[$schedule['day_of_week']] = $schedule;
    }
    
    for($hour = $start_hour; $hour < $end_hour; $hour++) {
        for($minute = 0; $minute < 60; $minute += $slot_duration) {
            $time = sprintf('%02d:%02d:00', $hour, $minute);
            echo "<tr>";
            echo "<td>" . date('h:i A', strtotime($time)) . "</td>";
            
            // For each day of the week
            for($day = 0; $day < 7; $day++) {
                $current_date = clone $monday;
                $current_date->modify("+$day days");
                $date_str = $current_date->format('Y-m-d');
                
                // Check if doctor has schedule for this day
                if(isset($all_schedules[$day]) && $all_schedules[$day]['is_available']) {
                    $schedule = $all_schedules[$day];
                    $current_time = strtotime($time);
                    $start = strtotime($schedule['start_time']);
                    $end = strtotime($schedule['end_time']);
                    
                    if($current_time >= $start && $current_time < $end) {
                        // Check if there's an appointment at this time
                        $appointment_query = mysqli_query($con, "SELECT * FROM appointmenttb 
                                                               WHERE doctor='$doctor' 
                                                               AND appdate='$date_str' 
                                                               AND apptime='$time'
                                                               AND userStatus=1 
                                                               AND doctorStatus=1");
                        
                        if(mysqli_num_rows($appointment_query) > 0) {
                            echo "<td><span class='time-slot booked'>Booked</span></td>";
                        } else {
                            echo "<td><span class='time-slot available'>Available</span></td>";
                        }
                    } else {
                        echo "<td><span class='time-slot unavailable'>Outside Hours</span></td>";
                    }
                } else {
                    echo "<td><span class='time-slot unavailable'>Not Available</span></td>";
                }
            }
            echo "</tr>";
        }
    }
} else {
    echo "<tr><td colspan='8'>Please select a doctor and week</td></tr>";
}
?> 