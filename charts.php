<?php
session_start();
$current_page = basename($_SERVER['PHP_SELF']);
require_once('classes/database.php');
$con = new Database();

$recentUser = $con->getRecentUsername();
$productWithHighestSales = $con->getProductWithHighestSales();
$totalProfit = $con->getTotalProfit();
$userWithMostProductsBought = $con->getUsernameWithMostProductsBought();
$OrdersStatusSummary =$con-> getOrdersStatusSummary();
$totalUsers = $con->getTotalUsers();
// Check if user is logged in and is an admin (account_type == 1)
if (!isset($_SESSION['username']) || $_SESSION['account_type'] != 1) {
    header('location: sign-in.php');
    exit();
}

// If logged in as admin, proceed with admin-specific tasks
if (isset($_SESSION['User_Id'])) {
    $id = $_SESSION['User_Id'];
    $data = $con->viewdata($id); // Assuming this retrieves user data, adjust if needed

    // Example: Get user profile picture
    $profilePicture = $data['user_profile_picture'] ?? 'path/to/default/profile_picture.jpg';
    $username = $_SESSION['username'];

    // Example: Get all messages (adjust as needed for admin functionality)
    $messages = $con->getAllMessages();
}


$messages = $con->getAllMessages();



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
    <!-- END VENDOR CSS-->
    <!-- BEGIN Margas's Cake  CSS-->
    <link rel="stylesheet" type="text/css" href="theme-assets/css/app-lite.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    

    <!-- END Margas's Cake  CSS-->
    <!-- BEGIN Page Level CSS-->
    <link rel="stylesheet" type="text/css" href="theme-assets/css/core/menu/menu-types/vertical-menu.css">
    <link rel="stylesheet" type="text/css" href="theme-assets/css/core/colors/palette-gradient.css">
    <link rel="stylesheet" type="text/css" href="theme-assets/css/pages/dashboard-ecommerce.css">
    <!-- END Page Level CSS-->
    <!-- BEGIN Custom CSS-->
    <!-- END Custom CSS-->
     <style>
        .white-text {
    color: white;

}
.blurred-container {
    background-color: rgba(255, 255, 255, 0.2); /* Adjust opacity as needed */
    backdrop-filter: blur(10px); /* Adjust blur intensity as needed */
}

     </style>
  </head>
  <body class="vertical-layout vertical-menu 2-columns   menu-expanded fixed-navbar" data-open="click" data-menu="vertical-menu" data-color="bg-chartbg" data-col="2-columns">

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
          <li class=" active"><a href="charts.php"><i class="ft-pie-chart"></i><span class="menu-title" data-i18n="">Charts</span></a>
          </li>
          <li class="nav-item"><a href="inbox.php"><i class="fa-solid fa-message"></i><span class="menu-title" data-i18n="">Messages</span></a>
          </li>
          <li class="nav-item "><a href="prod.php"><i class="fa-solid fa-plus"></i><span class="menu-title" data-i18n="">Add Product</span></a>
          </li>
          <li class=" nav-item"><a href="orders.php"><i class="fa-solid fa-bag-shopping"></i><span class="menu-title" data-i18n="">Orders</span></a>
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

    <div class="app-content content">
      <div class="content-wrapper">
        <div class="content-wrapper-before"></div>
        <div class="content-header row">
        </div>
        <div class="content-body"><!-- Chart -->

        <div class="container mt-5 blurred-container">
    <div class="row">
        <div class="col">
            <h2 class="mb-4" style="color: white;">Admin Dashboard</h2>
            <div class="row">
            <div class="col-md-3">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Total Users</h5>
                                <?php
                                
                                echo '<p class="card-text">' . htmlspecialchars($totalUsers['total_users']) . '</p>';
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Orders Status Summary</h5>
                                <ul class="list-group list-group-flush">
                                    <?php
                                    
                                    foreach ($OrdersStatusSummary as $status) {
                                        echo '<li class="list-group-item">' . htmlspecialchars($status['status']) . ': ' . htmlspecialchars($status['total_orders']) . '</li>';
                                    }
                                    ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Recent User</h5>
                            <p class="card-text"><?php echo htmlspecialchars($recentUser['username']); ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Product with Highest Sales</h5>
                            <p class="card-text"><?php echo htmlspecialchars($productWithHighestSales['productName']); ?> (<?php echo htmlspecialchars($productWithHighestSales['total_sales']); ?> sales)</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Total Profit</h5>
                            <p class="card-text">$<?php echo number_format($totalProfit['total_profit'], 2); ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Top Buyer</h5>
                            <p class="card-text"><?php echo htmlspecialchars($userWithMostProductsBought['username']); ?> (<?php echo htmlspecialchars($userWithMostProductsBought['total_quantity']); ?> products)</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>




    


    <!-- BEGIN VENDOR JS-->
    <script src="theme-assets/vendors/js/vendors.min.js" type="text/javascript"></script>
    <!-- BEGIN VENDOR JS-->
    <!-- BEGIN PAGE VENDOR JS-->
    <script src="theme-assets/vendors/js/charts/chartist.min.js" type="text/javascript"></script>
    <!-- END PAGE VENDOR JS-->
    <!-- BEGIN Margas's Cake  JS-->
    <script src="theme-assets/js/core/app-menu-lite.js" type="text/javascript"></script>
    <script src="theme-assets/js/core/app-lite.js" type="text/javascript"></script>
    <!-- END Margas's Cake  JS-->
    <!-- BEGIN PAGE LEVEL JS-->
    <script src="theme-assets/js/scripts/pages/dashboard-lite.js" type="text/javascript"></script>
    <!-- END PAGE LEVEL JS-->
  </body>
</html>