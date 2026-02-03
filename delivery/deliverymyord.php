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
    <style>
        .itm{ background-color: white; display: grid; }
        .itm img{ width: 400px; height: 400px; margin-left: auto; margin-right: auto; }
        p{ text-align: center; font-size: 28px; color: black; }
        .expiry-timer { font-family: 'Courier New', Courier, monospace; padding: 5px; border-radius: 4px; font-weight: bold; }
        .btn-route { background-color: #004AAD; color: white; padding: 8px 15px; text-decoration: none; border-radius: 5px; font-size: 14px; display: inline-block; }
        .btn-route:hover { background-color: #003580; }
        @media (max-width: 767px) { .itm img{ width: 350px; height: 350px; } }
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
            <li><a href="openmap.php">map</a></li>
            <li><a href="deliverymyord.php" class="active">myorders</a></li>
        </ul>
    </nav>
</header>
<br>

<div class="itm">
    <img src="../img/delivery.gif" alt="Delivery Animation"> 
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

    <div class="log">
        <a href="delivery.php">Take orders</a>
        <p>Orders assigned to you (ID: <?php echo $id; ?>)</p>
        <br>
    </div>

    <div class="table-container">
        <div class="table-wrapper">
            <table class="table">
                <thead>
                    <tr>
                        <th>Name</th>
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
                            <td data-label="name"><?php echo htmlspecialchars($row['name']); ?></td>
                            <td data-label="phoneno"><?php echo htmlspecialchars($row['phoneno']); ?></td>
                            <td data-label="Time Remaining">
                                <?php if (!empty($row['expiry_date'])): ?>
                                    <div class="expiry-timer" data-time="<?php echo $row['expiry_date']; ?>">
                                        Calculating...
                                    </div>
                                <?php else: echo "Not Set"; endif; ?>
                            </td>
                            <td data-label="Pickup Address"><?php echo htmlspecialchars($row['From_address']); ?></td>
                            <td data-label="Delivery Address"><?php echo htmlspecialchars($row['To_address'] ?? 'Pending'); ?></td>
                            <td data-label="Navigation">
                                <a href="<?php echo $map_url; ?>" target="_blank" class="btn-route">📍 Get Route</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="6" style="text-align:center;">No orders assigned to you yet.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
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
                el.innerHTML = "EXPIRED";
                el.style.color = "red";
            } else {
                const hours = Math.floor(distance / (1000 * 60 * 60));
                const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((distance % (1000 * 60)) / 1000);
                el.innerHTML = hours + "h " + minutes + "m " + seconds + "s left";
                el.style.color = (hours < 1) ? "orange" : "green";
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