<?php

class database {
    private $conn;

    // Constructor to initialize database connection
    function __construct() {
        $this->opencon();
    }

    // Open connection and assign to $this->conn
    private function opencon() {
        $this->conn = new PDO('mysql:host=localhost;dbname=cakes', 'root', '');
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    function check($username, $password) {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }
        return false;
    }

    function signup($username, $password, $firstname, $lastname, $birthday, $sex) {
        $query = $this->conn->prepare("SELECT username FROM users WHERE username = ?");
        $query->execute([$username]);
        $existingUser = $query->fetch();
        if ($existingUser) {
            return false;
        }
        return $this->conn->prepare("INSERT INTO users(username, password, firstname, lastname, birthday, sex)
            VALUES (?, ?, ?, ?, ?, ?)")
            ->execute([$username, $password, $firstname, $lastname, $birthday, $sex]);
    }

    function signupUser($firstname, $lastname, $birthday, $sex, $email, $username, $password, $profilePicture) {
        $this->conn->prepare("INSERT INTO users (firstname, lastname, birthday, sex, user_email, username, password, user_profile_picture) VALUES (?,?,?,?,?,?,?,?)")
            ->execute([$firstname, $lastname, $birthday, $sex, $email, $username, $password, $profilePicture]);
        return $this->conn->lastInsertId();
    }

    function insertAddress($User_Id, $street, $barangay, $city, $province) {
        return $this->conn->prepare("INSERT INTO user_address (User_Id, street, barangay, city, province) VALUES (?,?,?,?,?)")
            ->execute([$User_Id, $street, $barangay, $city, $province]);
    }

    function view() {
        return $this->conn->query("SELECT
            users.User_Id,
            users.firstname,
            users.lastname,
            users.birthday,
            users.sex,
            users.username, 
            users.password,
            users.user_profile_picture, 
            CONCAT(
                user_address.street,' ',user_address.barangay,' ',user_address.city,' ',user_address.province
            ) AS address
        FROM
            users
        JOIN user_address ON users.User_Id = user_address.User_Id")->fetchAll(PDO::FETCH_ASSOC);
    }

    function adminView() {
        $query = "SELECT
                    products.productName,
                    products.productPrice,
                    products.productTheme,
                    products.productImage,
                    products.productStock,
                    products.created_at,
                    CONCAT(user_address.street, ' ', user_address.barangay, ' ', user_address.city, ' ', user_address.province) AS address,
                    users.user_profile_picture
                  FROM
                    products
                  JOIN user_address ON products.User_Id = user_address.User_Id
                  JOIN users ON products.User_Id = users.User_Id";
        $stmt = $this->conn->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    function delete($id) {
        try {
            $this->conn->beginTransaction();
            $query = $this->conn->prepare("DELETE FROM user_address WHERE User_Id = ?");
            $query->execute([$id]);
            $query2 = $this->conn->prepare("DELETE FROM users WHERE User_Id = ?");
            $query2->execute([$id]);
            $this->conn->commit();
            return true; // Deletion successful
        } catch (PDOException $e) {
            $this->conn->rollBack();
            return false;
        }
    }

    function viewdata($id) {
        try {
            $query = $this->conn->prepare("SELECT
                users.User_Id,
                users.firstname,
                users.lastname,
                users.birthday,
                users.sex,
                users.username, 
                users.password,
                users.user_profile_picture,
                user_address.street,user_address.barangay,user_address.city,user_address.province
            FROM
                users
            JOIN user_address ON users.User_Id = user_address.User_Id
            WHERE users.User_Id = ?");
            $query->execute([$id]);
            return $query->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }

    

    function updateUser($User_Id, $username, $password, $firstname, $lastname, $birthday, $sex) {
        try { 
            $this->conn->beginTransaction();
            $query = $this->conn->prepare("UPDATE users SET username=?, password=?, firstname=?, lastname=?, birthday=?, sex=? WHERE User_Id=?");
            $query->execute([$username, $password, $firstname, $lastname, $birthday, $sex, $User_Id]);
            $this->conn->commit();
            return true;
        } catch (PDOException $e) {
            $this->conn->rollBack();
            return false;
        }
    }

    function updateUserAddress($User_Id, $street, $barangay, $city, $province) {
        try { 
            $this->conn->beginTransaction();
            $query = $this->conn->prepare("UPDATE user_address SET street=?, barangay=?, city=?, province=? WHERE User_Id=?");
            $query->execute([$street, $barangay, $city, $province, $User_Id]);
            $this->conn->commit();
            return true;
        } catch (PDOException $e) {
            $this->conn->rollBack();
            return false;
        }
    }

    function validateCurrentPassword($User_Id, $currentPassword) {
        $query = $this->conn->prepare("SELECT password FROM users WHERE User_Id = ?");
        $query->execute([$User_Id]);
        $user = $query->fetch(PDO::FETCH_ASSOC);
        if ($user && password_verify($currentPassword, $user['password'])) {
            return true;
        }
        return false;
    }

    function updatePassword($userId, $hashedPassword) {
        try {
            $this->conn->beginTransaction();
            $query = $this->conn->prepare("UPDATE users SET password = ? WHERE User_Id = ?");
            $query->execute([$hashedPassword, $userId]);
            $this->conn->commit();
            return true;
        } catch (PDOException $e) {
            $this->conn->rollBack();
            return false;
        }
    }

    function updateUserProfilePicture($userID, $profilePicturePath) {
        try {
            $this->conn->beginTransaction();
            $query = $this->conn->prepare("UPDATE users SET user_profile_picture = ? WHERE User_Id = ?");
            $query->execute([$profilePicturePath, $userID]);
            $this->conn->commit();
            return true;
        } catch (PDOException $e) {
            $this->conn->rollBack();
            return false;
        }
    }

    // Cart-related methods

    public function getCartItems($userId) {
        $query = $this->conn->prepare("SELECT carts.*, products.productName, products.productPrice FROM carts JOIN products ON carts.id = products.id WHERE carts.User_Id = ?");
        $query->execute([$userId]);
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
    

    function updateCartItemQuantity($cart_id, $quantity, $user_id) {
        try {
            $query = $this->conn->prepare("UPDATE carts SET quantity = ? WHERE Carts_Id = ? AND User_Id = ?");
            $query->execute([$quantity, $cart_id, $user_id]);
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

    public function removeFromCart($userId, $productId) {
        $query = $this->conn->prepare("DELETE FROM carts WHERE User_Id = ? AND id = ?");
        return $query->execute([$userId, $productId]);
    }
    

    function clearCart($user_id) {
        try {
            $query = $this->conn->prepare("DELETE FROM carts WHERE User_Id = ?");
            $query->execute([$user_id]);
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

    // Product-related methods

    function insertProduct($productName, $productPrice, $productTheme, $imagePath, $productStock) {
        try {
            $query = $this->conn->prepare("INSERT INTO products (productName, productPrice, productTheme, productImage,productStock) VALUES (?,?,?,?,?)");
            $query->execute([$productName, $productPrice, $productTheme, $imagePath, $productStock]);
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

    function viewProducts() {
        try {
            $query = $this->conn->query("SELECT * FROM products");
            return $query->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return []; // Return an empty array if there's an error
        }
    }

    public function getProductDetails($product_id) {
        try {
            $query = $this->conn->prepare("SELECT * FROM products WHERE id = ?");
            $query->execute([$product_id]);
            return $query->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return []; // Return an empty array if there's an error
        }
    }

    function getAllMessages() {
        try {
            $query = $this->conn->query("SELECT * FROM messages ORDER BY created_at DESC");
            return $query->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
            return []; // Return an empty array or handle the error as needed
        }
    }
    public function insertMessage($name, $email, $subject, $message) {
        $query = $this->conn->prepare("INSERT INTO messages(full_name, email, subject, concern) VALUES (?,?,?,?)");
        return $query->execute([$name, $email, $subject, $message]);
    } 
    public function addToCart($userId, $productId, $quantity) {
        $query = $this->conn->prepare("INSERT INTO carts (User_Id, id, quantity) VALUES (?, ?, ?)");
        return $query->execute([$userId, $productId, $quantity]);
    }    
    public function checkout($userId, $totalPrice) {
        // Insert checkout record
        $query = $this->conn->prepare("INSERT INTO checkout (user_id, total_price) VALUES (?, ?)");
        $query->execute([$userId, $totalPrice]);
        $checkoutId = $this->conn->lastInsertId();
    
        // Clear the cart after checkout
        $clearCartQuery = $this->conn->prepare("DELETE FROM carts WHERE User_Id = ?");
        $clearCartQuery->execute([$userId]);
    
        return $checkoutId;
    }
    
    function getOrders() {
        try {
            $query = $this->conn->prepare("SELECT 
                orders.Order_Id, 
                orders.total_price, 
                orders.status,
                orders.created_at,
                users.User_Id,
                users.firstname,
                users.lastname,
                users.user_email,
                GROUP_CONCAT(products.productName) AS productNames,
                GROUP_CONCAT(products.productPrice) AS productPrices,
                GROUP_CONCAT(products.productImage) AS productImages,
                GROUP_CONCAT(order_items.quantity) AS quantities
            FROM 
                orders
            JOIN users ON orders.User_Id = users.User_Id
            JOIN order_items ON orders.Order_Id = order_items.Order_Id
            JOIN products ON order_items.Product_Id = products.id
            GROUP BY orders.Order_Id, users.User_Id
            ORDER BY orders.created_at DESC");
            $query->execute();
            return $query->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
            return [];
        }
    }

    public function updateOrderStatus($orderId, $status) {
        try {
            $query = $this->conn->prepare("UPDATE orders SET status = ? WHERE Order_Id = ?");
            $query->execute([$status, $orderId]);
            return true;
        } catch (PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
            return false;
        }
    }
    
    
}

?>
