<?php

// Function to save user data to the database
function saveUserData($firstName, $lastName, $imagePath) {
    global $pdo;

    try {
        $stmt = $pdo->prepare("INSERT INTO users (first_name, last_name, image_path) VALUES (?, ?, ?)");
        $stmt->execute([$firstName, $lastName, $imagePath]);
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}