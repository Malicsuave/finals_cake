<?php

class database {
    public $conn;

    // Constructor to initialize database connection
    function __construct() {
        $this->opencon();
    }

    // Open connection and assign to $this->conn
    function opencon() {
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
        $this->conn->prepare("INSERT INTO users (username, password, firstname, lastname,birthday, sex, user_email, user_profile_picture) VALUES (?,?,?,?,?,?,?,?)")
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
    

    public function getOrders() {
        try {
            $query = $this->conn->query("SELECT * FROM checkout ORDER BY checkout_date DESC");
            return $query->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
            return [];
        }
    }

    
    public function insertCheckoutDetails($userId, $fullname, $email, $phone, $address) {
        try {
            $query = $this->conn->prepare("INSERT INTO delivery (User_Id, fullname, email, phone, address, status, checkout_date) 
                                          VALUES (?, ?, ?, ?, ?, 'pending', NOW())");
            return $query->execute([$userId, $fullname, $email, $phone, $address]);
        } catch (PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
            return false;
        }
    }
    public function getUserCheckouts($userId) {
        try {
            $query = $this->conn->prepare("SELECT * FROM delivery WHERE User_Id = ? ORDER BY checkout_date DESC");
            $query->execute([$userId]);
            return $query->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
            return [];
        }
    }

        public function getUserOrders($userId) {
            try {
                $query = $this->conn->query("SELECT * FROM delivery  ORDER BY checkout_date DESC");
                return $query->fetchAll(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                error_log("Database Error: " . $e->getMessage());
                return [];
            }
        }
        public function updateDeliveryStatus($status, $delivery_id) {
            try {
                $stmt = $this->conn->prepare("UPDATE delivery SET status = :status WHERE delivery_id = :delivery_id");
                $stmt->bindParam(':status', $status);
                $stmt->bindParam(':delivery_id', $delivery_id);
                return $stmt->execute();
            } catch (PDOException $e) {
                // Handle database errors here
                echo "Error: " . $e->getMessage();
                return false;
            }
        }
       
        
        public function insertProofOfPayment($transaction_id, $random_transaction_number, $image_path) {
            try {
                // Prepare SQL statement
                $stmt = $this->conn->prepare("INSERT INTO proof_of_payment (transaction_id, transaction_number, upload_photo, uploaded_at, approved) 
                                             VALUES (:transaction_id, :random_transaction_number, :image_path, NOW(), 0)");
                
                // Bind parameters
                $stmt->bindParam(':transaction_id', $transaction_id);
                $stmt->bindParam(':random_transaction_number', $random_transaction_number);
                $stmt->bindParam(':upload_photo', $image_path);
                
                // Execute the query
                if ($stmt->execute()) {
                    return true; // Return true if insertion is successful
                } else {
                    return false; // Return false if insertion fails
                }
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
                return false; // Return false on exception
            }
        }
       

        public function deleteProduct($product_id) {
            $stmt = $this->conn->prepare("DELETE FROM products WHERE id = :id");
            $stmt->bindParam(':id', $product_id);
            return $stmt->execute();
        }
        // Method to view all products
        

        public function getRecentUsername() {
            $stmt = $this->conn->prepare("SELECT username FROM users ORDER BY created_at DESC LIMIT 1");
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
    
        public function getProductWithHighestSales() {
            $stmt = $this->conn->prepare("SELECT productName, SUM(quantity) AS total_sales FROM checkout JOIN products ON checkout.checkout_Id = products.id GROUP BY product_id ORDER BY total_sales DESC LIMIT 1");
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
    
        public function getTotalProfit() {
            $stmt = $this->conn->prepare("SELECT SUM(productPrice * quantity) AS total_profit FROM checkout JOIN products ON checkout.checkout_Id = products.id WHERE status='complete' ");
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
    
        public function getUsernameWithMostProductsBought() {
            $stmt = $this->conn->prepare("SELECT users.username, SUM(checkout.quantity) AS total_quantity FROM checkout JOIN users ON checkout.User_Id = users.User_Id GROUP BY checkout.User_Id ORDER BY total_quantity DESC LIMIT 1");
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

        public function getOrdersStatusSummary() {
            try {
                $stmt = $this->conn->query("SELECT status, COUNT(*) AS total_orders
                                           FROM checkout
                                           GROUP BY status");
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                // Handle database errors gracefully
                error_log("Error fetching order status summary: " . $e->getMessage());
                return false;
            }
        }

        public function getTotalUsers() {
            try {
                $stmt = $this->conn->query("SELECT COUNT(*) AS total_users FROM users");
                return $stmt->fetch(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                die("Error fetching total users: " . $e->getMessage());
            }













    }
}
        


  
    


?>