<?php
session_start();

if (empty($_SESSION)) {
    header("location: ../views/index.php"); // Redirect to login if not logged in
    exit;
}

// Include user class for database operations
include "../classes/user.php";
$user = new user;

// Fetch user details
$currentUser = $user->getUserById($_SESSION['id']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        .background {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover; 
            z-index: -1; 
            opacity: 1; 
        }

        body {
            overflow: auto;
            margin: 0;
            padding: 0; 
        }


        .form-background {
            background-color: rgba(255, 255, 255, 0.2); 
            padding: 20px; 
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3); 
        }

        .form-background2 {
            background-color: rgba(255, 255, 255, 1); 
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0); 
        }

        .navbar {
            position: relative;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 10;
            background-color: rgba(23, 84, 149, 0);
            color: white;
            padding: 40px 0;
        }

        .custom-position {
            position: absolute;
            right: 0; 
            top: 0.1; 
            margin-right:
        }
        
        .navbar_text {
            color: rgba(0, 55, 125, 0.8);
        }

        .nav-item {
            margin-left: 90px; 
        }

        .nav-item + .nav-item {
            margin-left: 40px; 
        }
        
        .nav-logo {
            margin-left: 10px; 
        }

        .text-container {
            position: absolute;
            top: 31%;
            left: 45%;
            opacity: 0;
            transform: translateY(50px);
            animation: fadeInSlide 1s forwards;
            margin-right: 50px;
        }

        .image-container {
            position: absolute;
            top: 32%;
            left: 10%;
            opacity: 0;
            transform: translateY(50px);
            animation: fadeInSlide 1s forwards;
            margin-right: 50px;
        }


        @keyframes fadeInSlide {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .big-text {
            font-size: 3rem; 
            color: rgba(0, 75, 156, 0.9);
            margin: 0;
        }

        .small-text {
            font-size: 1.2rem; 
            color: rgba(0, 55, 125, 0.8);
            margin-top: 10px; 
        }

        @keyframes slideIn {
            to {
                opacity: 1; 
                transform: translateY(-50%); 
            }
        }

        .furniture-image {
            width: 400px; 
            height: auto; 
            border-radius: 8px; 
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3); 
        }

        .text-container, {
            opacity: 0; 
            transition: opacity 0.5s ease;
        }

        .text-container.visible,{
            opacity: 1; 
        }

        .b-divider {
            height: 40px; 
            background-color: transparent; 
            border: none; 
            margin: 1rem 0; 
        }
    </style>
</head>
<body>
<img class="background" src="../assets/dashboard.png">
    <nav class="navbar navbar-expand-lg navbar-transparent navbar-dark nav-logo">
        <a class="navbar-brand mx-5 fs-6" href="#" style="color: rgba(255, 255, 255, 0.9);">
            <strong>HQ</strong> Home Furnishing
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse nav-item" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item active">
                    <a class="nav-link fw-bold nav-item" style="color: rgba(0, 75, 156, 0.9)" href="home.php">Home<span class="sr-only"></span></a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link fw-bold" style="color: rgba(0, 75, 156, 0.9)" href="inventory.php">Manage Inventory<span class="sr-only"></span></a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link fw-bold" style="color: rgba(0, 75, 156, 0.9)" href="account.php">Account<span class="sr-only"></span></a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link fw-bold" style="color: rgba(0, 70, 156, 0.9)"><span class="fw-bold fs-7">Welcome, <?= ucfirst($_SESSION['username'])?>!</span></a>
                </li>
                <li class="nav-item active">
                    <a class="btn ms-auto rounded-pill" style="background-color: rgba(0, 75, 156, 0.9); color: white;" href="../actions/logout.php" type="button">Logout</a>
                </li>
            </ul>
        </div>
        </div>
    </nav>

    <div class="container mt-5">
        <h1 class="text-center"><?= htmlspecialchars($currentUser['first_name'] . ' ' . $currentUser['last_name']) ?></h1>

        <div class="text-center mt-4">
            <button class="btn" style="background-color: rgba(0, 75, 156, 0.9); color: white;" data-bs-toggle="modal" data-bs-target="#usernameModal">Change Username</button>
            <button class="btn btn-warning"  data-bs-toggle="modal" data-bs-target="#passwordModal">Change Password</button>
            <button class="btn" style="background-color: rgba(0, 75, 156, 0.9); color: white;" data-bs-toggle="modal" data-bs-target="#nameModal">Change Name</button>
        </div>
    </div>

    <!-- Change Username Modal -->
    <div class="modal fade" id="usernameModal" tabindex="-1" aria-labelledby="usernameModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="../actions/user-actions.php" method="post">
                    <div class="modal-header">
                        <h5 class="modal-title" id="usernameModalLabel">Change Username</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="text" name="new_username" class="form-control" placeholder="New Username" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" name="change_username">Change Username</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal for Changing First and Last Name -->
    <div class="modal fade" id="nameModal" tabindex="-1" aria-labelledby="nameModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="nameModalLabel">Change Name</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="../actions/user-actions.php" method="post">
                        <div class="mb-3">
                            <label for="newFirstName" class="form-label">New First Name</label>
                            <input type="text" class="form-control" name="new_first_name" id="newFirstName" required>
                        </div>
                        <div class="mb-3">
                            <label for="newLastName" class="form-label">New Last Name</label>
                            <input type="text" class="form-control" name="new_last_name" id="newLastName" required>
                        </div>
                        <button type="submit" class="btn btn-primary" name="change_name">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <!-- Change Password Modal -->
    <div class="modal fade" id="passwordModal" tabindex="-1" aria-labelledby="passwordModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="../actions/user-actions.php" method="post">
                    <div class="modal-header">
                        <h5 class="modal-title" id="passwordModalLabel">Change Password</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="password" name="current_password" class="form-control" placeholder="Current Password" required>
                        <input type="password" name="new_password" class="form-control mt-2" placeholder="New Password" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" name="change_password">Change Password</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Error Notification Modal -->
<div class="modal fade" id="errorModal" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="errorModalLabel">Error</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <?= isset($_SESSION['error_message']) ? htmlspecialchars($_SESSION['error_message']) : ''; ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        <?php if (isset($_SESSION['error_message'])): ?>
            var errorModal = new bootstrap.Modal(document.getElementById('errorModal'));
            errorModal.show();
            <?php unset($_SESSION['error_message']); ?> // Clear the error message after displaying it
        <?php endif; ?>
    });
</script>

</body>
</html>
