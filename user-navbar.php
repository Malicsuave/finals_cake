<?php
$current_page = basename($_SERVER['PHP_SELF']);
require_once('classes/database.php');
$con = new Database();

if (isset($_SESSION['User_Id'])) {
    $id = $_SESSION['User_Id'];
    $data = $con->viewdata($id);

    $profilePicture = $data['profile_picture'] ?? 'path/to/default/profile_picture.jpg';
    $username = $_SESSION['username'] ?? 'Guest';
    $account_type = $data['account_type'] ?? 1; // Fetch account type from database
} else {
    $profilePicture = 'path/to/default/profile_picture.jpg';
    $username = 'Guest';
    $account_type = 0; // Default to regular user account type for guests or unauthenticated users
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <meta name="description" content="">
        <meta name="author" content="">

        <title>Marga's Cake - Register Page</title>

        <!-- CSS FILES -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;300;400;700;900&display=swap" rel="stylesheet">
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link href="css/bootstrap-icons.css" rel="stylesheet">
        <link rel="stylesheet" href="css/slick.css"/>
        <link href="css/tooplate-little-fashion.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    </head>
</head>
<body>

<nav class="navbar navbar-expand-lg">
    <div class="container">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <a class="navbar-brand" href="index.php">
            <strong><span>Marga's</span> Cakes</strong>
        </a>

        <div class="d-lg-none">
            <a href="sign-in.php" class="bi-person custom-icon me-3"></a>
            <a href="product-detail.php" class="bi-bag custom-icon"></a>
        </div>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mx-auto">
                <li class="nav-item <?php echo ($current_page == 'index.php') ? 'active' : ''; ?>">
                    <a class="nav-link" href="index.php">Home</a>
                </li>
                <li class="nav-item <?php echo ($current_page == 'about.php') ? 'active' : ''; ?>">
                    <a class="nav-link" href="about.php">Story</a>
                </li>
                <li class="nav-item <?php echo ($current_page == 'products.php') ? 'active' : ''; ?>">
                    <a class="nav-link" href="products.php">Products</a>
                </li>
                <li class="nav-item <?php echo ($current_page == 'faq.php') ? 'active' : ''; ?>">
                    <a class="nav-link" href="faq.php">FAQs</a>
                </li>
                <li class="nav-item <?php echo ($current_page == 'contact.php') ? 'active' : ''; ?>">
                    <a class="nav-link" href="contact.php">Contact</a>
                    </li>
                    <?php if (isset($_SESSION['User_Id']) && $account_type == 1): ?>
                        <li class="nav-item <?php echo ($current_page == 'admin.php') ? 'active' : ''; ?>">
                            <a class="nav-link" href="admin.php">Admin</a>
                        </li>
                    <?php endif; ?>
            </ul>

            <div class="d-none d-lg-block">
                <?php if (isset($_SESSION['User_Id'])): ?>
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <img src="<?php echo $data['user_profile_picture']; ?>" width="30" height="30" class="rounded-circle mr-1" alt="Profile Picture"> <?php echo $username; ?>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownMenuLink">
                                <li><a class="dropdown-item" href=""><i class="fas fa-user-circle"></i> Upload Profile Picture</a></li>
                                <li><a class="dropdown-item" href="register.php"><i class="fas fa-user-edit"></i> Register</a></li>
                                <li><a class="dropdown-item" href="#"><i class="fas fa-key"></i> Change Password</a></li>
                                <li><a class="dropdown-item" href="cart.php"><i class="fa fa-cart-shopping"></i> Cart</a></li>
                                <li><a class="dropdown-item" href="products.php"><span> </span> <i class="fa-solid fa-cake-candles"></i>Product</a></li>
                                <li><a class="dropdown-item" href="logout.php" onclick="return confirm('Are you sure you want to leave?')"><i class="fa-solid fa-right-from-bracket"></i> Logout</a></li>
                            </ul>
                        </li>
                    </ul>
                <?php else: ?>
                    <a href="sign-in.php" class="bi-person custom-icon me-3"></a>
                    <a href="sign-in.php" class="bi-bag custom-icon"></a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</nav>

<!-- Include Bootstrap JS and dependencies -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.bundle.min.js"></script>
<script src="js/Headroom.js"></script>
<script src="js/jQuery.headroom.js"></script>
<script src="js/slick.min.js"></script>
<script src="js/custom.js"></script>
</body>
</html>
