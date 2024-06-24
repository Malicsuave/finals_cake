<?php
session_start();
require_once('classes/database.php');
$con = new Database();

if (isset($_GET['id'])) {
    $product_id = $_GET['id'];
    $product = $con->getProductDetails($product_id);

    if ($product) {
        // Product details retrieval successful, proceed with displaying details
        $productName = $product['productName'];
        $productDescription = $product['productTheme'];
        $productPrice = $product['productPrice'];
        // etc.
    } else {
        // Handle case where product details could not be retrieved
        echo "Product not found.";
    }
} else {
    // Handle case where no product ID is provided in the URL
    echo "Product ID not provided.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Details</title>
    <!-- Include your CSS files -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap-icons.css">
    <link rel="stylesheet" href="css/slick.css">
    <link rel="stylesheet" href="css/tooplate-little-fashion.css">
</head>
<body>
<?php include ('user-navbar.php'); ?>

<section class="product-detail section-padding">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-12">
                <div class="product-thumb">
                    <img src="<?php echo isset($product['productImage']) ? $product['productImage'] : 'default_image.jpg'; ?>" class="img-fluid product-image" alt="">
                </div>
            </div>

            <div class="col-lg-6 col-12">
                <div class="product-info d-flex">
                    <div>
                        <h2 class="product-title mb-0"><?php echo htmlspecialchars($product['productName']); ?></h2>
                        <p class="product-p"><?php echo htmlspecialchars($product['productTheme']); ?></p>
                    </div>
                    <small class="product-price text-muted ms-auto mt-auto mb-5">$<?php echo htmlspecialchars($product['productPrice']); ?></small>
                </div>

                <div class="product-description">
                    <strong class="d-block mt-4 mb-2">Description</strong>
                    <p class="lead mb-5"><?php echo htmlspecialchars($product['productTheme']); ?></p>
                </div>

                <div class="product-cart-thumb row">
                    <div class="col-lg-6 col-12">
                        <form method="post" action="cart.php">
                            <input type="hidden" name="product_id" value="<?php echo htmlspecialchars($product['id']); ?>">
                            <select class="form-select cart-form-select" id="inputGroupSelect01" name="quantity" required>
                                <option selected>Quantity</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                            </select>
                    </div>

                    <div class="col-lg-6 col-12 mt-4 mt-lg-0">
                        <button type="submit" class="btn custom-btn cart-btn">Add to Cart</button>
                    </div>
                        </form>
                </div>

                <p>
                    <a href="#" class="product-additional-link">Details</a>
                    <a href="#" class="product-additional-link">Delivery and Payment</a>
                </p>
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
