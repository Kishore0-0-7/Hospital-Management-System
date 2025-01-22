<?php
header('Content-Type: application/json');
require_once('connection.php');

$type = $_GET['type'] ?? '';
$response = [];

switch($type) {
    case 'appointment_status':
        $query = "SELECT 
            CASE 
                WHEN userStatus=1 AND doctorStatus=1 THEN 'Active'
                WHEN userStatus=0 AND doctorStatus=1 THEN 'Cancelled by Patient'
                WHEN userStatus=1 AND doctorStatus=0 THEN 'Cancelled by Doctor'
                ELSE 'Other'
            END as status,
            COUNT(*) as count
        FROM appointmenttb
        GROUP BY 
            CASE 
                WHEN userStatus=1 AND doctorStatus=1 THEN 'Active'
                WHEN userStatus=0 AND doctorStatus=1 THEN 'Cancelled by Patient'
                WHEN userStatus=1 AND doctorStatus=0 THEN 'Cancelled by Doctor'
                ELSE 'Other'
            END";
        
        $result = mysqli_query($con, $query);
        $labels = [];
        $data = [];
        $colors = [
            'Active' => '#28a745',
            'Cancelled by Patient' => '#dc3545',
            'Cancelled by Doctor' => '#ffc107',
            'Other' => '#6c757d'
        ];
        $backgroundColor = [];
        
        while($row = mysqli_fetch_assoc($result)) {
            $labels[] = $row['status'];
            $data[] = $row['count'];
            $backgroundColor[] = $colors[$row['status']] ?? '#6c757d';
        }
        
        $response = [
            'labels' => $labels,
            'datasets' => [[
                'data' => $data,
                'backgroundColor' => $backgroundColor
            ]]
        ];
        break;

    case 'gender_distribution':
        $query = "SELECT gender, COUNT(*) as count FROM patreg GROUP BY gender";
        $result = mysqli_query($con, $query);
        $labels = [];
        $data = [];
        $colors = [
            'Male' => '#007bff',
            'Female' => '#e83e8c',
            'Other' => '#6c757d'
        ];
        $backgroundColor = [];
        
        while($row = mysqli_fetch_assoc($result)) {
            $labels[] = $row['gender'];
            $data[] = $row['count'];
            $backgroundColor[] = $colors[$row['gender']] ?? '#6c757d';
        }
        
        $response = [
            'labels' => $labels,
            'datasets' => [[
                'data' => $data,
                'backgroundColor' => $backgroundColor
            ]]
        ];
        break;

    case 'revenue':
        $query = "SELECT 
            DATE_FORMAT(appdate, '%b %Y') as month,
            SUM(docFees) as revenue,
            COUNT(*) as appointments
        FROM appointmenttb 
        WHERE appdate >= DATE_SUB(CURDATE(), INTERVAL 12 MONTH)
        GROUP BY YEAR(appdate), MONTH(appdate)
        ORDER BY appdate ASC";
        
        $result = mysqli_query($con, $query);
        $labels = [];
        $revenue = [];
        $appointments = [];
        
        while($row = mysqli_fetch_assoc($result)) {
            $labels[] = $row['month'];
            $revenue[] = $row['revenue'];
            $appointments[] = $row['appointments'];
        }
        
        $response = [
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => 'Revenue',
                    'data' => $revenue,
                    'borderColor' => '#28a745',
                    'backgroundColor' => 'rgba(40, 167, 69, 0.1)',
                    'yAxisID' => 'y'
                ],
                [
                    'label' => 'Appointments',
                    'data' => $appointments,
                    'borderColor' => '#007bff',
                    'backgroundColor' => 'rgba(0, 123, 255, 0.1)',
                    'yAxisID' => 'y1'
                ]
            ]
        ];
        break;

    case 'age_distribution':
        $query = "SELECT 
            CASE 
                WHEN age < 18 THEN 'Under 18'
                WHEN age BETWEEN 18 AND 30 THEN '18-30'
                WHEN age BETWEEN 31 AND 50 THEN '31-50'
                ELSE 'Over 50'
            END as age_group,
            COUNT(*) as count
        FROM patient_health_details
        GROUP BY 
            CASE 
                WHEN age < 18 THEN 'Under 18'
                WHEN age BETWEEN 18 AND 30 THEN '18-30'
                WHEN age BETWEEN 31 AND 50 THEN '31-50'
                ELSE 'Over 50'
            END
        ORDER BY 
            CASE age_group
                WHEN 'Under 18' THEN 1
                WHEN '18-30' THEN 2
                WHEN '31-50' THEN 3
                ELSE 4
            END";
        
        $result = mysqli_query($con, $query);
        $labels = [];
        $data = [];
        $backgroundColor = [
            'rgba(54, 162, 235, 0.8)',
            'rgba(75, 192, 192, 0.8)',
            'rgba(255, 206, 86, 0.8)',
            'rgba(255, 99, 132, 0.8)'
        ];
        
        while($row = mysqli_fetch_assoc($result)) {
            $labels[] = $row['age_group'];
            $data[] = $row['count'];
        }
        
        $response = [
            'labels' => $labels,
            'datasets' => [[
                'data' => $data,
                'backgroundColor' => array_slice($backgroundColor, 0, count($data)),
                'borderColor' => 'rgba(255, 255, 255, 1)',
                'borderWidth' => 1
            ]]
        ];
        break;

    default:
        http_response_code(400);
        $response = ['error' => 'Invalid type specified'];
}

echo json_encode($response); 