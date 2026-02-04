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

  $sql = "select * from admin where email='$sanitized_emailid'";
  $result = mysqli_query($connection, $sql);
  $num = mysqli_num_rows($result);
 
  if ($num == 1) {
    while ($row = mysqli_fetch_assoc($result)) {
      if (password_verify($sanitized_password, $row['password'])) {
        $_SESSION['email'] = $email;
        $_SESSION['name'] = $row['name'];
        $_SESSION['location'] = $row['location'];
        $_SESSION['Aid']=$row['Aid'];
        header("location:admin.php");
      } else {
        $msg = 1;
      }
    }
  } else {
    $msg = 2; // Account not found
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - SAVE Plate</title>
    
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
    
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            /* Background Image */
            background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url('../img/p11.jpg');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .container {
            width: 100%;
            display: flex;
            justify-content: center;
        }

        /* Glass Card Styling */
        .login-card {
            width: 100%;
            max-width: 450px;
            background: rgba(255, 255, 255, 0.95); /* Glass Effect */
            padding: 50px 40px;
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.2);
            text-align: center;
        }

        .logo {
            font-size: 32px;
            font-weight: 600;
            color: #333;
            margin-bottom: 5px;
        }

        .logo b {
            color: #004AAD;
        }

        .subtitle {
            font-size: 16px;
            color: #666;
            margin-bottom: 40px; /* Space between text and inputs */
            font-weight: 400;
        }

        /* Input Fields */
        .input-group {
            position: relative;
            margin-bottom: 25px; /* Margin between inputs */
            text-align: left;
        }

        label {
            display: block;
            margin-bottom: 10px;
            font-weight: 500;
            color: #333;
            font-size: 15px;
        }

        input {
            width: 100%;
            padding: 14px 15px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 15px;
            outline: none;
            transition: all 0.3s ease;
            background: #fff;
        }

        input:focus {
            border-color: #004AAD;
            box-shadow: 0 0 5px rgba(0, 74, 173, 0.2);
        }

        /* Password Icons */
        .password-container {
            position: relative;
        }

        .showHidePw {
            position: absolute;
            top: 50%;
            right: 15px;
            transform: translateY(-50%);
            font-size: 20px;
            color: #777;
            cursor: pointer;
            transition: 0.2s;
        }

        .showHidePw:hover {
            color: #004AAD;
        }

        /* Error Messages */
        .error-msg {
            background-color: #ffebee;
            color: #d32f2f;
            padding: 12px;
            border-radius: 8px;
            font-size: 14px;
            margin-bottom: 25px;
            border: 1px solid #ffcdd2;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        /* Login Button */
        button {
            width: 100%;
            padding: 15px;
            background: #004AAD;
            color: white;
            border: none;
            border-radius: 50px;
            font-size: 18px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.3s ease;
            box-shadow: 0 5px 15px rgba(0, 74, 173, 0.2);
            margin-top: 10px;
        }

        button:hover {
            background: #003680;
            transform: translateY(-2px);
        }

        /* Footer Link */
        .signin-up {
            margin-top: 30px;
            font-size: 15px;
            color: #666;
        }
        
        .signin-up a {
            color: #004AAD;
            text-decoration: none;
            font-weight: 600;
        }

        .signin-up a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    
    <div class="container">
        <div class="login-card">
            
            <p class="logo">SAVE <b>Plate</b></p>
            <p class="subtitle">Admin Login</p>

            <form action="" method="post">
                
                <?php if($msg == 1): ?>
                    <div class="error-msg">
                        <i class="uil uil-exclamation-circle"></i> Incorrect Password.
                    </div>
                <?php elseif($msg == 2): ?>
                    <div class="error-msg">
                        <i class="uil uil-user-times"></i> Account does not exist.
                    </div>
                <?php endif; ?>

                <div class="input-group">
                    <label for="email">Email Address</label>
                    <input type="email" id="email" name="email" placeholder="admin@example.com" required />
                </div>
                
                <div class="input-group">
                    <label for="password">Password</label>
                    <div class="password-container">
                        <input type="password" id="password" name="password" placeholder="Enter your password" required />
                        <i class="uil uil-eye-slash showHidePw"></i>
                    </div>
                </div>

                <button type="submit" name="sign">Login</button>
                
                <div class="signin-up">
                    <p>Don't have an account? <a href="signup.php">Register</a></p>
                </div>

            </form>
        </div>
    </div>

    <script>
        const pwShowHide = document.querySelectorAll(".showHidePw");
        const pwFields = document.querySelectorAll("input[type='password']");

        pwShowHide.forEach(eyeIcon => {
            eyeIcon.addEventListener("click", () => {
                pwFields.forEach(pwField => {
                    if (pwField.type === "password") {
                        pwField.type = "text";
                        eyeIcon.classList.replace("uil-eye-slash", "uil-eye");
                    } else {
                        pwField.type = "password";
                        eyeIcon.classList.replace("uil-eye", "uil-eye-slash");
                    }
                });
            });
        });
    </script>

</body>
</html>