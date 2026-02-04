<?php
session_start();
// $connection=mysqli_connect("localhost:3307","root","");
// $db=mysqli_select_db($connection,'demo');
include '../connection.php';

$acc=0;
$msg=0;

// --- REGISTRATION LOGIC ---
if(isset($_POST['signup']))
{
    $username=$_POST['name'];
    $email=$_POST['email'];
    $password=$_POST['password'];
    $location=$_POST['district'];

    $pass=password_hash($password,PASSWORD_DEFAULT);
    $sql="select * from admin where email='$email'" ;
    $result= mysqli_query($connection, $sql);
    $num=mysqli_num_rows($result);
    if($num==1){
        $acc=1;
    }
    else{
        $query="insert into admin(name,email,password,location) values('$username','$email','$pass','$location')";
        $query_run= mysqli_query($connection, $query);
        if($query_run)
        {
            $msg=1;
        }
        else{
            echo '<script type="text/javascript">alert("data not saved")</script>';
        }
    }
}

// --- LOGIN LOGIC (Moved to top to fix header redirect errors) ---
if (isset($_POST['Login'])) {
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
          exit(); 
        } else {
          echo '<script>alert("Login Failed: Incorrect password");</script>';
        }
      }
    } else {
      echo '<script>alert("Account does not exist");</script>';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            /* Background consistent with your other pages */
            background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url('../img/p11.jpg');
            background-size: cover;
            background-position: center;
        }

        .container {
            position: relative;
            max-width: 450px;
            width: 100%;
            background: rgba(255, 255, 255, 0.95); /* Glass effect */
            border-radius: 20px;
            box-shadow: 0 5px 25px rgba(0, 0, 0, 0.2);
            overflow: hidden;
            margin: 0 20px;
        }

        .forms {
            padding: 30px;
            width: 200%; /* To hold both forms side by side */
            display: flex;
            align-items: flex-start;
            transition: transform 0.3s ease-in-out;
        }

        .form {
            width: 50%;
            padding-right: 30px;
        }

        /* Slide Logic */
        .container.active .forms {
            transform: translateX(-50%);
        }

        .form .title {
            position: relative;
            font-size: 27px;
            font-weight: 600;
            color: #333;
        }

        .form .title::before {
            content: '';
            position: absolute;
            left: 0;
            bottom: -3px;
            height: 3px;
            width: 30px;
            background-color: #004AAD;
            border-radius: 25px;
        }

        .form .input-field {
            position: relative;
            height: 50px;
            width: 100%;
            margin-top: 25px;
        }

        .input-field input, .input-field select {
            position: absolute;
            height: 100%;
            width: 100%;
            padding: 0 35px;
            border: none;
            outline: none;
            font-size: 16px;
            border-bottom: 2px solid #ccc;
            border-top: 2px solid transparent;
            background: transparent;
            transition: all 0.2s ease;
        }

        .input-field select {
            padding: 0 30px;
            color: #333;
            cursor: pointer;
        }

        .input-field input:is(:focus, :valid), .input-field select:focus {
            border-bottom-color: #004AAD;
        }

        .input-field i {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            color: #999;
            font-size: 23px;
            left: 0;
            transition: all 0.2s ease;
        }

        .input-field input:is(:focus, :valid) ~ i, .input-field select:focus ~ i {
            color: #004AAD;
        }

        .input-field i.icon {
            left: 0;
        }

        .input-field i.showHidePw {
            left: auto;
            right: 0;
            cursor: pointer;
            padding: 10px;
        }

        /* Button */
        .input-field.button {
            margin-top: 35px;
        }

        .input-field button {
            height: 100%;
            width: 100%;
            color: #fff;
            background-color: #004AAD;
            border: none;
            border-radius: 50px;
            font-size: 18px;
            font-weight: 500;
            letter-spacing: 1px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .input-field button:hover {
            background-color: #003680;
            transform: scale(0.98);
        }

        .login-signup {
            margin-top: 30px;
            text-align: center;
        }

        .text {
            color: #333;
            font-size: 14px;
        }

        .text a {
            color: #004AAD;
            text-decoration: none;
            font-weight: 600;
        }

        .text a:hover {
            text-decoration: underline;
        }

        /* Alerts */
        .alert {
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 5px;
            text-align: center;
            font-size: 14px;
            font-weight: 500;
        }
        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
    </style>
</head>
<body>
    
    <div class="container">
        <div class="forms">
            
            <div class="form login">
                <span class="title">Admin Login</span>
                
                <?php if($msg==1){ echo '<div class="alert alert-success">Account created successfully! Please login.</div>'; } ?>
                
                <form action="" method="post">
                    <div class="input-field">
                        <input type="text" placeholder="Enter your email" name="email" required>
                        <i class="uil uil-envelope icon"></i>
                    </div>
                    <div class="input-field">
                        <input type="password" class="password" name="password" placeholder="Enter your password" required>
                        <i class="uil uil-lock icon"></i>
                        <i class="uil uil-eye-slash showHidePw"></i>
                    </div>

                    <div class="input-field button">
                        <button type="submit" name="Login">Login Now</button>
                    </div>
                </form>

                <div class="login-signup">
                    <span class="text">Not a member?
                        <a href="#" class="text signup-link">Signup Now</a>
                    </span>
                </div>
            </div>

            <div class="form signup">
                <span class="title">Admin Registration</span>
                
                <?php if($acc==1){ echo '<div class="alert alert-danger">Account already exists!</div>'; } ?>

                <form action="" method="post">
                    <div class="input-field">
                        <input type="text" placeholder="Enter your name" name="name" required>
                        <i class="uil uil-user icon"></i>
                    </div>
                    <div class="input-field">
                        <input type="text" placeholder="Enter your email" name="email" required>
                        <i class="uil uil-envelope icon"></i>
                    </div>
                    
                    <div class="input-field">
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
                        <i class="uil uil-map-marker icon"></i>
                    </div>

                    <div class="input-field">
                        <input type="password" class="password" name="password" placeholder="Create password" required>
                        <i class="uil uil-lock icon"></i>
                        <i class="uil uil-eye-slash showHidePw"></i>
                    </div>

                    <div class="input-field button">
                        <button type="submit" name="signup">Register</button>
                    </div>
                </form>

                <div class="login-signup">
                    <span class="text">Already a member?
                        <a href="#" class="text login-link">Login Now</a>
                    </span>
                </div>
            </div>
        </div>
    </div>

    <script>
        const container = document.querySelector(".container"),
              pwShowHide = document.querySelectorAll(".showHidePw"),
              pwFields = document.querySelectorAll(".password"),
              signUp = document.querySelector(".signup-link"),
              login = document.querySelector(".login-link");

        // Toggle Password Visibility
        pwShowHide.forEach(eyeIcon => {
            eyeIcon.addEventListener("click", ()=>{
                pwFields.forEach(pwField => {
                    if(pwField.type === "password"){
                        pwField.type = "text";
                        pwShowHide.forEach(icon => {
                            icon.classList.replace("uil-eye-slash", "uil-eye");
                        })
                    }else{
                        pwField.type = "password";
                        pwShowHide.forEach(icon => {
                            icon.classList.replace("uil-eye", "uil-eye-slash");
                        })
                    }
                }) 
            })
        })

        // Switch Forms
        signUp.addEventListener("click", ( )=>{
            container.classList.add("active");
        });
        login.addEventListener("click", ( )=>{
            container.classList.remove("active");
        });
    </script>
</body>
</html>