<?php
// $connection = mysqli_connect("localhost:3307", "root", "");
// $db = mysqli_select_db($connection, 'demo');
 include("connect.php"); 
if($_SESSION['name']==''){
    header("location:signin.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="admin.css">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">

    <title>Donation History</title>
</head>
<body>
    <nav>
        <div class="logo-name">
            <div class="logo-image">
                </div>

            <span class="logo_name">ADMIN</span>
        </div>

        <div class="menu-items">
            <ul class="nav-links">
                <li><a href="admin.php">
                    <i class="uil uil-estate"></i>
                    <span class="link-name">Dashboard</span>
                </a></li>
                <li><a href="analytics.php">
                    <i class="uil uil-chart"></i>
                    <span class="link-name">Analytics</span>
                </a></li>
                <li><a href="donate.php">
                    <i class="uil uil-heart"></i>
                    <span class="link-name">Donates</span>
                </a></li>
                <li><a href="feedback.php">
                    <i class="uil uil-comments"></i>
                    <span class="link-name">Feedbacks</span>
                </a></li>
                <li><a href="adminprofile.php">
                    <i class="uil uil-user"></i>
                    <span class="link-name">Profile</span>
                </a></li>
                </ul>
            
            <ul class="logout-mode">
                <li><a href="../logout.php">
                    <i class="uil uil-signout"></i>
                    <span class="link-name">Logout</span>
                </a></li>

                <li class="mode">
                    <a href="#">
                        <i class="uil uil-moon"></i>
                        <span class="link-name">Dark Mode</span>
                    </a>

                    <div class="mode-toggle">
                      <span class="switch"></span>
                    </div>
                </li>
            </ul>
        </div>
    </nav>

    <section class="dashboard">
        
        <div class="top">
            <i class="uil uil-bars sidebar-toggle"></i>
            <p class="logo">Your <b style="color: #004AAD;">History</b></p>
             <p class="user"></p>
            </div>
        <br>
        <br>
        <br>
        
        <div class="activity">
            <div class="title">
                <i class="uil uil-clock-three"></i>
                <span class="text">Donation History</span>
            </div>

            <div class="table-container">
             <div class="table-wrapper">
             <table class="table">
            <thead>
            <tr>
                <th>Name</th>
                <th>Food Item</th>
                <th>Category</th>
                <th>Phone</th>
                <th>Date/Time</th>
                <th>Address</th>
                <th>Quantity</th>
                </tr>
            </thead>
            <tbody>
             <?php
              // Define the SQL query to fetch unassigned orders
              $id=$_SESSION['Aid'];
              $sql = "SELECT * FROM food_donations WHERE assigned_to =$id";
              
              // Execute the query
              $result=mysqli_query($connection, $sql);
          
              
              // Check for errors
              if (!$result) {
                  die("Error executing query: " . mysqli_error($conn));
              }
              
              // Fetch the data as an associative array
              $data = array();
              while ($row = mysqli_fetch_assoc($result)) {
                  $data[] = $row;
              }
            ?> 
        
            <?php foreach ($data as $row) { ?>
                <tr>
                    <td data-label="Name"><?= $row['name'] ?></td>
                    <td data-label="Food"><?= $row['food'] ?></td>
                    <td data-label="Category"><?= $row['category'] ?></td>
                    <td data-label="Phone"><?= $row['phoneno'] ?></td>
                    <td data-label="Date"><?= $row['date'] ?></td>
                    <td data-label="Address"><?= $row['address'] ?></td>
                    <td data-label="Quantity"><?= $row['quantity'] ?></td>
                </tr>
            <?php } ?>
            
            <?php if(empty($data)){ ?>
                <tr><td colspan="7" style="text-align: center;">No history found.</td></tr>
            <?php } ?>
            
            </tbody>
        </table>
         </div>
                </div>
        </div>
            </section>
    <script src="admin.js"></script>
</body>
</html>