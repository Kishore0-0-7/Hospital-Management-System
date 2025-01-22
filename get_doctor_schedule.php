<?php
session_start();
include('func1.php');
$con = mysqli_connect("localhost","root","","myhmsdb");

if(isset($_POST['date'])) {
    $date = $_POST['date'];
    $status_filter = isset($_POST['status']) ? $_POST['status'] : 'all';
    $doctor = $_SESSION['dname']; // Get logged-in doctor's username
    
    // Get day of week (0 = Sunday, 6 = Saturday)
    $day_of_week = date('w', strtotime($date));
    
    // Get doctor's schedule for this day
    $schedule_query = mysqli_query($con, "SELECT * FROM doctor_schedule 
                                        WHERE day_of_week='$day_of_week' 
                                        AND doctor='$doctor' 
                                        AND is_available=1");
    
    // Get all appointments for this date
    $appointments = array();
    $app_query = mysqli_query($con, "SELECT apptime 
                                    FROM appointmenttb 
                                    WHERE appdate='$date' 
                                    AND doctor='$doctor' 
                                    AND userStatus=1 
                                    AND doctorStatus=1");
    
    while($app = mysqli_fetch_assoc($app_query)) {
        $appointments[$app['apptime']] = true;
    }
    
    // Add legend
    echo '<div class="legend">
            <div class="legend-item">
                <div class="legend-color" style="background-color: #d4edda;"></div>
                <span>Available</span>
            </div>
            <div class="legend-item">
                <div class="legend-color" style="background-color: #f8d7da;"></div>
                <span>Booked</span>
            </div>
          </div>';
    
    $schedule = mysqli_fetch_assoc($schedule_query);
    if($schedule) {
        $start_time = strtotime($schedule['start_time']);
        $end_time = strtotime($schedule['end_time']);
        $slot_duration = $schedule['slot_duration'] * 60; // Convert minutes to seconds
        
        // Generate time blocks
        for($time = $start_time; $time < $end_time; $time += $slot_duration) {
            $slot_time = date('H:i:s', $time);
            $display_time = date('h:i A', $time);
            
            $is_booked = isset($appointments[$slot_time]);
            
            // Apply status filter
            if($status_filter != 'all') {
                if($status_filter == 'available' && $is_booked) continue;
                if($status_filter == 'booked' && !$is_booked) continue;
            }
            
            // Skip past time slots for today
            if($date == date('Y-m-d') && $time < time()) continue;
            
            $class = $is_booked ? 'booked' : 'available';
            $status = $is_booked ? 'Booked' : 'Available';
            
            echo "<div class='time-block $class'>
                    <div class='time'>$display_time</div>
                    <div class='status'>$status</div>
                  </div>";
        }
    } else {
        echo "<p class='text-center'>No schedule available for this day. Please set up your schedule first.</p>";
    }
} else {
    echo "<p class='text-center'>Please select a date to view availability.</p>";
}
?> 