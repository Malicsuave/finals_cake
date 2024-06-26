<?php
session_start();
require_once('classes/database.php');
$con = new Database();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['status']) && isset($_POST['delivery_id'])) {
    $status = $_POST['status'];
    $delivery_id = $_POST['delivery_id'];

    // Update delivery status in the database
    if ($con->updateDeliveryStatus($status, $delivery_id)) {
        // Redirect back to the page with a success message or handle as needed
        header("Location: admin_orders.php");
        exit();
    } else {
        // Handle update failure
        echo "Failed to update delivery status.";
    }
} else {
    // Handle invalid or missing POST data
    echo "Invalid request.";
}
?>