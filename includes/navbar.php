<?php
session_start(); // Ensure the session is started
$current_page = basename($_SERVER['PHP_SELF']);
require_once('classes/database.php');
$con = new Database();

if (isset($_SESSION['User_Id'])) {
    $id = $_SESSION['User_Id'];
    $data = $con->viewdata($id);

    // Assuming the profile picture URL is stored in the session or fetched from the database
    $profilePicture = $data['user_profile_picture'] ?? 'path/to/default/profile_picture.jpg';
    $username = $_SESSION['username'];
} else {
    $profilePicture = 'path/to/default/profile_picture.jpg';
    $username = 'Guest';
}
?>

<nav class="navbar navbar-expand-lg">
    <div class="container">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <a class="navbar-brand" href="index.php">
            <strong><span>Marga's</span> Cakes</strong>
        </a>

        <div class="d-lg-none">
            <a href="sign-in.php" class="bi-person custom-icon me-3"></a>
            <a href="product-detail.php" class="bi-bag custom-icon"></a>
        </div>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mx-auto">
                <li class="nav-item <?php echo ($current_page == 'index.php') ? 'active' : ''; ?>">
                    <a class="nav-link" href="index.php">Home</a>
                </li>
                <li class="nav-item <?php echo ($current_page == 'about.php') ? 'active' : ''; ?>">
                    <a class="nav-link" href="about.php">Story</a>
                </li>
                <li class="nav-item <?php echo ($current_page == 'products.php') ? 'active' : ''; ?>">
                    <a class="nav-link" href="products.php">Products</a>
                </li>
                <li class="nav-item <?php echo ($current_page == 'faq.php') ? 'active' : ''; ?>">
                    <a class="nav-link" href="faq.php">FAQs</a>
                </li>
                <li class="nav-item <?php echo ($current_page == 'contact.php') ? 'active' : ''; ?>">
                    <a class="nav-link" href="contact.php">Contact</a>
                </li>
            </ul>

            <div class="d-none d-lg-block">
                <?php if (isset($_SESSION['User_Id'])): ?>
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <img src="<?php echo $profilePicture; ?>" width="30" height="30" class="rounded-circle mr-1" alt="Profile Picture"> <?php echo $username; ?>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                                <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#changeProfilePictureModal"><i class="fas fa-user-circle"></i> Change Profile Picture</a>
                                <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#updateAccountInfoModal"><i class="fas fa-user-edit"></i> Update Account Information</a>
                                <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#changePasswordModal"><i class="fas fa-key"></i> Change Password</a>
                                <a class="dropdown-item" href="logout.php" onclick="return confirm('Are you sure you want to leave?')"><i class="fa-solid fa-right-from-bracket"></i> Logout</a>
                            </div>
                        </li>
                    </ul>
                <?php else: ?>
                    <a href="sign-in.php" class="bi-person custom-icon me-3"></a>
                    <a href="cart.php" class="bi-bag custom-icon"></a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</nav>

<!-- Include Bootstrap JS and dependencies -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>
