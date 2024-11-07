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

// Check if the 'id' parameter is set in the query string
if (isset($_GET['product_id'])) {
    // Sanitize the product ID
    $product_id = intval($_GET['product_id']); // Use intval to ensure it's an integer

    // Perform deletion query if product ID is valid
    if ($con->deleteProduct($product_id)) {
        // Redirect to product list page with success message
        header('Location: delete.php?message=Product deleted successfully.');
        exit();
    } else {
        // Redirect to product list page with error message
        header('Location: delete.php?error=Failed to delete product.');
        exit();
    }
} else {
    // If no product_id is set, show an error
    header('Location: delete.php?error=No product ID specified.');
    exit();
}
?>
