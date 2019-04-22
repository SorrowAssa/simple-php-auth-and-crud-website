<?php

require '../includes/config.php';
require_once '../includes/functions.php';
session_start();

// Define variables and initialize with empty values
$register_username = $register_password = $register_confirm_password = "";
$state = [
    "register_username" => "",
    "register_password" => "",
    "register_confirm_password" => "",
    "register_result" => ""
];

// Validate username
if(!ValfNullOrEmpty($_POST["register_username"])){
    $state["register_username"] = "Please enter a username.";
} 
elseif(!ValfLength($_POST["register_username"], 4, 18)){
    $state["register_username"] = "Username must be between 4 and 18 characters.";
} 
else{
    // Check if already taken
    $query = $bdd->prepare('SELECT count(*) FROM users WHERE username = :username');
    $query->execute([
        'username' => $_POST["register_username"]
    ]);
    $username_count = $query->fetchColumn();
    if ($username_count > 0) {
        $state["register_username"] = "This username is already taken.";
    }
    else{
        $register_username = trim($_POST["register_username"]);
    }
}

// Validate password
if(!ValfNullOrEmpty($_POST["register_password"])){
    $state["register_password"] = "Please enter a password.";     
} 
elseif(!ValfLength($_POST["register_password"], 8, null)){
    $state["register_password"] = "Password must have atleast 8 characters.";
} 
elseif (!preg_match('/^((?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])|(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[^a-zA-Z0-9])|(?=.*?[A-Z])(?=.*?[0-9])(?=.*?[^a-zA-Z0-9])|(?=.*?[a-z])(?=.*?[0-9])(?=.*?[^a-zA-Z0-9])).{8,}$/', trim($_POST["register_password"]))) {
    $state["register_password"] = 'Passwords must be at least 8 characters and contain at 3 of 4 of the following: upper case (A-Z), lower case (a-z), number (0-9) and special character (e.g. !@#$%^&*)';
} 
else{
    $register_password = trim($_POST["register_password"]);
}

// Validate confirm password
if(!ValfNullOrEmpty($_POST["register_confirm_password"])){
    $state["register_confirm_password"] = "Please confirm password.";     
} 
else{
    $confirm_password = $_POST["register_confirm_password"];
    if(empty($state["register_password"]) && ($register_password != $confirm_password)){
        $state["register_confirm_password"] = "Password did not match.";
    }
}

// Check input errors before inserting in database
if(empty($state["register_username"]) && empty($state["register_password"]) && empty($state["register_confirm_password"])){
    
    // Insert user
    $query = $bdd->prepare("INSERT INTO users (username, password) VALUES (:username, :password)");
    $state["register_result"] = $query->execute([
        'username' => $register_username,
        'password' => password_hash($register_password, PASSWORD_DEFAULT)
    ]);

    // If success, login user directly
    if ($state["register_result"]) {
        $_SESSION['username'] = $register_username;
        $_SESSION['isadmin'] = '0';
        $state['_redirect'] = 'index.php';
    }
}
// Return form validation state
echo json_encode($state);