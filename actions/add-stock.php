<?php
session_start();
require_once "../classes/Product.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'];

    $product = new Product();

    // Call the method to add stock
    $product->addStock($product_id, $quantity);

    // Redirect back to the inventory page
    header("location: ../views/inventory.php");
    exit;
}
?>
