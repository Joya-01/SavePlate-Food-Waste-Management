<?php
include("login.php"); 
// if($_SESSION['loggedin']==true){
//  header("location:loginindex.html");
// }

if($_SESSION['name']==''){
 header("location: signup.php");
}

?> 

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="home.css">
    <link rel="stylesheet" href="profile.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
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
                <li><a href="home.html">Home</a></li>
                <li><a href="about.html" >About</a></li>
                <li><a href="contact.html"  >Contact</a></li>
                <li><a href="profile.php"  class="active">Profile</a></li>
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
  
    <div class="profile">
        <div class="profilebox">
          
            <div class="profile-header">
                <p class="headingline"> 
                    <i class="fa fa-user-circle" aria-hidden="true"></i>
                    My Profile
                </p>
            </div>

            <div class="info">
                <p><strong>Name:</strong> <?php echo"". $_SESSION['name'] ;?> </p>
                <p><strong>Email:</strong> <?php echo"". $_SESSION['email'];?> </p>
                <p><strong>Gender:</strong> <?php echo"". $_SESSION['gender'] ;?> </p>
                
                <a href="logout.php" class="logout-btn">Logout</a>
            </div>

            <hr>
            
            <p class="heading">Donation History</p>
            
            <div class="table-container">
                <div class="table-wrapper">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Food Item</th>
                                <th>Type</th>
                                <th>Category</th>
                                <th>Date/Time</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $email=$_SESSION['email'];
                            $query="select * from food_donations where email='$email'";
                            $result=mysqli_query($connection, $query);
                            if($result==true){
                                while($row=mysqli_fetch_assoc($result)){
                                    echo "<tr>
                                            <td>".$row['food']."</td>
                                            <td>".$row['type']."</td>
                                            <td>".$row['category']."</td>
                                            <td>".$row['date']."</td>
                                          </tr>";
                                }
                            }
                            ?> 
                        </tbody>
                    </table>
                </div>
            </div>          
        </div>
    </div>
</body>
</html>