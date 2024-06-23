<?php
session_start();
$current_page = basename($_SERVER['PHP_SELF']);
require_once('classes/database.php');
$con = new Database();

if (isset($_SESSION['User_Id'])) {
    $id = $_SESSION['User_Id'];
    $data = $con->viewdata($id);

    $profilePicture = $data['user_profile_picture'] ?? 'path/to/default/profile_picture.jpg';
    $username = $_SESSION['username'];
} else {
    $profilePicture = 'path/to/default/profile_picture.jpg';
    $username = 'Guest';
}



// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle file upload
    $uploadDir = 'uploads/';
    $uploadFile = $uploadDir . basename($_FILES['productImage']['name']);

    if (move_uploaded_file($_FILES['productImage']['tmp_name'], $uploadFile)) {
        // File upload successful, prepare data for insertion
        $productName = $_POST['productName'];
        $productPrice = $_POST['productPrice'];
        $productTheme = $_POST['productTheme'];
        $productStock = isset($_POST['productStock']) ? 1 : 0; // 1 if checked, 0 otherwise
        $productImage = $uploadFile;

        // Insert into database
        $con->insertProduct($productName, $productPrice, $productTheme, $productImage, $productStock);

        // Redirect to admin_products.php after insertion
        header('Location: cards.php');
        exit();
    } else {
        // File upload failed
        echo "File upload failed.";
    }
}
?>






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
    <!-- END Margas's Cake  CSS-->
    <!-- BEGIN Page Level CSS-->
    <link rel="stylesheet" type="text/css" href="theme-assets/css/core/menu/menu-types/vertical-menu.css">
    <link rel="stylesheet" type="text/css" href="theme-assets/css/core/colors/palette-gradient.css">
    <link rel="stylesheet" type="text/css" href="theme-assets/css/pages/dashboard-ecommerce.css">
    <!-- END Page Level CSS-->
    <!-- BEGIN Custom CSS-->
    <!-- END Custom CSS-->
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
            <a class="dropdown-item" href="#"><i class="ft-message-square"></i> Chats</a>
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
          <li class="nav-item"><a href="icons.php"><i class="ft-box"></i><span class="menu-title" data-i18n="">Messages</span></a>
          </li>
          <li class="active "><a href="cards.php"><i class="ft-layers"></i><span class="menu-title" data-i18n="">Cards</span></a>
          </li>
          <li class=" nav-item"><a href="buttons.php"><i class="ft-box"></i><span class="menu-title" data-i18n="">Buttons</span></a>
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




<!-- Form to add a new product -->
<div class="card mb-4">
	<h5 class="card-header">Add New Product</h5>
	<div class="card-body">
		<form action="cards.php" method="POST" enctype="multipart/form-data">
			<div class="form-group">
				<label for="productName">Product Name</label>
				<input type="text" class="form-control" id="productName" name="productName" required>
			</div>
			<div class="form-group">
				<label for="productPrice">Price</label>
				<input type="number" class="form-control" id="productPrice" name="productPrice" required>
			</div>
			<div class="form-group">
				<label for="productTheme">Theme</label>
				<input type="text" class="form-control" id="productTheme" name="productTheme">
			</div>
			<div class="form-group">
				<label for="productImage">Product Image</label>
				<input type="file" class="form-control-file" id="productImage" name="productImage" accept="image/*" required>
			</div>
			<div class="form-check">
				<input type="checkbox" class="form-check-input" id="productStock" name="productStock" value="1" checked>
				<label class="form-check-label" for="productStock">In Stock</label>
			</div>
			<button type="submit" class="btn btn-primary mt-3">Add Product</button>
		</form>
	</div>
</div>

<!-- Table to display existing products -->
<div class="card">
	<h5 class="card-header">Product List</h5>
	<div class="card-body">
		<table class="table table-bordered">
			<thead>
				<tr>
					<th>Product Id</th>
					<th>User</th>
					<th>Product Name</th>
					<th>Product Price</th>
					<th>Product Theme</th>
          <th>Product Theme</th>
				</tr>
			</thead>
			<tbody>
      <?php
    $counter= 1;
    $data = $con->view();
    foreach ($data as $rows){
    ?>
        <tr>
          <td><?php echo $counter++?></td>
          <td>
        <?php if (!empty($rows['user_profile_picture'])): ?>
          <img src="<?php echo htmlspecialchars($rows['user_profile_picture']); ?>" alt="Profile Picture" style="width: 50px; height: 50px; border-radius: 50%;">
        <?php else: ?>
          <img src="path/to/default/profile/pic.jpg" alt="Default Profile Picture" style="width: 50px; height: 50px; border-radius: 50%;">
        <?php endif; ?>
      </td>
          <td><?php echo $rows ['productName']; ?> </td>
          <td><?php echo $rows ['productPrice'];  ?></td>
          <td><?php echo $rows ['productTheme'];  ?></td>
          <td><?php echo $rows ['productImage'];       ?></td>
          <td><?php echo $rows ['productStock'];  ?></td>
    
          
          <td>
          <div class="btn-group" role="group">
          <form action="" method="post" class="d-inline">
                                    <input type="hidden" name="id" value="<?php echo $rows['User_Id']; ?>">
                                    <button type="submit" class="btn btn-warning ">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                    </button>
                                </form>
                                <form method="POST" class="d-inline">
                                    <input type="hidden" name="id" value="<?php echo $rows['User_Id']; ?>">
                                    <button type="submit" name="delete" class="btn btn-danger " onclick="return confirm('Are you sure you want to delete this user?')">
                                    <i class="fa-solid fa-user-minus"></i>
                                    </button>
                                </form>
        </div>
        </td>
        </tr>
    <?php
    }
    ?>
        
			</tbody>
		</table>
	</div>
</div>
</div>
<!-- eCommerce statistic -->
</div>
   </div>
    </div>
<!--/ Statistics -->
   
    <!-- ////////////////////////////////////////////////////////////////////////////-->


    <footer class="footer footer-static footer-light navbar-border navbar-shadow">
      <div class="clearfix blue-grey lighten-2 text-sm-center mb-0 px-2"><span class="float-md-left d-block d-md-inline-block">2018  &copy; Copyright <a class="text-bold-800 grey darken-2" href="https://themeselection.com" target="_blank">ThemeSelection</a></span>
        <ul class="list-inline float-md-right d-block d-md-inline-blockd-none d-lg-block mb-0">
          <li class="list-inline-item"><a class="my-1" href="https://themeselection.com/" target="_blank"> More themes</a></li>
          <li class="list-inline-item"><a class="my-1" href="https://themeselection.com/support" target="_blank"> Support</a></li>
          <li class="list-inline-item"><a class="my-1" href="https://themeselection.com/products/Margas's Cake-admin-modern-bootstrap-webapp-dashboard-html-template-ui-kit/" target="_blank"> Purchase</a></li>
        </ul>
      </div>
    </footer>

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