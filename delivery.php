<?php
session_start();
require_once('classes/database.php'); // Adjust this path if needed
require 'PHPMailer/vendor/autoload.php'; // Ensure the correct path to autoload.php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Check if user is logged in
if (empty($_SESSION['User_Id'])) {
    header('Location: sign-in.php'); // Redirect to login page if not logged in
    exit;
}

class Delivery {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Insert delivery details into the database
    public function insertDeliveryDetails($userId, $fullname, $email, $phone, $address) {
        try {
            $query = $this->conn->prepare("INSERT INTO delivery (User_Id, fullname, email, phone, address, status, checkout_date) 
                                           VALUES (?, ?, ?, ?, ?, 'pending', NOW())");
            return $query->execute([$userId, $fullname, $email, $phone, $address]);
        } catch (PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
            return false;
        }
    }
}

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['fullname'], $_POST['user_email'], $_POST['phone'], $_POST['address'])) {
        $userId = $_SESSION['User_Id'];
        $fullname = $_POST['fullname'];
        $email = $_POST['user_email'];
        $phone = $_POST['phone'];
        $address = $_POST['address'];

        // Create a new database connection
        $database = new Database();
        $db = $database->getConnection();

        // Create a new Delivery instance
        $delivery = new Delivery($db);

        // Insert delivery details
        $isInserted = $delivery->insertDeliveryDetails($userId, $fullname, $email, $phone, $address);

        if ($isInserted) {
            // Send confirmation email
            $mail = new PHPMailer(true);
            try {
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'janinevalencian27@gmail.com';
                $mail->Password = 'ddjj bllh jbvu wphz';
                $mail->SMTPSecure = 'tls';
                $mail->Port = 587;

                $mail->setFrom('janinevalencian27@gmail.com', 'Marga Cakes');
                $mail->addAddress($email);
 
                $mail->isHTML(true);
                $mail->Subject = 'Order Confirmation';
                $mail->Body = "<p>Dear $fullname,</p>
                               <p>Your order has been successfully placed! We will deliver it to the following address:</p>
                               <p>$address</p>
                               <p>Thank you for choosing us!</p>";

                $mail->send();
                echo "Your order has been successfully placed! A confirmation email has been sent.";
                header('Location: index.php');
                exit;
            } catch (Exception $e) {
                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }
        } else {
            echo "An error occurred. Please try again.";
        }
    } else {
        echo "Please fill in all required fields.";
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
                <form action="index.php" method="post">
                    <div class="mb-3">
                        <label for="fullname" class="form-label">Full Name</label>
                        <input type="text" class="form-control" id="fullname" name="fullname" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email Address</label>
                        <input type="email" class="form-control" id="email" name="user_email" required>
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label">Phone Number</label>
                        <input type="text" class="form-control" id="phone" name="phone" required>
                    </div>
                    <div class="mb-3">
                        <label for="address" class="form-label">Delivery Address</label>
                        <textarea class="form-control" id="address" name="address" rows="3" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-success" id="submit">Submit Order</button>
                </form>
            </div>
        </div>
    </div>
</section>
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.bundle.min.js"></script>
<script src="js/custom.js"></script>
</body>
</html>