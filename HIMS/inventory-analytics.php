<?php
include 'common.php';
include 'config.php';

// Function to get inventory analytics
function getInventoryAnalytics() {
    global $conn;
    $analytics = array();
    
    // Total items in inventory
    $total_items = mysqli_fetch_array(mysqli_query($conn, 
        "SELECT COUNT(DISTINCT ItemID) FROM inventory"))[0];
    $analytics['total_items'] = $total_items;
    
    // Total stock value
    $total_value = mysqli_fetch_array(mysqli_query($conn, 
        "SELECT SUM(i.CurrentStock * it.CostPerUnit) 
         FROM inventory i 
         JOIN item it ON i.ItemID = it.ItemID"))[0];
    $analytics['total_value'] = $total_value;
    
    // Low stock items count
    $low_stock = mysqli_fetch_array(mysqli_query($conn, 
        "SELECT COUNT(*) FROM inventory WHERE CurrentStock <= ReorderLevel"))[0];
    $analytics['low_stock'] = $low_stock;
    
    // Expiring soon count (within 30 days)
    $expiring_soon = mysqli_fetch_array(mysqli_query($conn, 
        "SELECT COUNT(*) FROM inventory 
         WHERE ExpiryDate <= DATE_ADD(CURRENT_DATE, INTERVAL 30 DAY)"))[0];
    $analytics['expiring_soon'] = $expiring_soon;
    
    // Category-wise stock distribution
    $category_dist = array();
    $cat_query = mysqli_query($conn, 
        "SELECT c.CategoryName, COUNT(i.ItemID) as item_count, 
                SUM(inv.CurrentStock) as total_stock,
                SUM(inv.CurrentStock * i.CostPerUnit) as category_value
         FROM category c
         JOIN item i ON c.CategoryID = i.CategoryID
         JOIN inventory inv ON i.ItemID = inv.ItemID
         GROUP BY c.CategoryID, c.CategoryName");
    while($row = mysqli_fetch_assoc($cat_query)) {
        $category_dist[] = $row;
    }
    $analytics['category_distribution'] = $category_dist;
    
    // Stock movement trends (last 6 months)
    $stock_trends = array();
    for($i = 5; $i >= 0; $i--) {
        $month = date('Y-m', strtotime("-$i months"));
        $stock_value = mysqli_fetch_array(mysqli_query($conn, 
            "SELECT SUM(i.CurrentStock * it.CostPerUnit) 
             FROM inventory i 
             JOIN item it ON i.ItemID = it.ItemID
             WHERE DATE_FORMAT(i.ExpiryDate, '%Y-%m') = '$month'"))[0];
        $stock_trends[$month] = $stock_value ?: 0;
    }
    $analytics['stock_trends'] = $stock_trends;
    
    return $analytics;
}

function getInventorySuggestions() {
    global $conn;
    $suggestions = array();
    
    // Get items that need reordering (low stock)
    $low_stock_query = mysqli_query($conn, 
        "SELECT i.ItemID, it.ItemName, i.CurrentStock, i.ReorderLevel, 
                (i.ReorderLevel - i.CurrentStock) as stock_needed,
                s.SupplierName
         FROM inventory i 
         JOIN item it ON i.ItemID = it.ItemID
         JOIN category c ON it.CategoryID = c.CategoryID
         JOIN supplier s ON c.SupplierID = s.SupplierID
         WHERE i.CurrentStock <= i.ReorderLevel
         ORDER BY (i.ReorderLevel - i.CurrentStock) DESC
         LIMIT 5");
    
    while($row = mysqli_fetch_assoc($low_stock_query)) {
        $suggestions['reorder'][] = $row;
    }
    
    // Get items expiring soon (within 30 days) or already expired
    $expiring_query = mysqli_query($conn,
        "SELECT i.ItemID, it.ItemName, i.CurrentStock, i.ExpiryDate,
                DATEDIFF(i.ExpiryDate, CURRENT_DATE) as days_until_expiry,
                s.SupplierName,
                CASE 
                    WHEN i.ExpiryDate < CURRENT_DATE THEN 'expired'
                    ELSE 'expiring'
                END as status
         FROM inventory i 
         JOIN item it ON i.ItemID = it.ItemID
         JOIN category c ON it.CategoryID = c.CategoryID
         JOIN supplier s ON c.SupplierID = s.SupplierID
         WHERE i.ExpiryDate <= DATE_ADD(CURRENT_DATE, INTERVAL 30 DAY)
         ORDER BY i.ExpiryDate ASC
         LIMIT 5");
    
    while($row = mysqli_fetch_assoc($expiring_query)) {
        if($row['status'] == 'expired') {
            $suggestions['expired'][] = $row;
        } else {
            $suggestions['expiring'][] = $row;
        }
    }
    
    // Get overstocked items (stock > 2x reorder level and not expiring soon)
    $overstock_query = mysqli_query($conn,
        "SELECT i.ItemID, it.ItemName, i.CurrentStock, i.ReorderLevel,
                (i.CurrentStock - i.ReorderLevel) as excess_stock,
                s.SupplierName
         FROM inventory i 
         JOIN item it ON i.ItemID = it.ItemID
         JOIN category c ON it.CategoryID = c.CategoryID
         JOIN supplier s ON c.SupplierID = s.SupplierID
         WHERE i.CurrentStock > (i.ReorderLevel * 2)
         AND i.ExpiryDate > DATE_ADD(CURRENT_DATE, INTERVAL 30 DAY)
         ORDER BY (i.CurrentStock - i.ReorderLevel) DESC
         LIMIT 5");
    
    while($row = mysqli_fetch_assoc($overstock_query)) {
        $suggestions['overstock'][] = $row;
    }
    
    return $suggestions;
}

$analytics = getInventoryAnalytics();
$suggestions = getInventorySuggestions();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory Analytics - HMS</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .analytics-container {
            padding: 20px;
            margin-left: 250px;
        }
        .stats-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        .stat-card {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .stat-card h3 {
            margin: 0 0 10px 0;
            color: #333;
            font-size: 16px;
        }
        .stat-card .value {
            font-size: 24px;
            font-weight: bold;
            color: #007bff;
        }
        .chart-container {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }
        .chart-container h3 {
            margin: 0 0 20px 0;
            color: #333;
        }
        .charts-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
            gap: 20px;
        }
        @media (max-width: 768px) {
            .analytics-container {
                margin-left: 0;
                padding: 10px;
            }
            .charts-grid {
                grid-template-columns: 1fr;
            }
        }
        .suggestions-container {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            margin-top: 30px;
        }
        .suggestion-section {
            margin-bottom: 20px;
        }
        .suggestion-section h3 {
            color: #333;
            margin-bottom: 15px;
        }
        .suggestion-list {
            list-style: none;
            padding: 0;
        }
        .suggestion-item {
            padding: 10px;
            border-left: 4px solid;
            background: #f8f9fa;
            margin-bottom: 10px;
        }
        .suggestion-item.reorder {
            border-color: #dc3545;
        }
        .suggestion-item.expiring {
            border-color: #ffc107;
        }
        .suggestion-item.overstock {
            border-color: #17a2b8;
        }
        .suggestion-item.expired {
            border-color: #dc3545;
            background: #fff5f5;
        }
        .suggestion-item p {
            margin: 5px 0;
        }
        .suggestion-item .item-name {
            font-weight: bold;
        }
        .suggestion-item .supplier {
            color: #6c757d;
            font-size: 0.9em;
        }
    </style>
</head>
<body>
    <div class="analytics-container">
        <h2>Inventory Analytics Dashboard</h2>
        
        <!-- Summary Cards -->
        <div class="stats-cards">
            <div class="stat-card">
                <h3>Total Items</h3>
                <div class="value"><?php echo number_format($analytics['total_items']); ?></div>
            </div>
            <div class="stat-card">
                <h3>Total Stock Value</h3>
                <div class="value">₹<?php echo number_format($analytics['total_value'], 2); ?></div>
            </div>
            <div class="stat-card">
                <h3>Low Stock Items</h3>
                <div class="value"><?php echo number_format($analytics['low_stock']); ?></div>
            </div>
            <div class="stat-card">
                <h3>Expiring Soon</h3>
                <div class="value"><?php echo number_format($analytics['expiring_soon']); ?></div>
            </div>
        </div>
        
        <!-- Charts -->
        <div class="charts-grid">
            <!-- Category Distribution Chart -->
            <div class="chart-container">
                <h3>Category-wise Stock Distribution</h3>
                <canvas id="categoryChart"></canvas>
            </div>
            
            <!-- Stock Value Trends Chart -->
            <div class="chart-container">
                <h3>Stock Value Trends</h3>
                <canvas id="trendChart"></canvas>
            </div>
            
            <!-- Category Value Distribution Chart -->
            <div class="chart-container">
                <h3>Category Value Distribution</h3>
                <canvas id="categoryValueChart"></canvas>
            </div>
            
            <!-- Stock Levels Chart -->
            <div class="chart-container">
                <h3>Stock Levels by Category</h3>
                <canvas id="stockLevelsChart"></canvas>
            </div>
        </div>
        
        <!-- Suggestions -->
        <div class="suggestions-container">
            <h2>Inventory Suggestions</h2>
            
            <!-- Reorder Suggestions -->
            <?php if (!empty($suggestions['reorder'])): ?>
            <div class="suggestion-section">
                <h3>Items to Reorder</h3>
                <div class="suggestion-list">
                    <?php foreach ($suggestions['reorder'] as $item): ?>
                    <div class="suggestion-item reorder">
                        <p class="item-name"><?php echo $item['ItemName']; ?></p>
                        <p>Current Stock: <?php echo $item['CurrentStock']; ?> (Reorder Level: <?php echo $item['ReorderLevel']; ?>)</p>
                        <p>Need to order: <?php echo $item['stock_needed']; ?> units</p>
                        <p class="supplier">Supplier: <?php echo $item['SupplierName']; ?></p>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endif; ?>
            
            <!-- Expiring Items Suggestions -->
            <?php if (!empty($suggestions['expiring'])): ?>
            <div class="suggestion-section">
                <h3>Items Expiring Soon</h3>
                <div class="suggestion-list">
                    <?php foreach ($suggestions['expiring'] as $item): ?>
                    <div class="suggestion-item expiring">
                        <p class="item-name"><?php echo $item['ItemName']; ?></p>
                        <p>Current Stock: <?php echo $item['CurrentStock']; ?></p>
                        <p>Expires in: <?php echo $item['days_until_expiry']; ?> days (<?php echo $item['ExpiryDate']; ?>)</p>
                        <p class="supplier">Supplier: <?php echo $item['SupplierName']; ?></p>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endif; ?>
            
            <!-- Expired Items -->
            <?php if (!empty($suggestions['expired'])): ?>
            <div class="suggestion-section">
                <h3>Expired Items</h3>
                <div class="suggestion-list">
                    <?php foreach ($suggestions['expired'] as $item): ?>
                    <div class="suggestion-item expired">
                        <p class="item-name"><?php echo $item['ItemName']; ?></p>
                        <p>Current Stock: <?php echo $item['CurrentStock']; ?></p>
                        <p style="color: #dc3545;">Expired <?php echo abs($item['days_until_expiry']); ?> days ago (<?php echo $item['ExpiryDate']; ?>)</p>
                        <p class="supplier">Supplier: <?php echo $item['SupplierName']; ?></p>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endif; ?>
            
            <!-- Overstock Suggestions -->
            <?php if (!empty($suggestions['overstock'])): ?>
            <div class="suggestion-section">
                <h3>Overstocked Items</h3>
                <div class="suggestion-list">
                    <?php foreach ($suggestions['overstock'] as $item): ?>
                    <div class="suggestion-item overstock">
                        <p class="item-name"><?php echo $item['ItemName']; ?></p>
                        <p>Current Stock: <?php echo $item['CurrentStock']; ?> (Reorder Level: <?php echo $item['ReorderLevel']; ?>)</p>
                        <p>Excess Stock: <?php echo $item['excess_stock']; ?> units</p>
                        <p class="supplier">Supplier: <?php echo $item['SupplierName']; ?></p>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>

    <script>
    // Category Distribution Chart
    new Chart(document.getElementById('categoryChart'), {
        type: 'pie',
        data: {
            labels: <?php echo json_encode(array_column($analytics['category_distribution'], 'CategoryName')); ?>,
            datasets: [{
                data: <?php echo json_encode(array_column($analytics['category_distribution'], 'item_count')); ?>,
                backgroundColor: [
                    '#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF', '#FF9F40'
                ]
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });

    // Stock Value Trends Chart
    new Chart(document.getElementById('trendChart'), {
        type: 'line',
        data: {
            labels: <?php echo json_encode(array_keys($analytics['stock_trends'])); ?>,
            datasets: [{
                label: 'Stock Value',
                data: <?php echo json_encode(array_values($analytics['stock_trends'])); ?>,
                borderColor: '#007bff',
                tension: 0.1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return '₹' + value.toLocaleString();
                        }
                    }
                }
            }
        }
    });

    // Category Value Distribution Chart
    new Chart(document.getElementById('categoryValueChart'), {
        type: 'doughnut',
        data: {
            labels: <?php echo json_encode(array_column($analytics['category_distribution'], 'CategoryName')); ?>,
            datasets: [{
                data: <?php echo json_encode(array_column($analytics['category_distribution'], 'category_value')); ?>,
                backgroundColor: [
                    '#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF', '#FF9F40'
                ]
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });

    // Stock Levels Chart
    new Chart(document.getElementById('stockLevelsChart'), {
        type: 'bar',
        data: {
            labels: <?php echo json_encode(array_column($analytics['category_distribution'], 'CategoryName')); ?>,
            datasets: [{
                label: 'Total Stock',
                data: <?php echo json_encode(array_column($analytics['category_distribution'], 'total_stock')); ?>,
                backgroundColor: '#007bff'
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
    </script>
</body>
</html> 