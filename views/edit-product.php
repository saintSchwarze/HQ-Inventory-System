<?php
    session_start();
    if(empty($_SESSION)){
        header("location: ../views/inventory.php");
        exit;
    }

    include "../classes/Product.php";

    $product = new Product;

    $product_details = $product->displaySpecificProduct($_GET['product_id']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
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
        
        .navbar_text {
            color: rgba(0, 55, 125, 0.8);
        }

        .nav-item {
            margin-left: 110px; 
        }

        .nav-item + .nav-item {
            margin-left: 40px; 
        }
        
        .nav-logo {
            margin-left: 10px; 
        }

        @keyframes fadeInSlideUp {
            0% {
                opacity: 0;
                transform: translateY(20px); /* Start slightly lower */
            }
            100% {
                opacity: 1;
                transform: translateY(0); /* End at original position */
            }
        }

        .table-animated {
            animation: fadeInSlideUp 0.6s ease-out; /* Adjust duration and easing as needed */
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

    <div class="container mt-3">
        <div class="card border-0 mx-auto w-50 form-background">
            <div class="border-0">
                <h1 class="display-4 fw-bold text-warning text-center"><i class="fa-solid fa-pen-to-square"></i> Edit Product</h1>
            </div>
            <div class="card-body">
                <form action="../actions/product-actions.php?product_id=<?= $product_details['id']?>" method="post" class="w-75 mx-auto">
                    <div class="row mb-3">
                        <div class="col-md">
                            <label for="product-name" class="form-label small text-secondary text-dark">Product Name</label>
                            <input type="text" name="product_name" id="product-name" class="form-control" value="<?= $product_details['product_name']?>">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="price" class="form-label small text-secondary text-dark">Price</label>
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="price-tag">$</span>
                                <input type="number" name="price" id="price" class="form-control" aria-label="Price" aria-describedby="price-tag" value="<?= $product_details['price']?>">
                            </div>
                        </div>
                        <div class="col-md">
                            <label for="category" class="form-label small text-secondary text-dark">Category</label>
                            <input type="text" name="category" id="category" class="form-control" value="<?= $product_details['category']?>">
                        </div>
                        <div class="col-md">
                            <label for="category" class="form-label small text-secondary text-dark">Brand</label>
                            <input type="text" name="brand" id="brand" class="form-control" value="<?= $product_details['brand']?>">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md">
                            <button type="submit" class="btn btn-warning w-100" name="edit_product">Edit</button>
                        </div>
                    </div>
                    
                </form>
                
            </div>
            
        </div>
    </div>
</body>
</html>