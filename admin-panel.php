<!DOCTYPE html>
<?php 
include('func.php');  
include('newfunc.php');
$con=mysqli_connect("localhost","root","","myhmsdb");


  $pid = $_SESSION['pid'];
  $username = $_SESSION['username'];
  $email = $_SESSION['email'];
  $fname = $_SESSION['fname'];
  $gender = $_SESSION['gender'];
  $lname = $_SESSION['lname'];
  $contact = $_SESSION['contact'];



if(isset($_POST['app-submit']))
{
  $pid = $_SESSION['pid'];
  $username = $_SESSION['username'];
  $email = $_SESSION['email'];
  $fname = $_SESSION['fname'];
  $lname = $_SESSION['lname'];
  $gender = $_SESSION['gender'];
  $contact = $_SESSION['contact'];
  $doctor=$_POST['doctor'];
  $email=$_SESSION['email'];
  $docFees=$_POST['docFees'];

  $appdate=$_POST['appdate'];
  $apptime=$_POST['apptime'];
  $cur_date = date("Y-m-d");
  date_default_timezone_set('Asia/Kolkata');
  $cur_time = date("H:i:s");
  $apptime1 = strtotime($apptime);
  $appdate1 = strtotime($appdate);
	
  if(date("Y-m-d",$appdate1)>=$cur_date){
    if((date("Y-m-d",$appdate1)==$cur_date and date("H:i:s",$apptime1)>$cur_time) or date("Y-m-d",$appdate1)>$cur_date) {
      $check_query = mysqli_query($con,"select apptime from appointmenttb where doctor='$doctor' and appdate='$appdate' and apptime='$apptime'");

        if(mysqli_num_rows($check_query)==0){
          $query = mysqli_query($con, sprintf(
            "INSERT INTO appointmenttb (pid, fname, lname, gender, email, contact, doctor, docFees, appdate, apptime, userStatus, doctorStatus) 
             VALUES (%d, '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', 1, 1)",
            mysqli_real_escape_string($con, $pid),
            mysqli_real_escape_string($con, $fname),
            mysqli_real_escape_string($con, $lname),
            mysqli_real_escape_string($con, $gender),
            mysqli_real_escape_string($con, $email),
            mysqli_real_escape_string($con, $contact),
            mysqli_real_escape_string($con, $doctor),
            mysqli_real_escape_string($con, $docFees),
            mysqli_real_escape_string($con, $appdate),
            mysqli_real_escape_string($con, $apptime)
        ));
        
        if($query) {
            echo "<script>
                alert('Your appointment successfully booked');
                window.location.href = window.location.href;
            </script>";
            exit();
        } else {
            echo "<script>
                alert('Unable to process your request. Please try again!');
                window.location.href = window.location.href;
            </script>";
            exit();
        }
      } else {
        echo "<script>
            alert('We are sorry to inform that the doctor is not available in this time or date. Please choose different time or date!');
            window.history.back();
        </script>";
        exit();
      }
    } else {
      echo "<script>
          alert('Select a time or date in the future!');
          window.history.back();
      </script>";
      exit();
    }
  } else {
    echo "<script>
        alert('Select a time or date in the future!');
        window.history.back();
    </script>";
    exit();
  }
}

if(isset($_GET['cancel']))
  {
    $query=mysqli_query($con,"update appointmenttb set userStatus='0' where ID = '".$_GET['ID']."'");
    if($query)
    {
      echo "<script>alert('Your appointment successfully cancelled');</script>";
    }
  }

if(isset($_GET['complete']))
{
  $query=mysqli_query($con,"UPDATE appointmenttb SET status='completed' WHERE ID = '".$_GET['ID']."'");
  if($query)
  {
    echo "<script>alert('Appointment marked as completed');</script>";
  }
}




function generate_bill(){
  $con=mysqli_connect("localhost","root","","myhmsdb");
  $pid = $_SESSION['pid'];
  $output='';
  $query=mysqli_query($con,"select p.pid,p.ID,p.fname,p.lname,p.doctor,p.appdate,p.apptime,p.disease,p.allergy,p.prescription,a.docFees from prestb p inner join appointmenttb a on p.ID=a.ID and p.pid = '$pid' and p.ID = '".$_GET['ID']."'");
  while($row = mysqli_fetch_array($query)){
    $output .= '
    <label> Patient ID : </label>'.$row["pid"].'<br/><br/>
    <label> Appointment ID : </label>'.$row["ID"].'<br/><br/>
    <label> Patient Name : </label>'.$row["fname"].' '.$row["lname"].'<br/><br/>
    <label> Doctor Name : </label>'.$row["doctor"].'<br/><br/>
    <label> Appointment Date : </label>'.$row["appdate"].'<br/><br/>
    <label> Appointment Time : </label>'.$row["apptime"].'<br/><br/>
    <label> Disease : </label>'.$row["disease"].'<br/><br/>
    <label> Allergies : </label>'.$row["allergy"].'<br/><br/>
    <label> Prescription : </label>'.$row["prescription"].'<br/><br/>
    <label> Fees Paid : </label>'.$row["docFees"].'<br/>
    
    ';

  }
  
  return $output;
}


if(isset($_GET["generate_bill"])){
  require_once("TCPDF/tcpdf.php");
  $obj_pdf = new TCPDF('P',PDF_UNIT,PDF_PAGE_FORMAT,true,'UTF-8',false);
  $obj_pdf -> SetCreator(PDF_CREATOR);
  $obj_pdf -> SetTitle("Generate Bill");
  $obj_pdf -> SetHeaderData('','',PDF_HEADER_TITLE,PDF_HEADER_STRING);
  $obj_pdf -> SetHeaderFont(Array(PDF_FONT_NAME_MAIN,'',PDF_FONT_SIZE_MAIN));
  $obj_pdf -> SetFooterFont(Array(PDF_FONT_NAME_MAIN,'',PDF_FONT_SIZE_MAIN));
  $obj_pdf -> SetDefaultMonospacedFont('helvetica');
  $obj_pdf -> SetFooterMargin(PDF_MARGIN_FOOTER);
  $obj_pdf -> SetMargins(PDF_MARGIN_LEFT,'5',PDF_MARGIN_RIGHT);
  $obj_pdf -> SetPrintHeader(false);
  $obj_pdf -> SetPrintFooter(false);
  $obj_pdf -> SetAutoPageBreak(TRUE, 10);
  $obj_pdf -> SetFont('helvetica','',12);
  $obj_pdf -> AddPage();

  $content = '';

  $content .= '
      <br/>
      <h2 align ="center">The Care Crew</h2></br>
      <h3 align ="center"> Bill</h3>
      

  ';
 
  $content .= generate_bill();
  $obj_pdf -> writeHTML($content);
  ob_end_clean();
  $obj_pdf -> Output("bill.pdf",'I');

}

function get_specs(){
  $con=mysqli_connect("localhost","root","","myhmsdb");
  $query=mysqli_query($con,"select username,spec from doctb");
  $docarray = array();
    while($row =mysqli_fetch_assoc($query))
    {
        $docarray[] = $row;
    }
    return json_encode($docarray);
}

