<?php

include 'databaseconnect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $name = $_POST['name'];
    $location = $_POST['location'];
    $size  = $_POST['size'];
    $type = $_POST['type'];
    $price = $_POST['price'];
    $agent_name = $_POST['agent_name'];
    $agent_contact = $_POST['agent_contact'];


    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $image = $_FILES['image'];
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($image['name']);
        if (move_uploaded_file($image['tmp_name'], $target_file)) {
            $image_path = $target_file;
        } else {
            die("Error uploading the image.");
        }
    } else {
        die("Image upload failed");
    }

    $stmt = $conn->prepare("INSERT INTO properties (name, location, size, type, price, agent_name, agent_contact, image) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssss", $name, $location, $size, $type, $price, $agent_name, $agent_contact, $image_path);

    if ($stmt->execute()) {
        header("Location: property_listing.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "Invalid request method.";
}

// Close the database connection
$conn->close();
?>