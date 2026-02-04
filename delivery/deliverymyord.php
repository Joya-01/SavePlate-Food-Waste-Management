<?php
ob_start(); 
session_start(); // Ensure session is started to access $_SESSION['Did']

// Include database connection
include '../connection.php';
// include("connect.php"); // Only keep this if it doesn't conflict with connection.php

// 1. Fix: Ensure ID exists before using it to prevent "Undefined index" warnings
if(!isset($_SESSION['Did']) || $_SESSION['Did'] == ''){
    header("location:deliverylogin.php");
    exit();
}

$name = $_SESSION['name'];
$id = $_SESSION['Did'];

// 2. Fix: Check connection status
if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Orders - SavePlate</title>
    
    <link rel="stylesheet" href="delivery.css">
    <link rel="stylesheet" href="../home.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
    
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url('../img/p11.jpg');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            min-height: 100vh;
        }

        /* Container for main content */
        .main-container {
            max-width: 1200px;
            margin: 30px auto;
            padding: 0 20px;
        }

        /* Glass Card Style */
        .glass-card {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            padding: 30px;
            margin-bottom: 30px;
            text-align: center;
        }

        /* Image Section */
        .itm img { 
            width: 100%; 
            max-width: 300px; 
            height: auto; 
            border-radius: 10px;
        }

        /* Typography */
        h2.page-title {
            color: #004AAD;
            font-size: 28px;
            margin-bottom: 10px;
            font-weight: 700;
        }

        p.subtitle {
            color: #666;
            font-size: 16px;
            margin-bottom: 20px;
        }

        /* Action Buttons */
        .action-btn {
            display: inline-block;
            background: #004AAD;
            color: white;
            padding: 12px 25px;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 500;
            transition: 0.3s;
            box-shadow: 0 5px 15px rgba(0, 74, 173, 0.3);
            margin-bottom: 20px;
        }

        .action-btn:hover {
            background: #003680;
            transform: translateY(-2px);
        }

        /* Table Styling */
        .table-container {
            overflow-x: auto;
            border-radius: 10px;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            background: white;
        }

        .table thead {
            background-color: #004AAD;
            color: white;
        }

        .table th, .table td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }

        .table tbody tr:hover {
            background-color: #f9f9f9;
        }

        /* Route Button */
        .btn-route { 
            background-color: #28a745; 
            color: white; 
            padding: 8px 16px; 
            text-decoration: none; 
            border-radius: 5px; 
            font-size: 14px; 
            display: inline-flex;
            align-items: center;
            gap: 5px;
            transition: 0.3s;
        }

        .btn-route:hover { 
            background-color: #218838; 
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
        }

        /* Timer Badge */
        .expiry-timer { 
            font-family: 'Courier New', Courier, monospace; 
            background: #f0f0f0;
            padding: 5px 10px; 
            border-radius: 5px; 
            font-weight: bold; 
            font-size: 14px;
            display: inline-block;
            min-width: 140px;
            text-align: center;
        }

        /* Mobile Responsive */
        @media (max-width: 768px) { 
            .table thead { display: none; }
            .table, .table tbody, .table tr, .table td { display: block; width: 100%; }
            .table tr {
                margin-bottom: 20px;
                border: 1px solid #ddd;
                border-radius: 10px;
                padding: 15px;
                background: #fff;
                box-shadow: 0 2px 5px rgba(0,0,0,0.05);
            }
            .table td {
                text-align: right;
                padding-left: 50%;
                position: relative;
                border-bottom: 1px solid #eee;
            }
            .table td::before {
                content: attr(data-label);
                position: absolute;
                left: 0;
                width: 50%;
                padding-left: 15px;
                font-weight: 600;
                text-align: left;
                color: #004AAD;
            }
            .btn-route { display: block; text-align: center; margin-top: 5px; }
        }
    </style>
