<?php
    require "Database.php";
    class user extends Database{

        public function getUserById($id) {
            $sql = "SELECT * FROM users WHERE id = '$id'";
            return $this->conn->query($sql)->fetch_assoc();
        }
        
        public function changeUsername($id, $new_username) {
            $sql = "UPDATE users SET username = '$new_username' WHERE id = '$id'";
            if ($this->conn->query($sql)) {
                header("location: ../views/account.php");
                exit;
            } else {
                die("Error updating username: " . $this->conn->error);
            }
        }
        
        public function changePassword($id, $current_password, $new_password) {
            $sql = "SELECT password FROM users WHERE id = '$id'";
            $result = $this->conn->query($sql);
            $user = $result->fetch_assoc();
        
            if (password_verify($current_password, $user['password'])) {
                $sql = "UPDATE users SET password = '$new_password' WHERE id = '$id'";
                if ($this->conn->query($sql)) {
                    header("location: ../views/account.php");
                    exit;
                } else {
                    die("Error updating password: " . $this->conn->error);
                }
            } else {
                die("Current password is incorrect.");
            }
        }

        public function changeName($id, $new_first_name, $new_last_name) {
            $sql = "UPDATE users SET first_name = '$new_first_name', last_name = '$new_last_name' WHERE id = '$id'";
            if ($this->conn->query($sql)) {
                header("location: ../views/account.php");
                exit;
            } else {
                die("Error updating name: " . $this->conn->error);
            }
        }
        
        public function checkCurrentPassword($userId, $currentPassword) {
            // Assuming you have a method to get user details by ID
            $userDetails = $this->getUserById($userId);
        
            // Verify the current password with the hashed password from the database
            return password_verify($currentPassword, $userDetails['password']);
        }
    

        public function login($username, $password) {
            $sql = "SELECT * FROM users WHERE username = '$username'";
            $result = $this->conn->query($sql);
        
            if ($result->num_rows == 1) {
                $user = $result->fetch_assoc();
        
                if (password_verify($password, $user['password'])) {
                    session_start();
                    $_SESSION['id'] = $user['id'];
                    $_SESSION['username'] = $user['username'];
                    header("location: ../views/home.php");
                    exit;
                } else {
                    session_start();
                    $_SESSION['login_error'] = true; // Set session variable for login error
                    header("location: ../views/index.php"); // Redirect to the login page
                    exit;
                }
            } else {
                session_start();
                $_SESSION['login_error'] = true; // Set session variable for username not found
                header("location: ../views/index.php"); // Redirect to the login page
                exit;
            }
        }
    }
    
