<?php
function getAnalytics($con) {
    // Total Patients
    $total_patients = mysqli_fetch_array(mysqli_query($con, "SELECT COUNT(*) FROM patreg"))[0];
    
    // Total Appointments
    $total_appointments = mysqli_fetch_array(mysqli_query($con, "SELECT COUNT(*) FROM appointmenttb"))[0];
    
    // Total Revenue
    $total_revenue = mysqli_fetch_array(mysqli_query($con, "SELECT SUM(docFees) FROM appointmenttb"))[0];
    
    // Monthly Revenue
    $monthly_revenue = mysqli_fetch_array(mysqli_query($con, 
        "SELECT SUM(docFees) FROM appointmenttb 
         WHERE MONTH(appdate) = MONTH(CURRENT_DATE()) 
         AND YEAR(appdate) = YEAR(CURRENT_DATE())"))[0];
    
    // Patient Demographics
    $gender_dist = mysqli_query($con, "SELECT gender, COUNT(*) as count FROM patreg GROUP BY gender");
    
    // Appointment Status
    $app_status = mysqli_query($con, 
        "SELECT 
            CASE 
                WHEN userStatus=1 AND doctorStatus=1 THEN 'Active'
                WHEN userStatus=0 THEN 'Cancelled by Patient'
                WHEN doctorStatus=0 THEN 'Cancelled by Doctor'
            END as status,
            COUNT(*) as count 
        FROM appointmenttb 
        GROUP BY status");

    return array(
        'total_patients' => $total_patients,
        'total_appointments' => $total_appointments,
        'total_revenue' => $total_revenue,
        'monthly_revenue' => $monthly_revenue,
        'gender_dist' => $gender_dist,
        'app_status' => $app_status
    );
}
?>
