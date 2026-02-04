<?php
session_start();
include 'connection.php';
// $connection = mysqli_connect("localhost:3307", "root", "");
// $db = mysqli_select_db($connection, 'demo');
$msg=0;
if (isset($_POST['sign'])) {
  $email =mysqli_real_escape_string($connection, $_POST['email']);
  $password =mysqli_real_escape_string($connection, $_POST['password']);
 
  // $sanitized_emailid =  mysqli_real_escape_string($connection, $email);
  // $sanitized_password =  mysqli_real_escape_string($connection, $password);

  $sql = "select * from login where email='$email'";
  $result = mysqli_query($connection, $sql);
  $num = mysqli_num_rows($result);
 
  if ($num == 1) {
    while ($row = mysqli_fetch_assoc($result)) {
      if (password_verify($password, $row['password'])) {
        $_SESSION['email'] = $email;
        $_SESSION['name'] = $row['name'];
        $_SESSION['gender'] = $row['gender'];
        header("location:home.html");
      } else {
        $msg = 1;
   
      }
    }
  } else {
    echo "<h1><center>Account does not exists </center></h1>";
  }

}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SAVE Plate</title>
    <link rel="stylesheet" href="loginstyle.css">
    <link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css" />
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            /* Consistent background with your other pages */
            background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('img/p11.jpg');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .container {
            width: 100%;
            display: flex;
            justify-content: center;
            padding: 20px;
        }

        .regform {
            width: 100%;
            max-width: 420px;
            background: rgba(255, 255, 255, 0.95);
            padding: 45px 35px;
            border-radius: 15px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.2);
            text-align: center;
        }

        .logo {
            font-size: 32px;
            font-weight: 600;
            color: #333;
            margin-bottom: 5px;
        }

        #heading {
            font-size: 16px;
            color: #666;
            margin-bottom: 35px;
            font-weight: 400;
        }

        /* Input Fields */
        .input, .password {
            position: relative;
            margin-bottom: 25px;
            text-align: left;
        }

        input {
            width: 100%;
            padding: 14px 15px;
            padding-right: 45px; /* Space for the eye icon */
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 15px;
            outline: none;
            transition: all 0.3s ease;
            background: #fff;
        }

        input:focus {
            border-color: #004AAD;
            box-shadow: 0 0 8px rgba(0, 74, 173, 0.15);
        }

        /* Eye Icon Styling */
        .password i.showHidePw {
            position: absolute;
            top: 15px; /* Center vertically relative to input height */
            right: 15px;
            font-size: 20px;
            color: #777;
            cursor: pointer;
            transition: color 0.2s;
            z-index: 10;
        }

        .password i.showHidePw:hover {
            color: #004AAD;
        }

        /* Error Message Styling */
        .error {
            color: #d32f2f;
            font-size: 13px;
            margin-top: 5px;
            display: flex;
            align-items: center;
            gap: 5px;
        }
        
        .bx-error-circle {
            color: #d32f2f;
        }

        /* Button Styling */
        .btn button {
            width: 100%;
            padding: 14px;
            background: #004AAD;
            color: white;
            border: none;
            border-radius: 50px;
            font-size: 17px;
            font-weight: 500;
            cursor: pointer;
            transition: background 0.3s ease;
            box-shadow: 0 5px 15px rgba(0, 74, 173, 0.2);
        }

        .btn button:hover {
            background: #003680;
            transform: translateY(-2px);
        }

        /* Footer Links */
        .signin-up {
            margin-top: 25px;
            font-size: 14px;
            color: #666;
        }

        .signin-up a {
            color: #004AAD;
            text-decoration: none;
            font-weight: 600;
            margin-left: 5px;
        }

        .signin-up a:hover {
            text-decoration: underline;
        }

    </style>
</head>

<body>
    
    <div class="container">
        <div class="regform">

            <form action=" " method="post">

                <p class="logo">SAVE <b style="color: #004AAD;">Plate</b></p>
                <p id="heading"> Welcome back! <img src="" alt=""> </p>

                <div class="input">
                    <input type="email" placeholder="Email address" name="email" required />
                </div>
                
                <div class="password">
                    <input type="password" placeholder="Password" name="password" id="password" required />
                    
                    <i class="uil uil-eye-slash showHidePw"></i>
                  
                    <?php
                    if($msg==1){
                        echo '<div class="error">';
                        echo ' <i class="bx bx-error-circle error-icon"></i>';
                        echo ' Password does not match.'; // Cleaned up grammar slightly
                        echo '</div>';
                    }
                    ?>
                
                </div>

                <div class="btn">
                    <button type="submit" name="sign">Sign in</button>
                </div>
                
                <div class="signin-up">
                    <p id="signin-up">Don't have an account? <a href="signup.php">Register</a></p>
                </div>
            </form>
        </div>
    </div>

    <script src="login.js"></script>
    <script src="admin/login.js"></script>
</body>

</html>