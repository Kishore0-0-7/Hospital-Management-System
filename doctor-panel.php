<!DOCTYPE html>
<?php 
include('func1.php');
$con=mysqli_connect("localhost","root","","myhmsdb");
$doctor = $_SESSION['dname'];

if(isset($_GET['complete']))
{
  $query=mysqli_query($con,"UPDATE appointmenttb SET status='completed' WHERE ID = '".$_GET['ID']."'");
  if($query)
  {
    echo "<script>
      alert('Appointment marked as completed successfully!');
      window.location.href = 'doctor-panel.php#list-app';
    </script>";
  } else {
    echo "<script>alert('Unable to update appointment status. Error: " . mysqli_error($con) . "');</script>";
  }
}

if(isset($_GET['cancel']))
{
  $query=mysqli_query($con,"UPDATE appointmenttb SET doctorStatus='0' WHERE ID = '".$_GET['ID']."'");
  if($query)
  {
    echo "<script>
      alert('Appointment cancelled successfully!');
      window.location.href = 'doctor-panel.php#list-app';
    </script>";
  } else {
    echo "<script>alert('Unable to cancel appointment. Error: " . mysqli_error($con) . "');</script>";
  }
}

  // if(isset($_GET['prescribe'])){
    
  //   $pid = $_GET['pid'];
  //   $ID = $_GET['ID'];
  //   $appdate = $_GET['appdate'];
  //   $apptime = $_GET['apptime'];
  //   $disease = $_GET['disease'];
  //   $allergy = $_GET['allergy'];
  //   $prescription = $_GET['prescription'];
  //   $query=mysqli_query($con,"insert into prestb(doctor,pid,ID,appdate,apptime,disease,allergy,prescription) values ('$doctor',$pid,$ID,'$appdate','$apptime','$disease','$allergy','$prescription');");
  //   if($query)
  //   {
  //     echo "<script>alert('Prescribed successfully!');</script>";
  //   }
  //   else{
  //     echo "<script>alert('Unable to process your request. Try again!');</script>";
  //   }
  // }


