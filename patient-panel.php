  <a class="list-group-item list-group-item-action" href="#list-doc" id="list-doc-list" role="tab" data-toggle="list" aria-controls="home">Book Appointment</a>
  <a class="list-group-item list-group-item-action" href="#list-pat" id="list-pat-list" role="tab" data-toggle="list" aria-controls="home">My Appointments</a>
  <a class="list-group-item list-group-item-action" href="#list-pres" id="list-pres-list" role="tab" data-toggle="list" aria-controls="home">My Prescriptions</a>
  <a class="list-group-item list-group-item-action" href="#list-feedback" id="list-feedback-list" role="tab" data-toggle="list" aria-controls="home">Give Feedback</a>
  <a class="list-group-item list-group-item-action" href="#list-disease-pred" id="list-disease-pred-list" role="tab" data-toggle="list" aria-controls="home">Disease Prediction</a>
  <a class="list-group-item list-group-item-action" href="#list-brain" id="list-brain-list" role="tab" data-toggle="list" aria-controls="home">Brain Tumor Detection</a>

  <div class="tab-pane fade" id="list-feedback" role="tabpanel" aria-labelledby="list-feedback-list">
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Give Feedback</h4>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Doctor</th>
                                <th>Appointment Date</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $pid = $_SESSION['pid'];
                            $query = mysqli_query($con, "SELECT a.*, d.username as doctor_name 
                                                       FROM appointmenttb a 
                                                       JOIN doctb d ON a.doctor = d.username 
                                                       WHERE a.pid = '$pid' AND a.status = 'completed' 
                                                       AND NOT EXISTS (
                                                           SELECT 1 FROM feedback f 
                                                           WHERE f.appointment_id = a.ID
                                                       )
                                                       ORDER BY a.appdate DESC");
                            
                            while($row = mysqli_fetch_array($query)) {
                            ?>
                            <tr>
                                <td><?php echo $row['doctor_name']; ?></td>
                                <td><?php echo $row['appdate'] . ' ' . $row['apptime']; ?></td>
                                <td>Completed</td>
                                <td>
                                    <button type="button" class="btn btn-primary" 
                                            data-toggle="modal" 
                                            data-target="#feedbackModal" 
                                            data-doctor="<?php echo $row['doctor']; ?>"
                                            data-appointment="<?php echo $row['ID']; ?>">
                                        Give Feedback
                                    </button>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>

                <!-- Previous Feedback -->
                <h5 class="mt-4">My Previous Feedback</h5>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Doctor</th>
                                <th>Date</th>
                                <th>Rating</th>
                                <th>Comments</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $feedback_query = mysqli_query($con, "SELECT f.*, d.username as doctor_name 
                                                                FROM feedback f 
                                                                JOIN doctb d ON f.doctor_id = d.username 
                                                                WHERE f.patient_id = '$pid' 
                                                                ORDER BY f.feedback_date DESC");
                            
                            while($feedback = mysqli_fetch_array($feedback_query)) {
                            ?>
                            <tr>
                                <td><?php echo $feedback['doctor_name']; ?></td>
                                <td><?php echo date('Y-m-d', strtotime($feedback['feedback_date'])); ?></td>
                                <td>
                                    <?php 
                                    for($i = 1; $i <= 5; $i++) {
                                        echo $i <= $feedback['rating'] ? '★' : '☆';
                                    }
                                    ?>
                                </td>
                                <td><?php echo $feedback['comments']; ?></td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Feedback Modal -->
    <div class="modal fade" id="feedbackModal" tabindex="-1" role="dialog" aria-labelledby="feedbackModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="feedbackModalLabel">Give Feedback</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="submit_feedback.php" method="POST">
                    <div class="modal-body">
                        <input type="hidden" name="patient_id" value="<?php echo $pid; ?>">
                        <input type="hidden" name="doctor_id" id="modal_doctor_id">
                        <input type="hidden" name="appointment_id" id="modal_appointment_id">
                        
                        <div class="form-group">
                            <label>Rating:</label>
                            <div class="rating">
                                <?php for($i = 5; $i >= 1; $i--) { ?>
                                <input type="radio" name="rating" value="<?php echo $i; ?>" id="star<?php echo $i; ?>" required>
                                <label for="star<?php echo $i; ?>"><?php echo $i; ?> stars</label>
                                <?php } ?>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="comments">Comments:</label>
                            <textarea class="form-control" name="comments" rows="3" required></textarea>
                        </div>
                        
                        <div class="form-group">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="anonymous" name="anonymous">
                                <label class="custom-control-label" for="anonymous">Submit Anonymously</label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Submit Feedback</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
  </div> 

  <div class="tab-pane fade" id="list-disease-pred" role="tabpanel" aria-labelledby="list-disease-pred-list">
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Multiple Disease Prediction</h4>
                <p class="card-text">Check your health status using our AI-powered disease prediction tool. This tool can help predict various diseases based on your symptoms and health parameters.</p>
                <div class="text-center">
                    <a href="https://multiple-disease-prediction-hms.streamlit.app/" target="_blank" class="btn btn-primary">
                        <i class="fa fa-heartbeat"></i> Check Your Health Status
                    </a>
                </div>
                <div class="mt-4">
                    <h5>Available Health Checks:</h5>
                    <ul>
                        <li>Diabetes Risk Assessment</li>
                        <li>Heart Disease Risk Evaluation</li>
                        <li>Parkinsons Disease Screening</li>
                    </ul>
                    <div class="alert alert-warning" role="alert">
                        <i class="fa fa-info-circle"></i> Note: This is a preliminary screening tool. Please consult with your doctor for proper medical diagnosis.
                    </div>
                </div>
            </div>
        </div>
    </div>
  </div>

  <div class="tab-pane fade" id="list-brain" role="tabpanel" aria-labelledby="list-brain-list">
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Brain Tumor Detection</h4>
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
                        <i class="fa fa-heartbeat"></i> Launch Detection System
                    </a>
                </div>

                <div class="alert alert-info mt-4">
                    <h5><i class="fa fa-info-circle"></i> How to Use:</h5>
                    <ol>
                        <li>Click the button above to open the detection system</li>
                        <li>Upload your MRI scan</li>
                        <li>Wait for the AI analysis</li>
                        <li>Review the detection results</li>
                        <li>Share results with your doctor</li>
                    </ol>
                </div>

                <div class="alert alert-warning">
                    <strong><i class="fa fa-exclamation-triangle"></i> Important Note:</strong>
                    <p class="mb-0">This tool is designed to assist in early detection but should not replace professional medical diagnosis. Always consult with your healthcare provider regarding the results.</p>
                </div>
            </div>
        </div>
    </div>
  </div>

  <style>
        /* Existing styles */

        /* Star Rating Styles */
        .rating {
            display: flex;
            flex-direction: row-reverse;
            justify-content: flex-end;
        }

        .rating input {
            display: none;
        }

        .rating label {
            cursor: pointer;
            width: 40px;
            height: 40px;
            margin-top: 0;
            background-repeat: no-repeat;
            background-position: center;
            background-size: 76%;
            transition: .3s;
            filter: grayscale(100%);
            opacity: 0.5;
        }

        .rating label:before {
            content: '★';
            font-size: 30px;
            color: #ffd700;
        }

        .rating input:checked ~ label,
        .rating input:checked ~ label ~ label {
            filter: grayscale(0);
            opacity: 1;
        }

        .rating label:hover,
        .rating label:hover ~ label {
            filter: grayscale(0);
            opacity: 1;
        }
    </style>

    <script>
        // Existing scripts

        // Feedback Modal Handler
        $('#feedbackModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var doctor = button.data('doctor');
            var appointment = button.data('appointment');
            
            var modal = $(this);
            modal.find('#modal_doctor_id').val(doctor);
            modal.find('#modal_appointment_id').val(appointment);
        });

        // Show success/error messages
        <?php if(isset($_SESSION['feedback_success'])) { ?>
            alert('<?php echo $_SESSION['feedback_success']; ?>');
            <?php unset($_SESSION['feedback_success']); ?>
        <?php } ?>
        
        <?php if(isset($_SESSION['feedback_error'])) { ?>
            alert('<?php echo $_SESSION['feedback_error']; ?>');
            <?php unset($_SESSION['feedback_error']); ?>
        <?php } ?>
    </script> 