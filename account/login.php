<?php

require '../includes/config.php';
require_once '../includes/functions.php';
session_start();

$login_username = $login_password = "";
$state = [
    "login_username" => "",
    "login_password" => "",
    "login_result" => ""
];

// Validate username
if(!ValfNullOrEmpty($_POST["login_username"])){
    $state["login_username"] = "Please enter a username.";
}
else {
    $login_username = trim($_POST["login_username"]);
}

// Validate password
if(!ValfNullOrEmpty($_POST["login_password"])){
    $state["login_password"] = "Please enter a password.";     
}
else {
    $login_password = trim($_POST["login_password"]);
}

// Check input errors before check user
if(empty($state["login_username"]) && empty($state["login_password"])){
    
    // Get user info
    $query = $bdd->prepare('SELECT `id`, `username`, `password`, `role` FROM users WHERE `username` = :username');
    $query->execute([
        'username' => $login_username
    ]);
    $user_found = $query->fetch(PDO::FETCH_ASSOC);
    
    // If user found and password ok, login success
    if ($user_found && password_verify($login_password, $user_found['password'])) {
        $_SESSION['username'] = $user_found['username'];
        $_SESSION['isadmin'] = $user_found['role'];
        $state['_redirect'] = 'index.php';
    }
    else {
        $state["login_result"] = 'Username or password invalid';
    }
}

// Return form validation state
echo json_encode($state);