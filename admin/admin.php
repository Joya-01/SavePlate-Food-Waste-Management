<?php
ob_start(); 
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    
    <link rel="stylesheet" href="admin.css">
     
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">

    <title>Admin Dashboard Panel</title> 
    
    <?php
     $connection=mysqli_connect("localhost:3306","root","");
     $db=mysqli_select_db($connection,'foodwastedb');
    ?>
    
    <style>
        /* Ensuring Glassmorphism works if admin.css isn't fully updated */
        :root {
            --primary-color: #004AAD;
            --panel-color: rgba(255, 255, 255, 0.95);
            --text-color: #333;
            --black-light-color: #707070;
            --border-color: #e6e5e5;
            --toggle-color: #DDD;
            --box1-color: linear-gradient(135deg, #4DA3FF 0%, #004AAD 100%);
            --box2-color: linear-gradient(135deg, #FFD700 0%, #FF8C00 100%);
            --box3-color: linear-gradient(135deg, #E0C3FC 0%, #8EC5FC 100%);
            --title-icon-color: #fff;
        }

        body {
            background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('../img/p11.jpg');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            font-family: 'Poppins', sans-serif;
        }

        /* Glass Cards */
        .box {
            background: var(--box1-color) !important;
            border-radius: 15px !important;
            color: white !important;
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }
        .box2 { background: var(--box2-color) !important; }
        .box3 { background: var(--box3-color) !important; }
        
        .box .text, .box .number, .box i { color: white !important; }

        /* Table Container */
        .table-container {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 15px;
            padding: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }
        
        .table thead th {
            background-color: #004AAD;
            color: white;
            padding: 12px;
        }
        
        .btn-primary {
            background-color: #004AAD;
            color: white;
            padding: 8px 15px;
            border-radius: 20px;
            border: none;
            cursor: pointer;
        }
        
        .status-badge {
            padding: 5px 10px;
            border-radius: 15px;
            font-size: 12px;
            font-weight: 600;
        }
        .assigned { background: #d4edda; color: #155724; }
        .other { background: #f8d7da; color: #721c24; }
    </style>
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
                <li><a href="#">
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
            <p class="logo">SAVE <b style="color: #004AAD;">Plate</b></p>
             <p class="user"></p>
        </div>

        <div class="dash-content">
            <div class="overview">
                <div class="title">
                    <i class="uil uil-tachometer-fast-alt"></i>
                    <span class="text" style="color: white;">Dashboard</span>
                </div>

                <div class="boxes">
                    <div class="box box1">
                        <i class="uil uil-user"></i>
                        <span class="text">Total Users</span>
                        <?php
                           $query="SELECT count(*) as count FROM  login";
                           $result=mysqli_query($connection, $query);
                           $row=mysqli_fetch_assoc($result);
                         echo "<span class=\"number\">".$row['count']."</span>";
                        ?>
                    </div>
                    <div class="box box2">
                        <i class="uil uil-comments"></i>
                        <span class="text">Feedbacks</span>
                        <?php
                           $query="SELECT count(*) as count FROM  user_feedback";
                           $result=mysqli_query($connection, $query);
                           $row=mysqli_fetch_assoc($result);
                         echo "<span class=\"number\">".$row['count']."</span>";
                        ?>
                    </div>
                    <div class="box box3">
                        <i class="uil uil-heart"></i>
                        <span class="text">Total Donations</span>
                        <?php
                           $query="SELECT count(*) as count FROM food_donations";
                           $result=mysqli_query($connection, $query);
                           $row=mysqli_fetch_assoc($result);
                         echo "<span class=\"number\">".$row['count']."</span>";
                        ?>
                    </div>
                </div>
            </div>

            <div class="activity">
                <div class="title">
                    <i class="uil uil-clock-three"></i>
                    <span class="text" style="color: white;">Recent Donations</span>
                </div>
                
                <div class="get">
                    <?php
                    $loc= $_SESSION['location'];

                    // Define the SQL query to fetch unassigned orders
                    $sql = "SELECT * FROM food_donations WHERE assigned_to IS NULL and location=\"$loc\"";

                    // Execute the query
                    $result=mysqli_query($connection, $sql);
                    $id=$_SESSION['Aid'];

                    // Check for errors
                    if (!$result) {
                        die("Error executing query: " . mysqli_error($conn));
                    }

                    // Fetch the data as an associative array
                    $data = array();
                    while ($row = mysqli_fetch_assoc($result)) {
                        $data[] = $row;
                    }

                    // If the delivery person has taken an order, update the assigned_to field in the database
                    if (isset($_POST['food']) && isset($_POST['delivery_person_id'])) {
                        $order_id = $_POST['order_id'];
                        $delivery_person_id = $_POST['delivery_person_id'];
                        $sql = "SELECT * FROM food_donations WHERE Fid = $order_id AND assigned_to IS NOT NULL";
                        $result = mysqli_query($connection, $sql);

                        if (mysqli_num_rows($result) > 0) {
                            die("Sorry, this order has already been assigned to someone else.");
                        }

                        $sql = "UPDATE food_donations SET assigned_to = $delivery_person_id WHERE Fid = $order_id";
                        $result=mysqli_query($connection, $sql);

                        if (!$result) {
                            die("Error assigning order: " . mysqli_error($conn));
                        }

                        // Reload the page to prevent duplicate assignments
                        header('Location: ' . $_SERVER['REQUEST_URI']);
                        ob_end_flush();
                    }
                    ?>

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
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($data as $row) { ?>
                                        <tr>
                                            <td data-label="Name"><?= $row['name'] ?></td>
                                            <td data-label="Food"><?= $row['food'] ?></td>
                                            <td data-label="Category"><?= $row['category'] ?></td>
                                            <td data-label="Phone"><?= $row['phoneno'] ?></td>
                                            <td data-label="Date"><?= $row['date'] ?></td>
                                            <td data-label="Address"><?= $row['address'] ?></td>
                                            <td data-label="Quantity"><?= $row['quantity'] ?></td>
                                            <td data-label="Action">
                                                <?php if ($row['assigned_to'] == null) { ?>
                                                    <form method="post" action=" ">
                                                        <input type="hidden" name="order_id" value="<?= $row['Fid'] ?>">
                                                        <input type="hidden" name="delivery_person_id" value="<?= $id ?>">
                                                        <button type="submit" name="food" class="btn-primary">Get Food</button>
                                                    </form>
                                                <?php } else if ($row['assigned_to'] == $id) { ?>
                                                    <span class="status-badge assigned">Assigned to you</span>
                                                <?php } else { ?>
                                                    <span class="status-badge other">Taken</span>
                                                <?php } ?>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                    
                                    <?php if(empty($data)){ ?>
                                        <tr><td colspan="8" style="text-align: center;">No new donations in your location.</td></tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="admin.js"></script>
</body>
</html>