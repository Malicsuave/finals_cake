<?php

$current_page = basename($_SERVER['PHP_SELF']);
require_once('classes/database.php');
$con = new Database();

// Fetch all products
// Assuming viewProducts method retrieves all products from your database

if (isset($_SESSION['User_Id'])) {
    $id = $_SESSION['User_Id'];
    $data = $con->viewdata($id);

    $profilePicture = $data['user_profile_picture'] ?? 'path/to/default/profile_picture.jpg';
    $username = $_SESSION['username'];
} else {
    $profilePicture = 'path/to/default/profile_picture.jpg';
    $username = 'Guest';
}




$products = $con->getProducts(); // Assuming this method retrieves all products from the database


?>




<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Tooplate's Little Fashion - Products</title>

    <!-- CSS FILES -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;300;400;700;900&display=swap" rel="stylesheet">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="css/slick.css"/>
    <link href="css/tooplate-little-fashion.css" rel="stylesheet">
</head>

<body>
<?php include ('user-navbar.php'); ?> 

<section class="preloader">
    <div class="spinner">
        <span class="sk-inner-circle"></span>
    </div>
</section>

<main>
    <header class="site-header section-padding d-flex justify-content-center align-items-center">
        <div class="container">
            <div class="row">
                <div class="col-lg-10 col-12">
                    <h1>
                        <span class="d-block text-primary">Choose your</span>
                        <span class="d-block text-dark">theme of cake</span>
                    </h1>
                </div>
            </div>
        </div>
    </header>

<<<<<<< HEAD
    
=======
    <section class="products section-padding">
        <div class="container">
            <div class="row">

            <?php foreach ($products as $product): ?>
                <div class="col-lg-4 col-12 mb-3">
                    <div class="product-thumb">
                        <a href="product-detail.php?id=<?php echo $product['id']; ?>">
                            <img src="<?php echo isset($product['productImage']) ? $product['productImage'] : 'default_image.jpg'; ?>" class="img-fluid product-image" alt="">
                        </a>

                        <div class="product-top d-flex">
                            <?php if (isset($product['is_new']) && $product['is_new']): ?>
                                <span class="product-alert me-auto">New Arrival</span>
                            <?php endif; ?>

                            <a href="#" class="bi-heart-fill product-icon"></a>
                        </div>

                        <div class="product-info d-flex">
                            <div>
                                <h5 class="product-title mb-0">
                                    <a href="product-detail.php?id=<?php echo $product['id']; ?>" class="product-title-link">
                                        <?php echo isset($product['productName']) ? $product['productName'] : 'Unnamed Product'; ?>
                                    </a>
                                </h5>

                                <p class="product-p">
                                    <?php echo isset($product['productTheme']) ? $product['productTheme'] : 'No description available.'; ?>
                                </p>
                            </div>

                            <small class="product-price text-muted ms-auto">
                                $<?php echo isset($product['productPrice']) ? $product['productPrice'] : 'N/A'; ?>
                            </small>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>

            </div>
        </div>
    </section>
</main>
>>>>>>> 64b2a1c4e498d5fef483c637b032767d329f529f

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
