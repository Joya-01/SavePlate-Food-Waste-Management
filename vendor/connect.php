<?php
// Change 'root', '', 'demo' to match your actual database credentials
$connection = new mysqli("localhost", "root", "", "foodwastedb");

if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}
?>