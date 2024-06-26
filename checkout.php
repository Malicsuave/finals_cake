<?php
session_start();
require_once('classes/database.php');
$con = new Database();
echo $_SESSION['User_Id'];if (empty($_SESSION['username'])) {   
    header('location:sign-in.php');
  }
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if user is logged in
    if (isset($_SESSION['User_Id'])) {
        $userId = $_SESSION['User_Id'];
        // Check if all required fields are set
        if (isset($_POST['fullname'], $_POST['email'], $_POST['phone'], $_POST['address'])) {
            $fullname = $_POST['fullname'];
            $email = $_POST['email'];
            $phone = $_POST['phone'];
            $address = $_POST['address'];

            // Insert checkout details into database
            if ($con->insertCheckoutDetails($userId, $fullname, $email, $phone, $address)) {
                // Redirect to order status page upon successful insertion
                header("Location: orderstatus.php");
                exit;
            } else {
                echo "";
            }
        } else {
            echo "All fields are required.";
        }
    } else {
        echo "You need to log in to place an order.";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout Form</title>
    <!-- Include your CSS files -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap-icons.css">
    <link rel="stylesheet" href="css/tooplate-little-fashion.css">
</head>
<body>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delivery Form</title>
    <!-- Include your CSS files -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap-icons.css">
    <link rel="stylesheet" href="css/tooplate-little-fashion.css">
</head>
<body>

<section class="checkout-form section-padding">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-8 mx-auto">
                <h2 class="text-center mb-4">Delivery Form</h2>
                <form action="process-checkout.php" method="post">
                    <div class="mb-3">
                        <label for="fullname" class="form-label">Full Name</label>
                        <input type="text" class="form-control" id="fullname" name="fullname" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email Address</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label">Phone Number</label>
                        <input type="text" class="form-control" id="phone" name="phone" required>
                    </div>
                    <div class="mb-3">
                        <label for="address" class="form-label">Delivery Address</label>
                        <textarea class="form-control" id="address" name="address" rows="3" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-success">Submit Order</button>
                </form>
            </div>
        </div>
    </div>
</section>

<!-- Include your JavaScript files -->
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.bundle.min.js"></script>
<script src="js/custom.js"></script>
</body>
</html>

