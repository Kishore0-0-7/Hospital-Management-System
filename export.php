<?php
require('fpdf/fpdf.php');  // Using FPDF library

$con = mysqli_connect("localhost","root","","myhmsdb");

// Get export parameters
$type = $_GET['type'] ?? '';
$format = $_GET['format'] ?? '';

// Validate parameters
if (empty($type) || empty($format)) {
    die('Invalid parameters');
}

// Get filter parameters
$spec = $_GET['spec'] ?? '';
$maxFees = $_GET['maxFees'] ?? '';
$gender = $_GET['gender'] ?? '';
$ageRange = $_GET['ageRange'] ?? '';
$status = $_GET['status'] ?? '';
$date = $_GET['date'] ?? '';
$doctor = $_GET['doctor'] ?? '';
$search = $_GET['search'] ?? '';

// Get data based on type with filters
switch ($type) {
    case 'doctors':
        $query = "SELECT username as 'Doctor Name', spec as 'Specialization', email as 'Email', docFees as 'Fees' FROM doctb WHERE 1=1";
        if (!empty($spec)) {
            $query .= " AND spec = '" . mysqli_real_escape_string($con, $spec) . "'";
        }
        if (!empty($maxFees)) {
            $query .= " AND docFees <= " . (float)$maxFees;
        }
        if (!empty($search)) {
            $search = mysqli_real_escape_string($con, $search);
            $query .= " AND (username LIKE '%$search%' OR email LIKE '%$search%')";
        }
        $headers = ['Doctor Name', 'Specialization', 'Email', 'Fees'];
        $filename = 'doctors_list';
        break;

    case 'patients':
        $query = "SELECT fname as 'First Name', lname as 'Last Name', gender as 'Gender', email as 'Email', contact as 'Contact' FROM patreg WHERE 1=1";
        if (!empty($gender)) {
            $query .= " AND gender = '" . mysqli_real_escape_string($con, $gender) . "'";
        }
        if (!empty($ageRange)) {
            $ages = explode('-', $ageRange);
            if (count($ages) == 2) {
                $query .= " AND age BETWEEN " . (int)$ages[0] . " AND " . (int)$ages[1];
            }
        }
        if (!empty($search)) {
            $search = mysqli_real_escape_string($con, $search);
            $query .= " AND (fname LIKE '%$search%' OR lname LIKE '%$search%' OR email LIKE '%$search%' OR contact LIKE '%$search%')";
        }
        $headers = ['First Name', 'Last Name', 'Gender', 'Email', 'Contact'];
        $filename = 'patients_list';
        break;

    case 'appointments':
        $query = "SELECT 
            a.doctor as 'Doctor',
            a.fname as 'First Name',
            a.lname as 'Last Name',
            a.appdate as 'Date',
            a.apptime as 'Time',
            CASE 
                WHEN a.userStatus=1 AND a.doctorStatus=1 AND a.status='completed' THEN 'Completed'
                WHEN a.userStatus=1 AND a.doctorStatus=1 THEN 'Active'
                WHEN a.userStatus=0 AND a.doctorStatus=1 THEN 'Cancelled by Patient'
                WHEN a.userStatus=1 AND a.doctorStatus=0 THEN 'Cancelled by Doctor'
                ELSE 'Unknown'
            END as 'Status'
            FROM appointmenttb a WHERE 1=1";
        
        if (!empty($status)) {
            switch($status) {
                case 'active':
                    $query .= " AND userStatus=1 AND doctorStatus=1 AND status!='completed'";
                    break;
                case 'completed':
                    $query .= " AND status='completed'";
                    break;
                case 'cancelled_patient':
                    $query .= " AND userStatus=0 AND doctorStatus=1";
                    break;
                case 'cancelled_doctor':
                    $query .= " AND userStatus=1 AND doctorStatus=0";
                    break;
            }
        }
        if (!empty($date)) {
            $query .= " AND appdate = '" . mysqli_real_escape_string($con, $date) . "'";
        }
        if (!empty($doctor)) {
            $query .= " AND doctor = '" . mysqli_real_escape_string($con, $doctor) . "'";
        }
        if (!empty($search)) {
            $search = mysqli_real_escape_string($con, $search);
            $query .= " AND (fname LIKE '%$search%' OR lname LIKE '%$search%' OR doctor LIKE '%$search%')";
        }
        $headers = ['Doctor', 'First Name', 'Last Name', 'Date', 'Time', 'Status'];
        $filename = 'appointments_list';
        break;

    case 'prescriptions':
        $query = "SELECT 
            p.doctor as 'Doctor',
            p.pid as 'Patient ID',
            p.fname as 'First Name',
            p.lname as 'Last Name',
            p.appdate as 'Date',
            p.disease as 'Disease',
            p.allergy as 'Allergy',
            p.prescription as 'Prescription'
            FROM prestb p WHERE 1=1";
        
        if (!empty($search)) {
            $search = mysqli_real_escape_string($con, $search);
            $query .= " AND (fname LIKE '%$search%' OR lname LIKE '%$search%' OR doctor LIKE '%$search%' OR disease LIKE '%$search%')";
        }
        $headers = ['Doctor', 'Patient ID', 'First Name', 'Last Name', 'Date', 'Disease', 'Allergy', 'Prescription'];
        $filename = 'prescriptions_list';
        break;

    default:
        die('Invalid type');
}

