<?php
session_start();
// $connection = mysqli_connect("localhost:3307", "root", "");
// $db = mysqli_select_db($connection, 'demo');
include '../connection.php'; 
$msg=0;
if (isset($_POST['sign'])) {
  $email = $_POST['email'];
  $password = $_POST['password'];
  $sanitized_emailid =  mysqli_real_escape_string($connection, $email);
  $sanitized_password =  mysqli_real_escape_string($connection, $password);
  // $hash=password_hash($password,PASSWORD_DEFAULT);

  $sql = "select * from delivery_persons where email='$sanitized_emailid'";
  $result = mysqli_query($connection, $sql);
  $num = mysqli_num_rows($result);
 
  if ($num == 1) {
    while ($row = mysqli_fetch_assoc($result)) {
      if (password_verify($sanitized_password, $row['password'])) {
        $_SESSION['email'] = $email;
        $_SESSION['name'] = $row['name'];
        $_SESSION['Did']=$row['Did'];
        $_SESSION['city']=$row['city'];
        header("location:delivery.php");
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
    <title>Delivery Login - SAVE Plate</title>
    
    <link rel="stylesheet" href="deliverycss.css">
    
    <style>
        /* Ensuring the glass effect and background match other pages exactly */
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

        body {
            margin: 0;
            padding: 0;
            font-family: 'Poppins', sans-serif;
            /* Background image path relative to this file inside delivery/ folder, so ../img/p11.jpg */
            background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url('../img/p11.jpg');
            background-repeat: no-repeat;
            background-size: cover;
            background-position: center;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .center {
            width: 100%;
            max-width: 420px;
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.2);
            padding: 40px 30px;
            position: relative; /* Resetting absolute positioning from old css */
            top: auto;
            left: auto;
            transform: none;
            margin: 20px;
        }

        .center h1 {
            text-align: center;
            padding: 0 0 20px 0;
            border-bottom: 2px solid #f0f0f0;
            color: #333;
            font-size: 28px;
            font-weight: 600;
        }

        /* Form Elements */
        form .txt_field {
            position: relative;
            border-bottom: 2px solid #adadad;
            margin: 30px 0;
        }

        .txt_field input {
            width: 100%;
            padding: 0 5px;
            height: 40px;
            font-size: 16px;
            border: none;
            background: none;
            outline: none;
            color: #333;
        }

        .txt_field label {
            position: absolute;
            top: 50%;
            left: 5px;
            color: #adadad;
            transform: translateY(-50%);
            font-size: 16px;
            pointer-events: none;
            transition: .5s;
        }

        .txt_field span::before {
            content: '';
            position: absolute;
            top: 40px;
            left: 0;
            width: 0%;
            height: 2px;
            background: #004AAD; /* Brand Color */
            transition: .5s;
        }

        .txt_field input:focus ~ label,
        .txt_field input:valid ~ label {
            top: -5px;
            color: #004AAD;
        }

        .txt_field input:focus ~ span::before,
        .txt_field input:valid ~ span::before {
            width: 100%;
        }

        /* Button Styling */
        input[type="submit"] {
            width: 100%;
            height: 50px;
            border: none;
            background: #004AAD;
            border-radius: 25px;
            font-size: 18px;
            color: #fff;
            font-weight: 600;
            cursor: pointer;
            transition: .3s;
            margin-top: 10px;
            box-shadow: 0 5px 15px rgba(0, 74, 173, 0.3);
        }

        input[type="submit"]:hover {
            background: #003680;
            transform: translateY(-2px);
        }

        /* Link Styling */
        .signup_link {
            margin: 30px 0 10px;
            text-align: center;
            font-size: 15px;
            color: #666;
        }

        .signup_link a {
            color: #004AAD;
            text-decoration: none;
            font-weight: 600;
        }

        .signup_link a:hover {
            text-decoration: underline;
        }

        /* Error Message */
        .error {
            color: #d32f2f;
            background: #ffebee;
            padding: 10px;
            border-radius: 5px;
            text-align: center;
            font-size: 14px;
            border: 1px solid #ffcdd2;
        }
    </style>
  </head>
  <body>
    <div class="center">
      <h1>Delivery Login</h1>
      <form method="post">
        
        <div class="txt_field">
          <input type="email" name="email" required/>
          <span></span>
          <label>Email Address</label>
        </div>
        
        <div class="txt_field">
          <input type="password" name="password" required/>
          <span></span>
          <label>Password</label>
        </div>
        
        <?php
        if($msg==1){
            echo '<div class="error">Password does not match.</div>';
        }
        ?>
        
        <input type="submit" value="Login" name="sign">
        
        <div class="signup_link">
          Not a member? <a href="deliverysignup.php">Signup</a>
        </div>
      </form>
    </div>
  </body>
</html>