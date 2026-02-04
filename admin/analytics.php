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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    
    <link rel="stylesheet" href="admin.css">
     
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">

    <title>Analytics - Admin Dashboard</title> 
    
    <?php
     $connection=mysqli_connect("localhost:3306","root","");
     $db=mysqli_select_db($connection,'foodwastedb');
    ?>

    <style>
        /* Specific Styles for Analytics Page */
        .charts-wrapper {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
            gap: 30px;
            margin-top: 30px;
            padding-bottom: 30px;
        }

        .chart-card {
            background: rgba(255, 255, 255, 0.95);
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            border: 1px solid rgba(255,255,255,0.2);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .chart-title {
            font-size: 18px;
            font-weight: 600;
            color: #004AAD;
            margin-bottom: 15px;
            width: 100%;
            text-align: left;
            border-bottom: 1px solid #eee;
            padding-bottom: 10px;
        }

        canvas {
            width: 100% !important;
            max-width: 100%;
            height: auto !important;
        }

        @media (max-width: 768px) {
            .charts-wrapper {
                grid-template-columns: 1fr;
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
                <li><a href="#" class="active"> <i class="uil uil-chart"></i>
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
            <p class="logo">Data <b style="color: #004AAD;">Analytics</b></p>
             <p class="user"></p>
        </div>

        <div class="dash-content">
            <div class="overview">
                <div class="title">
                    <i class="uil uil-chart-line"></i>
                    <span class="text">Platform Statistics</span>
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
                    <i class="uil uil-graph-bar"></i>
                    <span class="text">Visual Reports</span>
                </div>

                <div class="charts-wrapper">
                    <div class="chart-card">
                        <h3 class="chart-title">User Demographics</h3>
                        <canvas id="myChart"></canvas>
                    </div>

                    <div class="chart-card">
                        <h3 class="chart-title">Donations by Location</h3>
                        <canvas id="donateChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
      <?php
            $query="SELECT count(*) as count FROM  login where gender=\"male\"";
            $q2="SELECT count(*) as count FROM  login where gender=\"female\"";
            $result=mysqli_query($connection, $query);
            $res2=mysqli_query($connection, $q2);
            $row=mysqli_fetch_assoc($result);
            $ro2=mysqli_fetch_assoc($res2);
            $female=$ro2['count'];
            $male=$row['count'];
            $q3="SELECT count(*) as count FROM food_donations where location=\"madurai\"";
            $res3=mysqli_query($connection, $q3);
            $ro3=mysqli_fetch_assoc($res3);
            $madurai=$ro3['count'];
            $q4="SELECT count(*) as count FROM food_donations where location=\"chennai\"";
            $res4=mysqli_query($connection, $q4);
            $ro4=mysqli_fetch_assoc($res4);
            $chennai=$ro4['count'];
            $q5="SELECT count(*) as count FROM food_donations where location=\"coimbatore\"";
            $res5=mysqli_query($connection, $q5);
            $ro5=mysqli_fetch_assoc($res5);
            $coimbatore=$ro5['count'];
      ?>
        
        var xValues = ["Male","Female"];
        var xplace = ["Madurai","Chennai","Coimbatore"];
        var yplace = [<?php echo json_encode($madurai,JSON_HEX_TAG);?>,<?php echo json_encode($coimbatore,JSON_HEX_TAG);?>,<?php echo json_encode($chennai,JSON_HEX_TAG);?>];
        var yValues = [<?php echo json_encode($male,JSON_HEX_TAG);?>,<?php echo json_encode($female,JSON_HEX_TAG);?>,30];
        
        // Updated colors to match theme
        var barColors = ["#004AAD", "#4DA3FF"];
        var barPlaceColors = ["#004AAD", "#FF8C00", "#28a745"];

        new Chart("myChart", {
          type: "doughnut", // Changed to doughnut for better UI variety
          data: {
            labels: xValues,
            datasets: [{
              backgroundColor: barColors,
              data: yValues
            }]
          },
          options: {
            legend: {display: true, position: 'bottom'},
            title: {
              display: false,
              text: "User Gender Distribution"
            }
          }
        });

        new Chart("donateChart", {
          type: "bar",
          data: {
            labels: xplace,
            datasets: [{
              backgroundColor: barPlaceColors,
              data: yplace
            }]
          },
          options: {
            legend: {display: false},
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            },
            title: {
              display: false,
              text: "Food Donation Details"
            }
          }
        });
    </script>

    <script src="admin.js"></script>
</body>
</html>