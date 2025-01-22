<?php
$con = mysqli_connect("localhost","root","","myhmsdb");

// Get all doctors
$doctors_query = mysqli_query($con, "SELECT username FROM doctb");

while($doctor = mysqli_fetch_array($doctors_query)) {
    $doctor_name = $doctor['username'];
    
    // Add weekday schedules (Monday to Friday)
    for($day = 1; $day <= 5; $day++) {
        $query = "INSERT INTO doctor_schedule (doctor, day_of_week, start_time, end_time, slot_duration, is_available) 
                  VALUES ('$doctor_name', $day, '09:00:00', '17:00:00', 30, 1)
                  ON DUPLICATE KEY UPDATE 
                  start_time='09:00:00', 
                  end_time='17:00:00', 
                  slot_duration=30, 
                  is_available=1";
        mysqli_query($con, $query);
    }
    
    // Add weekend schedules (shorter hours)
    for($day = 0; $day <= 6; $day += 6) {
        $query = "INSERT INTO doctor_schedule (doctor, day_of_week, start_time, end_time, slot_duration, is_available) 
                  VALUES ('$doctor_name', $day, '10:00:00', '14:00:00', 30, 1)
                  ON DUPLICATE KEY UPDATE 
                  start_time='10:00:00', 
                  end_time='14:00:00', 
                  slot_duration=30, 
                  is_available=1";
        mysqli_query($con, $query);
    }
}

echo "Default schedules added successfully!";
?> 