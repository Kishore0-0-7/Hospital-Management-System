<!DOCTYPE html>
<?php
include('func1.php');
$pid='';
$ID='';
$appdate='';
$apptime='';
$fname = '';
$lname= '';
$doctor = $_SESSION['dname'];

// Handle completion
if(isset($_GET['complete']) && isset($_GET['ID'])) {
  $query = mysqli_query($con,"update appointmenttb set status='completed' where ID = '".$_GET['ID']."'");
  if($query) {
    $_SESSION['success_msg'] = "Appointment marked as completed successfully!";
    header("Location: doctor-panel.php");
    exit();
  }
}

// Handle prescription submission
if(isset($_POST['prescribe']) && isset($_POST['pid']) && isset($_POST['ID']) && isset($_POST['appdate']) && isset($_POST['apptime']) && isset($_POST['lname']) && isset($_POST['fname'])){
  $appdate = $_POST['appdate'];
  $apptime = $_POST['apptime'];
  $disease = $_POST['disease'];
  $allergy = $_POST['allergy'];
  $fname = $_POST['fname'];
  $lname = $_POST['lname'];
  $pid = $_POST['pid'];
  $ID = $_POST['ID'];
  $prescription = $_POST['prescription'];
  
  $query=mysqli_query($con,"insert into prestb(doctor,pid,ID,fname,lname,appdate,apptime,disease,allergy,prescription) values ('$doctor','$pid','$ID','$fname','$lname','$appdate','$apptime','$disease','$allergy','$prescription')");
  if($query) {
    $_SESSION['success_msg'] = "Prescription added successfully!";
    header("Location: prescribe.php?pid=$pid&ID=$ID&fname=$fname&lname=$lname&appdate=$appdate&apptime=$apptime");
    exit();
  } else {
    $_SESSION['error_msg'] = "Error adding prescription. Please try again.";
    header("Location: prescribe.php?pid=$pid&ID=$ID&fname=$fname&lname=$lname&appdate=$appdate&apptime=$apptime");
    exit();
  }
}

// Get appointment details from URL
if(isset($_GET['pid']) && isset($_GET['ID']) && isset($_GET['appdate']) && isset($_GET['apptime']) && isset($_GET['fname']) && isset($_GET['lname'])) {
  $pid = $_GET['pid'];
  $ID = $_GET['ID'];
  $fname = $_GET['fname'];
  $lname = $_GET['lname'];
  $appdate = $_GET['appdate'];
  $apptime = $_GET['apptime'];
}

?>

<html lang="en">
  <head>


    <!-- Required meta tags -->
    <meta charset="utf-8">
    <link rel="shortcut icon" type="image/x-icon" href="images/favicon.png" />
    <meta name="viewport" content="width=device-width, -scale=1, shrink-to-fit=no">
    <link rel="stylesheet" type="text/css" href="font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="style.css">
    <!-- Bootstrap CSS -->
    
        <link rel="stylesheet" href="vendor/fontawesome/css/font-awesome.min.css">

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    
    <link href="https://fonts.googleapis.com/css?family=IBM+Plex+Sans&display=swap" rel="stylesheet">
      <nav class="navbar navbar-expand-lg navbar-dark bg-primary fixed-top">
  <a class="navbar-brand" href="#"><i class="fa fa-user-plus" aria-hidden="true"></i> Global Hospital </a>
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
  </style>

