<?php
include 'connect.php';

if(isset($_POST['submit'])) {
    $v_name = $_POST['vendor_name'];
    $phone = $_POST['phone'];
    $item = $_POST['item_name'];
    $desc = $_POST['description'];
    $orig_price = $_POST['original_price'];
    $disc_price = $_POST['discount_price'];
    $expiry = $_POST['expiry_date'];
    $loc = $_POST['location'];

    // Image Upload Logic
    $target_dir = "../img/"; // Ensure you have an 'img' folder in root
    $target_file = $target_dir . basename($_FILES["food_image"]["name"]);
    move_uploaded_file($_FILES["food_image"]["tmp_name"], $target_file);

    $sql = "INSERT INTO discounted_items (vendor_name, phone, item_name, description, original_price, discount_price, expiry_date, location, image_path) 
            VALUES ('$v_name', '$phone', '$item', '$desc', '$orig_price', '$disc_price', '$expiry', '$loc', '$target_file')";

    if($connection->query($sql) === TRUE) {
        echo "<script>alert('Item listed successfully!'); window.location.href='add_item.php';</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $connection->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vendor - Add Discount Item</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    
    <style>
        /* Base Styles */
        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        body { 
            font-family: 'Poppins', sans-serif; 
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        /* Card Container */
        .container { 
            width: 100%;
            max-width: 550px; 
            background: white; 
            padding: 40px; 
            border-radius: 20px; 
            box-shadow: 0 15px 35px rgba(0,0,0,0.1); 
        }

        /* Header */
        h2 { 
            text-align: center; 
            color: #004AAD; 
            margin-bottom: 30px; 
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        /* Form Elements */
        label {
            display: block;
            margin-bottom: 8px;
            color: #555;
            font-weight: 500;
            font-size: 0.9em;
        }

        input[type="text"],
        input[type="number"],
        input[type="datetime-local"],
        input[type="file"],
        textarea { 
            width: 100%; 
            padding: 12px 15px; 
            margin-bottom: 20px; 
            border: 1px solid #e1e1e1; 
            border-radius: 8px; 
            background: #f9f9f9;
            font-family: inherit;
            font-size: 14px;
            transition: all 0.3s ease;
        }

        textarea {
            resize: vertical;
            height: 100px;
        }

        /* Focus Effects */
        input:focus, textarea:focus {
            border-color: #004AAD;
            background: #fff;
            outline: none;
            box-shadow: 0 0 8px rgba(0, 74, 173, 0.1);
        }

        /* Price Group (Side by Side) */
        .price-group {
            display: flex;
            gap: 15px;
        }
        .price-group div {
            flex: 1;
        }

        /* Submit Button */
        button { 
            width: 100%; 
            padding: 15px; 
            background: #004AAD; 
            color: white; 
            border: none; 
            border-radius: 50px; 
            font-size: 16px; 
            font-weight: 600; 
            cursor: pointer; 
            transition: all 0.3s ease;
            box-shadow: 0 5px 15px rgba(0, 74, 173, 0.3);
            margin-top: 10px;
        }

        button:hover { 
            background: #003680; 
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0, 74, 173, 0.4);
        }

        /* File Input Styling Fix */
        input[type="file"] {
            padding: 10px;
            background: white;
        }

    </style>
</head>
<body>

<div class="container">
    <h2>List New Deal</h2>
    <form method="post" enctype="multipart/form-data">
        
        <label>Vendor Details</label>
        <input type="text" name="vendor_name" placeholder="Shop Name" required>
        <input type="text" name="phone" placeholder="Contact Phone" required>
        
        <label>Item Information</label>
        <input type="text" name="item_name" placeholder="Item Name (e.g. Bread)" required>
        <textarea name="description" placeholder="Description (e.g. Best before tomorrow)" required></textarea>
        
        <div class="price-group">
            <div>
                <label>Original Price (₹)</label>
                <input type="number" name="original_price" step="0.01" placeholder="0.00" required>
            </div>
            <div>
                <label>Discount Price (₹)</label>
                <input type="number" name="discount_price" step="0.01" placeholder="0.00" required>
            </div>
        </div>
        
        <label>Expiry Date & Time</label>
        <input type="datetime-local" name="expiry_date" required>
        
        <label>Pickup Location</label>
        <input type="text" name="location" placeholder="Full Address" required>
        
        <label>Item Image</label>
        <input type="file" name="food_image" required>
        
        <button type="submit" name="submit">List Item Now</button>
    </form>
</div>

</body>
</html>