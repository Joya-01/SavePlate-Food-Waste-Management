<?php
include("login.php"); 
if($_SESSION['name']==''){
  header("location: signin.php");
}

$emailid= $_SESSION['email'];
// Ensure the connection is correct for your local environment
$connection=mysqli_connect("localhost","root","","foodwastedb"); 

if(isset($_POST['submit']))
{
    $foodname=mysqli_real_escape_string($connection, $_POST['foodname']);
    $meal=mysqli_real_escape_string($connection, $_POST['meal']);
    $category=$_POST['image-choice'];
    $quantity=mysqli_real_escape_string($connection, $_POST['quantity']);
    $phoneno=mysqli_real_escape_string($connection, $_POST['phoneno']);
    $district=mysqli_real_escape_string($connection, $_POST['district']);
    $address=mysqli_real_escape_string($connection, $_POST['address']);
    $name=mysqli_real_escape_string($connection, $_POST['name']);
    
    // NEW: Capture and sanitize the expiry date
    $expiry_date = mysqli_real_escape_string($connection, $_POST['expiry_date']);

    // INSERT query including the expiry_date column
    $query="INSERT INTO food_donations(email, food, type, category, phoneno, location, address, name, quantity, expiry_date) 
            VALUES('$emailid', '$foodname', '$meal', '$category', '$phoneno', '$district', '$address', '$name', '$quantity', '$expiry_date')";
    
    $query_run= mysqli_query($connection, $query);
    if($query_run)
    {
        echo '<script type="text/javascript">alert("Donation saved successfully! The timer has started."); window.location.href="delivery.html";</script>';
    }
    else{
        echo '<script type="text/javascript">alert("Data not saved: ' . mysqli_error($connection) . '")</script>';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Food Donate</title>
    <link rel="stylesheet" href="loginstyle.css">
    <style>
        /* Specific Styles for Donate Form to override/supplement loginstyle.css */
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('img/p11.jpg');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            min-height: 100vh;
            padding: 20px 0;
        }

        .container {
            width: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .regformf {
            width: 100%;
            max-width: 800px; /* Wider form for better layout */
            background: rgba(255, 255, 255, 0.95);
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
            margin-top: 20px;
            margin-bottom: 20px;
        }

        .logo {
            font-size: 32px;
            text-align: center;
            font-weight: 600;
            color: #333;
            margin-bottom: 30px;
        }

        /* Input Styling */
        .input {
            margin-bottom: 20px;
        }

        .input label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: #444;
            font-size: 15px;
        }

        .input input[type="text"],
        .input input[type="datetime-local"],
        .input select {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 15px;
            outline: none;
            transition: 0.3s;
            background: #fff;
            font-family: 'Poppins', sans-serif;
        }

        .input input:focus, .input select:focus {
            border-color: #004AAD;
            box-shadow: 0 0 5px rgba(0, 74, 173, 0.2);
        }

        /* Grid Layout for Side-by-Side fields */
        .row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        /* Radio Buttons (Veg/Non-Veg) */
        .radio-group {
            display: flex;
            gap: 20px;
            align-items: center;
        }

        .radio-group label {
            cursor: pointer;
            font-size: 16px;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .radio-group input[type="radio"] {
            transform: scale(1.2);
            accent-color: #004AAD;
        }

        /* Image Selection Styling */
        .image-radio-group {
            display: flex;
            justify-content: center;
            gap: 30px;
            flex-wrap: wrap;
        }

        .image-radio-group input[type="radio"] {
            display: none; /* Hide actual radio button */
        }

        .image-radio-group label {
            cursor: pointer;
            transition: all 0.3s ease;
            border: 3px solid transparent;
            border-radius: 15px;
            padding: 5px;
            text-align: center;
        }

        .image-radio-group label img {
            width: 100px;
            height: 100px;
            object-fit: contain;
            display: block;
            border-radius: 10px;
            transition: 0.3s;
        }

        /* Highlight selected image */
        .image-radio-group input[type="radio"]:checked + label {
            border-color: #004AAD;
            background-color: rgba(0, 74, 173, 0.1);
            transform: scale(1.05);
            box-shadow: 0 5px 15px rgba(0, 74, 173, 0.2);
        }

        .image-radio-group input[type="radio"]:checked + label img {
           /* Optional: Add filter or effect */
        }

        .section-title {
            text-align: center;
            font-size: 18px;
            font-weight: 600;
            color: #004AAD;
            margin: 30px 0 20px;
            position: relative;
        }
        
        .section-title::after {
            content: '';
            display: block;
            width: 50px;
            height: 3px;
            background: #004AAD;
            margin: 5px auto 0;
            border-radius: 2px;
        }

        /* Submit Button */
        .btn button {
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
            margin-top: 10px;
            box-shadow: 0 5px 15px rgba(0, 74, 173, 0.3);
        }

        .btn button:hover {
            background: #003680;
            transform: translateY(-2px);
        }

        /* Mobile Responsive */
        @media (max-width: 768px) {
            .row {
                grid-template-columns: 1fr; /* Stack inputs on mobile */
                gap: 0;
            }
            .regformf {
                padding: 20px;
                margin: 10px;
            }
            .image-radio-group label img {
                width: 80px;
                height: 80px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="regformf">
            <form action="" method="post">
                <p class="logo">Food <b style="color: #004AAD;">Donate</b></p>
                
                <div class="input">
                    <label for="foodname">Food Name:</label>
                    <input type="text" id="foodname" name="foodname" placeholder="E.g., Rice and Curry, Bread, etc." required/>
                </div>
              
                <div class="input">
                    <label>Meal Type:</label>
                    <div class="radio-group">
                        <input type="radio" name="meal" id="veg" value="veg" required/>
                        <label for="veg">Veg</label>
                        
                        <input type="radio" name="meal" id="Non-veg" value="Non-veg">
                        <label for="Non-veg">Non-veg</label>
                    </div>
                </div>

                <div class="input">
                    <label style="text-align: center; margin-bottom: 15px;">Select Food Category:</label>
                    <div class="image-radio-group">
                        <input type="radio" id="cooked-food" name="image-choice" value="cooked-food" checked>
                        <label for="cooked-food">
                          <img src="img/cooked-food.png" alt="cooked-food">
                          <div style="font-size:12px; margin-top:5px;">Cooked</div>
                        </label>

                        <input type="radio" id="raw-food" name="image-choice" value="raw-food">
                        <label for="raw-food">
                          <img src="img/raw-food.png" alt="raw-food">
                          <div style="font-size:12px; margin-top:5px;">Raw</div>
                        </label>

                        <input type="radio" id="packed-food" name="image-choice" value="packed-food">
                        <label for="packed-food">
                          <img src="img/packed-food.png" alt="packed-food">
                          <div style="font-size:12px; margin-top:5px;">Packed</div>
                        </label>
                    </div>
                </div>

                <div class="row">
                    <div class="input">
                        <label for="quantity">Quantity (Person/Kg):</label>
                        <input type="text" id="quantity" name="quantity" placeholder="E.g., 5 people or 2kg" required/>
                    </div>

                    <div class="input">
                        <label for="expiry_date">Expiry Date & Time:</label>
                        <input type="datetime-local" id="expiry_date" name="expiry_date" required />
                    </div>
                </div>

                <p class="section-title">Contact & Location Details</p>
                
                <div class="row">
                    <div class="input">
                        <label for="name">Donor Name:</label>
                        <input type="text" id="name" name="name" value="<?php echo $_SESSION['name'] ;?>" required/>
                    </div>
                    <div class="input">
                        <label for="phoneno">Phone Number:</label>
                        <input type="text" id="phoneno" name="phoneno" maxlength="10" pattern="[0-9]{10}" placeholder="10-digit mobile number" required />
                    </div>
                </div>

                <div class="row">
                    <div class="input">
                        <label for="district">District:</label>
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
                    <div class="input">
                        <label for="address">Full Address:</label>
                        <input type="text" id="address" name="address" placeholder="House no, Street area" required/>
                    </div>
                </div>

                <div class="btn">
                    <button type="submit" name="submit">Submit Donation</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>