<?php
// Connect to database (Adjust path if your connect.php is elsewhere)
$connection = new mysqli("localhost", "root", "", "foodwastedb");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Nearby Deals</title>
    <link rel="stylesheet" href="admin/admin.css"> <style>
        .deals-container { display: flex; flex-wrap: wrap; justify-content: center; gap: 20px; padding: 20px; }
        .deal-card { background: white; width: 300px; border-radius: 10px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); overflow: hidden; position: relative; }
        .deal-img { width: 100%; height: 200px; object-fit: cover; }
        .deal-info { padding: 15px; }
        .price-tag { font-size: 1.2em; font-weight: bold; color: #28a745; }
        .old-price { text-decoration: line-through; color: #888; font-size: 0.9em; margin-right: 10px;}
        .timer { background: #ff4d4d; color: white; padding: 5px; text-align: center; font-weight: bold; }
        .btn-buy { display: block; width: 100%; padding: 10px; background: #007bff; color: white; text-align: center; text-decoration: none; margin-top: 10px; border-radius: 5px;}
    </style>
</head>
<body>

<nav style="background:#333; padding:15px; color:white; text-align:center;">
    <h1>SAVE Plate - Limited Time Deals</h1>
</nav>

<div class="deals-container">
    <?php
    // Fetch items that have NOT expired yet
    $current_time = date("Y-m-d H:i:s");
    $sql = "SELECT * FROM discounted_items WHERE status='available' AND expiry_date > '$current_time' ORDER BY expiry_date ASC";
    $result = $connection->query($sql);

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            // Calculate time difference for display
            $expiry = new DateTime($row['expiry_date']);
            $now = new DateTime();
            $interval = $now->diff($expiry);
            $time_left = $interval->format('%d days, %h hours left');
            
            // Image handling
            $img = !empty($row['image_path']) ? $row['image_path'] : 'img/default.jpg';
    ?>
            <div class="deal-card">
                <div class="timer">⏳ <?php echo $time_left; ?></div>
                <img src="<?php echo $img; ?>" class="deal-img" alt="Food">
                <div class="deal-info">
                    <h3><?php echo htmlspecialchars($row['item_name']); ?></h3>
                    <p class="store">🏪 <?php echo htmlspecialchars($row['vendor_name']); ?></p>
                    <p>📍 <?php echo htmlspecialchars($row['location']); ?></p>
                    
                    <div>
                        <span class="old-price">₹<?php echo $row['original_price']; ?></span>
                        <span class="price-tag">₹<?php echo $row['discount_price']; ?></span>
                    </div>
                    
                    <a href="tel:<?php echo $row['phone']; ?>" class="btn-buy">Contact Vendor</a>
                </div>
            </div>
    <?php 
        }
    } else {
        echo "<h3>No active deals at the moment. Check back later!</h3>";
    }
    ?>
</div>

</body>
</html>