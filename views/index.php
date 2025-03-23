<?php session_start(); 

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        .background {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover; 
            z-index: -1; 
            opacity: 1  ; 
        }

        body {
            margin: 0;
            overflow: hidden;
            padding: 0; 
        }

        .form-background {
            background-color: rgba(255, 255, 255, 0.2); 
            padding: 20px; 
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3); 
        }

        .form-background2 {
            background-color: rgba(255, 255, 255, 0); 
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0); 
        }

        .reg-background {
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
            margin-left: 200px; 
        }

        .nav-item + .nav-item {
            margin-left: 40px; /* Decrease this value for closer spacing */
        }
        
        .nav-logo {
            margin-left: 10px; 
        }
    </style>
</head>
<body>
    <img class="background" src="../assets/login.png">
    <nav class="navbar navbar-expand-lg navbar-transparent navbar-dark nav-logo">
    <a class="navbar-brand mx-5 fs-6" href="#" style="color: rgba(0, 75, 156, 0.9);">
    <strong>HQ</strong> Home Furnishing
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    </nav>
    <div class="container mt-5">
        <div class="card border-0 mx-auto form-background w-50">
            <div class=" border-0 mt-4">
                <h5 class="fw-bold text-center form-background2" style="color: rgba(0, 75, 156, 0.9)">INVENTORY MANAGEMENT SYSTEM</h5>
                <h2 class="display-5 fw-bold text-center form-background2" style="color: rgba(0, 75, 156, 0.9)">LOGIN <i class="fa-solid fa-right-to-bracket"></i></h2>
            </div>
            <class="card-body">
                <form action="../actions/user-actions.php" method="post" class="w-75 mx-auto">
                    <div class="row mb-3 g-2">
                        <label for="username" class="col-md-2 col-form-label text-md-end text-secondary small"></label>
                        <div class="col-md-8">
                            <input type="text" name="username" id="username" class="form-control" placeholder="Username">
                        </div>
                    </div>
                    <div class="row mb-3 g-2">
                        <label for="password" class="col-md-2 col-form-label text-md-end text-secondary small"></label>
                        <div class="col-md-8">
                            <input type="password" name="password" id="password" class="form-control" placeholder="Password">
                        </div>
                    </div>
                    <div class="row mb-3 g-2">
                        <div class="col-md-8 offset-md-2">
                            <button type="submit" class="btn btn-primary w-100" style="background-color: rgba(0, 75, 156, 0.9); color: white;" name="login">Login</button>
                        </div>
                    </div>
                    
                </form>
                <!-- Error Modal -->
                <div class="modal fade" id="errorModal" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="errorModalLabel">Login Error</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Incorrect username or password. Please try again.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        <?php if (isset($_SESSION['login_error'])): ?>
            var errorModal = new bootstrap.Modal(document.getElementById('errorModal'));
            errorModal.show();
            <?php unset($_SESSION['login_error']); // Clear the session variable ?>
        <?php endif; ?>
    });
</script>

</body>
</html>