<?php
$servername = "localhost";  // Typically 'localhost' for local servers
$username = "root";  // Your MySQL username
$password = "";  // Your MySQL password
$dbname = "blood_bank";  // The name of your database

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // Set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

