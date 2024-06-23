<?php

class database{
    private $conn;

    function opencon(){
        return new PDO('mysql:host=localhost; dbname=margacake', 'root', '');
    }

    function check($username, $password) {
        $con = $this->opencon();
        $stmt = $con->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }
        return false;
    }

    function signup($username, $password, $firstname, $lastname, $birthday, $sex){
        $con = $this->opencon();
        $query = $con->prepare("SELECT username FROM users WHERE username = ?");
        $query->execute([$username]);
        $existingUser = $query->fetch();
        if($existingUser){
            return false;
        }
        return $con->prepare("INSERT INTO users(username, password, firstname, lastname, birthday, sex)
            VALUES (?, ?, ?, ?, ?, ?)")
            ->execute([$username, $password, $firstname, $lastname, $birthday, $sex]);
    }

    function signupUser($firstname, $lastname, $birthday, $sex, $email, $username, $password, $profilePicture)
    {
        $con = $this->opencon();
        $con->prepare("INSERT INTO users (firstname, lastname, birthday, sex, user_email, username, password, user_profile_picture) VALUES (?,?,?,?,?,?,?,?)")->execute([$firstname, $lastname, $birthday, $sex, $email, $username, $password, $profilePicture]);
        return $con->lastInsertId();
    }

    function insertAddress($User_Id, $street, $barangay, $city, $province)
    {
        $con = $this->opencon();
        return $con->prepare("INSERT INTO user_address (User_Id, street, barangay, city, province) VALUES (?,?,?,?,?)")->execute([$User_Id, $street, $barangay,  $city, $province]);
    }

    function view(){
        $con = $this->opencon();
        return $con->query("SELECT
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
        JOIN user_address ON users.User_Id = user_address.User_Id")->fetchAll();
    }

    function delete($id){
        try {
            $con = $this->opencon();
            $con->beginTransaction();
            $query = $con->prepare("DELETE FROM user_address WHERE User_Id = ?");
            $query->execute([$id]);
            $query2 = $con->prepare("DELETE FROM users WHERE User_Id = ?");
            $query2->execute([$id]);
            $con->commit();
            return true; //Deletion successful
        } catch (PDOException $e) {
            $con->rollBack();
            return false;
        }
    }

    function viewdata($id){
        try {
            $con = $this->opencon();
            $query = $con->prepare("SELECT
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
            return $query->fetch();
        } catch (PDOException $e) {
            return [];
        }
    }

    function updateUser($User_Id, $username,$password,$firstname, $lastname, $birthday, $sex) {
        try { 
            $con = $this->opencon();
            $con->beginTransaction();
            $query = $con->prepare("UPDATE users SET username=?, password=?, firstname=?, lastname=?, birthday=?, sex=? WHERE User_Id=?");
            $query->execute([$username, $password, $firstname, $lastname, $birthday, $sex, $User_Id]);
            $con->commit();
            return true;
        } catch (PDOException $e) {
            $con->rollBack();
            return false;
        }
    }

    function updateUserAddress($User_Id, $street, $barangay, $city, $province) {
        try { 
            $con = $this->opencon();
            $con->beginTransaction();
            $query = $con->prepare("UPDATE user_address SET street=?, barangay=?, city=?, province=?  WHERE User_Id=?");
            $query->execute([$street,$barangay,$city,$province, $User_Id]);
            $con->commit();
            return true;
        } catch (PDOException $e) {
            $con->rollBack();
            return false;
        }
    }

    function validateCurrentPassword($User_Id, $currentPassword) {
        $con = $this->opencon();
        $query = $con->prepare("SELECT password FROM users WHERE User_Id = ?");
        $query->execute([$User_Id]);
        $user = $query->fetch(PDO::FETCH_ASSOC);
        if ($user && password_verify($currentPassword, $user['password'])) {
            return true;
        }
        return false;
    }

    function updatePassword($userId, $hashedPassword){
        try {
            $con = $this->opencon();
            $con->beginTransaction();
            $query = $con->prepare("UPDATE users SET password = ? WHERE User_Id = ?");
            $query->execute([$hashedPassword, $userId]);
            $con->commit();
            return true;
        } catch (PDOException $e) {
            $con->rollBack();
            return false;
        }
    }

    function updateUserProfilePicture($userID, $profilePicturePath) {
        try {
            $con = $this->opencon();
            $con->beginTransaction();
            $query = $con->prepare("UPDATE users SET user_profile_picture = ? WHERE User_Id = ?");
            $query->execute([$profilePicturePath, $userID]);
            $con->commit();
            return true;
        } catch (PDOException $e) {
            $con->rollBack();
            return false;
        }
    }

    // New method to insert product
    function insertProduct($productName, $productDescription, $productPrice, $imagePath) {
        global $con;
        
        $stmt = $con->prepare("INSERT INTO products (product_name, product_description	, product_price, product_image) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssds", $productName, $productDescription, $productPrice, $imagePath);
        
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
    function viewProducts() {
        try {
            $con = $this->opencon();
            $query = $con->query("SELECT * FROM products");
            return $query->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return []; // Return an empty array if there's an error
        }
    }
}

?>
