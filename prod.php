<?php
session_start();
$current_page = basename($_SERVER['PHP_SELF']);
require_once('classes/database.php');
$con = new Database();

// Ensure user is authenticated and has the correct account type
if (!isset($_SESSION['username']) || $_SESSION['account_type'] != 1) {
    header('location:sign-in.php');
    exit();
}

// Get user details or set to default if not logged in
if (isset($_SESSION['User_Id'])) {
    $id = $_SESSION['User_Id'];
    $data = $con->viewdata($id);
    $profilePicture = $data['user_profile_picture'] ?? 'path/to/default/profile_picture.jpg';
    $username = $_SESSION['username'];
} else {
    $profilePicture = 'path/to/default/profile_picture.jpg';
    $username = 'Guest';
}

// Show any messages from GET parameters
if (isset($_GET['message'])) {
    echo '<div class="alert alert-success">' . $_GET['message'] . '</div>';
} elseif (isset($_GET['error'])) {
    echo '<div class="alert alert-danger">' . $_GET['error'] . '</div>';
}

// Check if the form has been submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle file upload
    $uploadDir = 'uploads/';
    $uploadFile = $uploadDir . basename($_FILES['productImage']['name']);

    // Check if the file was uploaded successfully
    if (move_uploaded_file($_FILES['productImage']['tmp_name'], $uploadFile)) {
        // File upload successful, now prepare data for insertion
        $productName = $_POST['productName'];
        $productPrice = $_POST['productPrice'];
        $productTheme = $_POST['productTheme'];
        $productStock = isset($_POST['productStock']) ? 1 : 0; // 1 if checked, 0 otherwise
        $productImage = $uploadFile;

        // Insert the product into the database
        if ($con->insertProduct($productName, $productPrice, $productTheme, $productImage, $productStock)) {
            // Redirect to the products page after successful insertion
            header('Location: products.php');
            exit();
        } else {
            // If there was an error inserting the product, display an error message
            echo "Error inserting product into the database.";
        }
    } else {
        // If the file upload failed, display an error message
        echo "File upload failed.";
    }
}

// Get products for displaying them
$viewProducts = $con->viewProducts();

?>

<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description" content="Margas's Cake Admin is a modern Bootstrap 4 webapp &amp; admin dashboard html template with a large number of components, elegant design, clean and organized code.">
    <meta name="keywords" content="admin template, Margas's Cake admin template, dashboard template, gradient admin template, responsive admin template, webapp, eCommerce dashboard, analytic dashboard">
    <meta name="author" content="ThemeSelect">
    <title>Marga's Cake</title>
    <link rel="apple-touch-icon" href="theme-assets/images/ico/apple-icon-120.png">
    <link rel="shortcut icon" type="image/x-icon" href="theme-assets/images/ico/favicon.ico">
    <link href="https://fonts.googleapis.com/css?family=Muli:300,300i,400,400i,600,600i,700,700i%7CComfortaa:300,400,700" rel="stylesheet">
    <link href="https://maxcdn.icons8.com/fonts/line-awesome/1.1/css/line-awesome.min.css" rel="stylesheet">
    <!-- BEGIN VENDOR CSS-->
    <link rel="stylesheet" type="text/css" href="theme-assets/css/vendors.css">
    <link rel="stylesheet" type="text/css" href="theme-assets/vendors/css/charts/chartist.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <!-- END VENDOR CSS-->
    <!-- BEGIN Margas's Cake  CSS-->
    <link rel="stylesheet" type="text/css" href="theme-assets/css/app-lite.css">
    <!-- END Margas's Cake  CSS-->
    <!-- BEGIN Page Level CSS-->
    <link rel="stylesheet" type="text/css" href="theme-assets/css/core/menu/menu-types/vertical-menu.css">
    <link rel="stylesheet" type="text/css" href="theme-assets/css/core/colors/palette-gradient.css">
    <link rel="stylesheet" type="text/css" href="theme-assets/css/pages/dashboard-ecommerce.css">
    <!-- END Page Level CSS-->
</head>
<body class="vertical-layout vertical-menu 2-columns menu-expanded fixed-navbar" data-open="click" data-menu="vertical-menu" data-color="bg-chartbg" data-col="2-columns">

