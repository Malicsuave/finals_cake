<?php
session_start();
require_once('classes/database.php');
$con = new Database();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['orderId']) && isset($_POST['status'])) {
        $orderId = $_POST['orderId'];
        $status = $_POST['status'];

        // Update the order status
        $query = $con->conn->prepare("UPDATE checkout SET status = :status WHERE checkout_Id = :orderId");
        $query->bindParam(':status', $status);
        $query->bindParam(':orderId', $orderId);

        if ($query->execute()) {
            header("Location: orders.php");
            exit;
        } else {
            echo "Failed to update order status.";
        }
    } else {
        echo "Invalid request.";
    }
} else {
    echo "Invalid request method.";
}
?>
