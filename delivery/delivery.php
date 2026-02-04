<?php
ob_start(); 
// $connection = mysqli_connect("localhost:3307", "root", "");
// $db = mysqli_select_db($connection, 'demo');
include("connect.php"); 
include '../connection.php';
if($_SESSION['name']==''){
    header("location:deliverylogin.php");
}
$name=$_SESSION['name'];
$city=$_SESSION['city'];
$ch=curl_init();
curl_setopt($ch,CURLOPT_URL,"http://ip-api.com/json");
curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
$result=curl_exec($ch);
$result=json_decode($result);
// $city= $result->city;
// echo $city;

$id=$_SESSION['Did'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delivery Dashboard - SAVE Plate</title>
    <script language="JavaScript" src="http://www.geoplugin.net/javascript.gp" type="text/javascript"></script>
    <link rel="stylesheet" href="../home.css">
    <link rel="stylesheet" href="delivery.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
</head>
<body>
    <header>
        <div class="logo">SAVE <b style="color: #004AAD;">Plate</b></div>
        <div class="hamburger">
            <div class="line"></div>
            <div class="line"></div>
            <div class="line"></div>
        </div>
        <nav class="nav-bar">
            <ul>
                <li><a href="#home" class="active">Home</a></li>
                <li><a href="openmap.php" >Map</a></li>
                <li><a href="deliverymyord.php" >My Orders</a></li>
                </ul>
        </nav>
    </header>
    
    <script>
        const hamburger=document.querySelector(".hamburger");
        hamburger.onclick =function(){
            const navBar=document.querySelector(".nav-bar");
            navBar.classList.toggle("active");
        }
    </script>

    <?php
    // echo var_export(unserialize(file_get_contents('http://www.geoplugin.net/php.gp?ip=103.113.190.19')));
    // echo "Your city: {$city}\n";
    // $city = "<script language=javascript> document.write(geoplugin_city());</script>"; 
    // $scity=$city;
    ?>

    <div class="main-content">
        
        <div class="welcome-section">
            <h2>Welcome, <?php echo"$name";?></h2>
            <div class="itm">
                <img src="../img/delivery.gif" alt="Delivery" width="400" height="400"> 
            </div>
        </div>

        <div class="orders-section">
            <?php
            // Define the SQL query to fetch unassigned orders
            $sql = "SELECT fd.Fid AS Fid,fd.location as cure, fd.name,fd.phoneno,fd.date,fd.delivery_by, fd.address as From_address, 
            ad.name AS delivery_person_name, ad.address AS To_address
            FROM food_donations fd
            LEFT JOIN admin ad ON fd.assigned_to = ad.Aid where assigned_to IS NOT NULL and   delivery_by IS NULL and fd.location='$city';
            ";

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

            // Logic for taking order
            if (isset($_POST['food']) && isset($_POST['delivery_person_id'])) {
                $order_id = $_POST['order_id'];
                $delivery_person_id = $_POST['delivery_person_id'];
                $sql = "SELECT * FROM food_donations WHERE Fid = $order_id AND delivery_by IS NOT NULL";
                $result = mysqli_query($connection, $sql);

                if (mysqli_num_rows($result) > 0) {
                    die("Sorry, this order has already been assigned to someone else.");
                }

                $sql = "UPDATE food_donations SET delivery_by = $delivery_person_id WHERE Fid = $order_id";
                $result=mysqli_query($connection, $sql);

                if (!$result) {
                    die("Error assigning order: " . mysqli_error($conn));
                }

                header('Location: ' . $_SERVER['REQUEST_URI']);
                ob_end_flush();
            }
            ?>

            <div class="action-bar">
                <h3>Available Orders in <?php echo $city; ?></h3>
                <a href="deliverymyord.php" class="my-orders-btn"><i class="fa fa-list"></i> View My Orders</a>
            </div>
            
            [Image of relational database schema for order management]

            <div class="table-container">
                <div class="table-wrapper">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Donor Name</th>
                                <th>Phone</th>
                                <th>Date/Time</th>
                                <th>Pickup Address</th>
                                <th>Delivery Address</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($data as $row) { ?>
                                <tr>
                                    <td data-label="Name"><?= $row['name'] ?></td>
                                    <td data-label="Phone"><?= $row['phoneno'] ?></td>
                                    <td data-label="Date"><?= $row['date'] ?></td>
                                    <td data-label="Pickup Address"><?= $row['From_address'] ?></td>
                                    <td data-label="Delivery Address"><?= $row['To_address'] ?></td>
                                    <td data-label="Action" class="action-cell">
                                        <?php if ($row['delivery_by'] == null) { ?>
                                            <form method="post" action=" ">
                                                <input type="hidden" name="order_id" value="<?= $row['Fid'] ?>">
                                                <input type="hidden" name="delivery_person_id" value="<?= $id ?>">
                                                <button type="submit" name="food" class="take-order-btn">Take Order</button>
                                            </form>
                                        <?php } else if ($row['delivery_by'] == $id) { ?>
                                            <span class="badge assigned">Assigned to you</span>
                                        <?php } else { ?>
                                            <span class="badge other">Taken</span>
                                        <?php } ?>
                                    </td>
                                </tr>
                            <?php } ?>
                            
                            <?php if(empty($data)){ ?>
                                <tr>
                                    <td colspan="6" style="text-align:center;">No new orders available in your city right now.</td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>
</html>