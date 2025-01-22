<?php
include('func1.php');
$con = mysqli_connect("localhost","root","","myhmsdb");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Availability</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <style>
        .schedule-container {
            padding: 20px;
        }
        .schedule-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
            gap: 15px;
            margin-top: 20px;
        }
        .time-slot {
            background: #fff;
            border: 1px solid #ddd;
            padding: 15px;
            border-radius: 8px;
            text-align: center;
            transition: all 0.3s ease;
        }
        .time-slot:hover {
            transform: translateY(-3px);
            box-shadow: 0 3px 10px rgba(0,0,0,0.1);
        }
        .time-slot .time {
            font-size: 1.1em;
            font-weight: bold;
            margin-bottom: 8px;
        }
        .time-slot .doctor {
            color: #666;
            margin-bottom: 8px;
        }
        .time-slot .status {
            font-weight: bold;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 0.9em;
        }
        .time-slot.available {
            border-color: #28a745;
        }
        .time-slot.booked {
            border-color: #dc3545;
        }
        .time-slot.available .status {
            background-color: #d4edda;
            color: #155724;
        }
        .time-slot.booked .status {
            background-color: #f8d7da;
            color: #721c24;
        }
        .filters {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        .legend {
            display: flex;
            justify-content: center;
            gap: 30px;
            margin: 20px 0;
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
</head>
<body>
    <div class="schedule-container">
        <div class="filters">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label><strong>Select Doctor:</strong></label>
                        <select class="form-control" id="doctorSelect">
                            <option value="">All Doctors</option>
                            <?php
                            $doctors_query = mysqli_query($con, "SELECT username FROM doctb ORDER BY username");
                            while($doctor = mysqli_fetch_array($doctors_query)) {
                                echo "<option value='{$doctor['username']}'>{$doctor['username']}</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label><strong>Select Date:</strong></label>
                        <input type="date" class="form-control" id="dateSelect">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label><strong>Filter Status:</strong></label>
                        <select class="form-control" id="statusFilter">
                            <option value="all">All Slots</option>
                            <option value="available">Available Only</option>
                            <option value="booked">Booked Only</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <div class="legend">
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
            <!-- Will be populated by JavaScript -->
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
    $(document).ready(function() {
        // Set default date to today
        var today = new Date().toISOString().split('T')[0];
        $('#dateSelect').val(today);
        $('#dateSelect').attr('min', today);

        function updateSchedule() {
            var doctor = $('#doctorSelect').val();
            var date = $('#dateSelect').val();
            var status = $('#statusFilter').val();

            $.ajax({
                url: 'get_daily_schedule.php',
                type: 'POST',
                data: {
                    doctor: doctor,
                    date: date,
                    status: status
                },
                success: function(response) {
                    $('#scheduleGrid').html(response);
                }
            });
        }

        // Update schedule when filters change
        $('#doctorSelect, #dateSelect, #statusFilter').change(updateSchedule);

        // Initial load
        updateSchedule();
    });
    </script>
</body>
</html> 