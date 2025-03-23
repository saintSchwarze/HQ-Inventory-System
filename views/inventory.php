<?php 
    session_start();

    if(empty($_SESSION)){
        header("location: ../views/inventory.php");
        exit;
    }

    include "../classes/Product.php";

    $product = new Product();

    $product_list = $product->displayProducts();
    $history = $product->getProductHistory();
?>
<!DOCTYPE html>
<html lang="en">
<head>  
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory</title>
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
            margin-left: 90px; 
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

    <div class="container mt-5 form-background table-animated">
        <div class="centered-form-container">
            <div class="form-container">
            <div class="d-flex justify-content-between align-items-center">
                <div class="flex-grow-1 text-center">
                    <h1 class="display-5 fw-bold" style="color: rgba(0, 75, 156, 0.9)">Product List</h1>
                </div>
                <div>
                    <i class="fa-solid fa-plus fa-3x text-warning" data-bs-toggle="modal" data-bs-target="#add-product" style="cursor: pointer;"></i>
                </div>
            </div>
            </div>
            <div class="card-body">
                <?php
                    if(empty($product_list)){
                ?>
                    <div class="container-fluid bg-transparent p-5 text-danger text-center">
                        <h1 class="display-6 fw-bold pt-5 pb-3">Records Are Empty</h1>
                        <i class="fa-regular fa-circle-xmark fa-8x pb-5"></i>
                    </div>
                <?php
                    }else{
                ?>
                <table class="table">
                    <thead class="">
                        <th>Product Name</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Category</th>
                        <th>Manufacturer</th>
                        <th>
                            <div>
                                <select id="categoryFilter" class="form-select" onchange="filterByCategory()">
                                <option value="">Filter by Category</option>
                                <option value="Tables">Tables</option>
                                <option value="Desks">Desks</option>
                                <option value="Storage">Storage</option>
                                <option value="Bookcases">Bookcases</option>
                                <option value="Chairs">Chairs</option>
                                <option value="Cabinets">Cabinets</option>
                                <option value="Wardrobes">Wardrobes</option>
                                <option value="Electronics">Electronics</option>
                                </select> 
                            </div>
                        </th>
                        <th></th>
                        
                    </thead>
                    <tbody class="fw-bold">
                        <?php
                            foreach($product_list as $item){
                        ?>
                                <tr>
                                    <td><?= $item['product_name']?></td>
                                    <td><?= $item['price']?></td>
                                    <td><?= $item['quantity']?></td>
                                    <td><?= $item['category']?></td>
                                    <td><?= $item['brand']?></td>
                                    <td class="">
                                        <a href="#" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#edit-product-<?= $item['id'] ?>" title="Edit Product"><i class="fa-solid fa-pen"></i></a>
                                        <a href="#" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#add-stock-<?= $item['id'] ?>" title="Add Stock"><i class="fa-solid fa-plus"></i></a>
                                        <a href="#" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#adjust-stock-<?= $item['id'] ?>" title="Reduce Stock"><i class="fa-solid fa-minus"></i></a>
                                        <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#sell-product-<?= $item['id'] ?>" title="Sell Product"><i class="fa-solid fa-shopping-cart"></i></button>
                                        <a href="../actions/deactivate-product.php?product_id=<?= $item['id'] ?>" class="btn btn-danger btn-sm" title="Deactivate Product"><i class="fa-solid fa-ban"></i></a>
                                    </td>
                        <?php
                            if($item['quantity'] > 0){
                        ?>
                        <?php
                            }else{
                        ?>
                                <td>
                                </td>
                        <?php
                            }
                        ?>
                             </tr>
                        <?php
                            }
                        ?>
                    </tbody>
                </table>
                <?php
                    }
                ?>
            </div>
        </div>
    </div>

    
    
    <div class="container mt-5 form-background table-animated">
    <div class="card-body">
        <div class="flex-grow-1 text-center">
            <h1 class="display-5 fw-bold" style="color: rgba(0, 75, 156, 0.9)">History Log</h1>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th>Product Name</th>
                    <th>Status</th>
                    <th>Quantity</th>
                    <th>Category</th>
                    <th>Manufacturer</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody class="fw-bold">
                <?php
                foreach($history as $entry) {
                    $product_details = $product->getProductById($entry['product_id']);
                    if ($product_details) {
                        ?>
                        <tr>
                            <td><?= $product_details['product_name'] ?></td>
                            <td><?= ucfirst($entry['change_type']) ?></td>
                            <td><?= $entry['quantity'] ?></td>
                            <td><?= $entry['category'] ?></td>
                            <td><?= $entry['brand'] ?></td>
                            <td><?= $entry['change_date'] ?></td>
                        </tr>
                        <?php
                            }
                        }
                        ?>
                    </tbody>
                </table>
        </div>
    </div>

    <div class="container mt-5 form-background table-animated">
        <div class="card-body">
            <div class="flex-grow-1 text-center">
                <h1 class="display-5 fw-bold" style="color: rgba(0, 75, 156, 0.9)">Status Log</h1>
            </div>
            <table class="table">
                <thead>
                    <tr>
                        <th>Product Name</th>
                        <th>Status</th>
                        <th>Category</th>
                        <th>Manufacturer</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody class="fw-bold">
                    <?php
                    $status_log = $product->getDeactivatedProducts(); // Fetch deactivated products
                    foreach ($status_log as $item) {
                        ?>
                        <tr>
                            <td><?= $item['product_name'] ?></td>
                            <td>Inactive</td>
                            <td><?= $item['category'] ?></td>
                            <td><?= $item['brand'] ?></td>
                            <td>
                                <a href="../actions/reactivate-product.php?product_id=<?= $item['id'] ?>" class="btn btn-success btn-sm" title="Reactivate Product"><i class="fa-solid fa-undo"></i> Reactivate</a>
                            </td>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="container mt-5 form-background table-animated">
        <div class="card-body">
            <div class="flex-grow-1 text-center">
                <h1 class="display-5 fw-bold" style="color: rgba(0, 75, 156, 0.9)">Sales Report</h1>
            </div>
            <table class="table">
                <thead>
                    <tr>
                        <th>Product Name</th>
                        <th>Manufacturer</th>
                        <th>Category</th>
                        <th>Quantity Sold</th>
                        <th>Total Revenue</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody class="fw-bold">
                    <?php
                    $sales_report = $product->getSalesReport(); // Fetch sales data
                    foreach ($sales_report as $sale) {
                        ?>
                        <tr>
                            <td><?= $sale['product_name'] ?></td>
                            <td><?= $sale['manufacturer'] ?></td>
                            <td><?= $sale['category'] ?></td>
                            <td><?= $sale['quantity_sold'] ?></td>
                            <td>$<?= number_format($sale['total_revenue'], 2) ?></td>
                            <td><?= $sale['sale_date'] ?></td>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php foreach($product_list as $item): ?>
    <!-- Edit Product Modal -->
    <div class="modal fade" id="edit-product-<?= $item['id'] ?>" tabindex="-1" aria-labelledby="editProductLabel-<?= $item['id'] ?>" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editProductLabel-<?= $item['id'] ?>">Edit Product - <?= $item['product_name'] ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="../actions/product-actions.php" method="post">
                        <input type="hidden" name="product_id" value="<?= $item['id'] ?>">
                        <div class="row mb-3">
                            <div class="col-md">
                                <label for="edit-product-name-<?= $item['id'] ?>" class="form-label small text-warning">Product Name</label>
                                <input type="text" name="product_name" id="edit-product-name-<?= $item['id'] ?>" class="form-control" value="<?= $item['product_name'] ?>" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="edit-price-<?= $item['id'] ?>" class="form-label small text-secondary">Price</label>
                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="price-tag">$</span>
                                    <input type="number" name="price" id="edit-price-<?= $item['id'] ?>" class="form-control" value="<?= $item['price'] ?>" aria-label="Price" aria-describedby="price-tag" required>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md">
                                <label for="edit-category-<?= $item['id'] ?>" class="form-label small text-secondary">Category</label>
                                <select name="category" id="edit-category-<?= $item['id'] ?>" class="form-select" required>
                                    <option value="" disabled>Select a category</option>
                                    <option value="Tables" <?= $item['category'] == 'Tables' ? 'selected' : '' ?>>Tables</option>
                                    <option value="Desks" <?= $item['category'] == 'Desks' ? 'selected' : '' ?>>Desks</option>
                                    <option value="Storage" <?= $item['category'] == 'Storage' ? 'selected' : '' ?>>Storage</option>
                                    <option value="Bookcases" <?= $item['category'] == 'Bookcases' ? 'selected' : '' ?>>Bookcases</option>
                                    <option value="Chairs" <?= $item['category'] == 'Chairs' ? 'selected' : '' ?>>Chairs</option>
                                    <option value="Cabinets" <?= $item['category'] == 'Cabinets' ? 'selected' : '' ?>>Cabinets</option>
                                    <option value="Wardrobes" <?= $item['category'] == 'Wardrobes' ? 'selected' : '' ?>>Wardrobes</option>
                                    <option value="Electronics" <?= $item['category'] == 'Electronics' ? 'selected' : '' ?>>Electronics</option>
                                </select>
                            </div>

                            <div class="col-md">
                                <label for="edit-brand-<?= $item['id'] ?>" class="form-label small text-secondary">Manufacturer</label>
                                <input type="text" name="brand" id="edit-brand-<?= $item['id'] ?>" class="form-control" value="<?= $item['brand'] ?>" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md">
                                <button type="submit" class="btn btn-info w-100 btn-warning" name="edit_product">Update</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php endforeach; ?>


    <!-- ADD PRODUCT MODAL -->
<div class="modal fade" id="add-product" tabindex="-1" aria-labelledby="addProductLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content rounded-3 shadow">
            <div class="modal-header border-0">
                <h5 class="modal-title" id="addProductLabel">Add Product</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <form action="../actions/product-actions.php" method="post">
                    <div class="mb-3">
                        <label for="product-name" class="form-label">Product Name</label>
                        <input type="text" name="product_name" id="product-name" class="form-control" required>
                    </div>

                    <div class="mb-3 row">
                        <div class="col-md-6">
                            <label for="price" class="form-label">Price</label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" name="price" id="price" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="quantity" class="form-label">Quantity</label>
                            <input type="number" name="quantity" id="quantity" class="form-control" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="category" class="form-label">Category</label>
                        <select name="category" id="category" class="form-select" required>
                            <option value="" disabled selected>Select a category</option>
                            <option value="Tables">Tables</option>
                            <option value="Desks">Desks</option>
                            <option value="Storage">Storage</option>
                            <option value="Bookcases">Bookcases</option>
                            <option value="Chairs">Chairs</option>
                            <option value="Cabinets">Cabinets</option>
                            <option value="Wardrobes">Wardrobes</option>
                            <option value="Electronics">Electronics</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="brand" class="form-label">Manufacturer</label>
                        <input type="text" name="brand" id="brand" class="form-control" required>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary" name="add_product">Add</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


    <?php foreach($product_list as $item): ?>
    <!-- Add Stock Modal -->
    <div class="modal fade" id="add-stock-<?= $item['id'] ?>" tabindex="-1" aria-labelledby="addStockLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addStockLabel">Add Stock for <?= $item['product_name'] ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="../actions/add-stock.php" method="post">
                        <input type="hidden" name="product_id" value="<?= $item['id'] ?>">
                        <div class="mb-3">
                            <label for="add-quantity-<?= $item['id'] ?>" class="form-label">Quantity to Add</label>
                            <input type="number" name="quantity" id="add-quantity-<?= $item['id'] ?>" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-info">Add Stock</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Adjust Stock Modal -->
    <div class="modal fade" id="adjust-stock-<?= $item['id'] ?>" tabindex="-1" aria-labelledby="adjustStockLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="adjustStockLabel">Reduce Stock for <?= $item['product_name'] ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="../actions/adjust-stock.php" method="post">
                        <input type="hidden" name="product_id" value="<?= $item['id'] ?>">
                        <div class="mb-3">
                            <label for="adjust-quantity-<?= $item['id'] ?>" class="form-label">Quantity to Subtract</label>
                            <input type="number" name="quantity" id="adjust-quantity-<?= $item['id'] ?>" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-info">Adjust Stock</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>

<?php foreach($product_list as $product): ?>
<div class="modal fade" id="sell-product-<?= $product['id'] ?>" tabindex="-1" aria-labelledby="sellModalLabel-<?= $product['id'] ?>" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="sellModalLabel-<?= $product['id'] ?>">Sell <?= $product['product_name'] ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="../actions/sell-product.php" method="post">
                    <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                    <div class="mb-3">
                        <label for="sell-quantity-<?= $product['id'] ?>" class="form-label">Quantity to Sell</label>
                        <input type="number" name="quantity" id="sell-quantity-<?= $product['id'] ?>" class="form-control" min="1" max="<?= $product['quantity'] ?>" required>
                    </div>
                    <button type="submit" class="btn btn-success">Confirm Sale</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php endforeach; ?>


    <script>
    function filterByCategory() {
        const filter = document.getElementById('categoryFilter').value.toLowerCase();
        const table = document.querySelector('table tbody');
        const rows = table.getElementsByTagName('tr');

        for (let i = 0; i < rows.length; i++) {
            const categoryCell = rows[i].getElementsByTagName('td')[3]; // Adjust index based on category column
            if (categoryCell) {
                const category = categoryCell.textContent.toLowerCase();
                rows[i].style.display = (filter === "" || category === filter) ? "" : "none";
            }
        }
    }
    </script>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>