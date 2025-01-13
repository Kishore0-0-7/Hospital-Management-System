<?php 
include 'common.php';
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <link rel="shortcut icon" type="image/x-icon" href="../images/favicon.png" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" type="text/css" href="../font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="../style.css">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="../vendor/fontawesome/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css?family=IBM+Plex+Sans&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="nav2.css">
    <link rel="stylesheet" type="text/css" href="table1.css">
    
    <style type="text/css">
        /* Main content positioning */
        .main-content {
            margin-left: 250px;
            padding-top: 70px;
            min-height: 100vh;
            background: #f8f9fa;
        }

        /* Table styling */
        .table-responsive {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
        }

        #table1 {
            width: 100%;
            margin-bottom: 0;
            white-space: nowrap;
            margin-left: 150px;
  margin-right: auto;
        }

        #table1 thead th {
            background: #342ac1;
            color: white;
            padding: 15px;
            font-weight: 500;
        }

        #table1 tbody tr:hover {
            background: rgba(52,42,193,0.05);
        }

        /* Card modifications */
        .card {
            border: none;
            margin-bottom: 30px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
        }

        .head {
            background: -webkit-linear-gradient(left, #3931af, #00c6ff);
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 8px;
            color: white;
        }

        @media screen and (max-width: 768px) {
            .main-content {
                margin-left: 0;
                padding: 15px;
            }
            
            .table-responsive {
                padding: 10px;
            }
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary fixed-top">
        <a class="navbar-brand" href="#"><i class="fa fa-user-plus"></i>The Care Crew Hospital Inventory </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto" style="margin-inline: 1000px;">
                <li class="nav-item">
                    <a class="nav-link" href="../admin-panel1.php" style="color: rgb(255, 255, 255);"><i class="fa fa-sign-out"></i> Back to Admin</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="main-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="head">
                        <h2 class="mb-0" style="color: white;">INVENTORY MANAGEMENT</h2>
                    </div>
                    
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="table1">
                                    <thead>
                                        <tr>
                                            <th>Inventory ID</th>
                                            <th>Item Name</th>
                                            <th>Current Stock</th>
                                            <th>Cost Per Unit</th>
                                            <th>Expiry Date</th>
                                            <th>Supplier Name</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        include "config.php";
                                        $sql = "SELECT * FROM combined_view";
                                        $result = $conn->query($sql);
                                        if ($result->num_rows > 0) {
                                            while($row = $result->fetch_assoc()) {
                                                echo "<tr>";
                                                echo "<td>" . $row["InventoryID"] . "</td>";
                                                echo "<td>" . $row["ItemName"] . "</td>";
                                                echo "<td>" . $row["CurrentStock"] . "</td>";
                                                echo "<td>" . $row["CostPerUnit"] . "</td>";
                                                echo "<td>" . $row["ExpiryDate"] . "</td>";
                                                echo "<td>" . $row["SupplierName"] . "</td>";
                                                echo "</tr>";
                                            }
                                        } else {
                                            echo "<tr><td colspan='6'>No inventory found.</td></tr>";
                                        }
                                        $conn->close();
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    
                </div>
            </div>
        </div>
    </div>

    <!-- Optional JavaScript -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.10.1/sweetalert2.all.min.js"></script>
</body>
</html>