<div class="collapse navbar-collapse" id="navbarSupportedContent">
     <ul class="navbar-nav mr-auto">
       <li class="nav-item">
        <a class="nav-link" href="logout1.php"><i class="fa fa-sign-out" aria-hidden="true"></i>Logout</a>
        
      </li>
       <li class="nav-item">
       <a class="nav-link" href="doctor-panel.php"><i class="fa fa-sign-out" aria-hidden="true"></i>Back</a>
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
<?php
// Show alerts if they exist in session and then clear them
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
    <h3 style = "margin-left: 40%;  padding-bottom: 20px; font-family: 'IBM Plex Sans', sans-serif;"> Welcome &nbsp<?php echo $doctor ?>
   </h3>

   <!-- Add Patient Details Section -->
   <div class="card mb-4">
     <div class="card-header">
       <h5 class="card-title">Patient Information</h5>
     </div>
     <div class="card-body">
       <div class="row">
         <div class="col-md-6">
           <h6>Personal Details</h6>
           <p><strong>Patient ID:</strong> <?php echo $pid; ?></p>
           <p><strong>Name:</strong> <?php echo $fname . ' ' . $lname; ?></p>
           <?php
           // Fetch patient details
           $pat_query = mysqli_query($con, "SELECT * FROM patreg WHERE pid='$pid'");
           if($pat_info = mysqli_fetch_array($pat_query)) {
             echo "<p><strong>Gender:</strong> ".$pat_info['gender']."</p>";
             echo "<p><strong>Email:</strong> ".$pat_info['email']."</p>";
             echo "<p><strong>Contact:</strong> ".$pat_info['contact']."</p>";
           }
           ?>
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
       <!-- Update Health Details Form -->
       <form class="form-group" method="post" action="update_health_details.php">
         <input type="hidden" name="pid" value="<?php echo $pid; ?>" />
         <div class="row">
           <div class="col-md-6">
             <label>Age:</label>
             <input type="number" class="form-control" name="age" value="<?php echo $health_info['age']; ?>" required>
           </div>
           <div class="col-md-6">
             <label>Blood Group:</label>
             <select class="form-control" name="blood_group" required>
               <option value="">Select Blood Group</option>
               <option value="A+" <?php if($health_info['blood_group'] == 'A+') echo 'selected'; ?>>A+</option>
               <option value="A-" <?php if($health_info['blood_group'] == 'A-') echo 'selected'; ?>>A-</option>
               <option value="B+" <?php if($health_info['blood_group'] == 'B+') echo 'selected'; ?>>B+</option>
               <option value="B-" <?php if($health_info['blood_group'] == 'B-') echo 'selected'; ?>>B-</option>
               <option value="AB+" <?php if($health_info['blood_group'] == 'AB+') echo 'selected'; ?>>AB+</option>
               <option value="AB-" <?php if($health_info['blood_group'] == 'AB-') echo 'selected'; ?>>AB-</option>
               <option value="O+" <?php if($health_info['blood_group'] == 'O+') echo 'selected'; ?>>O+</option>
               <option value="O-" <?php if($health_info['blood_group'] == 'O-') echo 'selected'; ?>>O-</option>
             </select>
           </div>
         </div><br>
         <div class="row">
           <div class="col-md-6">
             <label>Weight (kg):</label>
             <input type="number" step="0.01" class="form-control" name="weight" value="<?php echo $health_info['weight']; ?>" required>
           </div>
           <div class="col-md-6">
             <label>Height (cm):</label>
             <input type="number" step="0.01" class="form-control" name="height" value="<?php echo $health_info['height']; ?>" required>
           </div>
         </div><br>
         <div class="row">
           <div class="col-md-6">
             <label>Medical Conditions:</label>
             <textarea class="form-control" name="medical_conditions" rows="3"><?php echo $health_info['medical_conditions']; ?></textarea>
           </div>
           <div class="col-md-6">
             <label>Allergies:</label>
             <textarea class="form-control" name="allergies" rows="3"><?php echo $health_info['allergies']; ?></textarea>
           </div>
         </div><br>
         <div class="row">
           <div class="col-md-6">
             <label>Emergency Contact:</label>
             <input type="text" class="form-control" name="emergency_contact" value="<?php echo $health_info['emergency_contact']; ?>" required>
           </div>
           <div class="col-md-6">
             <label>Emergency Contact Phone:</label>
             <input type="text" class="form-control" name="emergency_contact_phone" value="<?php echo $health_info['emergency_contact_phone']; ?>" required>
           </div>
         </div><br>
         <input type="submit" name="update_health_details" value="Update Details" class="btn btn-primary">
       </form>
     </div>
   </div>

   <!-- Previous Prescriptions -->
   <div class="card mb-4">
     <div class="card-header">
       <h5 class="card-title">Previous Prescriptions</h5>
     </div>
     <div class="card-body">
       <div class="table-responsive">
         <table class="table table-bordered">
           <thead>
             <tr></tr>
               <th>Date</th>
               <th>Doctor</th>
               <th>Disease</th>
               <th>Allergies</th>
               <th>Prescription</th>
             </tr>
           </thead>
           <tbody>
             <?php
             $prev_pres_query = mysqli_query($con, "SELECT * FROM prestb WHERE pid='$pid' ORDER BY appdate DESC");
             while($prev_pres = mysqli_fetch_array($prev_pres_query)) {
               echo "<tr>";
               echo "<td>".$prev_pres['appdate']."</td>";
               echo "<td>".$prev_pres['doctor']."</td>";
               echo "<td>".$prev_pres['disease']."</td>";
               echo "<td>".$prev_pres['allergy']."</td>";
               echo "<td>".$prev_pres['prescription']."</td>";
               echo "</tr>";
             }
             ?>
           </tbody>
         </table>
       </div>
     </div>
   </div>

   <!-- Original Prescription Form -->
   <div class="tab-pane" id="list-pres" role="tabpanel" aria-labelledby="list-pres-list"></div>
        <form class="form-group" name="prescribeform" method="post" action="prescribe.php">
        
          <div class="row">
                  <div class="col-md-4"><label>Disease:</label></div>
                  <div class="col-md-8">
                  <!-- <input type="text" class="form-control" name="disease" required> -->
                  <textarea id="disease" cols="86" rows ="5" name="disease" required></textarea>
                  </div><br><br><br>
                  
                  <div class="col-md-4"><label>Allergies:</label></div>
                  <div class="col-md-8">
                  <!-- <input type="text"  class="form-control" name="allergy" required> -->
                  <textarea id="allergy" cols="86" rows ="5" name="allergy" required></textarea>
                  </div><br><br><br>
                  <div class="col-md-4"><label>Prescription:</label></div>
                  <div class="col-md-8">
                  <!-- <input type="text" class="form-control"  name="prescription"  required> -->
                  <textarea id="prescription" cols="86" rows ="10" name="prescription" required></textarea>
                  </div><br><br><br>
                  <input type="hidden" name="fname" value="<?php echo $fname ?>" />
                  <input type="hidden" name="lname" value="<?php echo $lname ?>" />
                  <input type="hidden" name="appdate" value="<?php echo $appdate ?>" />
                  <input type="hidden" name="apptime" value="<?php echo $apptime ?>" />
                  <input type="hidden" name="pid" value="<?php echo $pid ?>" />
                  <input type="hidden" name="ID" value="<?php echo $ID ?>" />
                  <br><br><br><br>
                  <div class="row">
                    <div class="col-md-6">
                      <input type="submit" name="prescribe" value="Prescribe" class="btn btn-primary" style="margin-left: 40pc;">
                    </div>
                    <div class="col-md-6">
                      <a href="prescribe.php?ID=<?php echo $ID?>&complete=true" 
                        onClick="return confirm('Have you added the prescription? Clicking OK will mark this appointment as completed.')"
                        class="btn btn-success" style="margin-left: 40pc;">
                        Complete Appointment
                      </a>
                    </div>
                  </div>
                </form>
                <br>
        
      </div>
      </div>



