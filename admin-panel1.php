<!DOCTYPE html>
<?php 
$con=mysqli_connect("localhost","root","","myhmsdb");

include('newfunc.php');

if(isset($_POST['docsub']))
{
  $doctor=$_POST['doctor'];
  $dpassword=$_POST['dpassword'];
  $demail=$_POST['demail'];
  $spec=$_POST['special'];
  $docFees=$_POST['docFees'];
  $query="insert into doctb(username,password,email,spec,docFees)values('$doctor','$dpassword','$demail','$spec','$docFees')";
  $result=mysqli_query($con,$query);
  if($result)
    {
      echo "<script>alert('Doctor added successfully!');</script>";
  }
}


if(isset($_POST['docsub1']))
{
  $demail=$_POST['demail'];
  $query="delete from doctb where email='$demail';";
  $result=mysqli_query($con,$query);
  if($result)
    {
      echo "<script>alert('Doctor removed successfully!');</script>";
  }
  else{
    echo "<script>alert('Unable to delete!');</script>";
  }
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
    <link href="https://fonts.googleapis.com/css?family=IBM+Plex+Sans&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.10.1/sweetalert2.all.min.js"></script>
    <style>
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

    .btn-primary {
        background-color: #3c50c1;
        border-color: #3c50c1;
    }

    .col-md-4 {
        max-width: 25%;
        padding: 10px;
    }

    .panel {
        margin-bottom: 20px;
        background-color: #fff;
        border: 1px solid transparent;
        border-radius: 4px;
        box-shadow: 0 1px 3px rgba(0,0,0,.12), 0 1px 2px rgba(0,0,0,.24);
    }

    .panel-white {
        border: none;
        padding: 20px;
    }

    .panel-body {
        padding: 15px;
        text-align: center;
    }

    .StepTitle {
        margin-top: 15px !important;
        margin-bottom: 15px;
        font-size: 18px;
        font-weight: 500;
    }

    .chart-container {
        background: white;
        padding: 15px;
        border-radius: 4px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.12);
        margin-bottom: 20px;
        height: 300px;
    }

    .chart-title {
        font-size: 18px;
        font-weight: 500;
        margin-bottom: 15px;
        color: #333;
        text-align: center;
    }

    .row {
        margin-right: -15px;
        margin-left: -15px;
        display: flex;
        flex-wrap: wrap;
    }

    .card {
        margin-bottom: 20px;
        border: none;
        box-shadow: 0 1px 3px rgba(0,0,0,.12), 0 1px 2px rgba(0,0,0,.24);
    }

    .card-body {
        padding: 20px;
    }

    .table-responsive {
        margin-top: 15px;
        overflow-x: auto;
    }

    .tab-content {
        padding: 20px;
        background: #fff;
        border-radius: 4px;
        box-shadow: 0 1px 3px rgba(0,0,0,.12), 0 1px 2px rgba(0,0,0,.24);
    }

    .tab-pane {
        padding: 15px;
    }

    .list-group {
        margin-bottom: 20px;
        box-shadow: 0 1px 3px rgba(0,0,0,.12), 0 1px 2px rgba(0,0,0,.24);
    }

    .container-fluid {
        padding-right: 30px;
        padding-left: 30px;
    }

    @media (max-width: 768px) {
        .col-md-4 {
            max-width: 100% !important;
        }
        
        .row {
            margin-right: 0;
            margin-left: 0;
        }
    }

    /* Add chat button styles */
    .chat-button {
        position: fixed;
        bottom: 20px;
        right: 20px;
        background: #342ac1;
        color: white;
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
    }
    .chat-button:hover {
        transform: scale(1.1);
        background: #3c50c1;
    }

    .search-container {
        margin-bottom: 20px;
        padding: 15px;
        background: #f8f9fa;
        border-radius: 4px;
    }
    
    .search-row {
        display: flex;
        align-items: center;
        margin: 0 -5px;
    }
    
    .search-row > div {
        padding: 0 5px;
        margin-bottom: 0;
    }
    
    .search-input {
        flex: 1;
    }
    
    .search-button {
        width: auto;
    }

    .stats-card {
        background: #fff;
        border-radius: 5px;
        padding: 20px;
        margin-bottom: 20px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.12);
    }

    .stats-card h5 {
        margin-bottom: 15px;
        color: #333;
    }

    .stats-card h2 {
        margin: 0;
        color: #007bff;
    }
    </style>
      <nav class="navbar navbar-expand-lg navbar-dark bg-primary fixed-top">

        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <a class="navbar-brand" href="#"><i class="fa fa-user-plus" aria-hidden="true"></i> The Care Crew</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <script >
    var check = function() {
  if (document.getElementById('dpassword').value ==
    document.getElementById('cdpassword').value) {
    document.getElementById('message').style.color = '#5dd05d';
    document.getElementById('message').innerHTML = 'Matched';
  } else {
    document.getElementById('message').style.color = '#f55252';
    document.getElementById('message').innerHTML = 'Not Matching';
  }
}

    function alphaOnly(event) {
  var key = event.keyCode;
  return ((key >= 65 && key <= 90) || key == 8 || key == 32);
};

    function clickDiv(id) {
      var element = document.querySelector(id);
      if (element) {
        $(element).tab('show');
      }
    }
  </script>

  <style >
    .bg-primary {
    background: -webkit-linear-gradient(left, #3931af, #00c6ff);
}

.col-md-4{
  max-width:20% !important;
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

#cpass {
  display: -webkit-box;
}

#list-app{
  font-size:15px;
}

