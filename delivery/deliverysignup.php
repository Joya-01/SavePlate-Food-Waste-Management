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

    // $location=$_POST['district'];

    $pass=password_hash($password,PASSWORD_DEFAULT);
    $sql="select * from delivery_persons where email='$email'" ;
    $result= mysqli_query($connection, $sql);
    $num=mysqli_num_rows($result);
    if($num==1){
        // echo "<h1> already account is created </h1>";
        // echo '<script type="text/javascript">alert("already Account is created")</script>';
        echo "<h1><center>Account already exists</center></h1>";
    }
    else{
    
    $query="insert into delivery_persons(name,email,password,city) values('$username','$email','$pass','$location')";
    $query_run= mysqli_query($connection, $query);
    if($query_run)
    {
        // $_SESSION['email']=$email;
        // $_SESSION['name']=$row['name'];
        // $_SESSION['gender']=$row['gender'];
       
        header("location:delivery.php");
        // echo "<h1><center>Account does not exists </center></h1>";
        //  echo '<script type="text/javascript">alert("Account created successfully")</script>'; -->
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

    <title>Delivery Signup - SAVE Plate</title>
    <link rel="stylesheet" href="deliverycss.css">
    
    <style>
        /* Specific styles for Signup to match Login Glassmorphism */
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

        body {
            margin: 0;
            padding: 0;
            font-family: 'Poppins', sans-serif;
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
            max-width: 450px;
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.2);
            padding: 40px 30px;
            position: relative;
            transform: none; /* Resetting external CSS centering */
            top: auto;
            left: auto;
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
            background: #004AAD;
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

        /* Styling the Select Dropdown */
        .select-container {
            margin: 30px 0;
            position: relative;
        }

        select {
            width: 100%;
            height: 45px;
            padding: 10px;
            font-size: 16px;
            border: 2px solid #adadad;
            border-radius: 5px;
            background: transparent;
            outline: none;
            color: #333;
            transition: 0.3s;
            cursor: pointer;
        }

        select:focus {
            border-color: #004AAD;
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
    </style>
  </head>
  <body>
    <div class="center">
      <h1>Register</h1>
      <form method="post" action=" ">
        
        <div class="txt_field">
          <input type="text" name="username" required/>
          <span></span>
          <label>Username</label>
        </div>
        
        <div class="txt_field">
          <input type="email" name="email" required/>
          <span></span>
          <label>Email</label>
        </div>

        <div class="txt_field">
          <input type="password" name="password" required/>
          <span></span>
          <label>Password</label>
        </div>
        
        <div class="select-container">
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

        <input type="submit" name="sign" value="Register">
        
        <div class="signup_link">
          Already a member? <a href="deliverylogin.php">Sign in</a>
        </div>
      </form>
    </div>
  </body>
</html>