<!-- fixed-top-->
<nav class="header-navbar navbar-expand-md navbar navbar-with-menu navbar-without-dd-arrow fixed-top navbar-semi-light">
    <div class="navbar-wrapper">
        <div class="navbar-container content">
            <div class="collapse navbar-collapse show" id="navbar-mobile">
                <ul class="nav navbar-nav mr-auto float-left">
                    <li class="nav-item d-block d-md-none"><a class="nav-link nav-menu-main menu-toggle hidden-xs" href="#"><i class="ft-menu"></i></a></li>
                    <li class="nav-item d-none d-md-block"><a class="nav-link nav-link-expand" href="#"><i class="ficon ft-maximize"></i></a></li>
                    <li class="nav-item dropdown navbar-search"><a class="nav-link dropdown-toggle hide" data-toggle="dropdown" href="#"><i class="ficon ft-search"></i></a>
                        <ul class="dropdown-menu">
                            <li class="arrow_box">
                                <form>
                                    <div class="input-group search-box">
                                        <div class="position-relative has-icon-right full-width">
                                            <input class="form-control" id="search" type="text" placeholder="Search here...">
                                            <div class="form-control-position navbar-search-close"><i class="ft-x"></i></div>
                                        </div>
                                    </div>
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>

                <ul class="nav navbar-nav float-right">
                    <li class="dropdown dropdown-user nav-item">
                        <a class="dropdown-toggle nav-link dropdown-user-link" href="#" data-toggle="dropdown">
                            <span class="avatar avatar-online"><img src="<?php echo $data['user_profile_picture']; ?>" alt="avatar"></span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <div class="arrow_box_right">
                                <a class="dropdown-item" href="#">
                                    <span class="avatar avatar-online">
                                        <img src="<?php echo $data['user_profile_picture']; ?>" alt="avatar">
                                        <span class="user-name text-bold-700 ml-1"><?php echo $username; ?></span>
                                    </span>
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#"><i class="ft-user"></i> Edit Profile</a>
                                <a class="dropdown-item" href="inbox.php"><i class="ft-mail"></i> My Inbox</a>
                                <a class="dropdown-item" href="#"><i class="ft-check-square"></i> Task</a>
                                <a class="dropdown-item" href="chat.php"><i class="ft-message-square"></i> Chats</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="logout.php"><i class="ft-power"></i> Logout</a>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>

<!-- Main menu-->
<div class="main-menu menu-fixed menu-light menu-accordion menu-shadow" data-scroll-to-active="true" data-img="theme-assets/images/backgrounds/02.jpg">
    <div class="navbar-header">
        <ul class="nav navbar-nav flex-row">       
            <li class="nav-item mr-auto"><a class="navbar-brand" href="admin.php"><img class="brand-logo" alt="Margas's Cake admin logo" src="theme-assets/images/logo/logo.png"/>
                <h3 class="brand-text">Marga's Cake</h3></a></li>
            <li class="nav-item d-md-none"><a class="nav-link close-navbar"><i class="ft-x"></i></a></li>
        </ul>
    </div>
    <div class="main-menu-content">
        <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
        <li class="nav-item"><a href="admin.php"><i class="ft-home"></i><span class="menu-title" data-i18n="">Dashboard</span></a>
          </li>
          <li class=" nav-item"><a href="charts.php"><i class="ft-pie-chart"></i><span class="menu-title" data-i18n="">Charts</span></a>
          </li>
          <li class="nav-item"><a href="inbox.php"><i class="fa-solid fa-message"></i><span class="menu-title" data-i18n="">Messages</span></a>
          </li>
          <li class="nav-item "><a href="prod.php"><i class="fa-solid fa-plus"></i><span class="menu-title" data-i18n="">Add Product</span></a>
          </li>
          <li class="active"><a href="orders.php"><i class="fa-solid fa-bag-shopping"></i><span class="menu-title" data-i18n="">Orders</span></a>
          </li>
          <li class="nav-item"><a href="admin_orders.php"><i class="ft-credit-card"></i><span class="menu-title" data-i18n="">Delivery</span></a>
          </li>
          <li class="nav-item"><a href="delete.php"><i class="fa-solid fa-trash"></i><span class="menu-title" data-i18n="">Delete Product</span></a>
          </li>
        </ul>
      </div><a class="btn btn-danger btn-block btn-glow btn-upgrade-pro mx-1" href="index.php" target="_blank">Marga's Cake</a>
      <div class="navigation-background"></div>
      <div class="navigation-background"></div>
    </div>
</div>

<!-- Content -->
<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-body">
            <div class="row">
                <!-- Add Product Form -->
                <div class="col-md-12">
                    <h2>Add Product</h2>
                    <form method="POST" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="productName">Product Name</label>
                            <input type="text" class="form-control" name="productName" required>
                        </div>
                        <div class="form-group">
                            <label for="productPrice">Product Price</label>
                            <input type="number" step="0.01" class="form-control" name="productPrice" required>
                        </div>
                        <div class="form-group">
                            <label for="productTheme">Product Theme</label>
                            <input type="text" class="form-control" name="productTheme" required>
                        </div>
                        <div class="form-group">
                            <label for="productImage">Product Image</label>
                            <input type="file" class="form-control" name="productImage" required>
                        </div>
                        <div class="form-group">
                            <label for="productStock">In Stock</label>
                            <input type="checkbox" name="productStock">
                        </div>
                        <button type="submit" class="btn btn-primary">Add Product</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- END Content -->
</body>
</html>

