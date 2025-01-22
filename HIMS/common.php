<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="nav2.css">
    <link rel="stylesheet" type="text/css" href="form4.css">
    <link href="https://fonts.googleapis.com/css?family=IBM+Plex+Sans&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css">
    <title>THE CARE CREW HIMS</title>
    <style>
        .sidenav {
            width: 250px;
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            background: -webkit-linear-gradient(left, #3931af, #00c6ff);
            padding-top: 20px;
            z-index: 1000;
            overflow-y: auto;
        }

        .sidenav h2 {
            font-family: 'IBM Plex Sans', sans-serif;
            padding: 15px;
            margin-bottom: 30px;
            color: white;
            text-align: center;
            font-weight: 600;
        }

        .sidenav a, .dropdown-btn {
            font-family: 'IBM Plex Sans', sans-serif;
            padding: 12px 8px 12px 16px;
            text-decoration: none;
            font-size: 15px;
            color: white;
            display: block;
            border: none;
            background: none;
            width: 100%;
            text-align: left;
            cursor: pointer;
            outline: none;
            transition: 0.3s;
        }

        .sidenav a:hover, .dropdown-btn:hover {
            background-color: rgba(255,255,255,0.2);
            border-left: 4px solid white;
        }

        .dropdown-container {
            background-color: rgba(0,0,0,0.2);
            padding-left: 15px;
            display: none;
        }

        .dropdown-container a {
            font-size: 14px;
            padding: 10px 8px 10px 32px;
        }

        .fa-caret-down {
            float: right;
            padding-right: 8px;
        }

        .active {
            background-color: rgba(255,255,255,0.2);
            border-left: 4px solid white;
        }

        .topnav {
            position: fixed;
            top: 0;
            right: 0;
            width: calc(100% - 250px);
            z-index: 999;
            background: white;
            padding: 10px 20px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        .topnav a {
            color: #342ac1;
            font-family: 'IBM Plex Sans', sans-serif;
            font-weight: 600;
            float: right;
            text-decoration: none;
            padding: 5px 15px;
            border-radius: 4px;
            transition: 0.3s;
        }

        .topnav a:hover {
            background-color: #342ac1;
            color: white;
        }

        @media screen and (max-width: 768px) {
            .sidenav {
                width: 100%;
                height: auto;
                position: relative;
            }
            .topnav {
                width: 100%;
                margin-left: 0;
            }
        }
    </style>
</head>
<body>
    <div class="sidenav">
        <br>
        <br>
        <h2>IMS</h2>
        <a href="adminmainpage.php"><i class="fa fa-dashboard"></i> Dashboard</a>
        
        <button class="dropdown-btn">Inventory
            <i class="fa fa-caret-down"></i>
        </button>
        <div class="dropdown-container">
            <a href="inventory-add.php">Add to Inventory</a>
            <a href="inventory-view.php">Manage Inventory</a>
        </div>

        <button class="dropdown-btn">Suppliers
            <i class="fa fa-caret-down"></i>
        </button>
        <div class="dropdown-container">
            <a href="supplier-add.php">Add New Supplier</a>
            <a href="supplier-view.php">Manage Suppliers</a>
        </div>

        <button class="dropdown-btn">Category
            <i class="fa fa-caret-down"></i>
        </button>
        <div class="dropdown-container">
            <a href="category-add.php">Add New Category</a>
            <a href="category-view.php">Manage Category</a>
        </div>

        <button class="dropdown-btn">Transaction
            <i class="fa fa-caret-down"></i>
        </button>
        <div class="dropdown-container">
            <a href="transaction-add.php">Add New Transaction</a>
            <a href="transaction-view.php">Manage Transaction</a>
        </div>

        <button class="dropdown-btn">Items
            <i class="fa fa-caret-down"></i>
        </button>
        <div class="dropdown-container">
            <a href="item-add.php">Add New Items</a>
            <a href="item-view.php">Manage Items</a>
        </div>

        <button class="dropdown-btn">Reports
            <i class="fa fa-caret-down"></i>
        </button>
        <div class="dropdown-container">
            <a href="r2.php">Inventory - Low Stock</a>
            <a href="expiryreport.php">Inventory - Soon to Expire</a>
            <a href="r1.php">Transactions Reports</a>
            <a href="inventory-analytics.php">Inventory Analytics</a>
        </div>
    </div>


    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Dropdown menu functionality
            var dropdowns = document.getElementsByClassName("dropdown-btn");
            Array.from(dropdowns).forEach(function(dropdown) {
                dropdown.addEventListener("click", function() {
                    this.classList.toggle("active");
                    var dropdownContent = this.nextElementSibling;
                    dropdownContent.style.display = dropdownContent.style.display === "block" ? "none" : "block";
                });
            });

            // Active menu item
            var currentPage = window.location.pathname.split("/").pop();
            var menuItems = document.querySelectorAll('.sidenav a');
            menuItems.forEach(function(item) {
                if(item.getAttribute('href') === currentPage) {
                    item.classList.add('active');
                }
            });
        });
    </script>
</body>
</html>