<?php
session_start();
require_once('classes/database.php');
$con = new Database();
echo $_SESSION['User_Id'];if (empty($_SESSION['username'])) {   
    header('location:sign-in.php');
  }
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_SESSION['User_Id'])) {
        $userId = $_SESSION['User_Id'];

        if (isset($_POST['product_id']) && isset($_POST['quantity'])) {
            $productId = $_POST['product_id'];
            $quantity = $_POST['quantity'];

            if ($con->addToCart($userId, $productId, $quantity)) {
                header("Location: cart.php");
                exit;
            } else {
                echo "Failed to add to cart.";
            }
        } elseif (isset($_POST['delete_product_id'])) {
            $productId = $_POST['delete_product_id'];

            if ($con->removeFromCart($userId, $productId)) {
                header("Location: cart.php");
                exit;
            } else {
                echo "Failed to remove from cart.";
            }
        } elseif (isset($_POST['checkout'])) {
            // Calculate the total price
            $cartItems = $con->getCartItems($userId);
            $totalPrice = 0;
            foreach ($cartItems as $item) {
                $totalPrice += $item['productPrice'] * $item['quantity'];
            }

            if ($totalPrice > 0) {
                $checkoutId = $con->checkout($userId, $totalPrice);
                if ($checkoutId) {
                    echo "Checkout successful. Your order ID is: " . $checkoutId;
                } else {
                    echo "Failed to checkout.";
                }
            } else {
                echo "Your cart is empty.";
            }
        }
    } else {
        echo "You need to log in to modify your cart.";
    }
}

if (isset($_SESSION['User_Id'])) {
    $userId = $_SESSION['User_Id'];
    $cartItems = $con->getCartItems($userId);

    $Grand_total = 0;
    foreach ($cartItems as $item) {
        $Grand_total += $item['productPrice'] * $item['quantity'];
    }
} else {
    $cartItems = [];
    $Grand_total = 0;
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart</title>
    <!-- Include your CSS files -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap-icons.css">
    <link rel="stylesheet" href="css/slick.css">
    <link rel="stylesheet" href="css/tooplate-little-fashion.css">
</head>
<body>
<?php include('user-navbar.php'); ?>

<section class="cart section-padding">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-12">
                <h2 class="cart-title mb-4">Your Cart</h2>
                <div class="cart-items">
                    <?php if (!empty($cartItems)) { ?>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Quantity</th>
                                    <th>Price</th>
                                    <th>Total</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($cartItems as $item) { ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($item['productName']); ?></td>
                                        <td><?php echo htmlspecialchars($item['quantity']); ?></td>
                                        <td>$<?php echo htmlspecialchars($item['productPrice']); ?></td>
                                        <td>$<?php echo htmlspecialchars($item['productPrice'] * $item['quantity']); ?></td>
                                        <td>
                                            <form method="post" action="cart.php">
                                                <input type="hidden" name="delete_product_id" value="<?php echo htmlspecialchars($item['id']); ?>">
                                                <button type="submit" class="btn btn-danger">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                        <div class="cart-total">
                            <h3>Grand Total: $<?php echo $Grand_total; ?></h3>
                        </div>
                        <form method="post" action="cart.php">
    <input type="hidden" name="checkout" value="1">
    <button type="submit" class="btn btn-success">Checkout</button>
</form>
<form method="post" action="products.php">
    <input type="hidden" name="back" value="1">
    <button type="danger" class="btn btn-danger">Continue Shopping</button>
</form>
                    <?php } else { ?>
                        <p>Your cart is empty.</p>
                        <form method="post" action="checkout.php">
    <input type="hidden" name="checkout" value="1">
    <button type="submit" class="btn btn-success">Delivery</button>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</section>


<footer class="site-footer">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-10 me-auto mb-4">
                <h4 class="text-white mb-3"><a href="index.php">Marga's</a> Cake</h4>
                <p class="copyright-text text-muted mt-lg-5 mb-4 mb-lg-0">Copyright © 2024 <strong>Marga's Cake</strong></p>
                <br>
                <p class="copyright-text">Designed by <a href="https://www.margascake.com/" target="_blank">Developer</a></p>
            </div>

            <div class="col-lg-5 col-8">
                <h5 class="text-white mb-3">Sitemap</h5>
                <ul class="footer-menu d-flex flex-wrap">
                    <li class="footer-menu-item"><a href="about.php" class="footer-menu-link">About</a></li>
                    <li class="footer-menu-item"><a href="products.php" class="footer-menu-link">Products</a></li>
                    <li class="footer-menu-item"><a href="" class="footer-menu-link">Privacy policy</a></li>
                    <li class="footer-menu-item"><a href="faq.php" class="footer-menu-link">FAQs</a></li>
                    <li class="footer-menu-item"><a href="contact.php" class="footer-menu-link">Contact</a></li>
                </ul>
            </div>

            <div class="col-lg-3 col-4">
                <h5 class="text-white mb-3">Social</h5>
                <ul class="social-icon">
                    <li><a href="https://www.youtube.com/watch?v=dQw4w9WgXcQ" target="_blank" class="social-icon-link bi-youtube"></a></li>
                    <li><a href="https://www.youtube.com/watch?v=dQw4w9WgXcQ" target="_blank" class="social-icon-link bi-whatsapp"></a></li>
                    <li><a href="https://www.youtube.com/watch?v=dQw4w9WgXcQ" target="_blank" class="social-icon-link bi-instagram"></a></li>
                    <li><a href="https://www.youtube.com/watch?v=dQw4w9WgXcQ" target="_blank" class="social-icon-link bi-skype"></a></li>
                </ul>
            </div>
        </div>
    </div>
</footer>
<!-- JAVASCRIPT FILES -->
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.bundle.min.js"></script>
<script src="js/Headroom.js"></script>
<script src="js/jQuery.headroom.js"></script>
<script src="js/slick.min.js"></script>
<script src="js/custom.js"></script>

</body>
</html>
