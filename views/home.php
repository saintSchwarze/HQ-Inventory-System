<?php 
    session_start();

    if(empty($_SESSION)){
        header("location: ../views/home.php"); // Change this to your home page
        exit;
    }
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
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
    
    <div class="text-container">
    <h1 class="big-text fw-bold">Where Comfort Meets Efficiency</h1>
    <p class="small-text">For customers, we provide the highest quality of products, the same can be said for our staff, provided with a powerful inventory management system designed to reflect the quality and style of your furniture. Effortlessly track and manage your inventory, ensuring you can showcase our curated selection while keeping your business organized and efficient.

</p>
    <a href="../views/inventory.php" class="btn ms-auto rounded-pill" style="background-color: rgba(0, 75, 156, 0.9); color: white;">Go To Inventory</a>
    <div class="b-divider"></div>
    </div>

    <div class="image-container">
        <img src="../assets/pic1.jpg" alt="Stylish Furniture" class="furniture-image">
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script>
        window.onload = function() {
            document.querySelector('.text-container').style.opacity = '1';
        };

        function isElementInViewport(el) {
        const rect = el.getBoundingClientRect();
        return (
            rect.top >= 0 && 
            rect.bottom <= (window.innerHeight || document.documentElement.clientHeight)
        );
    }

        function checkVisibility() {
            const textContainer2 = document.querySelector('.text-container2'); // Only target Uncompromising Quality section
            if (isElementInViewport(textContainer2)) {
                textContainer2.classList.add('visible');
            }
        }

        window.addEventListener('scroll', checkVisibility);
        window.addEventListener('resize', checkVisibility); // Check visibility on resize

        // Initial check to fade in elements that are already in view on page load
        window.onload = checkVisibility;

    </script>
</body>
</html>