.btn-primary{
  background-color: #3c50c1;
  border-color: #3c50c1;
}
  </style>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
     <ul class="navbar-nav mr-auto">
       <li class="nav-item">
        <a class="nav-link" href="logout1.php"><i class="fa fa-sign-out" aria-hidden="true"></i>Logout</a>
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
  </style>
  <body style="padding-top:50px;">
   <div class="container-fluid" style="margin-top:50px;">
    <h3 style = "margin-left: 40%; padding-bottom: 20px;font-family: 'IBM Plex Sans', sans-serif;"> WELCOME RECEPTIONIST </h3>
    <div class="row">
  <div class="col-md-4" style="max-width:25%;margin-top: 3%;">
    <div class="list-group" id="list-tab" role="tablist">
      <a class="list-group-item list-group-item-action active" id="list-dash-list" data-toggle="list" href="#list-dash" role="tab" aria-controls="home">
        <i class="fa fa-th-large"></i> Dashboard
      </a>
      <a class="list-group-item list-group-item-action" href="#list-doc" id="list-doc-list" role="tab" data-toggle="list" aria-controls="home">
        <i class="fa fa-user-md"></i> Doctor List
      </a>
      <a class="list-group-item list-group-item-action" href="#list-pat" id="list-pat-list" role="tab" data-toggle="list" aria-controls="home">
        <i class="fa fa-users"></i> Patient List
      </a>
      <a class="list-group-item list-group-item-action" href="#list-app" id="list-app-list" role="tab" data-toggle="list" aria-controls="home">
        <i class="fa fa-calendar"></i> Appointment Details
      </a>
      <a class="list-group-item list-group-item-action" href="#list-pres" id="list-pres-list" role="tab" data-toggle="list" aria-controls="home">
        <i class="fa fa-file-text"></i> Prescription List
      </a>
      <a class="list-group-item list-group-item-action" href="#list-settings" id="list-adoc-list" role="tab" data-toggle="list" aria-controls="home">
        <i class="fa fa-user-plus"></i> Add Doctor
      </a>
      <a class="list-group-item list-group-item-action" href="#list-settings1" id="list-ddoc-list" role="tab" data-toggle="list" aria-controls="home">
        <i class="fa fa-user-times"></i> Delete Doctor
      </a>
      <a class="list-group-item list-group-item-action" href="#list-mes" id="list-mes-list" role="tab" data-toggle="list" aria-controls="home">
        <i class="fa fa-comments"></i> Queries
      </a>
      <a class="list-group-item list-group-item-action" href="#list-analytics" id="list-analytics-list" role="tab" data-toggle="list">
        <i class="fa fa-line-chart"></i> Analytics Dashboard
      </a>
      <a class="list-group-item list-group-item-action" href="#list-revenue" id="list-revenue-list" role="tab" data-toggle="list">
        <i class="fa fa-money"></i> Revenue Reports
      </a>
      <a class="list-group-item list-group-item-action" href="#list-statistics" id="list-statistics-list" role="tab" data-toggle="list">
        <i class="fa fa-bar-chart"></i> Patient Statistics
      </a>
      <a class="list-group-item list-group-item-action" href="#list-docs" id="list-docs-list" role="tab" data-toggle="list">
        <i class="fa fa-file"></i> Document Management
      </a>
      <a class="list-group-item list-group-item-action" href="HIMS/adminmainpage.php" target="_blank">
        <i class="fa fa-hospital-o"></i> Inventory Management
      </a>
      <a class="list-group-item list-group-item-action" id="list-predict-list" data-toggle="list" href="#list-predict" role="tab">
        <i class="fa fa-stethoscope"></i> Disease Prediction
      </a>
      <a class="list-group-item list-group-item-action" id="list-brain-list" data-toggle="list" href="#list-brain" role="tab">
        <i class="fa fa-heartbeat"></i> Brain Tumor Detection
      </a>
    </div><br>
  </div>
  <div class="col-md-8" style="margin-top: 3%;">
    <div class="tab-content" id="nav-tabContent" style="width: 950px;">



      <div class="tab-pane fade show active" id="list-dash" role="tabpanel" aria-labelledby="list-dash-list">
        <div class="container-fluid container-fullw bg-white">
          <div class="row justify-content-center align-items-center">
            <!-- Doctor List Panel -->
            <div class="col-sm-3">
              <div class="panel panel-white no-radius text-center h-100">
                <div class="panel-body">
                  <span class="fa-stack fa-2x"> <i class="fa fa-square fa-stack-2x text-primary"></i> <i class="fa fa-user-md fa-stack-1x fa-inverse"></i> </span>
                  <h4 class="StepTitle" style="margin-top: 5%;">Doctor List</h4>
                  <p class="links cl-effect-1">
                    <a href="#list-doc" onclick="clickDiv('#list-doc-list')">View Doctors</a>
                  </p>
                </div>
              </div>
            </div>

            <!-- Disease Prediction Panel -->
            <div class="col-sm-3">
              <div class="panel panel-white no-radius text-center h-100">
                <div class="panel-body">
                  <span class="fa-stack fa-2x"> 
                    <i class="fa fa-square fa-stack-2x text-primary"></i> 
                    <i class="fa fa-stethoscope fa-stack-1x fa-inverse"></i> 
                  </span>
                  <h4 class="StepTitle" style="margin-top: 5%;">Disease Prediction</h4>
                  <p class="links cl-effect-1">
                    <a href="https://multiple-disease-prediction-hms.streamlit.app/" target="_blank">
                      <i class="fa fa-stethoscope"></i> Launch Prediction
                    </a>
                  </p>
                </div>
              </div>
            </div>

            <!-- Brain Tumor Detection Panel -->
            <div class="col-sm-3">
              <div class="panel panel-white no-radius text-center h-100">
                <div class="panel-body">
                  <span class="fa-stack fa-2x"> 
                    <i class="fa fa-square fa-stack-2x text-primary"></i> 
                    <i class="fa fa-heartbeat fa-stack-1x fa-inverse"></i> 
                  </span>
                  <h4 class="StepTitle" style="margin-top: 5%;">Brain Tumor Detection</h4>
                  <p class="links cl-effect-1">
                    <a href="https://brain-tumor-detection-master.streamlit.app/" target="_blank">
                      <i class="fa fa-heartbeat"></i> Launch Detection
                    </a>
                  </p>
                </div>
              </div>
            </div>

            <!-- Patient List Panel -->
            <div class="col-sm-3">
              <div class="panel panel-white no-radius text-center h-100">
                <div class="panel-body">
                  <span class="fa-stack fa-2x"> <i class="fa fa-square fa-stack-2x text-primary"></i> <i class="fa fa-users fa-stack-1x fa-inverse"></i> </span>
                  <h4 class="StepTitle" style="margin-top: 5%;">Patient List</h4>
                  <p class="links cl-effect-1">
                    <a href="#list-pat" onclick="clickDiv('#list-pat-list')">View Patients</a>
                  </p>
                </div>
              </div>
            </div>
          </div>

          <div class="row justify-content-center align-items-center mt-4">
            <!-- Appointments Panel -->
            <div class="col-sm-3">
              <div class="panel panel-white no-radius text-center h-100">
                <div class="panel-body">
                  <span class="fa-stack fa-2x"> <i class="fa fa-square fa-stack-2x text-primary"></i> <i class="fa fa-calendar fa-stack-1x fa-inverse"></i> </span>
                  <h4 class="StepTitle" style="margin-top: 5%;">Appointments</h4>
                  <p class="links cl-effect-1">
                    <a href="#list-app" onclick="clickDiv('#list-app-list')">View Appointments</a>
                  </p>
                </div>
              </div>
            </div>

            <!-- Prescriptions Panel -->
            <div class="col-sm-3">
              <div class="panel panel-white no-radius text-center h-100">
                <div class="panel-body">
                  <span class="fa-stack fa-2x"> <i class="fa fa-square fa-stack-2x text-primary"></i> <i class="fa fa-file-text fa-stack-1x fa-inverse"></i> </span>
                  <h4 class="StepTitle" style="margin-top: 5%;">Prescriptions</h4>
                  <p class="links cl-effect-1">
                    <a href="#list-pres" onclick="clickDiv('#list-pres-list')">View Prescriptions</a>
                  </p>
                </div>
              </div>
            </div>

            <!-- Analytics Panel -->
            <div class="col-sm-3">
              <div class="panel panel-white no-radius text-center h-100">
                <div class="panel-body">
                  <span class="fa-stack fa-2x"> <i class="fa fa-square fa-stack-2x text-primary"></i> <i class="fa fa-line-chart fa-stack-1x fa-inverse"></i> </span>
                  <h4 class="StepTitle" style="margin-top: 5%;">Analytics</h4>
                  <p class="cl-effect-1">
                    <a href="#list-analytics" onclick="clickDiv('#list-analytics-list')">View Analytics</a>
                  </p>
                </div>
              </div>
            </div>

            <!-- Revenue Panel -->
            <div class="col-sm-3">
              <div class="panel panel-white no-radius text-center h-100">
                <div class="panel-body">
                  <span class="fa-stack fa-2x"> <i class="fa fa-square fa-stack-2x text-primary"></i> <i class="fa fa-money fa-stack-1x fa-inverse"></i> </span>
                  <h4 class="StepTitle" style="margin-top: 5%;">Revenue</h4>
                  <p class="cl-effect-1">
                    <a href="#list-revenue" onclick="clickDiv('#list-revenue-list')">View Revenue</a>
                  </p>
                </div>
              </div>
            </div>
          </div>

          <!-- Add these styles to fix the panel alignment -->
          <style>
            .panel-white {
              height: 100%;
              margin-bottom: 20px;
              background-color: #fff;
              border: 1px solid #e4e5e7;
              border-radius: 4px;
              box-shadow: 0 1px 1px rgba(0, 0, 0, .05);
            }

            .panel-body {
              padding: 20px;
              height: 100%;
              display: flex;
              flex-direction: column;
              justify-content: center;
              align-items: center;
              min-height: 240px;
            }

            .row {
              margin-right: -10px;
              margin-left: -10px;
            }

            .col-sm-3 {
              padding: 10px;
            }

            .StepTitle {
              margin: 15px 0;
              font-size: 18px;
              font-weight: 500;
              color: #333;
              text-align: center;
              min-height: 50px;
              display: flex;
              align-items: center;
              justify-content: center;
            }

            .links a {
              color: #3c50c1;
              text-decoration: none;
              transition: color 0.3s ease;
              display: inline-flex;
              align-items: center;
              gap: 8px;
            }

            .links a:hover {
              color: #2a3890;
              text-decoration: none;
            }

            .fa-stack {
              margin-bottom: 15px;
            }

            .list-group-item i {
              margin-right: 10px;
              width: 20px;
              text-align: center;
            }

            .row.justify-content-center {
              margin-bottom: 30px;
            }

            @media (max-width: 768px) {
              .col-sm-3 {
                width: 50%;
              }
              .panel-body {
                min-height: 200px;
              }
            }

            @media (max-width: 480px) {
              .col-sm-3 {
                width: 100%;
              }
              .panel-body {
                min-height: 180px;
              }
            }
          </style>

          <!-- Continue with the rest of your dashboard panels -->
          <div class="row" style="margin-top: 20px">
            <!-- Patient Statistics Panel -->
            <div class="col-sm-4">
              <div class="panel panel-white no-radius text-center">
                <div class="panel-body">
                  <span class="fa-stack fa-2x"> <i class="fa fa-square fa-stack-2x text-primary"></i> <i class="fa fa-bar-chart fa-stack-1x fa-inverse"></i> </span>
                  <h4 class="StepTitle" style="margin-top: 5%;">Patient Statistics</h4>
                  <p class="cl-effect-1">
                    <a href="#list-statistics" onclick="clickDiv('#list-statistics-list')">View Statistics</a>
                  </p>
                </div>
              </div>
            </div>

            <!-- Documents Panel -->
            <div class="col-sm-4">
              <div class="panel panel-white no-radius text-center">
                <div class="panel-body">
                  <span class="fa-stack fa-2x"> <i class="fa fa-square fa-stack-2x text-primary"></i> <i class="fa fa-file fa-stack-1x fa-inverse"></i> </span>
                  <h4 class="StepTitle" style="margin-top: 5%;">Documents</h4>
                  <p class="links cl-effect-1">
                    <a href="#list-docs" onclick="clickDiv('#list-docs-list')">Manage Documents</a>
                  </p>
                </div>
              </div>
            </div>

            <!-- Inventory Panel -->
            <div class="col-sm-4">
              <div class="panel panel-white no-radius text-center">
                <div class="panel-body">
                  <span class="fa-stack fa-2x"> <i class="fa fa-square fa-stack-2x text-primary"></i> <i class="fa fa-hospital-o fa-stack-1x fa-inverse"></i> </span>
                  <h4 class="StepTitle" style="margin-top: 5%;">Inventory</h4>
                  <p class="links cl-effect-1">
                    <a href="HIMS/adminmainpage.php" target="_blank">Manage Inventory</a>
                  </p>
                </div>
              </div>
            </div>
          </div>

          <div class="row" style="margin-top: 20px">
            <!-- Doctor Management Panel -->
            <div class="col-sm-4">
              <div class="panel panel-white no-radius text-center">
                <div class="panel-body">
                  <span class="fa-stack fa-2x"> <i class="fa fa-square fa-stack-2x text-primary"></i> <i class="fa fa-user-plus fa-stack-1x fa-inverse"></i> </span>
                  <h4 class="StepTitle" style="margin-top: 5%;">Doctor Management</h4>
                  <p class="links cl-effect-1">
                    <a href="#list-settings" onclick="clickDiv('#list-adoc-list')">Add Doctor</a>
                    &nbsp|
                    <a href="#list-settings1" onclick="clickDiv('#list-ddoc-list')">Delete Doctor</a>
                  </p>
                </div>
              </div>
            </div>

            <!-- Queries Panel -->
            <div class="col-sm-4">
              <div class="panel panel-white no-radius text-center">
                <div class="panel-body">
                  <span class="fa-stack fa-2x"> <i class="fa fa-square fa-stack-2x text-primary"></i> <i class="fa fa-question-circle fa-stack-1x fa-inverse"></i> </span>
                  <h4 class="StepTitle" style="margin-top: 5%;">Queries</h4>
                  <p class="links cl-effect-1">
                    <a href="#list-mes" onclick="clickDiv('#list-mes-list')">View Queries</a>
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <script>
      function clickDiv(id) {
        document.querySelector(id).click();
      }
      </script>

      <div class="tab-pane fade" id="list-doc" role="tabpanel" aria-labelledby="list-doc-list">
        <div class="panel panel-primary">
          <div class="panel-heading">
            <h4 class="panel-title">Doctor Management</h4>
          </div>
          <div class="panel-body">
            <div class="search-container">
              <div class="search-row">
                <div class="col-md-3">
                  <select class="form-control" id="doctorSpecFilter">
                    <option value="">All Specializations</option>
                    <option value="General">General</option>
                    <option value="Cardiologist">Cardiologist</option>
                    <option value="Neurologist">Neurologist</option>
                    <option value="Pediatrician">Pediatrician</option>
                  </select>
                </div>
                <div class="col-md-3">
                  <input type="number" class="form-control" id="doctorFeesFilter" placeholder="Max Fees">
                </div>
                <div class="col-md-4 search-input">
                  <input type="text" name="doctor_contact" placeholder="Search by Name or Email" class="form-control">
                </div>
                <div class="col-md-2 search-button">
                  <button type="button" class="btn btn-primary btn-block">Search</button>
                </div>
              </div>
            </div>
            
            <!-- Add Export Buttons -->
            <div class="mb-3">
              <div class="btn-group">
                <button type="button" class="btn btn-success" onclick="exportDoctorList('pdf')">
                  <i class="fa fa-file-pdf-o"></i> Export PDF
                </button>
                <button type="button" class="btn btn-info" onclick="exportDoctorList('csv')">
                  <i class="fa fa-file-excel-o"></i> Export CSV
                </button>
                <button type="button" class="btn btn-warning" onclick="exportDoctorList('excel')">
                  <i class="fa fa-file-excel-o"></i> Export Excel
                </button>
              </div>
            </div>

            <div class="table-responsive">
              <table class="table table-hover" id="doctorTable">
                <thead>
                  <tr>
                    <th scope="col">Doctor Name</th>
                    <th scope="col">Specialization</th>
                    <th scope="col">Email</th>
                    <th scope="col">Password</th>
                    <th scope="col">Fees</th>
                  </tr>
                </thead>
                <tbody>
                  <?php 
                    $query = "select * from doctb";
                    $result = mysqli_query($con,$query);
                    while ($row = mysqli_fetch_array($result)){
                      echo "<tr>
                        <td>{$row['username']}</td>
                        <td>{$row['spec']}</td>
                        <td>{$row['email']}</td>
                        <td>{$row['password']}</td>
                        <td>{$row['docFees']}</td>
                      </tr>";
                    }
                  ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>

    <div class="tab-pane fade" id="list-pat" role="tabpanel" aria-labelledby="list-pat-list">
        <div class="panel panel-primary">
          <div class="panel-heading">
            <h4 class="panel-title">Patient Management</h4>
          </div>
          <div class="panel-body">
            <!-- Add Export Buttons -->
            <div class="mb-3">
              <div class="btn-group">
                <button type="button" class="btn btn-success" onclick="exportPatientList('pdf')">
                  <i class="fa fa-file-pdf-o"></i> Export PDF
                </button>
                <button type="button" class="btn btn-info" onclick="exportPatientList('csv')">
                  <i class="fa fa-file-excel-o"></i> Export CSV
                </button>
                <button type="button" class="btn btn-warning" onclick="exportPatientList('excel')">
                  <i class="fa fa-file-excel-o"></i> Export Excel
                </button>
              </div>
            </div>

            <div class="search-container">
              <div class="search-row">
                <div class="col-md-3">
                  <select class="form-control" id="patientGenderFilter">
                    <option value="">All Genders</option>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                    <option value="Other">Other</option>
                  </select>
                </div>
                <div class="col-md-3">
                  <input type="text" class="form-control" id="patientAgeFilter" placeholder="Age Range (e.g. 20-30)">
                </div>
                <div class="col-md-4 search-input">
                  <input type="text" name="patient_contact" placeholder="Search by Name, Email or Contact" class="form-control">
                </div>
                <div class="col-md-2 search-button">
                  <button type="button" class="btn btn-primary btn-block">Search</button>
                </div>
              </div>
            </div>
            
            <div class="table-responsive">
              <table class="table table-hover">
                <thead>
                  <tr>
                  <th scope="col">Patient ID</th>
                    <th scope="col">First Name</th>
                    <th scope="col">Last Name</th>
                    <th scope="col">Gender</th>
                    <th scope="col">Email</th>
                    <th scope="col">Contact</th>
                    <th scope="col">Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php 
                    $query = "select * from patreg";
                    $result = mysqli_query($con,$query);
                    while ($row = mysqli_fetch_array($result)){
                  ?>
                    <tr>
                      <td><?php echo $row['pid'];?></td>
                      <td><?php echo $row['fname'];?></td>
                      <td><?php echo $row['lname'];?></td>
                      <td><?php echo $row['gender'];?></td>
                      <td><?php echo $row['email'];?></td>
                      <td><?php echo $row['contact'];?></td>
                      <td>
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#patientModal<?php echo $row['pid'];?>">
                          View Details
                        </button>
                      </td>
                    </tr>

                    <!-- Modal for each patient -->
                    <div class="modal fade" id="patientModal<?php echo $row['pid'];?>" tabindex="-1" role="dialog" aria-labelledby="patientModalLabel" aria-hidden="true">
                      <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="patientModalLabel">Patient Details</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body">
                            <div class="row">
                              <div class="col-md-6">
                                <h6>Personal Information</h6>
                                <p><strong>Patient ID:</strong> <?php echo $row['pid'];?></p>
                                <p><strong>Name:</strong> <?php echo $row['fname'].' '.$row['lname'];?></p>
                                <p><strong>Gender:</strong> <?php echo $row['gender'];?></p>
                                <p><strong>Email:</strong> <?php echo $row['email'];?></p>
                                <p><strong>Contact:</strong> <?php echo $row['contact'];?></p>
                                <p><strong>Password:</strong> <?php echo $row['password'];?> 
                                  <button type="button" class="btn btn-sm btn-primary" onclick="showPasswordForm(<?php echo $row['pid'];?>)">
                                    <i class="fa fa-edit"></i> Edit
                                  </button>
                                </p>
                                
                                <!-- Password Edit Form -->
                                <div id="passwordForm_<?php echo $row['pid'];?>" style="display:none;">
                                  <div class="form-group">
                                    <input type="text" class="form-control" id="newPass_<?php echo $row['pid'];?>" 
                                           placeholder="Enter new password">
                                    <button type="button" class="btn btn-primary mt-2" 
                                            onclick="updatePassword(<?php echo $row['pid'];?>)">
                                      Update Password
                                    </button>
                                    <button type="button" class="btn btn-secondary mt-2" 
                                            onclick="hidePasswordForm(<?php echo $row['pid'];?>)">
                                      Cancel
                                    </button>
                                  </div>
                                </div>
                              </div>
                              <div class="col-md-6">
                                <h6>Health Information</h6>
                                <?php
                                  $health_query = "SELECT * FROM patient_health_details WHERE pid = '".$row['pid']."'";
                                  $health_result = mysqli_query($con, $health_query);
                                  if($health_row = mysqli_fetch_array($health_result)) {
                                ?>
                                  <p><strong>Age:</strong> <?php echo $health_row['age'];?></p>
                                  <p><strong>Blood Group:</strong> <?php echo $health_row['blood_group'];?></p>
                                  <p><strong>Weight:</strong> <?php echo $health_row['weight'];?> kg</p>
                                  <p><strong>Height:</strong> <?php echo $health_row['height'];?> cm</p>
                                  <p><strong>Medical Conditions:</strong> <?php echo $health_row['medical_conditions'];?></p>
                                  <p><strong>Allergies:</strong> <?php echo $health_row['allergies'];?></p>
                                  <p><strong>Emergency Contact:</strong> <?php echo $health_row['emergency_contact'];?></p>
                                  <p><strong>Emergency Phone:</strong> <?php echo $health_row['emergency_contact_phone'];?></p>
                                <?php } else { ?>
                                  <p>No health details available</p>
                                <?php } ?>
                              </div>
                            </div>
                            <!-- Update Health Details Form -->
                            <form class="form-group" method="post" action="update_health_details.php">
                              <input type="hidden" name="pid" value="<?php echo $row['pid']; ?>" />
                              <div class="row">
                                <div class="col-md-6">
                                  <label>Age:</label>
                                  <input type="number" class="form-control" name="age" value="<?php echo $health_row['age']; ?>" required>
                                </div>
                                <div class="col-md-6">
                                  <label>Blood Group:</label>
                                  <select class="form-control" name="blood_group" required>
                                    <option value="">Select Blood Group</option>
                                    <option value="A+" <?php if($health_row['blood_group'] == 'A+') echo 'selected'; ?>>A+</option>
                                    <option value="A-" <?php if($health_row['blood_group'] == 'A-') echo 'selected'; ?>>A-</option>
                                    <option value="B+" <?php if($health_row['blood_group'] == 'B+') echo 'selected'; ?>>B+</option>
                                    <option value="B-" <?php if($health_row['blood_group'] == 'B-') echo 'selected'; ?>>B-</option>
                                    <option value="AB+" <?php if($health_row['blood_group'] == 'AB+') echo 'selected'; ?>>AB+</option>
                                    <option value="AB-" <?php if($health_row['blood_group'] == 'AB-') echo 'selected'; ?>>AB-</option>
                                    <option value="O+" <?php if($health_row['blood_group'] == 'O+') echo 'selected'; ?>>O+</option>
                                    <option value="O-" <?php if($health_row['blood_group'] == 'O-') echo 'selected'; ?>>O-</option>
                                  </select>
                                </div>
                              </div><br>
                              <div class="row">
                                <div class="col-md-6">
                                  <label>Weight (kg):</label>
                                  <input type="number" step="0.01" class="form-control" name="weight" value="<?php echo $health_row['weight']; ?>" required>
                                </div>
                                <div class="col-md-6">
                                  <label>Height (cm):</label>
                                  <input type="number" step="0.01" class="form-control" name="height" value="<?php echo $health_row['height']; ?>" required>
                                </div>
                              </div><br>
                              <div class="row">
                                <div class="col-md-6">
                                  <label>Medical Conditions:</label>
                                  <textarea class="form-control" name="medical_conditions" rows="3"><?php echo $health_row['medical_conditions']; ?></textarea>
                                </div>
                                <div class="col-md-6">
                                  <label>Allergies:</label>
                                  <textarea class="form-control" name="allergies" rows="3"><?php echo $health_row['allergies']; ?></textarea>
                                </div>
                              </div><br>
                              <div class="row">
                                <div class="col-md-6">
                                  <label>Emergency Contact:</label>
                                  <input type="text" class="form-control" name="emergency_contact" value="<?php echo $health_row['emergency_contact']; ?>" required>
                                </div>
                                <div class="col-md-6">
                                  <label>Emergency Contact Phone:</label>
                                  <input type="text" class="form-control" name="emergency_contact_phone" value="<?php echo $health_row['emergency_contact_phone']; ?>" required>
                                </div>
                              </div><br>
                              <input type="submit" name="update_health_details" value="Update Details" class="btn btn-primary">
                            </form>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                          </div>
                        </div>
                      </div>
                    </div>
                  <?php } ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>

      <div class="tab-pane fade" id="list-pres" role="tabpanel" aria-labelledby="list-pres-list">
        <div class="panel panel-primary">
          <div class="panel-heading">
            <h4 class="panel-title">Prescription Management</h4>
          </div>
          <div class="panel-body">
            <!-- Add Export Buttons -->
            <div class="mb-3">
              <div class="btn-group">
                <button type="button" class="btn btn-success" onclick="exportPrescriptions('pdf')">
                  <i class="fa fa-file-pdf-o"></i> Export PDF
                </button>
                <button type="button" class="btn btn-info" onclick="exportPrescriptions('csv')">
                  <i class="fa fa-file-excel-o"></i> Export CSV
                </button>
                <button type="button" class="btn btn-warning" onclick="exportPrescriptions('excel')">
                  <i class="fa fa-file-excel-o"></i> Export Excel
                </button>
              </div>
            </div>

            <div class="table-responsive">
              <table class="table table-hover">
                <thead>
                  <tr>
                  <th scope="col">Doctor</th>
                    <th scope="col">Patient ID</th>
                    <th scope="col">Appointment ID</th>
                    <th scope="col">First Name</th>
                    <th scope="col">Last Name</th>
                    <th scope="col">Appointment Date</th>
                    <th scope="col">Appointment Time</th>
                    <th scope="col">Disease</th>
                    <th scope="col">Allergy</th>
                    <th scope="col">Prescription</th>
                  </tr>
                </thead>
                <tbody>
                  <?php 
                    $query = "select * from prestb";
                    $result = mysqli_query($con,$query);
                    while ($row = mysqli_fetch_array($result)){
                      echo "<tr>
                        <td>{$row['doctor']}</td>
                        <td>{$row['pid']}</td>
                        <td>{$row['ID']}</td>
                        <td>{$row['fname']}</td>
                        <td>{$row['lname']}</td>
                        <td>{$row['appdate']}</td>
                        <td>{$row['apptime']}</td>
                        <td>{$row['disease']}</td>
                        <td>{$row['allergy']}</td>
                        <td>{$row['prescription']}</td>
                      </tr>";
                    }
                  ?>
                </tbody>
              </table>
            </div>
      </div>
      </div>
      </div>

      <div class="tab-pane fade" id="list-app" role="tabpanel" aria-labelledby="list-pat-list">
        <div class="panel panel-primary">
          <div class="panel-heading">
            <h4 class="panel-title">Appointment Management</h4>
          </div>
          <div class="panel-body">
            <!-- Add Export Buttons -->
            <div class="mb-3">
              <div class="btn-group">
                <button type="button" class="btn btn-success" onclick="exportAppointments('pdf')">
                  <i class="fa fa-file-pdf-o"></i> Export PDF
                </button>
                <button type="button" class="btn btn-info" onclick="exportAppointments('csv')">
                  <i class="fa fa-file-excel-o"></i> Export CSV
                </button>
                <button type="button" class="btn btn-warning" onclick="exportAppointments('excel')">
                  <i class="fa fa-file-excel-o"></i> Export Excel
                </button>
              </div>
            </div>

            <div class="col-md-12">
              <!-- Appointment Filters -->
              <div class="row mb-3">
                <div class="col-md-3">
                  <select class="form-control" id="appointmentStatusFilter">
                    <option value="">All Statuses</option>
                    <option value="active">Active</option>
                    <option value="completed">Completed</option>
                    <option value="cancelled_patient">Cancelled by Patient</option>
                    <option value="cancelled_doctor">Cancelled by Doctor</option>
                  </select>
                </div>
                <div class="col-md-3">
                  <input type="date" class="form-control" id="appointmentDateFilter">
                </div>
                <div class="col-md-2">
                  <select class="form-control" id="appointmentDoctorFilter">
                    <option value="">All Doctors</option>
                    <?php
                      $doc_query = "select username from doctb";
                      $doc_result = mysqli_query($con,$doc_query);
                      while($doc = mysqli_fetch_array($doc_result)) {
                        echo "<option value='{$doc['username']}'>{$doc['username']}</option>";
                      }
                    ?>
                  </select>
                </div>
                <div class="col-md-2">
                  <input type="text" name="app_contact" placeholder="Search" class="form-control">
                </div>
                <div class="col-md-2">
                  <input type="submit" name="app_search_submit" class="btn btn-primary" value="Search">
                </div>
              </div>
            </div>
            <div class="table-responsive">
              <table class="table table-hover">
                <thead>
                  <tr>
                  <th scope="col">Appointment ID</th>
                  <th scope="col">Patient ID</th>
                    <th scope="col">First Name</th>
                    <th scope="col">Last Name</th>
                    <th scope="col">Gender</th>
                    <th scope="col">Email</th>
                    <th scope="col">Contact</th>
                    <th scope="col">Doctor Name</th>
                    <th scope="col">Consultancy Fees</th>
                    <th scope="col">Appointment Date</th>
                    <th scope="col">Appointment Time</th>
                    <th scope="col">Appointment Status</th>
                  </tr>
                </thead>
                <tbody>
                  <?php 

                    $query = "select * from appointmenttb;";
                    $result = mysqli_query($con,$query);
                    while ($row = mysqli_fetch_array($result)){
                  ?>
                      <tr>
                        <td><?php echo $row['ID'];?></td>
                        <td><?php echo $row['pid'];?></td>
                        <td><?php echo $row['fname'];?></td>
                        <td><?php echo $row['lname'];?></td>
                        <td><?php echo $row['gender'];?></td>
                        <td><?php echo $row['email'];?></td>
                        <td><?php echo $row['contact'];?></td>
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
                      echo "Cancelled by Patient";
                    }

                    if(($row['userStatus']==1) && ($row['doctorStatus']==0))  
                    {
                      echo "Cancelled by Doctor";
                    }
                        ?></td>
                      </tr>
                    <?php } ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>