$result = mysqli_query($con, $query);
if (!$result) {
    die('Query failed: ' . mysqli_error($con));
}

// Export based on format
switch ($format) {
    case 'csv':
        exportCSV($result, $headers, $filename);
        break;
    case 'excel':
        exportExcel($result, $headers, $filename);
        break;
    case 'pdf':
        exportPDF($result, $headers, $filename);
        break;
    default:
        die('Invalid format');
}

function exportCSV($result, $headers, $filename) {
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="' . $filename . '.csv"');
    
    $output = fopen('php://output', 'w');
    
    // Add headers
    fputcsv($output, $headers);
    
    // Add data rows
    while ($row = mysqli_fetch_assoc($result)) {
        fputcsv($output, $row);
    }
    
    fclose($output);
}

function exportExcel($result, $headers, $filename) {
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment; filename="' . $filename . '.xls"');
    
    echo '<table border="1">';
    
    // Add headers
    echo '<tr>';
    foreach ($headers as $header) {
        echo '<th style="background-color: #f5f5f5; font-weight: bold;">' . htmlspecialchars($header) . '</th>';
    }
    echo '</tr>';
    
    // Add data rows
    while ($row = mysqli_fetch_assoc($result)) {
        echo '<tr>';
        foreach ($headers as $header) {
            echo '<td>' . htmlspecialchars($row[$header] ?? '') . '</td>';
        }
        echo '</tr>';
    }
    
    echo '</table>';
}

