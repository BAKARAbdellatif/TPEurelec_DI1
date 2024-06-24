<?php
function openConnection()
{

    // Database connection parameters
    $host = 'localhost'; // Change this to your database host
    $dbname = 'testdb'; // Change this to your database name
    $username = 'root'; // Change this to your database username
    $password = ''; // Change this to your database password

    try {
        // Establish a connection to the database
        $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);

        // Set the PDO error mode to exception
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        return $pdo;
    } catch (PDOException $e) {
        // Display an error message if the connection fails
        return null;
        echo "Connection failed: " . $e->getMessage();
    }
}
