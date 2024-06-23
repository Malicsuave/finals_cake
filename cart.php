<?php
session_start();
require_once('classes/database.php'); // Assuming this includes your Database class

// Create an instance of Database class
$con = new Database();

// Redirect to login page if user is not logged in
if (!isset($_SESSION['User_Id'])) {
    header('Location: login.php');
    exit();
}

$id = $_SESSION['User_Id'];

// Handle POST requests
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Add to cart
    if (isset($_POST['add_to_cart'])) {
        $product_id = intval($_POST['product_id']);
        $quantity = intval($_POST['quantity']);
        $con->addToCart($id, $product_id, $quantity);
    }

    // Update quantity
    if (isset($_POST['update_update_btn'])) {
        $update_quantity_id = intval($_POST['update_quantity_id']);
        $update_quantity = intval($_POST['update_quantity']);
        $con->updateCartItemQuantity($update_quantity_id, $update_quantity, $id);
    }

    // Delete item from cart
    if (isset($_POST['delete_item'])) {
        $delete_id = intval($_POST['delete_id']);
        $con->deleteCartItem($delete_id, $id);
    }

    // Delete all items from cart
    if (isset($_POST['delete_all'])) {
        $con->deleteAllCartItems($id);
    }
}

// Retrieve cart items
$cartItems = $con->getCartItems($id); // Assuming getCartItems retrieves cart items

// Calculate grand total
$grand_total = 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Shopping Cart</title>

   <!-- Bootstrap CSS -->
   <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
   <!-- Font Awesome CSS -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
   <!-- Custom CSS -->
   <link rel="stylesheet" href="css/style.css">
</head>
<body>
<?php include ('user-navbar.php'); ?>

<div class="container">

<section class="shopping-cart">

   <h1 class="heading">Shopping Cart</h1>

   <table class="table">
      <thead>
         <tr>
            <th>Image</th>
            <th>Name</th>
            <th>Price</th>
            <th>Quantity</th>
            <th>Total Price</th>
            <th>Action</th>
         </tr>
      </thead>

      <tbody>
         <?php
         if (!empty($cartItems)) {
             foreach ($cartItems as $item) {
                 $total_price = $item['price'] * $item['quantity'];
                 $grand_total += $total_price;
         ?>
         <tr>
            <td><img src="uploaded_img/<?php echo htmlspecialchars($item['image']); ?>" height="100" alt=""></td>
            <td><?php echo htmlspecialchars($item['product_name']); ?></td>
            <td>$<?php echo htmlspecialchars($item['price']); ?>/-</td>
            <td>
               <form action="" method="post">
                  <input type="hidden" name="update_quantity_id" value="<?php echo htmlspecialchars($item['Carts_Id']); ?>">
                  <input type="number" name="update_quantity" min="1" value="<?php echo htmlspecialchars($item['quantity']); ?>">
                  <input type="submit" value="Update" name="update_update_btn">
               </form>
            </td>
            <td>$<?php echo htmlspecialchars($total_price); ?>/-</td>
            <td>
               <form action="" method="post">
                  <input type="hidden" name="delete_id" value="<?php echo htmlspecialchars($item['Carts_Id']); ?>">
                  <input type="submit" value="Remove" name="delete_item" onclick="return confirm('Remove item from cart?')">
               </form>
            </td>
         </tr>
         <?php
             }
         } else {
             echo '<tr><td colspan="6" class="text-center">No items in cart</td></tr>';
         }
         ?>
         <tr class="table-bottom">
            <td><a href="products.php" class="option-btn" style="margin-top: 0;">Continue Shopping</a></td>
            <td colspan="3">Grand Total</td>
            <td>$<?php echo htmlspecialchars($grand_total); ?>/-</td>
            <td>
               <form action="" method="post">
                  <input type="submit" value="Delete All" name="delete_all" onclick="return confirm('Are you sure you want to delete all?');" class="delete-btn">
               </form>
            </td>
         </tr>
      </tbody>
   </table>

   <div class="checkout-btn">
      <a href="checkout.php" class="btn custom-btn cart-btn ms-lg-4">Checkout</a>
   </div>

</section>

</div>

<footer class="site-footer">
    <!-- Footer content -->
</footer>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<!-- Bootstrap JS -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
<!-- Custom JS -->
<script src="js/Headroom.js"></script>
<script src="js/jQuery.headroom.js"></script>
<script src="js/slick.min.js"></script>
<script src="js/custom.js"></script>

</body>
</html>
