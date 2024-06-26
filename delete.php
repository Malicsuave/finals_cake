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

// Fetch all products
$products = $con->viewProducts();

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
}
// Assuming this method retrieves all products from the database
?>

<!doctype html>
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description" content="Marga's Cake Admin is a modern Bootstrap 4 webapp & admin dashboard html template with a large number of components, elegant design, clean and organized code.">
    <meta name="keywords" content="admin template, Marga's Cake admin template, dashboard template, gradient admin template, responsive admin template, webapp, eCommerce dashboard, analytic dashboard">
    <meta name="author" content="ThemeSelect">
    <title>Marga's Cake - Delete</title>
    <link rel="apple-touch-icon" href="theme-assets/images/ico/apple-icon-120.png">
    <link rel="shortcut icon" type="image/x-icon" href="theme-assets/images/ico/favicon.ico">
    <link href="https://fonts.googleapis.com/css?family=Muli:300,300i,400,400i,600,600i,700,700i%7CComfortaa:300,400,700" rel="stylesheet">
    <link href="https://maxcdn.icons8.com/fonts/line-awesome/1.1/css/line-awesome.min.css" rel="stylesheet">
    <!-- BEGIN VENDOR CSS-->
    <link rel="stylesheet" type="text/css" href="theme-assets/css/vendors.css">
    <link rel="stylesheet" type="text/css" href="theme-assets/vendors/css/charts/chartist.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- END VENDOR CSS-->
    <!-- BEGIN Marga's Cake  CSS-->
    <link rel="stylesheet" type="text/css" href="theme-assets/css/app-lite.css">
    <!-- END Marga's Cake  CSS-->
    <!-- BEGIN Page Level CSS-->
    <link rel="stylesheet" type="text/css" href="theme-assets/css/core/menu/menu-types/vertical-menu.css">
    <link rel="stylesheet" type="text/css" href="theme-assets/css/core/colors/palette-gradient.css">
    <link rel="stylesheet" type="text/css" href="theme-assets/css/pages/dashboard-ecommerce.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- END Page Level CSS-->
    <!-- BEGIN Custom CSS-->
    <style>
        .footer {
            position: fixed;
            bottom: 0;
            width: 83%;
            background-color: #f8f9fa; /* Adjust as per your design */
            padding: 10px 20px; /* Adjust padding as needed */
        }
    </style>
</head>

<body class="vertical-layout vertical-menu 2-columns menu-expanded fixed-navbar" data-open="click" data-menu="vertical-menu" data-color="bg-chartbg" data-col="2-columns"></body>
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
                          <div class="form-control-position navbar-search-close"><i class="ft-x">   </i></div>
                        </div>
                      </div>
                    </form>
                  </li>
                </ul>
              </li>
            </ul>
           
            <ul class="nav navbar-nav float-right">
              <li class="dropdown dropdown-notification nav-item"><a class="nav-link nav-link-label" href="#" data-toggle="dropdown"><i class="ficon ft-mail">             </i></a>
                <div class="dropdown-menu dropdown-menu-right">
                  <div class="arrow_box_right"><a class="dropdown-item" href="#"><i class="ft-book"></i> Read Mail</a><a class="dropdown-item" href="#"><i class="ft-bookmark"></i> Read Later</a><a class="dropdown-item" href="#"><i class="ft-check-square"></i> Mark all Read       </a></div>
                </div>
              </li>
              <li class="dropdown dropdown-user nav-item">
    <a class="dropdown-toggle nav-link dropdown-user-link" href="#" data-toggle="dropdown">
        <span class="avatar avatar-online"><img src="<?php echo $data['user_profile_picture'];; ?>" alt="avatar"></span>
    </a>
    <div class="dropdown-menu dropdown-menu-right">
        <div class="arrow_box_right">
            <a class="dropdown-item" href="#">
                <span class="avatar avatar-online">
                    <img src="<?php echo $data['user_profile_picture']; ?>" alt="avatar">
                    <span class="user-name text-bold-700 ml-1"><?php echo $username; ?></span>
                    <span></span>
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

    <!-- ////////////////////////////////////////////////////////////////////////////-->


    <div class="main-menu menu-fixed menu-light menu-accordion    menu-shadow " data-scroll-to-active="true" data-img="theme-assets/images/backgrounds/02.jpg">
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
          <li class=" nav-item"><a href="orders.php"><i class="fa-solid fa-bag-shopping"></i><span class="menu-title" data-i18n="">Orders</span></a>
          </li>
          <li class="nav-item"><a href="admin_orders.php"><i class="ft-credit-card"></i><span class="menu-title" data-i18n="">Delivery</span></a>
          </li>
          <li class="active"><a href="delete.php"><i class="fa-solid fa-trash"></i><span class="menu-title" data-i18n="">Delete Product</span></a>
          </li>
        </ul>
      </div><a class="btn btn-danger btn-block btn-glow btn-upgrade-pro mx-1" href="index.php" target="_blank">Marga's Cake</a>
      <div class="navigation-background"></div>
      <div class="navigation-background"></div>
    </div>

    <div class="app-content content">
        <div class="content-wrapper">
           
            <div class="content-body">
                <main>
                    <div class="container mt-5">
                        <div class="row">
                            <div class="col">
                                <h2 class="mb-4">Manage Products</h2>
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Product Name</th>
                                                <th scope="col">Theme</th>
                                                <th scope="col">Price</th>
                                                <th scope="col">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($products as $index => $product): ?>
                                                <tr>
                                                    <th scope="row"><?php echo $index + 1; ?></th>
                                                    <td><?php echo isset($product['productName']) ? $product['productName'] : 'Unnamed Product'; ?></td>
                                                    <td><?php echo isset($product['productTheme']) ? $product['productTheme'] : 'No description available.'; ?></td>
                                                    <td>$<?php echo isset($product['productPrice']) ? $product['productPrice'] : 'N/A'; ?></td>
                                                    <td>
                                                        <a href="deleteprod.php?product_id=<?php echo $product['id']; ?>" class="btn btn-danger btn-sm">Delete</a>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </div>
    </div>
<main>
    
<!-- JAVASCRIPT FILES -->
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.bundle.min.js"></script>
<script src="js/Headroom.js"></script>
<script src="js/jQuery.headroom.js"></script>
<script src="js/slick.min.js"></script>
<script src="js/custom.js"></script>

</body>
</html>
