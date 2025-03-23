<?php
include "../classes/Product.php";

$product_id = $_GET['product_id'];
$product = new Product();
$product->reactivateProduct($product_id);

header("location: ../views/inventory.php");
?>