</head>
<body>
    <header>
        <div class="logo">SAVE <b style="color: #004AAD;">Plate</b></div>
        <div class="hamburger">
            <div class="line"></div><div class="line"></div><div class="line"></div>
        </div>
        <nav class="nav-bar">
            <ul>
                <li><a href="delivery.php">Home</a></li>
                <li><a href="openmap.php">Map</a></li>
                <li><a href="deliverymyord.php" class="active">My Orders</a></li>
            </ul>
        </nav>
    </header>

    <div class="main-container">
        
        <div class="glass-card">
            <h2 class="page-title">Assigned Deliveries</h2>
            <p class="subtitle">Delivery Partner ID: <b><?php echo $id; ?></b></p>
            <div class="itm">
                <img src="../img/delivery.gif" alt="Delivery Animation"> 
            </div>
            <br>
            <a href="delivery.php" class="action-btn"><i class="fa fa-plus-circle"></i> Take New Orders</a>
        </div>

        <div class="get">
            <?php
            // 3. Fix: The query must look for orders where delivery_by matches the Logged-in ID
            // We also select To_address from the admin table via the assigned_to link
            $sql = "SELECT fd.*, fd.address as From_address, ad.address AS To_address
                    FROM food_donations fd
                    LEFT JOIN admin ad ON fd.assigned_to = ad.Aid 
                    WHERE fd.delivery_by = '$id'";

            $result = mysqli_query($connection, $sql);
            $data = array();

            if ($result) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $data[] = $row;
                }
            }
            ?>

            <div class="glass-card" style="padding: 0; overflow: hidden; text-align: left;">
                <div class="table-container">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Donor Name</th>
                                <th>Phone</th>
                                <th>Time Remaining</th>
                                <th>Pickup Address</th>
                                <th>Delivery Address</th>
                                <th>Navigation</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (count($data) > 0): ?>
                                <?php foreach ($data as $row): 
                                    $origin = urlencode($row['From_address']);
                                    $dest = urlencode($row['To_address'] ?? 'Admin Office'); 
                                    $map_url = "https://www.google.com/maps/dir/?api=1&origin=$origin&destination=$dest";
                                ?>
                                <tr>
                                    <td data-label="Name" style="font-weight: 500;"><?php echo htmlspecialchars($row['name']); ?></td>
                                    
                                    <td data-label="Phone">
                                        <a href="tel:<?php echo htmlspecialchars($row['phoneno']); ?>" style="color: #333; text-decoration: none;">
                                            <i class="fa fa-phone" style="color:#004AAD; margin-right:5px;"></i>
                                            <?php echo htmlspecialchars($row['phoneno']); ?>
                                        </a>
                                    </td>
                                    
                                    <td data-label="Time Remaining">
                                        <?php if (!empty($row['expiry_date'])): ?>
                                            <div class="expiry-timer" data-time="<?php echo $row['expiry_date']; ?>">
                                                <i class="fa fa-clock-o"></i> Calc...
                                            </div>
                                        <?php else: echo "<span style='color:grey'>Not Set</span>"; endif; ?>
                                    </td>
                                    
                                    <td data-label="Pickup Address">
                                        <i class="fa fa-map-marker" style="color: red;"></i> <?php echo htmlspecialchars($row['From_address']); ?>
                                    </td>
                                    
                                    <td data-label="Delivery Address">
                                        <i class="fa fa-building" style="color: green;"></i> <?php echo htmlspecialchars($row['To_address'] ?? 'Pending'); ?>
                                    </td>
                                    
                                    <td data-label="Navigation">
                                        <a href="<?php echo $map_url; ?>" target="_blank" class="btn-route">
                                            <i class="fa fa-location-arrow"></i> Get Route
                                        </a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr><td colspan="6" style="text-align:center; padding: 30px;">No orders currently assigned to you. <br><a href="delivery.php" style="color: #004AAD;">Go pick some up!</a></td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
    function startCountdowns() {
        const timerElements = document.querySelectorAll('.expiry-timer');
        setInterval(() => {
            timerElements.forEach(el => {
                const expiryStr = el.getAttribute('data-time');
                const expiryTime = new Date(expiryStr).getTime();
                const now = new Date().getTime();
                const distance = expiryTime - now;

                if (distance < 0) {
                    el.innerHTML = "<i class='fa fa-exclamation-circle'></i> EXPIRED";
                    el.style.color = "white";
                    el.style.backgroundColor = "#d32f2f"; // Red
                } else {
                    const hours = Math.floor(distance / (1000 * 60 * 60));
                    const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                    const seconds = Math.floor((distance % (1000 * 60)) / 1000);
                    
                    el.innerHTML = `<i class='fa fa-clock-o'></i> ${hours}h ${minutes}m ${seconds}s`;
                    
                    if(hours < 1) {
                        el.style.color = "#856404";
                        el.style.backgroundColor = "#fff3cd"; // Yellow/Orange warning
                    } else {
                        el.style.color = "#155724";
                        el.style.backgroundColor = "#d4edda"; // Green safe
                    }
                }
            });
        }, 1000);
    }
    document.addEventListener('DOMContentLoaded', startCountdowns);

    // Hamburger Menu Logic
    const hamburger = document.querySelector(".hamburger");
    const navBar = document.querySelector(".nav-bar");
    hamburger.onclick = () => navBar.classList.toggle("active");
    </script>
</body>
</html>