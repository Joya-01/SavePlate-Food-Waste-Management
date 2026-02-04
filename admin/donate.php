<?php
// $connection = mysqli_connect("localhost:3307", "root", "");
// $db = mysqli_select_db($connection, 'demo');
include "../connection.php";
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

    <title>Admin Profile & Filter</title> 
    
    <?php
     $connection=mysqli_connect("localhost:3306","root","");
     $db=mysqli_select_db($connection,'foodwastedb');
    ?>
    
    <style>
        /* Embedding Glassmorphism Styles for Filter Section */
        .filter-card {
            background: rgba(255, 255, 255, 0.95);
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            margin-bottom: 30px;
            display: flex;
            flex-direction: column;
            align-items: center;
            border: 1px solid rgba(255,255,255,0.2);
        }

        .filter-card form {
            display: flex;
            align-items: center;
            gap: 15px;
            flex-wrap: wrap;
            justify-content: center;
            width: 100%;
        }

        .filter-card label {
            font-size: 18px;
            font-weight: 600;
            color: #004AAD;
        }

        .filter-card select {
            padding: 10px 15px;
            border: 1px solid #ddd;
            border-radius: 50px;
            outline: none;
            font-size: 15px;
            min-width: 250px;
            background: #fff;
        }

        .filter-card input[type="submit"] {
            background: #004AAD;
            color: white;
            padding: 10px 25px;
            border: none;
            border-radius: 50px;
            font-weight: 500;
            cursor: pointer;
            transition: 0.3s;
            font-size: 15px;
        }

        .filter-card input[type="submit"]:hover {
            background: #003680;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 74, 173, 0.3);
        }

        /* Mobile Adjustments */
        @media (max-width: 768px) {
            .filter-card form {
                flex-direction: column;
            }
            .filter-card select, .filter-card input[type="submit"] {
                width: 100%;
            }
        }
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
                <li><a href="adminprofile.php" class="active"> <i class="uil uil-user"></i>
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
                    <i class="uil uil-filter"></i>
                    <span class="text">Filter Donations by Location</span>
                </div>

                <div class="activity">
                    <div class="filter-card">
                        <form method="post">
                            <label for="location">Select District:</label>
                            <select id="location" name="location" required>
                                <option value="" disabled selected>Select Location</option>
                                <option value="almora">Almora</option>
                                <option value="bageshwar">Bageshwar</option>
                                <option value="chamoli">Chamoli</option>
                                <option value="champawat">Champawat</option>
                                <option value="dehradun">Dehradun</option>
                                <option value="haridwar">Haridwar</option>
                                <option value="nainital">Nainital</option>
                                <option value="pauri-garhwal">Pauri Garhwal</option>
                                <option value="pithoragarh">Pithoragarh</option>
                                <option value="rudraprayag">Rudraprayag</option>
                                <option value="tehri-garhwal">Tehri Garhwal</option>
                                <option value="udhamsingh-nagar">Udham Singh Nagar</option>
                                <option value="uttarkashi">Uttarkashi</option>
                            </select> 
                            <input type="submit" value="Get Details">
                        </form>
                    </div>

                    <?php
                    // Get the selected location from the form
                    if(isset($_POST['location'])) {
                      $location = $_POST['location'];
                      
                      // Query the database for people in the selected location
                      $sql = "SELECT * FROM food_donations WHERE location='$location'";
                      $result=mysqli_query($connection, $sql);
                    
                      if ($result->num_rows > 0) {
                        
                        echo "<div class=\"table-container\">";
                        echo "<div class=\"table-wrapper\">";
                        echo "<table class=\"table\">";
                        echo "<thead>
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
                              <tbody>";

                        while($row = $result->fetch_assoc()) {
                            echo "<tr>
                                    <td data-label=\"Name\">".$row['name']."</td>
                                    <td data-label=\"Food\">".$row['food']."</td>
                                    <td data-label=\"Category\">".$row['category']."</td>
                                    <td data-label=\"Phone\">".$row['phoneno']."</td>
                                    <td data-label=\"Date\">".$row['date']."</td>
                                    <td data-label=\"Address\">".$row['address']."</td>
                                    <td data-label=\"Quantity\">".$row['quantity']."</td>
                                  </tr>";
                        }
                        echo "</tbody></table></div></div>";
                      } else {
                        echo "<div class='filter-card' style='margin-top: 20px;'><p style='text-align:center;'>No results found for <b>" . $location . "</b>.</p></div>";
                      }
                    }
                    ?>
                </div>
            </div>
        </div>
    </section>

    <script src="admin.js"></script>
</body>
</html>