?>
<html lang="en">
  <head>


    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" type="text/css" href="font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="style.css">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="vendor/fontawesome/css/font-awesome.min.css">
    <link rel="shortcut icon" type="image/x-icon" href="images/favicon.png" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    
    <link href="https://fonts.googleapis.com/css?family=IBM+Plex+Sans&display=swap" rel="stylesheet">
      <nav class="navbar navbar-expand-lg navbar-dark bg-primary fixed-top">
  <a class="navbar-brand" href="#"><i class="fa fa-user-plus" aria-hidden="true"></i>The Care Crew</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

    <style >
      .btn-outline-light:hover{
        color: #25bef7;
        background-color: #f8f9fa;
        border-color: #f8f9fa;
      }
    </style>

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
    <h3 style = "margin-left: 40%; padding-bottom: 20px;font-family:'IBM Plex Sans', sans-serif;"> Welcome &nbsp<?php echo $_SESSION['dname'] ?>  </h3>
    <div class="row">
  <div class="col-md-4" style="max-width:18%;margin-top: 3%;">
    <div class="list-group" id="list-tab" role="tablist">
      <a class="list-group-item list-group-item-action active" href="#list-dash" role="tab" aria-controls="home" data-toggle="list">
        <i class="fa fa-th-large"></i> Dashboard
      </a>
      <a class="list-group-item list-group-item-action" href="#list-app" id="list-app-list" role="tab" data-toggle="list" aria-controls="home">
        <i class="fa fa-calendar"></i> Appointments
      </a>
      <a class="list-group-item list-group-item-action" href="#list-pres" id="list-pres-list" role="tab" data-toggle="list" aria-controls="home">
        <i class="fa fa-list-alt"></i> Prescription List
      </a>
      <a class="list-group-item list-group-item-action" href="#list-docs" id="list-docs-list" role="tab" data-toggle="list" aria-controls="home">
        <i class="fa fa-file-text"></i> Patient Documents
      </a>
      <a class="list-group-item list-group-item-action" href="#list-disease-pred" id="list-disease-pred-list" role="tab" data-toggle="list" aria-controls="home">
        <i class="fa fa-heartbeat"></i> Disease Prediction
      </a>
      <a class="list-group-item list-group-item-action" href="#list-brain" id="list-brain-list" role="tab" data-toggle="list" aria-controls="home">
        <i class="fa fa-stethoscope"></i> Brain Tumor Detection
      </a>
    </div><br>
  </div>
  <div class="col-md-8" style="margin-top: 3%;">
    <div class="tab-content" id="nav-tabContent" style="width: 950px;">
      <div class="tab-pane fade show active" id="list-dash" role="tabpanel" aria-labelledby="list-dash-list">
        <div class="container-fluid container-fullw bg-white">
          <div class="row justify-content-center">
            <div class="col-sm-3">
              <div class="panel panel-white no-radius text-center h-100">
                <div class="panel-body">
                  <span class="fa-stack fa-2x"> <i class="fa fa-square fa-stack-2x text-primary"></i> <i class="fa fa-calendar fa-stack-1x fa-inverse"></i> </span>
                  <h4 class="StepTitle" style="margin-top: 5%;">View Appointments</h4>
                  <p class="links cl-effect-1">
                    <a href="#list-app" onclick="clickDiv('#list-app')">
                      <i class="fa fa-calendar"></i> Appointment List
                    </a>
                  </p>
                </div>
              </div>
            </div>

            <div class="col-sm-3">
              <div class="panel panel-white no-radius text-center h-100">
                <div class="panel-body">
                  <span class="fa-stack fa-2x"> <i class="fa fa-square fa-stack-2x text-primary"></i> <i class="fa fa-list-alt fa-stack-1x fa-inverse"></i> </span>
                  <h4 class="StepTitle" style="margin-top: 5%;">Prescriptions</h4>
                  <p class="links cl-effect-1">
                    <a href="#list-pres" onclick="clickDiv('#list-pres')">
                      <i class="fa fa-list-alt"></i> Prescription List
                    </a>
                  </p>
                </div>
              </div>
            </div>

            <div class="col-sm-3">
              <div class="panel panel-white no-radius text-center h-100">
                <div class="panel-body">
                  <span class="fa-stack fa-2x"> <i class="fa fa-square fa-stack-2x text-primary"></i> <i class="fa fa-file-text fa-stack-1x fa-inverse"></i> </span>
                  <h4 class="StepTitle" style="margin-top: 5%;">Documents</h4>
                  <p class="links cl-effect-1">
                    <a href="#list-docs" onclick="clickDiv('#list-docs')">
                      <i class="fa fa-file-text"></i> Patient Documents
                    </a>
                  </p>
                </div>
              </div>
            </div>

            <div class="col-sm-3">
              <div class="panel panel-white no-radius text-center h-100">
                <div class="panel-body">
                  <span class="fa-stack fa-2x"> <i class="fa fa-square fa-stack-2x text-primary"></i> <i class="fa fa-heartbeat fa-stack-1x fa-inverse"></i> </span>
                  <h4 class="StepTitle" style="margin-top: 5%;">Disease Prediction</h4>
                  <p class="links cl-effect-1">
                    <a href="#list-disease-pred" onclick="clickDiv('#list-disease-pred')">
                      <i class="fa fa-heartbeat"></i> Predict Disease
                    </a>
                  </p>
                </div>
              </div>
            </div>

            <div class="col-sm-3">
              <div class="panel panel-white no-radius text-center h-100">
                <div class="panel-body">
                  <span class="fa-stack fa-2x"> <i class="fa fa-square fa-stack-2x text-primary"></i> <i class="fa fa-stethoscope fa-stack-1x fa-inverse"></i> </span>
                  <h4 class="StepTitle" style="margin-top: 5%;">Brain Tumor Detection</h4>
                  <p class="links cl-effect-1">
                    <a href="#list-brain" onclick="clickDiv('#list-brain')">
                      <i class="fa fa-stethoscope"></i> Launch Detection
                    </a>
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    <div class="tab-pane fade" id="list-app" role="tabpanel" aria-labelledby="list-app-list">
        
              <table class="table table-hover">
                <thead>
                  <tr>
                    <th scope="col">Patient ID</th>
                    <th scope="col">Appointment ID</th>
                    <th scope="col">First Name</th>
                    <th scope="col">Last Name</th>
                    <th scope="col">Gender</th>
                    <th scope="col">Email</th>
                    <th scope="col">Contact</th>
                    <th scope="col">Appointment Date</th>
                    <th scope="col">Appointment Time</th>
                    <th scope="col">Current Status</th>
                    <th scope="col">Action</th>
                    <th scope="col">Prescribe</th>

                  </tr>
                </thead>
                <tbody>
                  <?php 
                    $con=mysqli_connect("localhost","root","","myhmsdb");
                    global $con;
                    $dname = $_SESSION['dname'];
                    $query = "select pid,ID,fname,lname,gender,email,contact,appdate,apptime,userStatus,doctorStatus,status from appointmenttb where doctor='$dname';";
                    $result = mysqli_query($con,$query);
                    while ($row = mysqli_fetch_array($result)){
                      ?>
                      <tr>
                      <td><?php echo $row['pid'];?></td>
                        <td><?php echo $row['ID'];?></td>
                        <td><?php echo $row['fname'];?></td>
                        <td><?php echo $row['lname'];?></td>
                        <td><?php echo $row['gender'];?></td>
                        <td><?php echo $row['email'];?></td>
                        <td><?php echo $row['contact'];?></td>
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
                      echo "Cancelled by You";
                    }
                        ?></td>

                     <td>
                        <?php if(($row['userStatus']==1) && ($row['doctorStatus']==1) && $row['status'] != 'completed')  
                        { ?>
                          <a href="doctor-panel.php?ID=<?php echo $row['ID']?>&complete=1" 
                              onClick="return confirm('Are you sure you want to mark this appointment as completed?')"
                              title="Complete Appointment" tooltip-placement="top" tooltip="Complete">
                              <button class="btn btn-success">Complete</button>
                          </a>
                          <a href="doctor-panel.php?ID=<?php echo $row['ID']?>&cancel=1" 
                              onClick="return confirm('Are you sure you want to cancel this appointment ?')"
                              title="Cancel Appointment" tooltip-placement="top" tooltip="Remove">
                              <button class="btn btn-danger">Cancel</button>
                          </a>
	                        <?php } else {
                            if($row['status'] == 'completed') {
                              echo "<span class='badge badge-success'>Completed</span>";
                            } else {
                              echo "<span class='badge badge-danger'>Cancelled</span>";
                            }
                          } ?>
                        </td>

                        <td>
                        <?php if(($row['userStatus']==1) && ($row['doctorStatus']==1) && $row['status'] != 'completed')  
                        { ?>
                        <a href="prescribe.php?pid=<?php echo $row['pid']?>&ID=<?php echo $row['ID']?>&fname=<?php echo $row['fname']?>&lname=<?php echo $row['lname']?>&appdate=<?php echo $row['appdate']?>&apptime=<?php echo $row['apptime']?>"
                        tooltip-placement="top" tooltip="Remove" title="prescribe">
                        <button class="btn btn-success">Prescibe</button></a>
                        <?php } else {
                            echo "-";
                        } ?>
                        </td>


                      </tr></a>
                    <?php } ?>
                </tbody>
              </table>
        <br>
      </div>

      

      <div class="tab-pane fade" id="list-pres" role="tabpanel" aria-labelledby="list-pres-list">
        <table class="table table-hover">
                <thead>
                  <tr>
                    
                    <th scope="col">Patient ID</th>
                    
                    <th scope="col">First Name</th>
                    <th scope="col">Last Name</th>
                    <th scope="col">Appointment ID</th>
                    <th scope="col">Appointment Date</th>
                    <th scope="col">Appointment Time</th>
                    <th scope="col">Disease</th>
                    <th scope="col">Allergy</th>
                    <th scope="col">Prescribe</th>
                  </tr>
                </thead>
                <tbody>
                  <?php 

                    $con=mysqli_connect("localhost","root","","myhmsdb");
                    global $con;

                    $query = "select pid,fname,lname,ID,appdate,apptime,disease,allergy,prescription from prestb where doctor='$doctor';";
                    
                    $result = mysqli_query($con,$query);
                    if(!$result){
                      echo mysqli_error($con);
                    }
                    

                    while ($row = mysqli_fetch_array($result)){
                  ?>
                      <tr>
                        <td><?php echo $row['pid'];?></td>
                        <td><?php echo $row['fname'];?></td>
                        <td><?php echo $row['lname'];?></td>
                        <td><?php echo $row['ID'];?></td>
                        
                        <td><?php echo $row['appdate'];?></td>
                        <td><?php echo $row['apptime'];?></td>
                        <td><?php echo $row['disease'];?></td>
                        <td><?php echo $row['allergy'];?></td>
                        <td><?php echo $row['prescription'];?></td>
                    
                      </tr>
                    <?php }
                    ?>
                </tbody>
              </table>
      </div>




      <div class="tab-pane fade" id="list-docs" role="tabpanel" aria-labelledby="list-docs-list">
          <div class="card">
              <div class="card-body">
                  <h4 class="card-title">Patient Documents</h4>
                  
                  <!-- Patient Selection -->
                  <div class="form-group mb-4">
                      <label for="patient-select">Select Patient:</label>
                      <select class="form-control" id="patient-select" onchange="loadPatientDocuments(this.value)">
                          <option value="">Select a patient</option>
                          <?php
                          $patients_query = mysqli_query($con, "SELECT DISTINCT p.pid, p.fname, p.lname 
                                                              FROM appointmenttb a 
                                                              JOIN patreg p ON a.pid = p.pid 
                                                              WHERE a.doctor='$doctor' 
                                                              ORDER BY p.fname, p.lname");
                          while($patient = mysqli_fetch_array($patients_query)) {
                              echo "<option value='{$patient['pid']}'>{$patient['fname']} {$patient['lname']}</option>";
                          }
                          ?>
                      </select>
                  </div>
                  
                  <!-- Upload Document Form -->
                  <div class="mb-4" id="upload-form" style="display: none;">
                      <h5>Upload New Document</h5>
                      <form action="document_handler.php" method="post" enctype="multipart/form-data" class="form-group">
                          <input type="hidden" name="doctor_id" value="<?php echo $doctor; ?>">
                          <input type="hidden" name="uploaded_by" value="doctor">
                          <input type="hidden" name="pid" id="upload-pid">
                          
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
                  <div id="documents-list">
                      <p class="text-muted">Please select a patient to view their documents.</p>
                  </div>
              </div>
          </div>
      </div>

      <div class="tab-pane fade" id="list-disease-pred" role="tabpanel" aria-labelledby="list-disease-pred-list">
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Multiple Disease Prediction System</h4>
                    <p class="card-text">Use our advanced AI-powered system to assist in early disease detection and patient screening.</p>
                    
                    <div class="row mt-4">
                        <div class="col-md-6">
                            <h5>Available Disease Predictions:</h5>
                            <ul class="list-unstyled">
                                <li><i class="fa fa-check-circle text-success"></i> Diabetes</li>
                                <li><i class="fa fa-check-circle text-success"></i> Heart Disease</li>
                                <li><i class="fa fa-check-circle text-success"></i> Parkinson's Disease</li>
                                <li><i class="fa fa-check-circle text-success"></i> Liver Disease</li>
                                <li><i class="fa fa-check-circle text-success"></i> Hepatitis</li>
                                <li><i class="fa fa-check-circle text-success"></i> Jaundice</li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <h5>Key Features:</h5>
                            <ul class="list-unstyled">
                                <li><i class="fa fa-arrow-right text-primary"></i> Symptom-based analysis</li>
                                <li><i class="fa fa-arrow-right text-primary"></i> Medical history integration</li>
                                <li><i class="fa fa-arrow-right text-primary"></i> Lab results interpretation</li>
                                <li><i class="fa fa-arrow-right text-primary"></i> Risk factor assessment</li>
                                <li><i class="fa fa-arrow-right text-primary"></i> Instant prediction results</li>
                            </ul>
                        </div>
                    </div>

                    <div class="text-center my-4">
                        <a href="https://multiple-disease-prediction-hms.streamlit.app/" target="_blank" class="btn btn-primary btn-lg">
                            <i class="fa fa-stethoscope"></i> Launch Disease Prediction Tool
                        </a>
                    </div>

                    <div class="alert alert-info mt-4">
                        <h5><i class="fa fa-info-circle"></i> How to Use:</h5>
                        <ol>
                            <li>Click the button above to open the prediction system</li>
                            <li>Select the disease type you want to predict</li>
                            <li>Enter patient's symptoms and medical data</li>
                            <li>Review the prediction results</li>
                            <li>Use results to support your clinical diagnosis</li>
                        </ol>
                    </div>

                    <div class="alert alert-warning">
                        <strong><i class="fa fa-exclamation-triangle"></i> Professional Note:</strong>
                        <p class="mb-0">This tool is designed to assist in clinical decision-making but should not replace professional medical judgment. Always combine prediction results with proper clinical examination and diagnostic tests.</p>
                    </div>
                </div>
            </div>
        </div>
      </div>

      <div class="tab-pane fade" id="list-brain" role="tabpanel" aria-labelledby="list-brain-list">
        <div class="container-fluid">
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
                            <i class="fa fa-stethoscope"></i> Launch Brain Tumor Detection Tool
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
                        <strong><i class="fa fa-exclamation-triangle"></i> Professional Note:</strong>
                        <p class="mb-0">This tool is designed to assist in clinical decision-making but should not replace professional medical judgment. Always combine detection results with proper clinical examination and diagnostic tests.</p>
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.10.1/sweetalert2.all.min.js"></script>
    <!-- Add chat button before closing body tag -->
    <a href="https://hospital-management-system-chatbot.streamlit.app/" target="_blank" class="chat-button" title="Chat with us">
        <i class="fa fa-comments"></i>
    </a>

    <!-- Add this JavaScript for handling document list updates -->
    <script>
    function loadPatientDocuments(pid) {
        if (!pid) {
            document.getElementById('upload-form').style.display = 'none';
            document.getElementById('documents-list').innerHTML = '<p class="text-muted">Please select a patient to view their documents.</p>';
            return;
        }
        
        document.getElementById('upload-form').style.display = 'block';
        document.getElementById('upload-pid').value = pid;
        
        // Fetch documents using AJAX
        fetch('get_patient_documents.php?pid=' + pid)
            .then(response => response.text())
            .then(html => {
                document.getElementById('documents-list').innerHTML = html;
            })
            .catch(error => {
                console.error('Error:', error);
                document.getElementById('documents-list').innerHTML = '<p class="text-danger">Error loading documents.</p>';
            });
    }
    </script>

    <?php
    // Show alert if exists in session and then clear it
    if(isset($_SESSION['success_msg'])) {
        echo '<script>
            window.onload = function() {
                alert("'.$_SESSION['success_msg'].'");
            }
        </script>';
        unset($_SESSION['success_msg']);
    }
    ?>

    <style>
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

    <script>
    function clickDiv(id) {
      // Remove the '#' if present
      const baseId = id.replace('#', '');
      
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
      document.querySelectorAll('.panel-body a').forEach(link => {
        link.addEventListener('click', function(e) {
          if (this.getAttribute('onclick')) {
            e.preventDefault();
            const targetId = this.getAttribute('href');
            clickDiv(targetId);
          }
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

    <!-- Add this before the closing body tag -->
    <script>
    // Load patient data when selected
    function loadPatientData(pid) {
        if (!pid) {
            document.getElementById('lab-results').innerHTML = '<p class="text-muted">Select a patient to view lab results analysis.</p>';
            return;
        }

        // Fetch patient's health records and lab results
        fetch('get_patient_health_data.php?pid=' + pid)
            .then(response => response.json())
            .then(data => {
                // Update lab results section
                let labHtml = '<div class="table-responsive"><table class="table table-bordered">';
                labHtml += '<thead><tr><th>Test</th><th>Result</th><th>Reference Range</th><th>Status</th></tr></thead><tbody>';
                
                // Add sample lab results (replace with actual data from database)
                if (data.lab_results && data.lab_results.length > 0) {
                    data.lab_results.forEach(result => {
                        labHtml += `<tr>
                            <td>${result.test}</td>
                            <td>${result.value}</td>
                            <td>${result.range}</td>
                            <td><span class="badge badge-${result.status === 'Normal' ? 'success' : 'warning'}">${result.status}</span></td>`;
                    });
                } else {
                    labHtml += '<tr><td colspan="4" class="text-center">No lab results available</td></tr>';
                }
                
                labHtml += '</tbody></table></div>';
                document.getElementById('lab-results').innerHTML = labHtml;
            })
            .catch(error => {
                console.error('Error:', error);
                document.getElementById('lab-results').innerHTML = '<p class="text-danger">Error loading patient data.</p>';
            });
    }

    // Analyze symptoms
    function analyzeSymptoms() {
        const symptoms = document.getElementById('symptoms').value.trim();
        if (!symptoms) {
            alert('Please enter symptoms');
            return;
        }

        const resultsDiv = document.getElementById('symptom-results');
        resultsDiv.innerHTML = '<div class="text-center"><div class="spinner-border text-primary" role="status"></div></div>';

        // Call the symptom analysis API
        fetch('analyze_symptoms.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ symptoms: symptoms.split(',').map(s => s.trim()) })
        })
        .then(response => response.json())
        .then(data => {
            let html = '<div class="alert alert-info">';
            html += '<h6>Possible Conditions:</h6><ul>';
            data.conditions.forEach(condition => {
                html += `<li><strong>${condition.name}</strong> (${condition.probability}% probability)
                    <br><small class="text-muted">Key Indicators: ${condition.indicators}</small></li>`;
            });
            html += '</ul></div>';
            resultsDiv.innerHTML = html;
        })
        .catch(error => {
            console.error('Error:', error);
            resultsDiv.innerHTML = '<div class="alert alert-danger">Error analyzing symptoms. Please try again.</div>';
        });
    }

    // Get treatment recommendations
    function getTreatmentRecommendations() {
        const diagnosis = document.getElementById('diagnosis').value.trim();
        if (!diagnosis) {
            alert('Please enter a diagnosis');
            return;
        }

        const resultsDiv = document.getElementById('treatment-results');
        resultsDiv.innerHTML = '<div class="text-center"><div class="spinner-border text-primary" role="status"></div></div>';

        // Call the treatment recommendations API
        fetch('get_treatment_recommendations.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ diagnosis: diagnosis })
        })
        .then(response => response.json())
        .then(data => {
            let html = '<div class="alert alert-info">';
            html += '<h6>Recommended Treatments:</h6><ul>';
            data.treatments.forEach(treatment => {
                html += `<li><strong>${treatment.name}</strong>
                    <br><small class="text-muted">${treatment.description}</small>
                    <br><small class="text-muted">Evidence Level: ${treatment.evidence_level}</small></li>`;
            });
            html += '</ul></div>';
            resultsDiv.innerHTML = html;
        })
        .catch(error => {
            console.error('Error:', error);
            resultsDiv.innerHTML = '<div class="alert alert-danger">Error getting treatment recommendations. Please try again.</div>';
        });
    }

    // Check drug interactions
    function checkDrugInteractions() {
        const medications = document.getElementById('medications').value.trim();
        if (!medications) {
            alert('Please enter medications');
            return;
        }

        const resultsDiv = document.getElementById('interaction-results');
        resultsDiv.innerHTML = '<div class="text-center"><div class="spinner-border text-primary" role="status"></div></div>';

        // Call the drug interactions API
        fetch('check_drug_interactions.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ medications: medications.split(',').map(m => m.trim()) })
        })
        .then(response => response.json())
        .then(data => {
            let html = '<div class="alert alert-info">';
            if (data.interactions.length > 0) {
                html += '<h6>Potential Interactions Found:</h6><ul>';
                data.interactions.forEach(interaction => {
                    html += `<li><strong>${interaction.drugs.join(' + ')}</strong>
                        <br><span class="badge badge-${interaction.severity === 'High' ? 'danger' : 
                                                      interaction.severity === 'Moderate' ? 'warning' : 'info'}">${interaction.severity}</span>
                        <br><small class="text-muted">${interaction.description}</small></li>`;
                });
                html += '</ul>';
            } else {
                html += '<p class="mb-0">No significant drug interactions found.</p>';
            }
            html += '</div>';
            resultsDiv.innerHTML = html;
        })
        .catch(error => {
            console.error('Error:', error);
            resultsDiv.innerHTML = '<div class="alert alert-danger">Error checking drug interactions. Please try again.</div>';
        });
    }
    </script>
  </body>
</html>
