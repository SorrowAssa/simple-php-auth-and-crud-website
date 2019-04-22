<?php

session_start();
if (isset($_SESSION['username'])) {
    session_unset();
    session_destroy(); 
}
$state = [
    '_redirect' => 'index.php'
];
echo json_encode($state);