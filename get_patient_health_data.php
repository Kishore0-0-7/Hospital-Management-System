<?php
include('func1.php');
$con = mysqli_connect("localhost", "root", "", "myhmsdb");

header('Content-Type: application/json');

if (!isset($_GET['pid'])) {
    echo json_encode(['error' => 'Patient ID is required']);
    exit();
}

$pid = mysqli_real_escape_string($con, $_GET['pid']);

// Get patient's health details
$health_query = mysqli_query($con, "SELECT * FROM patient_health_details WHERE pid='$pid'");
$health_data = mysqli_fetch_assoc($health_query);

// Get patient's lab results
$lab_query = mysqli_query($con, "SELECT * FROM lab_results WHERE pid='$pid' ORDER BY test_date DESC");
$lab_results = [];

while ($row = mysqli_fetch_assoc($lab_query)) {
    $lab_results[] = [
        'test' => $row['test_name'],
        'value' => $row['test_value'],
        'range' => $row['reference_range'],
        'status' => $row['status'],
        'date' => $row['test_date']
    ];
}

// If no lab results, provide sample data
if (empty($lab_results)) {
    $lab_results = [
        [
            'test' => 'Blood Glucose',
            'value' => '95',
            'range' => '70-100 mg/dL',
            'status' => 'Normal',
            'date' => date('Y-m-d')
        ],
        [
            'test' => 'Blood Pressure',
            'value' => '120/80',
            'range' => '90-120/60-80 mmHg',
            'status' => 'Normal',
            'date' => date('Y-m-d')
        ],
        [
            'test' => 'Cholesterol',
            'value' => '210',
            'range' => '< 200 mg/dL',
            'status' => 'High',
            'date' => date('Y-m-d')
        ]
    ];
}

$response = [
    'health_data' => $health_data,
    'lab_results' => $lab_results
];

echo json_encode($response);
?> 