<div class="tab-pane fade" id="list-messages" role="tabpanel" aria-labelledby="list-messages-list">...</div>

      <div class="tab-pane fade" id="list-settings" role="tabpanel" aria-labelledby="list-settings-list">
        <div class="panel panel-primary">
          <div class="panel-heading">
            <h4 class="panel-title">Add Doctor</h4>
          </div>
          <div class="panel-body">
        <form class="form-group" method="post" action="admin-panel1.php">
          <div class="row">
                  <div class="col-md-4"><label>Doctor Name:</label></div>
                  <div class="col-md-8"><input type="text" class="form-control" name="doctor" onkeydown="return alphaOnly(event);" required></div><br><br>
                  <div class="col-md-4"><label>Specialization:</label></div>
                  <div class="col-md-8">
                   <select name="special" class="form-control" id="special" required="required">
                      <option value="head" name="spec" disabled selected>Select Specialization</option>
                      <option value="General" name="spec">General</option>
                      <option value="Cardiologist" name="spec">Cardiologist</option>
                      <option value="Neurologist" name="spec">Neurologist</option>
                      <option value="Pediatrician" name="spec">Pediatrician</option>
                    </select>
                    </div><br><br>
                  <div class="col-md-4"><label>Email ID:</label></div>
                  <div class="col-md-8"><input type="email"  class="form-control" name="demail" required></div><br><br>
                  <div class="col-md-4"><label>Password:</label></div>
                  <div class="col-md-8"><input type="password" class="form-control"  onkeyup='check();' name="dpassword" id="dpassword"  required></div><br><br>
                  <div class="col-md-4"><label>Confirm Password:</label></div>
                  <div class="col-md-8"  id='cpass'><input type="password" class="form-control" onkeyup='check();' name="cdpassword" id="cdpassword" required>&nbsp &nbsp<span id='message'></span> </div><br><br>
                   
                  
                  <div class="col-md-4"><label>Consultancy Fees:</label></div>
                  <div class="col-md-8"><input type="text" class="form-control"  name="docFees" required></div><br><br>
                </div>
          <input type="submit" name="docsub" value="Add Doctor" class="btn btn-primary">
        </form>
          </div>
        </div>
      </div>

      <div class="tab-pane fade" id="list-settings1" role="tabpanel" aria-labelledby="list-settings1-list">
        <div class="panel panel-primary">
          <div class="panel-heading">
            <h4 class="panel-title">Delete Doctor</h4>
          </div>
          <div class="panel-body">
        <form class="form-group" method="post" action="admin-panel1.php">
          <div class="row">
          
                  <div class="col-md-4"><label>Email ID:</label></div>
                  <div class="col-md-8"><input type="email"  class="form-control" name="demail" required></div><br><br>
                  
                </div>
          <input type="submit" name="docsub1" value="Delete Doctor" class="btn btn-primary" onclick="confirm('do you really want to delete?')">
        </form>
          </div>
        </div>
      </div>


       <div class="tab-pane fade" id="list-attend" role="tabpanel" aria-labelledby="list-attend-list">...</div>

       <div class="tab-pane fade" id="list-mes" role="tabpanel" aria-labelledby="list-mes-list">
        <div class="panel panel-white no-radius text-center">
          <div class="panel-body">
            <span class="fa-stack fa-2x"> 
              <i class="fa fa-square fa-stack-2x text-primary"></i> 
              <i class="fa fa-comments fa-stack-1x fa-inverse"></i> 
            </span>
            <h4 class="StepTitle" style="margin-top: 5%;">Queries Management</h4>
            <div class="col-md-12">
      <form class="form-group" action="messearch.php" method="post">
        <div class="row">
                  <div class="col-md-10"><input type="text" name="mes_contact" placeholder="Enter Contact" class="form-control"></div>
                  <div class="col-md-2"><input type="submit" name="mes_search_submit" class="btn btn-primary" value="Search"></div>
                </div>
      </form>
    </div>
            <div class="table-responsive">
              <table class="table table-hover">
                <thead>
                  <tr>
                    <th>User Name</th>
                    <th>Email</th>
                    <th>Contact</th>
                    <th>Message</th>
                  </tr>
                </thead>
                <tbody>
                  <?php 

                    $query = "select * from contact;";
                    $result = mysqli_query($con,$query);
                    while ($row = mysqli_fetch_array($result)){
              
                      #$fname = $row['fname'];
                      #$lname = $row['lname'];
                      #$email = $row['email'];
                      #$contact = $row['contact'];
                  ?>
                      <tr>
                        <td><?php echo $row['name'];?></td>
                        <td><?php echo $row['email'];?></td>
                        <td><?php echo $row['contact'];?></td>
                        <td><?php echo $row['message'];?></td>
                      </tr>
                    <?php } ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>

      <div class="tab-pane fade" id="list-analytics" role="tabpanel" aria-labelledby="list-analytics-list">
        <div class="row">
            <div class="col-md-6">
                <div class="chart-container">
                    <div class="chart-title">Appointment Status Distribution</div>
                    <canvas id="appointmentStatusChart"></canvas>
                </div>
            </div>
            <div class="col-md-6">
                <div class="chart-container">
                    <div class="chart-title">Monthly Appointments Trend</div>
                    <canvas id="appointmentTrendChart"></canvas>
                </div>
            </div>
        </div>
      </div>

      <div class="tab-pane fade" id="list-revenue" role="tabpanel" aria-labelledby="list-revenue-list">
        <div class="row">
            <div class="col-md-8">
                <div class="chart-container">
                    <div class="chart-title">Monthly Revenue Analysis</div>
                    <canvas id="revenueChart"></canvas>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stats-card">
                    <h5>Revenue Summary</h5>
                    <?php
                        $total_revenue = mysqli_fetch_array(mysqli_query($con, 
                            "SELECT SUM(docFees) FROM appointmenttb"))[0];
                        $monthly_revenue = mysqli_fetch_array(mysqli_query($con, 
                            "SELECT SUM(docFees) FROM appointmenttb 
                            WHERE MONTH(appdate) = MONTH(CURRENT_DATE()) 
                            AND YEAR(appdate) = YEAR(CURRENT_DATE())"))[0];
                        $avg_revenue = mysqli_fetch_array(mysqli_query($con, 
                            "SELECT AVG(docFees) FROM appointmenttb"))[0];
                    ?>
                    <div class="mb-3">
                        <h6>Total Revenue</h6>
                        <h3>₹<?php echo number_format($total_revenue, 2); ?></h3>
                    </div>
                    <div class="mb-3">
                        <h6>Monthly Revenue</h6>
                        <h3>₹<?php echo number_format($monthly_revenue, 2); ?></h3>
                    </div>
                    <div>
                        <h6>Average Revenue per Appointment</h6>
                        <h3>₹<?php echo number_format($avg_revenue, 2); ?></h3>
                    </div>
                </div>
            </div>
        </div>
      </div>

      <div class="tab-pane fade" id="list-statistics" role="tabpanel" aria-labelledby="list-statistics-list">
        <div class="row">
            <div class="col-md-6">
                <div class="chart-container">
                    <div class="chart-title">Patient Gender Distribution</div>
                    <canvas id="genderChart"></canvas>
                </div>
            </div>
            <div class="col-md-6">
                <div class="chart-container">
                    <div class="chart-title">Patient Age Distribution</div>
                    <canvas id="ageChart"></canvas>
                </div>
            </div>
        </div>
      </div>

      <div class="tab-pane fade" id="list-docs" role="tabpanel" aria-labelledby="list-docs-list">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title mb-4">Document Management</h4>
            
            <!-- Document Search and Filter - Updated Layout -->
            <div class="search-container bg-light p-3 rounded mb-4">
                <div class="row align-items-center">
                    <div class="col-md-3 mb-2 mb-md-0">
                        <label class="small mb-1">Document Type</label>
                        <select class="form-control" id="docTypeFilter">
                            <option value="">All Document Types</option>
                            <option value="application/pdf">PDF</option>
                            <option value="image/jpeg">JPEG</option>
                            <option value="image/png">PNG</option>
                            <option value="application/msword">DOC</option>
                        </select>
                    </div>
                    <div class="col-md-3 mb-2 mb-md-0">
                        <label class="small mb-1">Uploaded By</label>
                        <select class="form-control" id="uploadedByFilter">
                            <option value="">All Sources</option>
                            <option value="doctor">Doctor</option>
                            <option value="patient">Patient</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>
                    <div class="col-md-4 mb-2 mb-md-0">
                        <label class="small mb-1">Search Documents</label>
                        <input type="text" class="form-control" id="docSearch" placeholder="Enter keywords...">
                    </div>
                    <div class="col-md-2">
                        <label class="small mb-1">&nbsp;</label>
                        <button class="btn btn-primary btn-block" onclick="filterDocuments()">
                            <i class="fa fa-search"></i> Search
                        </button>
                    </div>
                </div>
            </div>

            <!-- Add this style block after the search container -->
            <style>
            .search-container {
                background-color: #f8f9fa;
                border: 1px solid #dee2e6;
            }
            
            .search-container label {
                color: #495057;
                font-weight: 500;
            }
            
            .search-container .form-control {
                height: 38px;
            }
            
            .search-container .btn-primary {
                height: 38px;
                display: flex;
                align-items: center;
                justify-content: center;
                gap: 5px;
            }
            
            @media (max-width: 768px) {
                .search-container .btn-primary {
                    margin-top: 24px;
                }
            }
            </style>

            <!-- Rest of the document management code remains the same -->
            <div class="mb-4">
                <button class="btn btn-primary mb-3" type="button" data-toggle="collapse" data-target="#uploadForm">
                    Upload New Document
                </button>
                <div class="collapse" id="uploadForm">
                    <div class="card card-body">
                        <form action="document_handler.php" method="post" enctype="multipart/form-data" class="form-group">
                            <div class="form-group">
                                <label>Select Patient:</label>
                                <select name="pid" class="form-control" required>
                                    <option value="">Select Patient</option>
                                    <?php
                                    $pat_query = mysqli_query($con, "SELECT pid, fname, lname FROM patreg ORDER BY fname");
                                    while($pat = mysqli_fetch_array($pat_query)) {
                                        echo "<option value='{$pat['pid']}'>{$pat['fname']} {$pat['lname']} (ID: {$pat['pid']})</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label>Document Type:</label>
                                <select name="doc_type" class="form-control" required>
                                    <option value="">Select Type</option>
                                    <option value="Medical Report">Medical Report</option>
                                    <option value="Lab Result">Lab Result</option>
                                    <option value="Prescription">Prescription</option>
                                    <option value="Insurance">Insurance Document</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label>Select File:</label>
                                <input type="file" class="form-control-file" name="document" required>
                            </div>
                            
                            <div class="form-group">
                                <label>Description:</label>
                                <textarea class="form-control" name="description" rows="2" required></textarea>
                            </div>
                            
                            <input type="hidden" name="uploaded_by" value="admin">
                            <button type="submit" name="upload_document" class="btn btn-primary">Upload Document</button>
                        </form>
                    </div>
                </div>
            </div>
            
            <!-- Documents List -->
            <div class="table-responsive">
                <table class="table table-hover" id="documentsTable">
                    <thead>
                        <tr>
                            <th>Patient Name</th>
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
                        $docs_query = mysqli_query($con, "SELECT d.*, p.fname, p.lname 
                                                         FROM documents d 
                                                         JOIN patreg p ON d.pid = p.pid 
                                                         ORDER BY d.upload_date DESC");
                        while($doc = mysqli_fetch_array($docs_query)) {
                            $doc_type = explode('/', $doc['document_type'])[1];
                            echo "<tr>
                                <td>{$doc['fname']} {$doc['lname']}</td>
                                <td>{$doc['document_name']}</td>
                                <td>{$doc_type}</td>
                                <td>{$doc['uploaded_by']}</td>
                                <td>" . date('Y-m-d H:i', strtotime($doc['upload_date'])) . "</td>
                                <td>{$doc['description']}</td>
                                <td>
                                    <a href='document_handler.php?download={$doc['id']}' class='btn btn-sm btn-info'>Download</a>
                                    <a href='document_handler.php?delete={$doc['id']}' class='btn btn-sm btn-danger' onclick='return confirm(\"Are you sure you want to delete this document?\")'>Delete</a>
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

      <div class="tab-pane fade" id="list-predict" role="tabpanel" aria-labelledby="list-predict-list">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Multiple Disease Prediction System</h4>
                <p class="card-text">Our advanced AI-powered system helps healthcare providers and patients with early disease detection and risk assessment.</p>

                <div class="row mt-4">
                    <div class="col-md-6">
                        <div class="card bg-light">
                            <div class="card-body">
                                <h5 class="card-title"><i class="fa fa-heartbeat text-danger"></i> Supported Diseases</h5>
                                <ul class="list-unstyled">
                                    <li><i class="fa fa-check-circle text-success"></i> Diabetes</li>
                                    <li><i class="fa fa-check-circle text-success"></i> Heart Disease</li>
                                    <li><i class="fa fa-check-circle text-success"></i> Parkinson's Disease</li>
                                    <li><i class="fa fa-check-circle text-success"></i> Liver Disease</li>
                                    <li><i class="fa fa-check-circle text-success"></i> Hepatitis</li>
                                    <li><i class="fa fa-check-circle text-success"></i> Jaundice</li>
                                    <li><i class="fa fa-plus-circle text-primary"></i> More conditions being added...</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card bg-light">
                            <div class="card-body">
                                <h5 class="card-title"><i class="fa fa-cogs text-primary"></i> System Features</h5>
                                <ul class="list-unstyled">
                                    <li><i class="fa fa-arrow-right text-primary"></i> Comprehensive symptom analysis</li>
                                    <li><i class="fa fa-arrow-right text-primary"></i> Patient history consideration</li>
                                    <li><i class="fa fa-arrow-right text-primary"></i> Lab results integration</li>
                                    <li><i class="fa fa-arrow-right text-primary"></i> Risk factor evaluation</li>
                                    <li><i class="fa fa-arrow-right text-primary"></i> Real-time predictions</li>
                                    <li><i class="fa fa-arrow-right text-primary"></i> User-friendly interface</li>
                                    <li><i class="fa fa-arrow-right text-primary"></i> Secure data handling</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="text-center my-4">
                    <a href="https://multiple-disease-prediction-hms.streamlit.app/" target="_blank" class="btn btn-primary btn-lg">
                        <i class="fa fa-stethoscope"></i> Launch Disease Prediction System
                    </a>
                </div>

                <div class="row mt-4">
                    <div class="col-md-6">
                        <div class="alert alert-info">
                            <h5><i class="fa fa-info-circle"></i> How It Works:</h5>
                            <ol>
                                <li>Access the prediction system</li>
                                <li>Choose the disease to predict</li>
                                <li>Input required medical data</li>
                                <li>Get instant prediction results</li>
                                <li>Share results with healthcare providers</li>
                            </ol>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="alert alert-warning">
                            <h5><i class="fa fa-exclamation-triangle"></i> Important Notes:</h5>
                            <ul>
                                <li>Results are for screening purposes only</li>
                                <li>Not a substitute for medical diagnosis</li>
                                <li>Consult healthcare providers for proper diagnosis</li>
                                <li>Regular system updates for improved accuracy</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="card bg-light mt-4">
                    <div class="card-body">
                        <h5 class="card-title"><i class="fa fa-chart-line text-success"></i> Benefits</h5>
                        <div class="row">
                            <div class="col-md-4">
                                <h6>For Patients</h6>
                                <ul>
                                    <li>Early health risk detection</li>
                                    <li>Convenient health screening</li>
                                    <li>Increased health awareness</li>
                                </ul>
                            </div>
                            <div class="col-md-4">
                                <h6>For Doctors</h6>
                                <ul>
                                    <li>Assisted decision making</li>
                                    <li>Efficient patient screening</li>
                                    <li>Data-driven insights</li>
                                </ul>
                            </div>
                            <div class="col-md-4">
                                <h6>For Healthcare Facilities</h6>
                                <ul>
                                    <li>Improved patient care</li>
                                    <li>Enhanced screening process</li>
                                    <li>Better resource allocation</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
      </div>

      <div class="tab-pane fade" id="list-brain" role="tabpanel" aria-labelledby="list-brain-list">
        <div class="card">
          <div class="card-body">
            <h4 class="card-title">Brain Tumor Detection System</h4>
            <p class="card-text">Use our advanced AI-powered system for brain tumor detection and analysis.</p>
            
            <div class="row mt-4">
              <div class="col-md-6">
                <h5>Key Features:</h5>
                <ul class="list-unstyled">
                  <li><i class="fa fa-check-circle text-success"></i> MRI Image Analysis</li>
                  <li><i class="fa fa-check-circle text-success"></i> Real-time Detection</li>
                  <li><i class="fa fa-check-circle text-success"></i> High Accuracy Results</li>
                  <li><i class="fa fa-check-circle text-success"></i> Instant Report Generation</li>
                </ul>
              </div>
              <div class="col-md-6">
                <h5>Benefits:</h5>
                <ul class="list-unstyled">
                  <li><i class="fa fa-arrow-right text-primary"></i> Early Detection</li>
                  <li><i class="fa fa-arrow-right text-primary"></i> Quick Analysis</li>
                  <li><i class="fa fa-arrow-right text-primary"></i> Support Clinical Decisions</li>
                  <li><i class="fa fa-arrow-right text-primary"></i> Improved Patient Care</li>
                </ul>
              </div>
            </div>

            <div class="text-center my-4">
              <a href="https://brain-tumor-detection-master.streamlit.app/" target="_blank" class="btn btn-primary btn-lg">
                <i class="fa fa-heartbeat"></i> Launch Detection
              </a>
            </div>

            <div class="alert alert-info mt-4">
              <h5><i class="fa fa-info-circle"></i> How to Use:</h5>
              <ol>
                <li>Click the button above to open the detection system</li>
                <li>Upload the patient's MRI scan</li>
                <li>Wait for the AI analysis</li>
                <li>Review the detection results</li>
                <li>Use results to support diagnosis</li>
              </ol>
            </div>

            <div class="alert alert-warning">
              <strong><i class="fa fa-exclamation-triangle"></i> Important Note:</strong>
              <p class="mb-0">This tool is designed to assist in clinical decision-making but should not replace professional medical judgment. Always combine detection results with proper clinical examination and diagnostic tests.</p>
            </div>
          </div>
        </div>
      </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Appointment Status Chart
        var appointmentCtx = document.getElementById('appointmentStatusChart');
        if (appointmentCtx) {
            var appointmentChart = new Chart(appointmentCtx, {
                type: 'pie',
                data: {
                    labels: ['Active', 'Completed', 'Cancelled by Patient', 'Cancelled by Doctor'],
                    datasets: [{
                        data: [
                            <?php 
                            $active = mysqli_fetch_array(mysqli_query($con, 
                                "SELECT COUNT(*) FROM appointmenttb WHERE userStatus=1 AND doctorStatus=1 AND status!='completed'"))[0];
                            $completed = mysqli_fetch_array(mysqli_query($con, 
                                "SELECT COUNT(*) FROM appointmenttb WHERE status='completed'"))[0];
                            $cancelled_patient = mysqli_fetch_array(mysqli_query($con, 
                                "SELECT COUNT(*) FROM appointmenttb WHERE userStatus=0"))[0];
                            $cancelled_doctor = mysqli_fetch_array(mysqli_query($con, 
                                "SELECT COUNT(*) FROM appointmenttb WHERE doctorStatus=0"))[0];
                            echo "$active, $completed, $cancelled_patient, $cancelled_doctor";
                            ?>
                        ],
                        backgroundColor: ['#28a745', '#17a2b8', '#dc3545', '#ffc107']
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

        // Monthly Appointments Trend Chart
        var trendCtx = document.getElementById('appointmentTrendChart');
        if (trendCtx) {
            var trendChart = new Chart(trendCtx, {
                type: 'line',
                data: {
                    labels: [
                        <?php
                        for ($i = 5; $i >= 0; $i--) {
                            echo "'" . date('M Y', strtotime("-$i months")) . "',";
                        }
                        ?>
                    ],
                    datasets: [{
                        label: 'Number of Appointments',
                        data: [
                            <?php
                            for ($i = 5; $i >= 0; $i--) {
                                $month = date('Y-m', strtotime("-$i months"));
                                $count = mysqli_fetch_array(mysqli_query($con, 
                                    "SELECT COUNT(*) FROM appointmenttb 
                                    WHERE DATE_FORMAT(appdate, '%Y-%m') = '$month'"))[0];
                                echo "$count,";
                            }
                            ?>
                        ],
                        borderColor: '#007bff',
                        tension: 0.1,
                        fill: false
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
                    }
                }
            });
        }

        // Revenue Chart (Monthly)
        var revenueCtx = document.getElementById('revenueChart');
        if (revenueCtx) {
            var revenueChart = new Chart(revenueCtx, {
                type: 'bar',
                data: {
                    labels: [
                        <?php
                        for ($i = 5; $i >= 0; $i--) {
                            echo "'" . date('M Y', strtotime("-$i months")) . "',";
                        }
                        ?>
                    ],
                    datasets: [{
                        label: 'Monthly Revenue',
                        data: [
                            <?php
                            for ($i = 5; $i >= 0; $i--) {
                                $month = date('Y-m', strtotime("-$i months"));
                                $revenue = mysqli_fetch_array(mysqli_query($con, 
                                    "SELECT COALESCE(SUM(docFees), 0) FROM appointmenttb 
                                    WHERE DATE_FORMAT(appdate, '%Y-%m') = '$month'"))[0];
                                echo "$revenue,";
                            }
                            ?>
                        ],
                        backgroundColor: '#007bff'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    return '₹' + value;
                                }
                            }
                        }
                    }
                }
            });
        }

        // Gender Distribution Chart
        var genderCtx = document.getElementById('genderChart');
        if (genderCtx) {
            var genderChart = new Chart(genderCtx, {
                type: 'doughnut',
                data: {
                    labels: ['Male', 'Female', 'Other'],
                    datasets: [{
                        data: [
                            <?php
                            $male = mysqli_fetch_array(mysqli_query($con, 
                                "SELECT COUNT(*) FROM patreg WHERE gender='Male'"))[0];
                            $female = mysqli_fetch_array(mysqli_query($con, 
                                "SELECT COUNT(*) FROM patreg WHERE gender='Female'"))[0];
                            $other = mysqli_fetch_array(mysqli_query($con, 
                                "SELECT COUNT(*) FROM patreg WHERE gender='Other'"))[0];
                            echo "$male, $female, $other";
                            ?>
                        ],
                        backgroundColor: ['#007bff', '#dc3545', '#ffc107']
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

        // Age Distribution Chart
        var ageCtx = document.getElementById('ageChart');
        if (ageCtx) {
            var ageChart = new Chart(ageCtx, {
                type: 'bar',
                data: {
                    labels: ['0-18', '19-30', '31-50', '51-70', '70+'],
                    datasets: [{
                        label: 'Number of Patients',
                        data: [
                            <?php
                            $age_ranges = [
                                "SELECT COUNT(*) FROM patient_health_details WHERE age <= 18",
                                "SELECT COUNT(*) FROM patient_health_details WHERE age > 18 AND age <= 30",
                                "SELECT COUNT(*) FROM patient_health_details WHERE age > 30 AND age <= 50",
                                "SELECT COUNT(*) FROM patient_health_details WHERE age > 50 AND age <= 70",
                                "SELECT COUNT(*) FROM patient_health_details WHERE age > 70"
                            ];
                            foreach ($age_ranges as $query) {
                                $count = mysqli_fetch_array(mysqli_query($con, $query))[0];
                                echo "$count,";
                            }
                            ?>
                        ],
                        backgroundColor: '#20c997'
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
                    }
                }
            });
        }
    });
    </script>

    </div>
  </div>
</div>
   </div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIKvXipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.10.1/sweetalert2.all.min.js"></script>

    <!-- Add filter handling script -->
    <script>
    $(document).ready(function() {
        // Function to filter table rows
        function filterTable(tableId, searchText) {
            $(tableId + ' tbody tr').each(function() {
                var found = false;
                $(this).find('td').each(function() {
                    if($(this).text().toLowerCase().indexOf(searchText.toLowerCase()) >= 0) {
                        found = true;
                        return false; // Break the loop
                    }
                });
                $(this).toggle(found);
            });
        }

        // Doctor search
        $('input[name="doctor_contact"]').on('keyup', function() {
            filterTable('#list-doc table', $(this).val());
        });

        // Patient search
        $('input[name="patient_contact"]').on('keyup', function() {
            filterTable('#list-pat table', $(this).val());
        });

        // Appointment search
        $('input[name="app_contact"]').on('keyup', function() {
            filterTable('#list-app table', $(this).val());
        });

        // Doctor filters
        $('#doctorSpecFilter, #doctorFeesFilter').on('change', function() {
            var spec = $('#doctorSpecFilter').val();
            var maxFees = $('#doctorFeesFilter').val();
            
            $('#list-doc table tbody tr').each(function() {
                var row = $(this);
                var rowSpec = row.find('td:eq(1)').text();
                var rowFees = parseFloat(row.find('td:eq(4)').text());
                
                var specMatch = !spec || rowSpec === spec;
                var feesMatch = !maxFees || rowFees <= parseFloat(maxFees);
                
                row.toggle(specMatch && feesMatch);
            });
        });

        // Patient filters
        $('#patientGenderFilter, #patientAgeFilter').on('change keyup', function() {
            var gender = $('#patientGenderFilter').val();
            var ageRange = $('#patientAgeFilter').val();
            
            $('#list-pat table tbody tr').each(function() {
                var row = $(this);
                var rowGender = row.find('td:eq(3)').text();
                
                var genderMatch = !gender || rowGender === gender;
                var ageMatch = true;
                
                if(ageRange) {
                    var range = ageRange.split('-');
                    if(range.length === 2) {
                        var minAge = parseInt(range[0]);
                        var maxAge = parseInt(range[1]);
                        var rowAge = parseInt(row.find('td:eq(5)').text());
                        ageMatch = rowAge >= minAge && rowAge <= maxAge;
                    }
                }
                
                row.toggle(genderMatch && ageMatch);
            });
        });

        // Appointment filters
        $('#appointmentStatusFilter, #appointmentDateFilter, #appointmentDoctorFilter').on('change', function() {
            var status = $('#appointmentStatusFilter').val();
            var date = $('#appointmentDateFilter').val();
            var doctor = $('#appointmentDoctorFilter').val();
            
            $('#list-app table tbody tr').each(function() {
                var row = $(this);
                var rowStatus = row.find('td:last').text().trim().toLowerCase();
                var rowDate = row.find('td:eq(9)').text();
                var rowDoctor = row.find('td:eq(7)').text();
                
                var statusMatch = !status || 
                    (status === 'active' && rowStatus === 'active') ||
                    (status === 'completed' && rowStatus === 'completed') ||
                    (status === 'cancelled_patient' && rowStatus === 'cancelled by patient') ||
                    (status === 'cancelled_doctor' && rowStatus === 'cancelled by doctor');
                
                var dateMatch = !date || rowDate === date;
                var doctorMatch = !doctor || rowDoctor === doctor;
                
                row.toggle(statusMatch && dateMatch && doctorMatch);
            });
        });

        // Clear filters
        $('.btn-clear-filters').click(function() {
            $(this).closest('.panel-body').find('select').val('');
            $(this).closest('.panel-body').find('input[type="text"], input[type="number"], input[type="date"]').val('');
            $(this).closest('.panel-body').find('table tbody tr').show();
        });
    });
    </script>

    <!-- Add chat button -->
    <a href="https://hospital-management-system-chatbot.streamlit.app/" target="_blank" class="chat-button" title="Chat with us">
        <i class="fa fa-comments"></i>
    </a>

<!-- Add this JavaScript before the closing body tag -->
<script>
function filterDocuments() {
    const typeFilter = document.getElementById('docTypeFilter').value.toLowerCase();
    const sourceFilter = document.getElementById('uploadedByFilter').value.toLowerCase();
    const searchText = document.getElementById('docSearch').value.toLowerCase();
    
    const table = document.getElementById('documentsTable');
    const rows = table.getElementsByTagName('tr');
    
    for (let i = 1; i < rows.length; i++) {
        const row = rows[i];
        const type = row.cells[2].textContent.toLowerCase();
        const source = row.cells[3].textContent.toLowerCase();
        const text = row.textContent.toLowerCase();
        
        const typeMatch = !typeFilter || type.includes(typeFilter);
        const sourceMatch = !sourceFilter || source === sourceFilter;
        const textMatch = !searchText || text.includes(searchText);
        
        row.style.display = (typeMatch && sourceMatch && textMatch) ? '' : 'none';
    }
}

// Add event listeners for real-time filtering
document.getElementById('docSearch').addEventListener('keyup', filterDocuments);
document.getElementById('docTypeFilter').addEventListener('change', filterDocuments);
document.getElementById('uploadedByFilter').addEventListener('change', filterDocuments);
</script>

<!-- Add Export Functions -->
<script>
function exportDoctorList(format) {
    const spec = document.getElementById('doctorSpecFilter').value;
    const maxFees = document.getElementById('doctorFeesFilter').value;
    const search = document.querySelector('input[name="doctor_contact"]').value;
    
    window.location.href = `export.php?type=doctors&format=${format}&spec=${spec}&maxFees=${maxFees}&search=${search}`;
}

function exportPatientList(format) {
    const gender = document.getElementById('patientGenderFilter').value;
    const ageRange = document.getElementById('patientAgeFilter').value;
    const search = document.querySelector('input[name="patient_contact"]').value;
    
    window.location.href = `export.php?type=patients&format=${format}&gender=${gender}&ageRange=${ageRange}&search=${search}`;
}

function exportAppointments(format) {
    const status = document.getElementById('appointmentStatusFilter').value;
    const date = document.getElementById('appointmentDateFilter').value;
    const doctor = document.getElementById('appointmentDoctorFilter').value;
    const search = document.querySelector('input[name="app_contact"]').value;
    
    window.location.href = `export.php?type=appointments&format=${format}&status=${status}&date=${date}&doctor=${doctor}&search=${search}`;
}

function exportPrescriptions(format) {
    const search = document.querySelector('input[name="pres_contact"]')?.value || '';
    window.location.href = `export.php?type=prescriptions&format=${format}&search=${search}`;
}
</script>
  </body>
</html>