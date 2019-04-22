<?php

try {
    //create mysql connection
    $bdd = new PDO('mysql:host=localhost;charset=utf8', 'demo', 'mypass123', [ PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION ]);
}
catch(Exception $e) {
    echo 'Error while trying to connect to DB. Please update the mysql user and password in files [includes/config/php:5] and [demo/create_demo_db.php:5] (user with db creation rights) and refresh the page.';
    die();
}

// Connect to database
try {
    $errorType = 'Connection failed';
    
    // Db creation
    $errorType = 'Db creation failed';
    $query = $bdd->prepare('CREATE DATABASE IF NOT EXISTS `demo-simple-auth`');
    $query->execute();

    // Table creation
    $errorType = 'Table creation failed';

    $query = $bdd->prepare(
        'CREATE TABLE IF NOT EXISTS `demo-simple-auth`.`users` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `username` varchar(255) NOT NULL,
            `password` varchar(255) NOT NULL,
            `role` int(11) NOT NULL DEFAULT \'0\',
            `creation_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (`id`),
            UNIQUE KEY `username` (`username`)
        ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
        
        CREATE TABLE IF NOT EXISTS `demo-simple-auth`.`events` (
            `id` INT NOT NULL AUTO_INCREMENT,
            `title` VARCHAR(255) NOT NULL,
            `creator` VARCHAR(255) NOT NULL,
            `description` VARCHAR(4000) NULL,
            PRIMARY KEY (`id`)
        ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
        ');
    $query->execute();
}
catch(Exception $e) {
    printf($errorType.'\n'.$e->getMessage());
}

header("Location: ../index.php");
die();