<?php

$hostName = 'localhost: 3307';
$dbUser = 'root';
$dbPassword = '';
$dbName = 'purrfect';
$conn = mysqli_connect($hostName, $dbUser, $dbPassword, $dbName);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

?>