?>
<html lang="en">
  <head>


    <!-- Required meta tags -->
    <meta charset="utf-8">
    <link rel="shortcut icon" type="image/x-icon" href="images/favicon.png" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" type="text/css" href="font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="style.css">
    <!-- Bootstrap CSS -->
    
        <link rel="stylesheet" href="vendor/fontawesome/css/font-awesome.min.css">

    
  
    
    



    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    
    <link href="https://fonts.googleapis.com/css?family=IBM+Plex+Sans&display=swap" rel="stylesheet">
      <nav class="navbar navbar-expand-lg navbar-dark bg-primary fixed-top">
  <a class="navbar-brand" href="#"><i class="fa fa-user-plus" aria-hidden="true"></i>The Care Crew</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <style >
    .bg-primary {
      background: -webkit-linear-gradient(left, #3931af, #00c6ff);
    }
    .list-group-item.active {
      z-index: 2;
      color: #fff;
      background-color: #342ac1;
      border-color: #007bff;
    }
    .text-primary {
      color: #342ac1!important;
    }

    .btn-primary{
      background-color: #3c50c1;
      border-color: #3c50c1;
    }

    /* Analytics styles */
    .tab-pane#list-analytics {
      padding: 20px 0;
    }
    
    .tab-pane#list-analytics .card {
      margin-bottom: 20px;
      border-radius: 10px;
      box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    
    .tab-pane#list-analytics .card-body {
      padding: 25px;
    }
    
    .tab-pane#list-analytics h4.card-title {
      font-size: 24px;
      font-weight: 600;
      margin-bottom: 30px;
    }
    
    .tab-pane#list-analytics h5.card-title {
      font-size: 18px;
      font-weight: 600;
      margin-bottom: 25px;
    }
    
    .tab-pane#list-analytics .chart-container {
      margin: auto;
    }
    
    .tab-pane#list-analytics .rounded {
      border-radius: 10px !important;
    }
    
    .tab-pane#list-analytics .shadow-sm {
      box-shadow: 0 2px 4px rgba(0,0,0,0.075) !important;
    }
    
    .tab-pane#list-analytics .badge-pill {
      font-size: 14px;
      padding: 8px 16px;
    }
    
    .tab-pane#list-analytics .alert {
      border-radius: 8px;
    }
    
    .tab-pane#list-analytics .prescription-stats h6 {
      font-size: 13px;
      font-weight: 600;
    }
    
    .tab-pane#list-analytics .prescription-stats h4 {
      font-size: 24px;
      font-weight: 600;
    }

    /* Existing chat button styles */
    .chat-button {
        position: fixed;
        bottom: 30px;
        right: 30px;
        width: 60px;
        height: 60px;
        border-radius: 50%;
        background: #342ac1;
        display: flex;
        align-items: center;
        justify-content: center;
        text-decoration: none !important;
        box-shadow: 0 4px 8px rgba(0,0,0,0.3);
        transition: transform 0.3s ease, background-color 0.3s ease;
        z-index: 9999;
    }

    .chat-button i {
        color: white;
        font-size: 24px;
    }

    .chat-button:hover {
        transform: scale(1.1);
        background: #3c50c1;
    }

    .chat-button:hover i {
        color: white;
    }

    /* Add these styles for appointment analytics boxes */
    .tab-pane#list-analytics .stats-box {
      height: 100%;
      display: flex;
      flex-direction: column;
      justify-content: center;
      padding: 1.5rem;
      transition: transform 0.2s;
    }
    
    .tab-pane#list-analytics .stats-box:hover {
      transform: translateY(-2px);
    }
    
    .tab-pane#list-analytics .stats-box h6 {
      font-size: 0.875rem;
      text-transform: uppercase;
      letter-spacing: 0.5px;
      opacity: 0.8;
    }
    
    .tab-pane#list-analytics .stats-box h3 {
      font-size: 2rem;
      font-weight: 700;
      margin: 0;
    }
    
    .tab-pane#list-analytics .row.g-3 {
      margin: -0.5rem;
    }
    
    .tab-pane#list-analytics .row.g-3 > div {
      padding: 0.5rem;
    }
    
    .tab-pane#list-analytics .chart-container {
      margin-bottom: 1rem;
    }
  </style>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
     <ul class="navbar-nav mr-auto">
       <li class="nav-item">
        <a class="nav-link" href="logout.php"><i class="fa fa-sign-out" aria-hidden="true"></i>logout</a>
      </li>
       <li class="nav-item">
        <a class="nav-link" href="#"></a>
      </li>
    </ul>
  </div>
