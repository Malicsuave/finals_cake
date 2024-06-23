<?php
require_once 'classes/database.php';

$db = new database();

// Fetch all products
$products = $db->getProducts();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products</title>
    <style>
        .product {
            border: 1px solid #ddd;
            padding: 16px;
            margin: 16px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .product img {
            max-width: 100%;
            height: auto;
        }
    </style>
</head>
<body>
    <h1>Products</h1>
    <?php if ($products): ?>
        <?php foreach ($products as $product): ?>
            <div class="product">
                <h2><?php echo htmlspecialchars($product['productName']); ?></h2>
                <p>Price: $<?php echo htmlspecialchars($product['productPrice']); ?></p>
                <p>Theme: <?php echo htmlspecialchars($product['productTheme']); ?></p>
                <p>Stock: <?php echo htmlspecialchars($product['productStock']); ?></p>
                <?php if ($product['productImage']): ?>
                    <img src="<?php echo htmlspecialchars($product['productImage']); ?>" alt="<?php echo htmlspecialchars($product['productName']); ?>">
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>No products found.</p>
    <?php endif; ?>
</body>
</html>