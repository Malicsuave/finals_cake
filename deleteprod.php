<?php
session_start();

// Check if user is logged in and is an admin (account_type == 1)
if (!isset($_SESSION['username']) || $_SESSION['account_type'] != 1) {
    header('location: sign-in.php');
    exit();
}

// Include database connection
require_once('classes/database.php');
$con = new Database();

// Check if product_id is set in the query string
if (isset($_GET['id'])) {
    $product_id = $_GET['id'];

    // Perform deletion query
    if ($con->deleteProduct($product_id)) {
        // Redirect to product list page with success message
        header('location: delete.php?message=Product deleted successfully.');
        exit();
    } else {
        // Redirect to product list page with error message
        header('location: delete.php?error=Failed to delete product.');
        exit();
    }
} else {
    // Redirect to product list page if product_id is not provided
    header('location: delete.php');
    exit();
}
?>
