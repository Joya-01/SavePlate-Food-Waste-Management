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
</head>
<body style="background-color: #004AAD;">
    <div class="container">
        <div class="regformf" >
            <form action="" method="post">
                <p class="logo">Food <b style="color: #004AAD;">Donate</b></p>
                
                <div class="input">
                    <label for="foodname"> Food Name:</label>
                    <input type="text" id="foodname" name="foodname" required/>
                </div>
              
                <div class="radio">
                    <label for="meal">Meal type :</label> 
                    <br><br>
                    <input type="radio" name="meal" id="veg" value="veg" required/>
                    <label for="veg" style="padding-right: 40px;">Veg</label>
                    <input type="radio" name="meal" id="Non-veg" value="Non-veg" >
                    <label for="Non-veg">Non-veg</label>
                </div>
                <br>

                <div class="input">
                    <label for="food">Select the Category:</label>
                    <br><br>
                    <div class="image-radio-group">
                        <input type="radio" id="raw-food" name="image-choice" value="raw-food">
                        <label for="raw-food">
                          <img src="img/raw-food.png" alt="raw-food" >
                        </label>
                        <input type="radio" id="cooked-food" name="image-choice" value="cooked-food" checked>
                        <label for="cooked-food">
                          <img src="img/cooked-food.png" alt="cooked-food" >
                        </label>
                        <input type="radio" id="packed-food" name="image-choice" value="packed-food">
                        <label for="packed-food">
                          <img src="img/packed-food.png" alt="packed-food" >
                        </label>
                    </div>
                </div>

                <div class="input">
                    <label for="quantity">Quantity:(number of person /kg)</label>
                    <input type="text" id="quantity" name="quantity" required/>
                </div>

                <div class="input">
                    <label for="expiry_date">Expiry Time (When will food spoil?):</label>
                    <input type="datetime-local" id="expiry_date" name="expiry_date" required 
                           style="padding: 10px; width: 100%; border-radius: 5px; border: none; margin-top: 5px;"/>
                </div>

                <b><p style="text-align: center;">Contact Details</p></b>
                
                <div class="input">
                    <div>
                        <label for="name">Name:</label>
                        <input type="text" id="name" name="name" value="<?php echo $_SESSION['name'] ;?>" required/>
                    </div>
                    <div>
                        <label for="phoneno">PhoneNo:</label>
                        <input type="text" id="phoneno" name="phoneno" maxlength="10" pattern="[0-9]{10}" required />
                    </div>
                </div>

                <div class="input">
                    <label for="district">District:</label>
                    <select id="district" name="district" style="padding:10px;" required>
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

                    <label for="address" style="padding-left: 10px;">Address:</label>
                    <input type="text" id="address" name="address" required/><br>
                </div>

                <div class="btn">
                    <button type="submit" name="submit"> submit</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>