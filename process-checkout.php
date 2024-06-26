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
                echo "Failed to save checkout details.";
            }
        } else {
            echo "All fields are required.";
        }
    } else {
        echo "You need to log in to place an order.";
    }
}
?>
