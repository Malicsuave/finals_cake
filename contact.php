<?php
session_start();
require_once('classes/database.php');

// Instantiate Database class
$con = new Database();

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_message'])) {
    // Sanitize and validate input
    $name = htmlspecialchars(trim($_POST['full_name']));
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    $subject = htmlspecialchars(trim($_POST['subject']));
    $message = htmlspecialchars(trim($_POST['message']));

    // Insert data into database using Database class method
    if ($con->insertMessage($name, $email, $subject, $message)) {
        // Redirect to a thank you page or display a success message
        header("Location: contact.php?success=1");
        exit();
    } else {
        // Handle database insertion error
        $error_message = "Error: Failed to insert message into database.";
    }
}
?>




<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <meta name="description" content="">
        <meta name="author" content="">

        <title>Marga's Cake - Contact Page</title>

        <!-- CSS FILES -->
        <link rel="preconnect" href="https://fonts.googleapis.com">

        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;300;400;700;900&display=swap" rel="stylesheet">

        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link href="css/bootstrap-icons.css" rel="stylesheet">

        <link rel="stylesheet" href="css/slick.css"/>

        <link href="css/tooplate-little-fashion.css" rel="stylesheet">
        
<!--

Tooplate 2127 Little Fashion

https://www.tooplate.com/view/2127-little-fashion

-->
    </head>
    
    <body>
    <?php include ('user-navbar.php'); ?> 
        <section class="preloader">
            <div class="spinner">
                <span class="sk-inner-circle"></span>
            </div>
        </section>
    
        <main>
            <header class="site-header section-padding-img site-header-image">
                <div class="container">
                    <div class="row">

                        <div class="col-lg-10 col-12 header-info">
                            <h1>
                                <span class="d-block text-primary">Say hello to us</span>
                                <span class="d-block text-dark">love to hear you</span>
                            </h1>
                        </div>
                    </div>
                </div>

                <img src="images/header/positive-european-woman-has-break-after-work.jpg" class="header-image img-fluid" alt="">
            </header>

            <section class="contact section-padding">
                <div class="container">
                    <div class="row">
                        
                        <div class="col-lg-6 col-12">
                            <h2 class="mb-4">Let's <span>begin</span></h2>

                            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" class="contact-form me-lg-5 pe-lg-3">
    <div class="form-floating">
        <input type="text" name="full_name" id="name" class="form-control" placeholder="Full name" required>
        <label for="name">Full name</label>
    </div>

    <div class="form-floating my-4">
        <input type="email" name="email" id="email" class="form-control" placeholder="Email address" required>
        <label for="email">Email address</label>
    </div>
    
    <div class="form-floating my-4">
        <input type="text" name="subject" id="subject" class="form-control" placeholder="Subject" required>
        <label for="subject">Subject</label>
    </div>

    <div class="form-floating mb-4">
        <textarea id="message" name="message" class="form-control" placeholder="Leave a comment here" required style="height: 160px"></textarea>
        <label for="message">Tell us about your concern</label>
    </div>

    <button type="submit" name="submit_message" class="form-control">Send</button>
</form>
                        </div>

                        <div class="col-lg-6 col-12 mt-5 ms-auto">
                            <div class="row">
                                <div class="col-6 border-end contact-info">
                                    <h6 class="mb-3">New Business</h6>

                                    <a href="mailto:hello@company.com" class="custom-link">
                                        marga@cake.com
                                        <i class="bi-arrow-right ms-2"></i>
                                    </a>
                                </div>

                                <div class="col-6 contact-info">
                                	<h6 class="mb-3">Main Studio</h6>

                                    <a href="mailto:studio@company.com" class="custom-link">
                                        marga@cake.com
                                        <i class="bi-arrow-right ms-2"></i>
                                    </a>
                                </div>

                                <div class="col-6 border-top border-end contact-info">
                                    <h6 class="mb-3">Our Office</h6>

                                    <p class="text-muted">NU Lipa</p>
                                </div>

                                <div class="col-6 border-top contact-info">
                                    <h6 class="mb-3">Our Socials</h6>

                                    <ul class="social-icon">

                                        <li><a href="#" class="social-icon-link bi-messenger"></a></li>

                                        <li><a href="#" class="social-icon-link bi-youtube"></a></li>

                                        <li><a href="#" class="social-icon-link bi-instagram"></a></li>

                                        <li><a href="#" class="social-icon-link bi-whatsapp"></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>

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


        <!-- JAVASCRIPT FILES -->
        <script src="js/jquery.min.js"></script>
        <script src="js/bootstrap.bundle.min.js"></script>
        <script src="js/Headroom.js"></script>
        <script src="js/jQuery.headroom.js"></script>
        <script src="js/slick.min.js"></script>
        <script src="js/custom.js"></script>
    </body>
</html>