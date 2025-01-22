<?php
include('func1.php');
$con = mysqli_connect("localhost","root","","myhmsdb");

if(isset($_POST['date'])) {
    $date = $_POST['date'];
    $status_filter = isset($_POST['status']) ? $_POST['status'] : 'all';
    $doctor_filter = isset($_POST['doctor']) ? $_POST['doctor'] : '';
    
    // Get day of week (0 = Sunday, 6 = Saturday)
    $day_of_week = date('w', strtotime($date));
    
    // Build doctor condition
    $doctor_condition = "";
    if($doctor_filter) {
        $doctor_condition = "AND doctor='$doctor_filter'";
    }
    
    // Get all doctors' schedules for this day
    $schedule_query = mysqli_query($con, "SELECT * FROM doctor_schedule 
                                        WHERE day_of_week='$day_of_week' 
                                        AND is_available=1 
                                        $doctor_condition");
    
    // Get all appointments for this date
    $appointments = array();
    $app_query = mysqli_query($con, "SELECT doctor, apptime 
                                    FROM appointmenttb 
                                    WHERE appdate='$date' 
                                    AND userStatus=1 
                                    AND doctorStatus=1 
                                    $doctor_condition");
    
    while($app = mysqli_fetch_assoc($app_query)) {
        $key = $app['doctor'] . '_' . $app['apptime'];
        $appointments[$key] = true;
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
    
    // For each doctor's schedule
    while($schedule = mysqli_fetch_assoc($schedule_query)) {
        $doctor = $schedule['doctor'];
        $start_time = strtotime($schedule['start_time']);
        $end_time = strtotime($schedule['end_time']);
        $slot_duration = $schedule['slot_duration'] * 60; // Convert minutes to seconds
        
        // Generate time blocks
        for($time = $start_time; $time < $end_time; $time += $slot_duration) {
            $slot_time = date('H:i:s', $time);
            $display_time = date('h:i A', $time);
            $key = $doctor . '_' . $slot_time;
            
            $is_booked = isset($appointments[$key]);
            
            // Apply status filter
            if($status_filter != 'all') {
                if($status_filter == 'available' && $is_booked) continue;
                if($status_filter == 'booked' && !$is_booked) continue;
            }
            
            // Skip past time slots for today
            if($date == date('Y-m-d') && $time < time()) continue;
            
            $class = $is_booked ? 'booked' : 'available';
            $status = $is_booked ? 'Booked' : 'Available';
            
            echo "<div class='time-block $class' title='$doctor - $display_time'>
                    <div class='time'>$display_time</div>
                    <div class='doctor'>$doctor</div>
                    <div class='status'>$status</div>
                  </div>";
        }
    }
} else {
    echo "<p class='text-center'>Please select a date</p>";
}
?> 