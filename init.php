<?php

error_reporting(E_ALL);

session_start();

$host = '127.0.0.1';
$dbName = 'users';
$user = 'root';
$password = '111111';

// Establish a database connection using PDO
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbName", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}