</nav>
  </head>
  <style type="text/css">
    button:hover{cursor:pointer;}
    #inputbtn:hover{cursor:pointer;}
    
    /* Chat button styles */
    .chat-button {
        position: fixed;
        bottom: 20px;
        right: 20px;
        background: #342ac1;
        color: white !important;
        width: 60px;
        height: 60px;
        border-radius: 50%;
        text-align: center;
        line-height: 60px;
        font-size: 24px;
        cursor: pointer;
        box-shadow: 0 2px 5px rgba(0,0,0,0.3);
        z-index: 1000;
        transition: all 0.3s ease;
        text-decoration: none;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .chat-button:hover {
        transform: scale(1.1);
        background: #3c50c1;
        color: white !important;
        text-decoration: none;
    }

    .chat-button i {
        font-size: 24px;
    }
  </style>
  <body style="padding-top:50px;">
   
    <?php
    // Show messages if they exist in session and then clear them
    if(isset($_SESSION['success_msg'])) {
        echo '<script>
            window.onload = function() {
                alert("'.$_SESSION['success_msg'].'");
            }
        </script>';
        unset($_SESSION['success_msg']);
    }
    if(isset($_SESSION['error_msg'])) {
        echo '<script>
            window.onload = function() {
                alert("'.$_SESSION['error_msg'].'");
            }
        </script>';
        unset($_SESSION['error_msg']);
    }
    ?>

    <div class="container-fluid" style="margin-top:50px;">
    <h3 style="margin-left: 40%; padding-bottom: 20px;font-family: 'IBM Plex Sans', sans-serif;"> Welcome <?php echo $fname . " " . $lname; ?> </h3>
    <div class="row">
  <div class="col-md-4" style="max-width:25%; margin-top: 3%">
    <div class="list-group" id="list-tab" role="tablist">
      <a class="list-group-item list-group-item-action active" id="list-dash-list" data-toggle="list" href="#list-dash" role="tab" aria-controls="home">Dashboard</a>
      <a class="list-group-item list-group-item-action" id="list-home-list" data-toggle="list" href="#list-home" role="tab" aria-controls="home">Book Appointment</a>
      <a class="list-group-item list-group-item-action" id="list-pat-list" data-toggle="list" href="#app-hist" role="tab" aria-controls="home">Appointment History</a>
      <a class="list-group-item list-group-item-action" id="list-pres-list" data-toggle="list" href="#list-pres" role="tab" aria-controls="home">Prescriptions</a>
      <a class="list-group-item list-group-item-action" id="list-health-list" data-toggle="list" href="#list-health" role="tab" aria-controls="home">Health Details</a>
      <a class="list-group-item list-group-item-action" id="list-analytics-list" data-toggle="list" href="#list-analytics" role="tab" aria-controls="home">Analytics</a>
      <a class="list-group-item list-group-item-action" id="list-docs-list" data-toggle="list" href="#list-docs" role="tab" aria-controls="home">Documents</a>
      <a class="list-group-item list-group-item-action" id="list-predict-list" data-toggle="list" href="#list-predict" role="tab">Disease Prediction</a>
    </div><br>
  </div>
  <div class="col-md-8" style="margin-top: 3%;">
    <div class="tab-content" id="nav-tabContent" style="width: 950px;">

      <!-- Analytics Section -->
      <div class="tab-pane fade" id="list-analytics" role="tabpanel" aria-labelledby="list-analytics-list">
        <div class="container-fluid">
          <div class="card">
            <div class="card-body">
              <h4 class="card-title text-center mb-4">Patient Analytics Dashboard</h4>
              
              <!-- Appointment Tracking with Chart -->
              <div class="row mb-4">
                <div class="col-md-12">
                  <div class="card bg-light">
                    <div class="card-body">
                      <h5 class="card-title text-center mb-4">Appointment Analytics</h5>
                      <div class="row align-items-center">
                        <div class="col-md-6">
                          <div class="chart-container" style="position: relative; height:300px; width:100%">
                            <canvas id="appointmentChart"></canvas>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="row g-3">
                            <?php
                              // Get appointment statistics
                              $appt_query = mysqli_query($con, "SELECT 
                                COUNT(*) as total_appointments,
                                SUM(CASE WHEN userStatus=1 AND doctorStatus=1 THEN 1 ELSE 0 END) as completed_appointments,
                                SUM(CASE WHEN userStatus=0 OR doctorStatus=0 THEN 1 ELSE 0 END) as cancelled_appointments,
                                COUNT(DISTINCT doctor) as unique_doctors
                                FROM appointmenttb WHERE pid='$pid'");
                              $appt_stats = mysqli_fetch_assoc($appt_query);
                              
                              // Calculate completion rate
                              $completion_rate = ($appt_stats['total_appointments'] > 0) ? 
                                round(($appt_stats['completed_appointments'] / $appt_stats['total_appointments']) * 100, 1) : 0;
                            ?>
                            <div class="col-6 mb-3">
                              <div class="stats-box bg-primary text-white rounded shadow-sm">
                                <h6 class="mb-2 text-white-50">Total Appointments</h6>
                                <h3 class="mb-0 fw-bold"><?php echo $appt_stats['total_appointments']; ?></h3>
                              </div>
                            </div>
                            <div class="col-6 mb-3">
                              <div class="stats-box bg-success text-white rounded shadow-sm">
                                <h6 class="mb-2 text-white-50">Completed</h6>
                                <h3 class="mb-0 fw-bold"><?php echo $appt_stats['completed_appointments']; ?></h3>
                              </div>
                            </div>
                            <div class="col-6 mb-3">
                              <div class="stats-box bg-danger text-white rounded shadow-sm">
                                <h6 class="mb-2 text-white-50">Cancelled</h6>
                                <h3 class="mb-0 fw-bold"><?php echo $appt_stats['cancelled_appointments']; ?></h3>
                              </div>
                            </div>
                            <div class="col-6 mb-3">
                              <div class="stats-box bg-info text-white rounded shadow-sm">
                                <h6 class="mb-2 text-white-50">Completion Rate</h6>
                                <h3 class="mb-0 fw-bold"><?php echo $completion_rate; ?>%</h3>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <!-- BMI and Prescription Analysis -->
              <div class="row">
                <div class="col-md-6">
                  <div class="card bg-light h-100 shadow-sm">
                    <div class="card-body">
                      <h5 class="card-title text-center mb-4">BMI Analysis</h5>
                      <div class="text-center mb-4">
                        <div class="chart-container" style="position: relative; height:200px; width:100%">
                          <canvas id="bmiChart"></canvas>
                        </div>
                      </div>
                      <?php
                        $health_query = mysqli_query($con, "SELECT * FROM patient_health_details WHERE pid='$pid'");
                        if($health_info = mysqli_fetch_array($health_query)) {
                          $height_m = $health_info['height'] / 100;
                          $bmi = round($health_info['weight'] / ($height_m * $height_m), 1);
                          
                          // BMI Category and recommendations
                          $bmi_category = "";
                          $recommendations = "";
                          if($bmi < 18.5) {
                            $bmi_category = "Underweight";
                            $recommendations = "Consider increasing caloric intake and strength training";
                          } else if($bmi < 25) {
                            $bmi_category = "Normal";
                            $recommendations = "Maintain current healthy lifestyle";
                          } else if($bmi < 30) {
                            $bmi_category = "Overweight";
                            $recommendations = "Focus on balanced diet and regular exercise";
                          } else {
                            $bmi_category = "Obese";
                            $recommendations = "Consult with healthcare provider for weight management plan";
                          }
                      ?>
                      <div class="bmi-stats">
                        <div class="text-center mb-3">
                          <h4 class="mb-2"><?php echo $bmi; ?></h4>
                          <span class="badge badge-pill badge-<?php 
                            echo ($bmi_category == 'Normal') ? 'success' : 
                                (($bmi_category == 'Underweight') ? 'warning' : 'danger'); 
                          ?> px-3 py-2">
                            <?php echo $bmi_category; ?>
                          </span>
                        </div>
                        <div class="alert alert-info mb-0">
                          <strong>Recommendation:</strong><br>
                          <?php echo $recommendations; ?>
                        </div>
                      </div>
                      <?php } else { ?>
                      <div class="text-center">
                        <p class="text-muted">No BMI data available. Please update your health details.</p>
                      </div>
                      <?php } ?>
                    </div>
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="card bg-light h-100 shadow-sm">
                    <div class="card-body">
                      <h5 class="card-title text-center mb-4">Prescription Analytics</h5>
                      <div class="chart-container mb-4" style="position: relative; height:200px; width:100%">
                        <canvas id="prescriptionChart"></canvas>
                      </div>
                      <div class="prescription-stats">
                        <?php
                          $pres_query = mysqli_query($con, "SELECT 
                            COUNT(*) as total_prescriptions,
                            COUNT(DISTINCT doctor) as unique_doctors,
                            GROUP_CONCAT(DISTINCT disease) as conditions,
                            MAX(appdate) as last_prescription
                            FROM prestb WHERE pid='$pid'");
                          $pres_stats = mysqli_fetch_assoc($pres_query);
                        ?>
                        <div class="row text-center">
                          <div class="col-6 mb-3">
                            <div class="p-3 bg-light rounded border">
                              <h6 class="text-muted mb-1">Total Prescriptions</h6>
                              <h4 class="mb-0"><?php echo $pres_stats['total_prescriptions']; ?></h4>
                            </div>
                          </div>
                          <div class="col-6 mb-3">
                            <div class="p-3 bg-light rounded border">
                              <h6 class="text-muted mb-1">Doctors Consulted</h6>
                              <h4 class="mb-0"><?php echo $pres_stats['unique_doctors']; ?></h4>
                            </div>
                          </div>
                        </div>
                        <div class="mt-3">
                          <p class="mb-2"><strong>Conditions Treated:</strong><br>
                            <span class="text-muted"><?php echo $pres_stats['conditions'] ? $pres_stats['conditions'] : 'None'; ?></span>
                          </p>
                          <p class="mb-0"><strong>Last Prescription:</strong><br>
                            <span class="text-muted"><?php echo $pres_stats['last_prescription'] ? date('d-m-Y', strtotime($pres_stats['last_prescription'])) : 'None'; ?></span>
                          </p>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Document Management Section -->
      <div class="tab-pane fade" id="list-docs" role="tabpanel" aria-labelledby="list-docs-list">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Document Management</h4>
                
                <!-- Upload Document Form -->
                <div class="mb-4">
                    <h5>Upload New Document</h5>
                    <form action="document_handler.php" method="post" enctype="multipart/form-data" class="form-group">
                        <input type="hidden" name="pid" value="<?php echo $pid; ?>">
                        <input type="hidden" name="uploaded_by" value="patient">
                        
                        <div class="form-group">
                            <label for="document">Select Document (PDF, JPEG, PNG, DOC):</label>
                            <input type="file" class="form-control-file" id="document" name="document" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="description">Description:</label>
                            <textarea class="form-control" id="description" name="description" rows="2" required></textarea>
                        </div>
                        
                        <button type="submit" name="upload_document" class="btn btn-primary">Upload Document</button>
                    </form>
                </div>
                
                <!-- Documents List -->
                <div>
                    <h5>My Documents</h5>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Document Name</th>
                                    <th>Type</th>
                                    <th>Uploaded By</th>
                                    <th>Upload Date</th>
                                    <th>Description</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $docs_query = mysqli_query($con, "SELECT * FROM documents WHERE pid='$pid' ORDER BY upload_date DESC");
                                while($doc = mysqli_fetch_array($docs_query)) {
                                    $doc_type = explode('/', $doc['document_type'])[1];
                                    echo "<tr>
                                        <td>{$doc['document_name']}</td>
                                        <td>{$doc_type}</td>
                                        <td>{$doc['uploaded_by']}</td>
                                        <td>" . date('Y-m-d H:i', strtotime($doc['upload_date'])) . "</td>
                                        <td>{$doc['description']}</td>
                                        <td>
                                            <a href='document_handler.php?download={$doc['id']}' class='btn btn-sm btn-info'>Download</a>
                                            " . ($doc['uploaded_by'] == 'patient' ? 
                                            "<a href='document_handler.php?delete={$doc['id']}' class='btn btn-sm btn-danger' onclick='return confirm(\"Are you sure you want to delete this document?\")'>Delete</a>" 
                                            : "") . "
                                        </td>
                                    </tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
      </div>

      <!-- Dashboard Section -->
      <div class="tab-pane fade show active" id="list-dash" role="tabpanel" aria-labelledby="list-dash-list">
        <div class="container-fluid container-fullw bg-white">
          <div class="row">
            <!-- Appointments Panel -->
            <div class="col-sm-4 mb-4">
              <div class="panel panel-white no-radius text-center shadow-sm">
                <div class="panel-body">
                  <span class="fa-stack fa-2x"> 
                    <i class="fa fa-square fa-stack-2x text-primary"></i> 
                    <i class="fa fa-calendar fa-stack-1x fa-inverse"></i> 
                  </span>
                  <h4 class="StepTitle" style="margin-top: 5%;"> Appointments</h4>
                  <p class="links cl-effect-1">
                    <a href="#list-home">
                      Book New Appointment
                    </a>
                    <br>
                    <a href="#app-hist">
                      View Appointment History
                    </a>
                  </p>
                </div>
              </div>
            </div>

            <!-- Health Records Panel -->
            <div class="col-sm-4 mb-4">
              <div class="panel panel-white no-radius text-center shadow-sm">
                <div class="panel-body">
                  <span class="fa-stack fa-2x"> 
                    <i class="fa fa-square fa-stack-2x text-primary"></i> 
                    <i class="fa fa-heartbeat fa-stack-1x fa-inverse"></i> 
                  </span>
                  <h4 class="StepTitle" style="margin-top: 5%;"> Health Records</h4>
                  <?php
                  $health_query = mysqli_query($con, "SELECT * FROM patient_health_details WHERE pid='$pid'");
                  if($health_info = mysqli_fetch_array($health_query)) {
                    $bmi = 0;
                    if($health_info['height'] > 0) {
                      $height_m = $health_info['height'] / 100;
                      $bmi = round($health_info['weight'] / ($height_m * $height_m), 1);
                    }
                  ?>
                  <div class="health-summary text-left p-3">
                    <p><strong>BMI:</strong> <?php echo $bmi; ?> 
                      (<?php 
                      if($bmi < 18.5) echo "Underweight";
                      else if($bmi < 25) echo "Normal";
                      else if($bmi < 30) echo "Overweight";
                      else echo "Obese";
                      ?>)
                    </p>
                    <p><strong>Next Checkup:</strong> 
                      <?php 
                      $next_checkup = strtotime("+3 months", strtotime($health_info['last_updated']));
                      echo date("Y-m-d", $next_checkup);
                      ?>
                    </p>
                  </div>
                  <?php } ?>
                  <p class="links cl-effect-1">
                    <a href="#list-health">
                      View/Update Health Details
                    </a>
                  </p>
                </div>
              </div>
            </div>

            <!-- Prescriptions Panel -->
            <div class="col-sm-4 mb-4">
              <div class="panel panel-white no-radius text-center shadow-sm">
                <div class="panel-body">
                  <span class="fa-stack fa-2x"> 
                    <i class="fa fa-square fa-stack-2x text-primary"></i> 
                    <i class="fa fa-list-alt fa-stack-1x fa-inverse"></i> 
                  </span>
                  <h4 class="StepTitle" style="margin-top: 5%;"> Prescriptions</h4>
                  <?php
                  $pres_query = mysqli_query($con, "SELECT COUNT(*) as total FROM prestb WHERE pid='$pid'");
                  $pres_count = mysqli_fetch_assoc($pres_query)['total'];
                  ?>
                  <p class="text-muted">Total Prescriptions: <?php echo $pres_count; ?></p>
                  <p class="links cl-effect-1">
                    <a href="#list-pres">
                      View Prescriptions & Bills
                    </a>
                  </p>
                </div>
              </div>
            </div>

            <!-- Analytics Panel -->
            <div class="col-sm-4 mb-4">
              <div class="panel panel-white no-radius text-center shadow-sm">
                <div class="panel-body">
                  <span class="fa-stack fa-2x"> 
                    <i class="fa fa-square fa-stack-2x text-primary"></i> 
                    <i class="fa fa-bar-chart fa-stack-1x fa-inverse"></i> 
                  </span>
                  <h4 class="StepTitle" style="margin-top: 5%;"> Analytics</h4>
                  <?php
                  $total_visits = mysqli_fetch_assoc(mysqli_query($con, 
                    "SELECT COUNT(*) as total FROM appointmenttb 
                     WHERE pid='$pid' AND userStatus=1 AND doctorStatus=1"))['total'];
                  ?>
                  <p class="text-muted">Total Visits: <?php echo $total_visits; ?></p>
                  <p class="links cl-effect-1">
                    <a href="#list-analytics">
                      View Health Analytics
                    </a>
                  </p>
                </div>
              </div>
            </div>

            <!-- Documents Panel -->
            <div class="col-sm-4 mb-4">
              <div class="panel panel-white no-radius text-center shadow-sm">
                <div class="panel-body">
                  <span class="fa-stack fa-2x"> 
                    <i class="fa fa-square fa-stack-2x text-primary"></i> 
                    <i class="fa fa-file-text fa-stack-1x fa-inverse"></i> 
                  </span>
                  <h4 class="StepTitle" style="margin-top: 5%;"> Documents</h4>
                  <?php
                  $docs_query = mysqli_query($con, "SELECT COUNT(*) as total FROM documents WHERE pid='$pid'");
                  $docs_count = mysqli_fetch_assoc($docs_query)['total'];
                  ?>
                  <p class="text-muted">Uploaded Documents: <?php echo $docs_count; ?></p>
                  <p class="links cl-effect-1">
                    <a href="#list-docs">
                      Manage Documents
                    </a>
                  </p>
                </div>
              </div>
            </div>

            <!-- Chat Support Panel -->
            <div class="col-sm-4 mb-4">
              <div class="panel panel-white no-radius text-center shadow-sm">
                <div class="panel-body">
                  <span class="fa-stack fa-2x"> 
                    <i class="fa fa-square fa-stack-2x text-primary"></i> 
                    <i class="fa fa-comments fa-stack-1x fa-inverse"></i> 
                  </span>
                  <h4 class="StepTitle" style="margin-top: 5%;"> Support</h4>
                  <p class="text-muted">24/7 Chat Support Available</p>
                  <p class="links cl-effect-1">
                    <a href="javascript:void(0)" onclick="window.open('https://hospital-management-system-chatbot.streamlit.app/', '_blank')">
                      Chat with Support
                    </a>
                  </p>
                </div>
              </div>
            </div>

            <!-- Health Check Panel -->
            <div class="col-sm-4 mb-4">
              <div class="panel panel-white no-radius text-center shadow-sm">
                <div class="panel-body">
                  <span class="fa-stack fa-2x"> 
                    <i class="fa fa-square fa-stack-2x text-primary"></i> 
                    <i class="fa fa-stethoscope fa-stack-1x fa-inverse"></i> 
                  </span>
                  <h4 class="StepTitle" style="margin-top: 5%;">AI Health Check</h4>
                  <p class="text-muted">Multiple Disease Prediction System</p>
                  <p class="links cl-effect-1">
                    <a href="https://multiple-disease-prediction-hms.streamlit.app/" target="_blank">
                      Check Your Health Now
                    </a>
                  </p>
                  <div class="small mt-2">
                    <span class="text-muted">Analyze your risk for multiple conditions:</span>
                    <ul class="list-unstyled mt-2">
                      <li><i class="fa fa-check-circle text-success"></i> Diabetes</li>
                      <li><i class="fa fa-check-circle text-success"></i> Heart Disease</li>
                      <li><i class="fa fa-check-circle text-success"></i> Liver Disease</li>
                      <li><i class="fa fa-check-circle text-success"></i> And more...</li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>

          </div>
        </div>
      </div>

      <div class="tab-pane fade" id="list-home" role="tabpanel" aria-labelledby="list-home-list">
        <div class="container-fluid">
          <div class="card">
            <div class="card-body">
              <center><h4>Create an appointment</h4></center><br>
              <form class="form-group" method="post" action="admin-panel.php" id="appointmentForm">
                <div class="row">
                  
                  <!-- <?php

                        $con=mysqli_connect("localhost","root","","myhmsdb");
                        $query=mysqli_query($con,"select username,spec from doctb");
                        $docarray = array();
                          while($row =mysqli_fetch_assoc($query))
                          {
                              $docarray[] = $row;
                          }
                          echo json_encode($docarray);

                  ?> -->
        

                    <div class="col-md-4">
                          <label for="spec">Specialization:</label>
                        </div>
                        <div class="col-md-8">
                          <select name="spec" class="form-control" id="spec">
                              <option value="" disabled selected>Select Specialization</option>
                              <?php 
                              display_specs();
                              ?>
                          </select>
                        </div>

                        <br><br>

                        <script>
                      document.getElementById('spec').onchange = function foo() {
                        let spec = this.value;   
                        console.log(spec)
                        let docs = [...document.getElementById('doctor').options];
                        
                        docs.forEach((el, ind, arr)=>{
                          arr[ind].setAttribute("style","");
                          if (el.getAttribute("data-spec") != spec ) {
                            arr[ind].setAttribute("style","display: none");
                          }
                        });
                      };

                  </script>

              <div class="col-md-4"><label for="doctor">Doctors:</label></div>
                <div class="col-md-8">
                    <select name="doctor" class="form-control" id="doctor" required="required">
                      <option value="" disabled selected>Select Doctor</option>
                
                      <?php display_docs(); ?>
                    </select>
                  </div><br/><br/> 


                        <script>
              document.getElementById('doctor').onchange = function updateFees(e) {
                var selection = document.querySelector(`[value=${this.value}]`).getAttribute('data-value');
                document.getElementById('docFees').value = selection;
              };
            </script>

                  
                  

                  
                        <!-- <div class="col-md-4"><label for="doctor">Doctors:</label></div>
                                <div class="col-md-8">
                                    <select name="doctor" class="form-control" id="doctor1" required="required">
                                      <option value="" disabled selected>Select Doctor</option>
                                      
                                    </select>
                                </div>
                                <br><br> -->

                                <!-- <script>
                                  document.getElementById("spec").onchange = function updateSpecs(event) {
                                      var selected = document.querySelector(`[data-value=${this.value}]`).getAttribute("value");
                                      console.log(selected);

                                      var options = document.getElementById("doctor1").querySelectorAll("option");

                                      for (i = 0; i < options.length; i++) {
                                        var currentOption = options[i];
                                        var category = options[i].getAttribute("data-spec");

                                        if (category == selected) {
                                          currentOption.style.display = "block";
                                        } else {
                                          currentOption.style.display = "none";
                                        }
                                      }
                                    }
                                </script> -->

                        
                    <!-- <script>
                    let data = 
                
              document.getElementById('spec').onchange = function updateSpecs(e) {
                let values = data.filter(obj => obj.spec == this.value).map(o => o.username);   
                document.getElementById('doctor1').value = document.querySelector(`[value=${values}]`).getAttribute('data-value');
              };
            </script> -->


                  
                  <div class="col-md-4"><label for="consultancyfees">
                                Consultancy Fees
                              </label></div>
                              <div class="col-md-8">
                              <!-- <div id="docFees">Select a doctor</div> -->
                              <input class="form-control" type="text" name="docFees" id="docFees" readonly="readonly"/>
                  </div><br><br>

                  <div class="col-md-4"><label>Appointment Date</label></div>
                  <div class="col-md-8">
                    <input type="date" class="form-control datepicker" name="appdate" id="appdate" required>
                  </div><br><br>

                  <div class="col-md-4"><label>Available Time Slots</label></div>
                  <div class="col-md-8">
                    <select name="apptime" class="form-control" id="apptime" required="required">
                      <option value="" disabled selected>Select Time</option>
                    </select>
                  </div><br><br>

                  <script>
                  $(document).ready(function() {
                    // When doctor or date changes, update available time slots
                    $('#doctor, #appdate').change(function() {
                      var doctor = $('#doctor').val();
                      var date = $('#appdate').val();
                      
                      if(doctor && date) {
                        // Set minimum date to today
                        var today = new Date().toISOString().split('T')[0];
                        $('#appdate').attr('min', today);
                        
                        // Fetch available time slots
                        $.ajax({
                          url: 'get_available_slots.php',
                          type: 'POST',
                          data: {
                            doctor: doctor,
                            date: date
                          },
                          success: function(response) {
                            $('#apptime').html(response);
                          }
                        });
                      }
                    });
                  });
                  </script>

                  <div class="col-md-4">
                    <input type="submit" name="app-submit" value="Create new entry" class="btn btn-primary" id="submitBtn">
                  </div>
                  <div class="col-md-8"></div>                  
                </div>
              </form>
            </div>
          </div>
        </div><br>
      </div>
      
<div class="tab-pane fade" id="app-hist" role="tabpanel" aria-labelledby="list-pat-list">
        
              <table class="table table-hover">
                <thead>
                  <tr>
                    
                    <th scope="col">Doctor Name</th>
                    <th scope="col">Consultancy Fees</th>
                    <th scope="col">Appointment Date</th>
                    <th scope="col">Appointment Time</th>
                    <th scope="col">Current Status</th>
                    <th scope="col">Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php 

                    $con=mysqli_connect("localhost","root","","myhmsdb");
                    global $con;

                    $query = "select ID,doctor,docFees,appdate,apptime,userStatus,doctorStatus,status from appointmenttb where fname ='$fname' and lname='$lname';";
                    $result = mysqli_query($con,$query);
                    while ($row = mysqli_fetch_array($result)){
              
                      #$fname = $row['fname'];
                      #$lname = $row['lname'];
                      #$email = $row['email'];
                      #$contact = $row['contact'];
                  ?>
                      <tr>
                        <td><?php echo $row['doctor'];?></td>
                        <td><?php echo $row['docFees'];?></td>
                        <td><?php echo $row['appdate'];?></td>
                        <td><?php echo $row['apptime'];?></td>
                        
                          <td>
                    <?php if(($row['userStatus']==1) && ($row['doctorStatus']==1))  
                    {
                      if($row['status'] == 'completed') {
                        echo "Completed";
                      } else {
                        echo "Active";
                      }
                    }
                    if(($row['userStatus']==0) && ($row['doctorStatus']==1))  
                    {
                      echo "Cancelled by You";
                    }

                    if(($row['userStatus']==1) && ($row['doctorStatus']==0))  
                    {
                      echo "Cancelled by Doctor";
                    }
                        ?></td>

                        <td>
                        <?php if(($row['userStatus']==1) && ($row['doctorStatus']==1) && $row['status'] != 'completed')  
                        { ?>

													
	                        <a href="admin-panel.php?ID=<?php echo $row['ID']?>&cancel=update" 
                              onClick="return confirm('Are you sure you want to cancel this appointment ?')"
                              title="Cancel Appointment" tooltip-placement="top" tooltip="Remove"><button class="btn btn-danger">Cancel</button></a>
                          <a href="admin-panel.php?ID=<?php echo $row['ID']?>&complete=update" 
                              onClick="return confirm('Mark this appointment as completed?')"
                              title="Complete Appointment" tooltip-placement="top" tooltip="Complete">
                              <button class="btn btn-success">Complete</button>
                          </a>
	                        <?php } else {
                              if($row['status'] == 'completed') {
                                echo "<span class='badge badge-success'>Completed</span>";
                              } else {
                                echo "Cancelled";
                              }
                            } ?>
                        
                        </td>
                      </tr>
                    <?php } ?>
                </tbody>
              </table>
        <br>
      </div>



      <div class="tab-pane fade" id="list-pres" role="tabpanel" aria-labelledby="list-pres-list">
        
              <table class="table table-hover">
                <thead>
                  <tr>
                    
                    <th scope="col">Doctor Name</th>
                    <th scope="col">Appointment ID</th>
                    <th scope="col">Appointment Date</th>
                    <th scope="col">Appointment Time</th>
                    <th scope="col">Diseases</th>
                    <th scope="col">Allergies</th>
                    <th scope="col">Prescriptions</th>
                    <th scope="col">Bill Payment</th>
                  </tr>
                </thead>
                <tbody>
                  <?php 

                    $con=mysqli_connect("localhost","root","","myhmsdb");
                    global $con;

                    $query = "select doctor,ID,appdate,apptime,disease,allergy,prescription from prestb where pid='$pid';";
                    
                    $result = mysqli_query($con,$query);
                    if(!$result){
                      echo mysqli_error($con);
                    }
                    

                    while ($row = mysqli_fetch_array($result)){
                  ?>
                      <tr>
                        <td><?php echo $row['doctor'];?></td>
                        <td><?php echo $row['ID'];?></td>
                        <td><?php echo $row['appdate'];?></td>
                        <td><?php echo $row['apptime'];?></td>
                        <td><?php echo $row['disease'];?></td>
                        <td><?php echo $row['allergy'];?></td>
                        <td><?php echo $row['prescription'];?></td>
                        <td>
                          <form method="get">
                          <!-- <a href="admin-panel.php?ID=" 
                              onClick=""
                              title="Pay Bill" tooltip-placement="top" tooltip="Remove"><button class="btn btn-success">Pay</button>
                              </a></td> -->

                              <a href="admin-panel.php?ID=<?php echo $row['ID']?>">
                              <input type ="hidden" name="ID" value="<?php echo $row['ID']?>"/>
                              <input type = "submit" onclick="alert('Bill Paid Successfully');" name ="generate_bill" class = "btn btn-success" value="Pay Bill"/>
                              </a>
                              </td>
                              </form>

                    
                      </tr>
                    <?php }
                    ?>
                </tbody>
              </table>
        <br>
      </div>




      <div class="tab-pane fade" id="list-availability" role="tabpanel" aria-labelledby="list-availability-list">
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Doctor Availability</h4>
                    
                    <div class="filter-section">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label>Select Doctor:</label>
                                <select class="form-control" id="doctorSelect" required>
                                    <option value="">Select Doctor</option>
                                    <?php
                                    $doctors_query = mysqli_query($con, "SELECT username FROM doctb ORDER BY username");
                                    while($doctor = mysqli_fetch_array($doctors_query)) {
                                        echo "<option value='{$doctor['username']}'>{$doctor['username']}</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label>Select Date:</label>
                                <input type="date" class="form-control" id="dateSelect" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="btn-group mb-3" role="group">
                                    <button type="button" class="btn btn-primary active" data-filter="all">All Slots</button>
                                    <button type="button" class="btn btn-success" data-filter="available">Available Only</button>
                                    <button type="button" class="btn btn-danger" data-filter="booked">Booked Only</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="legend mb-3">
                        <div class="legend-item">
                            <div class="legend-color" style="background-color: #d4edda;"></div>
                            <span>Available</span>
                        </div>
                        <div class="legend-item">
                            <div class="legend-color" style="background-color: #f8d7da;"></div>
                            <span>Booked</span>
                        </div>
                    </div>

                    <div id="scheduleGrid" class="schedule-grid">
                        <p class="text-center">Please select a doctor and date to view availability.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>




      <div class="tab-pane fade" id="list-health" role="tabpanel" aria-labelledby="list-health-list">
        <div class="card">
            <div class="card-body">
              <div class="row mb-4">
                <div class="col-md-6">
                  <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#healthDetailsModal">
                    View Health Details
                  </button>
                </div>
              </div>
                <h4 class="card-title">Update Health Details</h4>
                <form class="form-group" method="post" action="update_health_details.php">
                    <div class="row">
                        <div class="col-md-4"><label>Age:</label></div>
                        <div class="col-md-8">
                            <input type="number" class="form-control" name="age" required>
                        </div>
                    </div><br>
                    <div class="row">
                        <div class="col-md-4"><label>Blood Group:</label></div>
                        <div class="col-md-8">
                            <select class="form-control" name="blood_group" required>
                                <option value="">Select Blood Group</option>
                                <option value="A+">A+</option>
                                <option value="A-">A-</option>
                                <option value="B+">B+</option>
                                <option value="B-">B-</option>
                                <option value="AB+">AB+</option>
                                <option value="AB-">AB-</option>
                                <option value="O+">O+</option>
                                <option value="O-">O-</option>
                            </select>
                        </div>
                    </div><br>
                    <div class="row">
                        <div class="col-md-4"><label>Weight (kg):</label></div>
                        <div class="col-md-8">
                            <input type="number" step="0.01" class="form-control" name="weight" required>
                        </div>
                    </div><br>
                    <div class="row">
                        <div class="col-md-4"><label>Height (cm):</label></div>
                        <div class="col-md-8"></div></div>
                            <input type="number" step="0.01" class="form-control" name="height" required>
                        </div>
                    </div><br>
                    <div class="row">
                        <div class="col-md-4"><label>Medical Conditions:</label></div>
                        <div class="col-md-8">
                            <textarea class="form-control" name="medical_conditions" rows="3"></textarea>
                        </div>
                    </div><br>
                    <div class="row">
                        <div class="col-md-4"><label>Allergies:</label></div>
                        <div class="col-md-8">
                            <textarea class="form-control" name="allergies" rows="3"></textarea>
                        </div>
                    </div><br>
                    <div class="row">
                        <div class="col-md-4"><label>Current Medications:</label></div>
                        <div class="col-md-8">
                            <textarea class="form-control" name="current_medications" rows="3"></textarea>
                    <input type="submit" name="update_health_details" value="Update Details" class="btn btn-primary">
                </form>
            </div>
        </div>
    </div>

  <!-- Health Details Modal -->
  <div class="modal fade" id="healthDetailsModal" tabindex="-1" role="dialog" aria-labelledby="healthDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="healthDetailsModalLabel">My Health Details</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-6">
              <h6>Personal Information</h6>
              <p><strong>Patient ID:</strong> <?php echo $pid; ?></p>
              <p><strong>Name:</strong> <?php echo $fname . ' ' . $lname; ?></p>
              <p><strong>Gender:</strong> <?php echo $gender; ?></p>
              <p><strong>Email:</strong> <?php echo $email; ?></p>
              <p><strong>Contact:</strong> <?php echo $contact; ?></p>
            </div>
            <div class="col-md-6">
              <h6>Health Information</h6>
              <?php
              // Fetch health details
              $health_query = mysqli_query($con, "SELECT * FROM patient_health_details WHERE pid='$pid'");
              if($health_info = mysqli_fetch_array($health_query)) {
                echo "<p><strong>Age:</strong> ".$health_info['age']."</p>";
                echo "<p><strong>Blood Group:</strong> ".$health_info['blood_group']."</p>";
                echo "<p><strong>Weight:</strong> ".$health_info['weight']." kg</p>";
                echo "<p><strong>Height:</strong> ".$health_info['height']." cm</p>";
                echo "<p><strong>Medical Conditions:</strong> ".$health_info['medical_conditions']."</p>";
                echo "<p><strong>Allergies:</strong> ".$health_info['allergies']."</p>";
                echo "<p><strong>Current Medications:</strong> ".$health_info['current_medications']."</p>";
                echo "<p><strong>Emergency Contact:</strong> ".$health_info['emergency_contact']." (".$health_info['emergency_contact_phone'].")</p>";
              } else {
                echo "<p>No health details available</p>";
              }
              ?>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

      <div class="tab-pane fade" id="list-messages" role="tabpanel" aria-labelledby="list-messages-list">...</div>
      <div class="tab-pane fade" id="list-settings" role="tabpanel" aria-labelledby="list-settings-list">
        <form class="form-group" method="post" action="func.php">
          <label>Doctors name: </label>
          <input type="text" name="name" placeholder="Enter doctors name" class="form-control">
          <br>
          <input type="submit" name="doc_sub" value="Add Doctor" class="btn btn-primary">
        </form>
      </div>
       <div class="tab-pane fade" id="list-attend" role="tabpanel" aria-labelledby="list-attend-list">...</div>
      <div class="tab-pane fade" id="list-predict" role="tabpanel" aria-labelledby="list-predict-list">
  <div class="card">
    <div class="card-body">
      <h4 class="card-title">Check Your Health with AI Prediction</h4>
      <div class="alert alert-info">
        <p><strong>Get early insights about your health conditions.</strong></p>
        <p>Our AI system can help predict various diseases based on your symptoms and medical data:</p>
        <div class="row mt-3">
          <div class="col-md-6">
            <ul class="list-unstyled">
              <li><i class="fa fa-check-circle text-success"></i> Diabetes</li>
              <li><i class="fa fa-check-circle text-success"></i> Heart Disease</li>
              <li><i class="fa fa-check-circle text-success"></i> Parkinson's Disease</li>
            </ul>
          </div>
          <div class="col-md-6">
            <ul class="list-unstyled">
              <li><i class="fa fa-check-circle text-success"></i> Liver Disease</li>
              <li><i class="fa fa-check-circle text-success"></i> Hepatitis</li>
              <li><i class="fa fa-check-circle text-success"></i> Jaundice</li>
            </ul>
          </div>
        </div>
      </div>
      
      <div class="text-center my-4">
        <a href="https://multiple-disease-prediction-hms.streamlit.app/" target="_blank" class="btn btn-primary btn-lg">
          <i class="fa fa-stethoscope"></i> Start Health Check
        </a>
      </div>

      <div class="mt-4">
        <h5>Benefits:</h5>
        <ul>
          <li>Quick preliminary health assessment</li>
          <li>Early detection of potential health issues</li>
          <li>Data-driven insights based on your symptoms</li>
          <li>Easy to use interface</li>
          <li>Instant results</li>
        </ul>
        
        <div class="alert alert-warning mt-3">
          <i class="fa fa-exclamation-triangle"></i> 
          <strong>Important Note:</strong> This tool is for preliminary screening only and should not be used as a replacement for professional medical advice. Please consult with your doctor for proper diagnosis and treatment.
        </div>
      </div>
    </div>
  </div>
</div>
    </div>
  </div>
</div>
   </div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.10.1/sweetalert2.all.min.js"></script>
    <!-- Add Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Charts Initialization -->
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Get the appointment statistics from PHP
        const completedAppointments = <?php echo $appt_stats['completed_appointments'] ?? 0; ?>;
        const cancelledAppointments = <?php echo $appt_stats['cancelled_appointments'] ?? 0; ?>;
        
        // Initialize Appointment Chart
        const appointmentCtx = document.getElementById('appointmentChart');
        if (appointmentCtx) {
            new Chart(appointmentCtx, {
                type: 'doughnut',
                data: {
                    labels: ['Completed', 'Cancelled'],
                    datasets: [{
                        data: [completedAppointments, cancelledAppointments],
                        backgroundColor: ['#28a745', '#dc3545'],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom'
                        }
                    }
                }
            });
        }

        // Initialize BMI Chart
        const bmiCtx = document.getElementById('bmiChart');
        if (bmiCtx) {
            const bmi = <?php echo $bmi ?? 0; ?>;
            new Chart(bmiCtx, {
                type: 'bar',
                data: {
                    labels: ['Your BMI'],
                    datasets: [{
                        label: 'BMI Value',
                        data: [bmi],
                        backgroundColor: [
                            bmi < 18.5 ? '#ffc107' : 
                            bmi < 25 ? '#28a745' : 
                            bmi < 30 ? '#ffc107' : '#dc3545'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            max: 40,
                            ticks: {
                                stepSize: 5
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            display: false
                        }
                    }
                }
            });
        }

        // Initialize Prescription Chart
        const prescriptionCtx = document.getElementById('prescriptionChart');
        if (prescriptionCtx) {
            const totalPrescriptions = <?php echo $pres_stats['total_prescriptions'] ?? 0; ?>;
            const uniqueDoctors = <?php echo $pres_stats['unique_doctors'] ?? 0; ?>;
            
            new Chart(prescriptionCtx, {
                type: 'bar',
                data: {
                    labels: ['Total Prescriptions', 'Doctors Consulted'],
                    datasets: [{
                        label: 'Count',
                        data: [totalPrescriptions, uniqueDoctors],
                        backgroundColor: ['#17a2b8', '#6610f2'],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            display: false
                        }
                    }
                }
            });
        }
    });
    </script>

    <!-- Add this right before the closing body tag -->
    <a href="javascript:void(0)" onclick="window.open('https://hospital-management-system-chatbot.streamlit.app/', '_blank')" class="chat-button" title="Chat with Support">
        <i class="fa fa-comments"></i>
    </a>

    <script>
    $(document).ready(function() {
        // Function to switch tabs
        function switchToTab(tabId) {
            // Hide all tab panes
            $('.tab-pane').removeClass('show active');
            
            // Show the selected tab pane
            $(tabId).addClass('show active');
            
            // Update sidebar active state
            $('.list-group-item').removeClass('active');
            $('.list-group-item[href="' + tabId + '"]').addClass('active');
        }

        // Handle dashboard panel link clicks
        $('.panel-body a').click(function(e) {
            e.preventDefault();
            switchToTab($(this).attr('href'));
        });

        // Handle sidebar tab clicks
        $('.list-group-item').click(function(e) {
            e.preventDefault();
            switchToTab($(this).attr('href'));
        });

        // Show dashboard by default
        $('#list-dash').addClass('show active');
        $('#list-dash-list').addClass('active');
    });
    </script>

    <!-- Add this new tab pane for documents -->
    <div class="tab-pane fade" id="list-docs" role="tabpanel" aria-labelledby="list-docs-list">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Document Management</h4>
                
                <!-- Upload Document Form -->
                <div class="mb-4">
                    <h5>Upload New Document</h5>
                    <form action="document_handler.php" method="post" enctype="multipart/form-data" class="form-group">
                        <input type="hidden" name="pid" value="<?php echo $pid; ?>">
                        <input type="hidden" name="uploaded_by" value="patient">
                        
                        <div class="form-group">
                            <label for="document">Select Document (PDF, JPEG, PNG, DOC):</label>
                            <input type="file" class="form-control-file" id="document" name="document" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="description">Description:</label>
                            <textarea class="form-control" id="description" name="description" rows="2" required></textarea>
                        </div>
                        
                        <button type="submit" name="upload_document" class="btn btn-primary">Upload Document</button>
                    </form>
                </div>
                
                <!-- Documents List -->
                <div>
                    <h5>My Documents</h5>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Document Name</th>
                                    <th>Type</th>
                                    <th>Uploaded By</th>
                                    <th>Upload Date</th>
                                    <th>Description</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $docs_query = mysqli_query($con, "SELECT * FROM documents WHERE pid='$pid' ORDER BY upload_date DESC");
                                while($doc = mysqli_fetch_array($docs_query)) {
                                    $doc_type = explode('/', $doc['document_type'])[1];
                                    echo "<tr>
                                        <td>{$doc['document_name']}</td>
                                        <td>{$doc_type}</td>
                                        <td>{$doc['uploaded_by']}</td>
                                        <td>" . date('Y-m-d H:i', strtotime($doc['upload_date'])) . "</td>
                                        <td>{$doc['description']}</td>
                                        <td>
                                            <a href='document_handler.php?download={$doc['id']}' class='btn btn-sm btn-info'>Download</a>
                                            " . ($doc['uploaded_by'] == 'patient' ? 
                                            "<a href='document_handler.php?delete={$doc['id']}' class='btn btn-sm btn-danger' onclick='return confirm(\"Are you sure you want to delete this document?\")'>Delete</a>" 
                                            : "") . "
                                        </td>
                                    </tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add this script at the bottom of the file -->
    <script>
    document.getElementById('appointmentForm').addEventListener('submit', function(e) {
        // Disable the submit button to prevent double submission
        document.getElementById('submitBtn').disabled = true;
    });

    // Re-enable the submit button when the page is loaded/reloaded
    window.onload = function() {
        document.getElementById('submitBtn').disabled = false;
    }
    </script>

    <!-- Add this script right after the opening <body> tag -->
    <script>
    function clickDiv(id) {
      // Remove the -list suffix if present
      const baseId = id.replace('-list', '');
      
      // Remove active class from all tabs
      document.querySelectorAll('.list-group-item').forEach(item => {
        item.classList.remove('active');
      });
      
      // Hide all tab panes
      document.querySelectorAll('.tab-pane').forEach(pane => {
        pane.classList.remove('show', 'active');
      });
      
      // Show selected tab pane
      const targetPane = document.getElementById(baseId);
      if (targetPane) {
        targetPane.classList.add('show', 'active');
        
        // Find and activate the corresponding tab
        const tabId = baseId + '-list';
        const tab = document.getElementById(tabId);
        if (tab) {
          tab.classList.add('active');
        }
        
        // Scroll to the section
        targetPane.scrollIntoView({ behavior: 'smooth' });
      }
    }

    // Add event listeners when document is ready
    document.addEventListener('DOMContentLoaded', function() {
      // Handle tab switching from the sidebar
      document.querySelectorAll('.list-group-item').forEach(item => {
        item.addEventListener('click', function(e) {
          e.preventDefault();
          const href = this.getAttribute('href');
          clickDiv(href);
        });
      });
      
      // Handle tab switching from dashboard links
      document.querySelectorAll('.panel-body a[onclick]').forEach(link => {
        link.addEventListener('click', function(e) {
          e.preventDefault();
          const targetId = this.getAttribute('onclick').match(/'([^']+)'/)[1];
          clickDiv(targetId);
        });
      });
    });
    </script>

    <!-- Add this to ensure Bootstrap tab functionality works -->
    <script>
    $(document).ready(function() {
        // Initialize Bootstrap tabs
        $('[data-toggle="tab"]').on('shown.bs.tab', function (e) {
            // Update sidebar active state
            $('.list-group-item').removeClass('active');
            $('a[href="' + $(e.target).attr('href') + '"]').addClass('active');
        });
    });
    </script>

    <!-- Add this CSS in the head section -->
    <style>
      .availability-table th, .availability-table td {
        text-align: center;
        padding: 10px;
        font-size: 0.9em;
      }
      .schedule-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
        gap: 10px;
        padding: 15px;
      }
      .time-block {
        background: #fff;
        border: 1px solid #ddd;
        padding: 10px;
        border-radius: 5px;
        text-align: center;
        transition: all 0.3s ease;
      }
      .time-block:hover {
        transform: translateY(-2px);
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
      }
      .time-block .time {
        font-weight: bold;
        margin-bottom: 5px;
      }
      .time-block .doctor {
        font-size: 0.9em;
        color: #666;
      }
      .time-block .status {
        margin-top: 5px;
        font-size: 0.8em;
        font-weight: bold;
      }
      .time-block.available {
        background-color: #d4edda;
        border-color: #c3e6cb;
      }
      .time-block.booked {
        background-color: #f8d7da;
        border-color: #f5c6cb;
      }
      .time-block.available .status {
        color: #155724;
      }
      .time-block.booked .status {
        color: #721c24;
      }
      .legend {
        display: flex;
        justify-content: center;
        gap: 20px;
        margin: 15px 0;
        padding: 10px;
        background: #f8f9fa;
        border-radius: 5px;
      }
      .legend-item {
        display: flex;
        align-items: center;
        gap: 5px;
      }
      .legend-color {
        width: 24px;
        height: 24px;
        border-radius: 4px;
      }
      .filter-section {
        background: #f8f9fa;
        padding: 20px;
        border-radius: 8px;
        margin-bottom: 20px;
      }
      .btn-group .btn {
        margin-right: 5px;
      }
      .btn-group .btn.active {
        box-shadow: 0 0 0 3px rgba(0,123,255,0.3);
      }
      .schedule-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
        gap: 15px;
        padding: 15px;
      }
      .time-block {
        background: #fff;
        border: 1px solid #ddd;
        padding: 15px;
        border-radius: 8px;
        text-align: center;
        transition: all 0.3s ease;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
      }
      .time-block:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
      }
      .time-block .time {
        font-size: 1.1em;
        font-weight: bold;
        margin-bottom: 8px;
      }
      .time-block .doctor {
        color: #666;
        margin-bottom: 8px;
        font-size: 0.9em;
      }
      .time-block .status {
        font-size: 0.9em;
        font-weight: 500;
        padding: 4px 8px;
        border-radius: 4px;
        display: inline-block;
      }
      .time-block.available {
        background-color: #d4edda;
        border-color: #c3e6cb;
      }
      .time-block.booked {
        background-color: #f8d7da;
        border-color: #f5c6cb;
      }
      .time-block.available .status {
        background-color: #28a745;
        color: white;
      }
      .time-block.booked .status {
        background-color: #dc3545;
        color: white;
      }
      .legend {
        display: flex;
        justify-content: center;
        gap: 30px;
        padding: 15px;
        background: #f8f9fa;
        border-radius: 8px;
      }
      .legend-item {
        display: flex;
        align-items: center;
        gap: 8px;
      }
      .legend-color {
        width: 24px;
        height: 24px;
        border-radius: 4px;
      }
    </style>

    <!-- Add this JavaScript before the closing body tag -->
    <script>
    $(document).ready(function() {
      function updateAvailabilityTable() {
        var doctor = $('#doctorSelect').val();
        var week = $('#weekSelect').val();
        
        if(doctor && week) {
          $.ajax({
            url: 'get_weekly_availability.php',
            type: 'POST',
            data: {
              doctor: doctor,
              week: week
            },
            success: function(response) {
              $('#availabilityBody').html(response);
            }
          });
        }
      }
      
      $('#doctorSelect, #weekSelect').change(updateAvailabilityTable);
      
      // Set default week to current week
      var now = new Date();
      var year = now.getFullYear();
      var weekNum = Math.ceil((now - new Date(year, 0, 1) + 1) / 86400000 / 7);
      $('#weekSelect').val(year + '-W' + (weekNum < 10 ? '0' + weekNum : weekNum));
    });
    </script>

    <script>
    $(document).ready(function() {
        // Set default date to today
        var today = new Date().toISOString().split('T')[0];
        $('#dateSelect').val(today);
        $('#dateSelect').attr('min', today);

        function updateSchedule() {
            var doctor = $('#doctorSelect').val();
            var date = $('#dateSelect').val();
            var status = $('.btn-group .btn.active').data('filter') || 'all';

            if (!doctor) {
                $('#scheduleGrid').html('<p class="text-center">Please select a doctor to view availability.</p>');
                return;
            }

            if (!date) {
                $('#scheduleGrid').html('<p class="text-center">Please select a date to view availability.</p>');
                return;
            }

            $('#scheduleGrid').html('<p class="text-center">Loading schedule...</p>');

            $.ajax({
                url: window.location.origin + '/HMS/get_patient_doctor_schedule.php',
                type: 'POST',
                data: {
                    doctor: doctor,
                    date: date,
                    status: status
                },
                success: function(response) {
                    $('#scheduleGrid').html(response);
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                    $('#scheduleGrid').html('<p class="text-danger">Error loading schedule. Please try again.</p>');
                }
            });
        }

        // Update schedule when filters change
        $('#doctorSelect, #dateSelect').change(updateSchedule);

        // Handle filter button clicks
        $('.btn-group .btn').click(function() {
            $('.btn-group .btn').removeClass('active');
            $(this).addClass('active');
            updateSchedule();
        });

        // Initial message
        if (!$('#doctorSelect').val()) {
            $('#scheduleGrid').html('<p class="text-center">Please select a doctor and date to view availability.</p>');
        } else {
            updateSchedule();
        }
    });
    </script>
  </body>
</html>
