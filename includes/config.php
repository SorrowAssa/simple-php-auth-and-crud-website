<?php

// FOR DEMO SET YOU LOCAL URL
$baseurl = "http://localhost:8080/";

// Connect to database
try {
    $bdd = new PDO('mysql:host=localhost;dbname=demo-simple-auth;charset=utf8', 'demo', 'mypass123', [ PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION ]);
}
catch(Exception $e) {
    header('Location: ../demo/create_demo_db.php');    // if demo, try create db first !
    // die('Error, please try later');  // prod message
    die('Error: '.$e->getMessage());    // test error message
}