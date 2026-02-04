<?php
include 'connection.php';
// $connection=mysqli_connect("localhost:3307","root","");
// $db=mysqli_select_db($connection,'demo');
if(isset($_POST['sign']))
{
    $username=$_POST['name'];
    $email=$_POST['email'];
    $password=$_POST['password'];
    $gender=$_POST['gender'];

    $pass=password_hash($password,PASSWORD_DEFAULT);
    $sql="select * from login where email='$email'" ;
    $result= mysqli_query($connection, $sql);
    $num=mysqli_num_rows($result);
    if($num==1){
        echo "<h1><center>Account already exists</center></h1>";
    }
    else{
    
    $query="insert into login(name,email,password,gender) values('$username','$email','$pass','$gender')";
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
    <title>Login</title>
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
            /* Consistent background with your home page */
            background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('img/p11.jpg');
            background-size: cover;
            background-position: center;
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
            max-width: 450px;
            background: rgba(255, 255, 255, 0.95);
            padding: 40px 30px;
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
        }

        .logo {
            font-size: 30px;
            font-weight: 600;
            text-align: center;
            color: #333;
            margin-bottom: 10px;
        }

        #heading {
            text-align: center;
            font-size: 16px;
            color: #666;
            margin-bottom: 30px;
        }

        /* Form Inputs */
        .input, .password {
            margin-bottom: 20px;
            position: relative;
        }

        .textlabel {
            display: block;
            margin-bottom: 5px;
            font-weight: 500;
            color: #333;
            font-size: 14px;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 15px;
            outline: none;
            transition: 0.3s;
        }

        input[type="text"]:focus,
        input[type="email"]:focus,
        input[type="password"]:focus {
            border-color: #004AAD;
            box-shadow: 0 0 5px rgba(0, 74, 173, 0.2);
        }

        /* Password Eye Icon */
        .password i {
            position: absolute;
            top: 42px; /* Adjust based on label height */
            right: 15px;
            font-size: 20px;
            color: #777;
            cursor: pointer;
        }

        /* Radio Buttons */
        .radio {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 25px;
            font-size: 15px;
        }

        .radio input[type="radio"] {
            accent-color: #004AAD;
            transform: scale(1.1);
        }

        /* Submit Button */
        .btn button {
            width: 100%;
            padding: 12px;
            background: #004AAD;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 18px;
            font-weight: 500;
            cursor: pointer;
            transition: 0.3s;
        }

        .btn button:hover {
            background: #003680;
        }

        /* Sign In Link */
        .signin-up {
            margin-top: 20px;
            text-align: center;
        }

        .signin-up p {
            font-size: 15px !important; /* Overriding inline style */
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
        <div class="regform">
       
            <form action="" method="post">
                <p class="logo">SAVE <b style="color: #004AAD;">Plate</b></p>
                <p id="heading">Create your account</p>
                
                <div class="input">
                    <label class="textlabel" for="name">User Name</label>
                    <input type="text" id="name" name="name" placeholder="Enter your full name" required/>
                </div>
                
                <div class="input">
                    <label class="textlabel" for="email">Email Address</label>
                    <input type="email" id="email" name="email" placeholder="Enter your email" required/>
                </div>

                <div class="password">
                    <label class="textlabel" for="password">Password</label>
                    <input type="password" name="password" id="password" placeholder="Create a password" required/>
                    <i class="uil uil-eye-slash showHidePw" id="showpassword"></i>                
                </div>
    
                <div class="radio">
                    <label style="font-weight: 500; margin-right: 10px;">Gender:</label>
                    
                    <input type="radio" name="gender" id="male" value="male" required/>
                    <label for="male">Male</label>
                    
                    <input type="radio" name="gender" id="female" value="female">
                    <label for="female">Female</label>
                </div>

                <div class="btn">
                    <button type="submit" name="sign">Sign Up</button>
                </div>
                
                <div class="signin-up">
                    <p>Already have an account? <a href="signin.php">Sign in</a></p>
                </div>
            </form>
        </div>
    </div>
  
    <script src="admin/login.js"></script>
       
</body>
</html>