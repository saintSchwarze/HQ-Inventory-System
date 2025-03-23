<?php
include "../classes/Product.php";

$product_id = $_POST['product_id'];
$quantity = $_POST['quantity'];

$product = new Product();
$product->sellProduct($product_id, $quantity);

header("location: ../views/inventory.php");
?>