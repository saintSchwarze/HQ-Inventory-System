    <?php

        require_once "Database.php";

        class Product extends Database {

            public function addProduct($product_name, $price, $quantity, $category, $brand) {
                $sql = "INSERT INTO products (product_name, price, quantity, category, brand) VALUES (?, ?, ?, ?, ?)";
                $stmt = $this->conn->prepare($sql);
                $stmt->bind_param("sdiss", $product_name, $price, $quantity, $category, $brand);
            
                if ($stmt->execute()) {
                    $new_product_id = $this->conn->insert_id;
                    $this->logProductChange($new_product_id, $product_name, 'Added', $quantity, $category, $brand);
                    header("location: ../views/inventory.php");
                    exit;
                } else {
                    die("Error in Adding: " . $this->conn->error);
                }
            }
            
            public function addStock($product_id, $addition_quantity) {
                $sql = "UPDATE products SET quantity = quantity + ? WHERE id = ?";
                $stmt = $this->conn->prepare($sql);
                $stmt->bind_param("ii", $addition_quantity, $product_id);
                
                if ($stmt->execute()) {
                    // Optionally log the addition if needed
                    $product_details = $this->displaySpecificProduct($product_id);
                    $this->logProductChange($product_id, $product_details['product_name'], 'Added Stock', $addition_quantity, $product_details['category'], $product_details['brand']);
                    return true; // Stock added successfully
                } else {
                    die("Error in adding stock: " . $this->conn->error);
                }
            }
            

            public function displayProducts() {
                $sql = "SELECT * FROM products WHERE is_deleted = 0";
                $result = $this->conn->query($sql);
                return $result->fetch_all(MYSQLI_ASSOC);
            }

            public function displaySpecificProduct($product_id){
                $sql = "SELECT * FROM products WHERE id = '$product_id'";

                if($result = $this->conn->query($sql)){
                    return $result->fetch_assoc();
                }else{
                    die("Error in retrieving product: " .$this->conn->error);
                }
            }

            public function editProduct($product_id, $product_name, $price, $category, $brand) {
                $sql = "UPDATE products SET product_name = ?, price = ?, category = ?, brand = ? WHERE id = ?";
                $stmt = $this->conn->prepare($sql);
                $stmt->bind_param("sdssi", $product_name, $price, $category, $brand, $product_id);
            
                if ($stmt->execute()) {
                    $this->logProductChangeEdit($product_id, $product_name,'Edited', $category, $brand);
                    header("location: ../views/inventory.php");
                    exit;
                } else {
                    die("Error in editing product: " . $this->conn->error);
                }
            }

            public function logProductChange($product_id, $product_name, $change_type, $quantity, $category, $brand) {
                $sql = "INSERT INTO product_history (product_id, product_name, change_type, quantity, category, brand) VALUES (?, ?, ?, ?, ?, ?)";
                $stmt = $this->conn->prepare($sql);
                $stmt->bind_param("isssss", $product_id, $product_name, $change_type, $quantity, $category, $brand);
                $stmt->execute();
                $stmt->close();
            }

            public function logProductChangeEdit($product_id, $product_name, $change_type, $category, $brand) {
                $sql = "INSERT INTO product_history (product_id, product_name, change_type, category, brand) VALUES (?, ?, ?, ?, ?)";
                $stmt = $this->conn->prepare($sql);
                $stmt->bind_param("issss", $product_id, $product_name, $change_type, $category, $brand);
                $stmt->execute();
                $stmt->close();
            }

            public function deleteProduct($product_id) {
                // First, get the product details to log in history
                $product_details = $this->displaySpecificProduct($product_id);
                
                // Update the product status to 'deleted'
                $sql = "UPDATE products SET is_deleted = 1 WHERE id = ?";
                $stmt = $this->conn->prepare($sql);
                $stmt->bind_param("i", $product_id);
                
                if ($stmt->execute()) {
                    // Log the deletion in product history
                    $this->logProductChange($product_id, $product_details['product_name'], 'Deleted', $product_details['quantity'], $product_details['category'], $product_details['brand']);
                    header("location: ../views/inventory.php");
                    exit;
                } else {
                    die("Error in deleting product: " . $this->conn->error);
                }
            }
            
            public function deactivateProduct($product_id) {
                $sql = "UPDATE products SET is_deleted = 1 WHERE id = ?";
                $stmt = $this->conn->prepare($sql);
                $stmt->bind_param("i", $product_id);
                $stmt->execute();
            }
            
            public function reactivateProduct($product_id) {
                $sql = "UPDATE products SET is_deleted = 0 WHERE id = ?";
                $stmt = $this->conn->prepare($sql);
                $stmt->bind_param("i", $product_id);
                $stmt->execute();
            }
            
            public function getDeactivatedProducts() {
                $sql = "SELECT * FROM products WHERE is_deleted = 1";
                $result = $this->conn->query($sql);
                return $result->fetch_all(MYSQLI_ASSOC);
            }

            public function adjustStock($product_id, $adjustment_quantity) {
                $sql = "UPDATE products SET quantity = quantity - ? WHERE id = ?";
                $stmt = $this->conn->prepare($sql);
                $stmt->bind_param("ii", $adjustment_quantity, $product_id);
                
                if ($stmt->execute()) {
                    // Optionally log the adjustment if needed
                    $product_details = $this->displaySpecificProduct($product_id);
                    $this->logProductChange($product_id, $product_details['product_name'], 'Reduced Stock', $adjustment_quantity, $product_details['category'], $product_details['brand']);
                    return true; // Stock adjusted successfully
                } else {
                    die("Error in adjusting stock: " . $this->conn->error);
                }
            }

            public function getSalesReport() {
                $sql = "SELECT 
                            p.product_name, 
                            p.brand AS manufacturer, 
                            p.category, 
                            s.quantity_sold, 
                            (s.quantity_sold * p.price) AS total_revenue, 
                            s.sale_date 
                        FROM sales s
                        JOIN products p ON s.product_id = p.id
                        ORDER BY s.sale_date DESC";
                $result = $this->conn->query($sql);
                return $result->fetch_all(MYSQLI_ASSOC);
            }

            public function sellProduct($product_id, $quantity) {
                // Reduce stock
                $sql = "UPDATE products SET quantity = quantity - ? WHERE id = ?";
                $stmt = $this->conn->prepare($sql);
                $stmt->bind_param("ii", $quantity, $product_id);
                $stmt->execute();
            
                // Record sale
                $sql = "INSERT INTO sales (product_id, quantity_sold) VALUES (?, ?)";
                $stmt = $this->conn->prepare($sql);
                $stmt->bind_param("ii", $product_id, $quantity);
                $stmt->execute();
            }

            public function sellStock($product_id, $sell_quantity) {
                $sql = "UPDATE products SET quantity = quantity - ? WHERE id = ?";
                $stmt = $this->conn->prepare($sql);
                $stmt->bind_param("ii", $sell_quantity, $product_id);
                
                if ($stmt->execute()) {
                    // Optionally log the adjustment if needed
                    $product_details = $this->displaySpecificProduct($product_id);
                    $this->logProductChange($product_id, $product_details['product_name'], 'Sold', $sell_quantity, $product_details['category'], $product_details['brand']);
                    return true; // Stock adjusted successfully
                } else {
                    die("Error in adjusting stock: " . $this->conn->error);
                }
            }

            public function getProductHistory() {
                $sql = "SELECT * FROM product_history ORDER BY change_date DESC";
                $result = $this->conn->query($sql);
                
                $history = []; // Initialize an empty array to store history records
            
                if ($result) {
                    while ($row = $result->fetch_assoc()) {
                        $history[] = $row; // Add each row to the history array
                    }
                } else {
                    die("Error retrieving product history: " . $this->conn->error);
                }
            
                return $history; // Return the populated history array
            }
            
            
            
            public function getProductById($id) {
                $stmt = $this->conn->prepare("SELECT product_name FROM products WHERE id = ?");
                $stmt->bind_param("i", $id); // Use bind_param for security
                $stmt->execute();
                return $stmt->get_result()->fetch_assoc();
            }

            
        }