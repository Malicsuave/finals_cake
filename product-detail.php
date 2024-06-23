<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <meta name="description" content="">
        <meta name="author" content="">

        <title>Tooplate's Little Fashion - Product Detail</title>

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
                            <span class="d-block text-primary">We provide you</span>
                            <span class="d-block text-dark">Fashionable Stuffs</span>
                        </h1>
                    </div>
                </div>
            </div>
        </header>

        <section class="product-detail section-padding">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 col-12">
                        <div class="product-thumb">
                            <img src="photos/1.png" class="img-fluid product-image" alt="">
                        </div>
                    </div>

                    <div class="col-lg-6 col-12">
                        <div class="product-info d-flex">
                            <div>
                                <h2 class="product-title mb-0">Tree pot</h2>
                                <p class="product-p">Original package design from house</p>
                            </div>
                            <small class="product-price text-muted ms-auto mt-auto mb-5">$25</small>
                        </div>

                        <div class="product-description">
                            <strong class="d-block mt-4 mb-2">Description</strong>
                            <p class="lead mb-5">Over three years in business, We’ve had the chance to work on a variety of projects, with companies</p>
                        </div>

                        <div class="product-cart-thumb row">
                            <div class="col-lg-6 col-12">
                                <form method="post" action="products.php">
                                    <input type="hidden" name="product_id" value="1"> <!-- Replace 1 with dynamic product ID -->
                                    <select class="form-select cart-form-select" id="inputGroupSelect01" name="quantity">
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

        <section class="related-product section-padding border-top">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <h3 class="mb-5">You might also like</h3>
                    </div>
                    <!-- Related products code -->
                </div>
            </div>
        </section>
    </main>

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

    <!-- CART MODAL -->
    <div class="modal fade" id="cart-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content border-0">
                <div class="modal-header flex-column">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-6 col-12 mt-4 mt-lg-0">
                            <img src="photos/1.png" class="img-fluid product-image" alt="">
                        </div>
                        <div class="col-lg-6 col-12 mt-3 mt-lg-0">
                            <h3 class="modal-title" id="exampleModalLabel">$ Tier Cake</h3>
                            <p class="product-price text-muted mt-3">4,500</p>
                            <p class="product-p">Quantity: <span class="ms-1">1</span></p>
                            <div class="border-top mt-4 pt-3">
                                <p class="product-p"><strong>Total: <span class="ms-1">4,500</span></strong></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="row w-50">
                        <a type="button" class="btn custom-btn cart-btn ms-lg-4" href="cart.php">Add To Cart</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JAVASCRIPT FILES -->
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/Headroom.js"></script>
    <script src="js/jQuery.headroom.js"></script>
    <script src="js/slick.min.js"></script>
    <script src="js/custom.js"></script>

    </body>
</html>

<?php
// Add this PHP block at the top of the file or a separate included file

session_start();
include('db_connection.php'); // Include your database connection file

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id']; // Assuming you have stored the user_id in session
    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'];

    // Check if product is already in the cart
    $query = "SELECT * FROM carts WHERE user_id = ? AND product_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('ii', $user_id, $product_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Update the quantity if product already exists
        $query = "UPDATE carts SET quantity = quantity + ? WHERE user_id = ? AND product_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('iii', $quantity, $user_id, $product_id);
    } else {
        // Insert a new record if product does not exist
        $query = "INSERT INTO carts (user_id, product_id, quantity) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('iii', $user_id, $product_id, $quantity);
    }

    if ($stmt->execute()) {
        echo "<script>alert('Product added to cart successfully');</script>";
    } else {
        echo "<script>alert('Failed to add product to cart');</script>";
    }
}
?>