function exportPDF($result, $headers, $filename) {
    class PDF extends FPDF {
        protected $widths;
        protected $aligns;

        // Page header
        function Header() {
            if (file_exists('images/favicon.png')) {
                $this->Image('images/favicon.png', 10, 6, 30);
            }
            $this->SetFont('Arial', 'B', 15);
            // Move title to center of page
            $this->Cell(0, 10, 'Hospital Management System', 0, 0, 'C');
            $this->Ln(20);
        }

        // Page footer
        function Footer() {
            $this->SetY(-15);
            $this->SetFont('Arial', 'I', 8);
            $this->Cell(0, 10, 'Page ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
        }

        // Set the array of column widths
        function SetWidths($w) {
            $this->widths = $w;
        }

        // Set the array of column alignments
        function SetAligns($a) {
            $this->aligns = $a;
        }

        // Calculate the height of the row
        function Row($data) {
            $nb = 0;
            for($i = 0; $i < count($data); $i++) {
                $nb = max($nb, $this->NbLines($this->widths[$i], $data[$i]));
            }
            $h = 6 * $nb;
            $this->CheckPageBreak($h);
            
            for($i = 0; $i < count($data); $i++) {
                $w = $this->widths[$i];
                $a = isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
                $x = $this->GetX();
                $y = $this->GetY();
                $this->Rect($x, $y, $w, $h);
                $this->MultiCell($w, 6, $data[$i], 0, $a);
                $this->SetXY($x + $w, $y);
            }
            $this->Ln($h);
        }

        function CheckPageBreak($h) {
            if($this->GetY() + $h > $this->PageBreakTrigger)
                $this->AddPage($this->CurOrientation);
        }

        function NbLines($w, $txt) {
            $cw = &$this->CurrentFont['cw'];
            if($w == 0)
                $w = $this->w - $this->rMargin - $this->x;
            $wmax = ($w - 2 * $this->cMargin) * 1000 / $this->FontSize;
            $s = str_replace("\r", '', $txt);
            $nb = strlen($s);
            if($nb > 0 && $s[$nb - 1] == "\n")
                $nb--;
            $sep = -1;
            $i = 0;
            $j = 0;
            $l = 0;
            $nl = 1;
            while($i < $nb) {
                $c = $s[$i];
                if($c == "\n") {
                    $i++;
                    $sep = -1;
                    $j = $i;
                    $l = 0;
                    $nl++;
                    continue;
                }
                if($c == ' ')
                    $sep = $i;
                $l += $cw[$c];
                if($l > $wmax) {
                    if($sep == -1) {
                        if($i == $j)
                            $i++;
                    }
                    else
                        $i = $sep + 1;
                    $sep = -1;
                    $j = $i;
                    $l = 0;
                    $nl++;
                }
                else
                    $i++;
            }
            return $nl;
        }
    }

    // Create new PDF document
    $pdf = new PDF('L'); // Set to Landscape orientation
    $pdf->AliasNbPages();
    $pdf->AddPage();
    $pdf->SetFont('Arial', '', 10);
    $pdf->SetMargins(10, 10, 10);

    // Title
    $pdf->SetFont('Arial', 'B', 16);
    $pdf->Cell(0, 10, ucwords(str_replace('_', ' ', $filename)), 0, 1, 'C');
    $pdf->Ln(5);

    // Calculate column widths based on content
    $column_widths = array();
    $data = array();
    mysqli_data_seek($result, 0);
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }

    foreach ($headers as $header) {
        $max_width = $pdf->GetStringWidth($header) + 4;
        foreach ($data as $row) {
            $width = $pdf->GetStringWidth($row[$header] ?? '') + 4;
            $max_width = max($max_width, $width);
        }
        $column_widths[] = $max_width;
    }

    // Adjust widths if total exceeds page width
    $total_width = array_sum($column_widths);
    $page_width = $pdf->GetPageWidth() - 20; // 20mm margins
    if ($total_width > $page_width) {
        $ratio = $page_width / $total_width;
        foreach ($column_widths as &$width) {
            $width *= $ratio;
        }
    }

    // Set column widths
    $pdf->SetWidths($column_widths);

    // Set alignments (center for headers, left for data)
    $alignments = array_fill(0, count($headers), 'C');
    $pdf->SetAligns($alignments);

    // Add headers
    $pdf->SetFont('Arial', 'B', 11);
    $pdf->SetFillColor(230, 230, 230);
    $pdf->Row($headers);

    // Add data rows
    $pdf->SetFont('Arial', '', 10);
    $pdf->SetFillColor(245, 245, 245);
    $fill = false;
    foreach ($data as $row) {
        $row_data = array();
        foreach ($headers as $header) {
            $row_data[] = $row[$header] ?? '';
        }
        $pdf->Row($row_data);
        $fill = !$fill;
    }

    // Output PDF
    $pdf->Output('D', $filename . '.pdf');
}
?> 