<?php
session_start();
require_once "../classes/Product.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'];

    $product = new Product();

    // Call the method to adjust stock
    $product->adjustStock($product_id, $quantity); // This should be updated to subtract the quantity

    // Redirect back to the inventory page
    header("location: ../views/inventory.php");
    exit;
}
?>
