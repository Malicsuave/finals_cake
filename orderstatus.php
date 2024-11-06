<?php
session_start();
require_once('classes/database.php');
$con = new Database();

if (!isset($_SESSION['User_Id'])) {
    echo "You need to log in to view your order status.";
    exit;
}

$userId = $_SESSION['User_Id'];
echo $userId;
$orders = $con->getUserOrders($userId);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Status</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap-icons.css">
    <link rel="stylesheet" href="css/tooplate-little-fashion.css">
</head>
<body>
<?php include('user-navbar.php'); ?>

<section class="order-status section-padding">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-12">
                <h2 class="order-status-title mb-4">Your Order Status</h2>
                <?php if (!empty($orders)) { ?>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Order ID</th>
                                <th>Full Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Address</th>
                                <th>Order Date</th>
                                <th>Status</th>
                                
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($orders as $order) { ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($order['delivery_id']); ?></td>
                                    <td><?php echo htmlspecialchars($order['fullname']); ?></td>
                                    <td><?php echo htmlspecialchars($order['email']); ?></td>
                                    <td><?php echo htmlspecialchars($order['phone']); ?></td>
                                    <td><?php echo htmlspecialchars($order['address']); ?></td>
                                    <td><?php echo htmlspecialchars($order['checkout_date']); ?></td>
                                    <td><?php echo htmlspecialchars($order['status']); ?></td>
                                    <td>
                                        
                                            <form action="update.php" method="post" class="d-inline">
                                                <div class="dropdown">
                                                    
                                                    
                                                </div>
                                                <input type="hidden" name="orderId" value="<?php echo htmlspecialchars($order['delivery_id']); ?>">
                                            </form>
                                        <?php } ?>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                
                <a href="products.php" class="btn btn-primary mt-3">Continue Shopping</a>
            </div>
        </div>
    </div>
</section>

<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.bundle.min.js"></script>
<script src="js/custom.js"></script>
</body>
</html>
