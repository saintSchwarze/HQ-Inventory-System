<?php
    session_start();
    include "../classes/user.php";
    $user = new user;
    if(isset($_POST['login'])){
        $username = $_POST['username'];
        $password = $_POST['password'];

        $user->login($username, $password);
    }

    elseif (isset($_POST['change_username'])) {
        $new_username = $_POST['new_username'];
        $user->changeUsername($_SESSION['id'], $new_username);
    } elseif (isset($_POST['change_password'])) {
        $current_password = $_POST['current_password'];
        $new_password = password_hash($_POST['new_password'], PASSWORD_DEFAULT);


    // Check if the current password is correct
    if ($user->checkCurrentPassword($_SESSION['id'], $current_password)) { // You need to implement this method
        $user->changePassword($_SESSION['id'], $current_password, $new_password);
        header("Location: ../views/account.php");
        exit;
    } else {
        $_SESSION['error_message'] = "Incorrect current password.";
        header("Location: ../views/account.php");
        exit;
    }
    }
    elseif (isset($_POST['change_name'])) {
        $new_first_name = $_POST['new_first_name'];
        $new_last_name = $_POST['new_last_name'];
        $user->changeName($_SESSION['id'], $new_first_name, $new_last_name);
    }
    
    
    