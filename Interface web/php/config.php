<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Configuration
$host = 'localhost';
$username = 'root';
$password = '';
$dbname = 'pfmp';
$port = 3307;

$conn = new mysqli($host, $username, $password, $dbname, $port);
    if ($conn->connect_error) {
        throw new Exception("Échec de connexion : " . $conn->connect_error);
    }


?>