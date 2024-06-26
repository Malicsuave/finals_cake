<?php
session_start();
require_once('classes/database.php');

$con = new Database();

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    // Validate and sanitize inputs
    $transaction_id = $_SESSION['transaction_id'] ?? null; // Adjust according to your session management
    $random_transaction_number = htmlspecialchars($_POST['random_transaction_number']); // Sanitize input

    // File upload handling
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["proof_of_payment_image"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if image file is a real image
    $check = getimagesize($_FILES["proof_of_payment_image"]["tmp_name"]);
    if ($check === false) {
        echo "File is not an image.";
        $uploadOk = 0;
    }

    // Check file size
    if ($_FILES["proof_of_payment_image"]["size"] > 500000) { // 500KB limit, adjust as necessary
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Allow certain file formats
    $allowed_types = array('jpg', 'jpeg', 'png', 'gif');
    if (!in_array($imageFileType, $allowed_types)) {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    } else {
        // if everything is ok, try to upload file
        if (move_uploaded_file($_FILES["proof_of_payment_image"]["tmp_name"], $target_file)) {
            // File uploaded successfully, now insert into database
            $image_path = $target_file;

            // Insert into database using the Database class function
            if ($con->insertProofOfPayment($transaction_id, $random_transaction_number, $image_path)) {
                echo "Proof of payment uploaded successfully!";
                // Redirect or show success message to the user
            } else {
                echo "Failed to upload proof of payment.";
                // Handle error (e.g., show error message)
            }
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
    // Insert into database using the Database class function
$inserted = $con->insertProofOfPayment($transaction_id, $random_transaction_number, $image_path);


}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Proof of Payment</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Custom CSS -->
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            padding-top: 50px;
        }
        .container {
            max-width: 600px;
            margin: auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h2 {
            text-align: center;
            margin-bottom: 30px;
        }
        form {
            margin-bottom: 20px;
        }
        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }
        .btn-primary:hover {
            background-color: #0069d9;
            border-color: #0062cc;
        }
    </style>
</head>
<body>

    <?php include ('user-navbar.php'); ?>

    <div class="container mt-5">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <h2>Upload Proof of Payment</h2>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="random_transaction_number">Transaction Number:</label>
                        <input type="text" class="form-control" id="random_transaction_number" name="random_transaction_number" required>
                    </div>
                    <div class="form-group">
                        <label for="proof_of_payment_image">Proof of Payment Image:</label>
                        <input type="file" class="form-control-file" id="proof_of_payment_image" name="proof_of_payment_image" accept="image/*" required>
                    </div>
                    <button type="submit" name="submit" class="btn btn-primary btn-block">Upload Proof of Payment</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
