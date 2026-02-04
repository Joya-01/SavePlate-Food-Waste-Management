<?php
// session_start();
// $connection=mysqli_connect("localhost:3307","root","");
// $db=mysqli_select_db($connection,'demo');
include '../connection.php';
$msg=0;
if(isset($_POST['sign']))
{

    $username=$_POST['username'];
    $email=$_POST['email'];
    $password=$_POST['password'];

    $location=$_POST['district'];
    $address=$_POST['address'];

    $pass=password_hash($password,PASSWORD_DEFAULT);
    $sql="select * from admin where email='$email'" ;
    $result= mysqli_query($connection, $sql);
    $num=mysqli_num_rows($result);
    if($num==1){
        echo "<h1><center>Account already exists</center></h1>";
    }
    else{
    
    $query="insert into admin(name,email,password,location,address) values('$username','$email','$pass','$location','$address')";
    $query_run= mysqli_query($connection, $query);
    if($query_run)
    {
        header("location:signin.php");
    }
    else{
        echo '<script type="text/javascript">alert("data not saved")</script>';
        
    }
}


   
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Registration - SAVE Plate</title>
    
    <link rel="stylesheet" href="loginstyle.css">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url('../img/p11.jpg');
            background-repeat: no-repeat;
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            /* Added vertical padding to ensure form doesn't touch edges on small screens */
            padding: 40px 20px; 
        }

        .container {
            width: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        #form {
            width: 100%;
            max-width: 500px; /* Slightly wider for the address field */
            background: rgba(255, 255, 255, 0.95); /* Glass effect */
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.2);
            padding: 45px 40px; /* Balanced padding */
            margin: 0 auto;
        }

        .title {
            font-size: 32px;
            font-weight: 600;
            color: #333;
            display: block;
            text-align: center;
            margin-bottom: 35px; /* More space below title */
            position: relative;
        }
        
        .title::after {
            content: '';
            display: block;
            width: 60px;
            height: 4px;
            background: #004AAD;
            margin: 10px auto 0;
            border-radius: 5px;
        }

        /* Standardized Spacing for All Inputs */
        .input-group {
            margin-bottom: 20px; /* Consistent gap between fields */
            position: relative;
        }

        label {
            display: block;
            margin-bottom: 8px; /* Space between label and input */
            font-weight: 500;
            color: #444;
            font-size: 15px;
        }

        input, select, textarea {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 15px;
            outline: none;
            transition: 0.3s;
            background: #fff;
            font-family: 'Poppins', sans-serif;
            color: #333;
        }

        textarea {
            resize: vertical; /* Allow resizing only vertically */
            height: 100px;    /* Good default height for address */
        }

        input:focus, select:focus, textarea:focus {
            border-color: #004AAD;
            box-shadow: 0 0 5px rgba(0, 74, 173, 0.2);
        }

        /* Password Eye Icon Positioning */
        .password-wrapper {
            position: relative;
        }

        .showHidePw {
            position: absolute;
            top: 50%;
            right: 15px;
            transform: translateY(-50%);
            cursor: pointer;
            font-size: 20px;
            color: #777;
            transition: 0.2s;
        }

        .showHidePw:hover {
            color: #004AAD;
        }

        /* Button Styling */
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
            transition: 0.3s;
            margin-top: 25px; /* Extra space above button */
            box-shadow: 0 5px 15px rgba(0, 74, 173, 0.3);
        }

        button:hover {
            background: #003680;
            transform: translateY(-2px);
        }

        /* Footer Links */
        .login-signup {
            margin-top: 25px;
            text-align: center;
            font-size: 15px;
            color: #666;
        }

        .login-signup a {
            color: #004AAD;
            text-decoration: none;
            font-weight: 600;
        }

        .login-signup a:hover {
            text-decoration: underline;
        }

        /* Error Text */
        .error {
            color: #d32f2f;
            font-size: 13px;
            margin-top: 5px;
            display: flex;
            align-items: center;
            gap: 5px;
        }
    </style>
</head>
<body>
    
    <div class="container">
        <form action=" " method="post" id="form">
            <span class="title">Register</span>
            
            <div class="input-group">
                <label for="username">Name</label>
                <input type="text" id="username" name="username" placeholder="Enter your full name" required/>
            </div>
            
            <div class="input-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="Enter your email address" required/>
            </div>

            <div class="input-group">
                <label for="password">Password</label>
                <div class="password-wrapper">
                    <input type="password" name="password" id="password" placeholder="Create a password" required/>
                    <i class="uil uil-eye-slash showHidePw" id="showpassword"></i>
                </div>
                
                <?php
                if($msg==1){
                    echo '<div class="error">';
                    echo '<i class="bx bx-error-circle error-icon"></i>';
                    echo 'Password does not match.';
                    echo '</div>';
                }
                ?> 
            </div>

            <div class="input-group">
                <label for="address">Address</label>
                <textarea id="address" name="address" placeholder="Enter your full address" required></textarea>
            </div>
            
            <div class="input-group">
                <label for="district">District</label>
                <select id="district" name="district" required>
                    <option value="" disabled selected>Select District</option>
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
            </div>
                  
            <button type="submit" name="sign">Register</button>
            
            <div class="login-signup" >
                <span class="text">Already a member?
                    <a href="signin.php" class="text login-link">Login Now</a>
                </span>
            </div>
        </form>
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
    
    <script src="signin.js" defer></script>
</body>
</html>