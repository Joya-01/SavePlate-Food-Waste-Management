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

    <title>User Feedback - Admin Panel</title> 
    
    <?php
     $connection=mysqli_connect("localhost:3306","root","");
     $db=mysqli_select_db($connection,'foodwastedb');
    ?>
    
    <style>
        /* Page-specific overrides for the message column */
        .table td:last-child {
            max-width: 300px;
            white-space: normal;
            line-height: 1.5;
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
                <li><a href="feedback.php" class="active"> <i class="uil uil-comments"></i>
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
            <p class="logo">User <b style="color: #004AAD;">Feedback</b></p>
             <p class="user"></p>
        </div>
        <br><br><br>

        <div class="activity">
            
            <div class="table-container">
                <div class="table-wrapper">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Message</th>
                            </tr>
                        </thead>
                        <tbody>
                           <?php
                            $query="select * from user_feedback ";
                            $result=mysqli_query($connection, $query);
                            
                            if($result==true){
                                while($row=mysqli_fetch_assoc($result)){
                                    echo "<tr>
                                            <td data-label=\"Name\">".$row['name']."</td>
                                            <td data-label=\"Email\">".$row['email']."</td>
                                            <td data-label=\"Message\">".$row['message']."</td>
                                          </tr>";
                                }
                            }
                           ?> 
                        </tbody>
                    </table>
                </div>
            </div>
            
        </div>
    </section>

    <script src="admin.js"></script>
</body>
</html>