<?php

    include_once "../classes/Product.php";

    $product = new Product;

    if(isset($_POST['add_product'])){
        $product_name = $_POST['product_name'];
        $price = $_POST['price'];
        $quantity = $_POST['quantity'];
        $category = $_POST['category'];
        $brand = $_POST['brand'];

        $product->addProduct($product_name, $price, $quantity, $category, $brand);
        $stmt = $conn->prepare("INSERT INTO product_history (product_id, name_product, change_type, quantity, category, brand) VALUES (?, 'added', ?, ?, ?)");
        $stmt->execute([$new_product_id, $_POST['name_product'], $_POST['change_type'], $_POST['quantity'], $_POST['category'], $_POST['brand']]);
    }
    if (isset($_POST['edit_product'])) {
        $product_id = $_POST['product_id'];
        $product_name = $_POST['product_name'];
        $price = $_POST['price'];
        $category = $_POST['category'];
        $brand = $_POST['brand'];

        $product->editProduct($product_id, $product_name, $price,  $category, $brand);
        $stmt = $conn->prepare("INSERT INTO product_history (product_id, name_product, change_type, quantity, category, brand) VALUES (?, 'added', ?, ?)");
        $stmt->execute([$new_product_id, $_POST['name_product'], $_POST['change_type'], $_POST['category'], $_POST['brand']]);
        
        header("location: ../views/inventory.php");
        exit;
    
    }
