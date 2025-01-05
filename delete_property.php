<?php
include 'databaseconnect.php';

// Check if the property ID is passed
if (isset($_GET['id'])) {
    $property_id = $_GET['id'];

    // Delete the property from the database
    $query = "DELETE FROM properties WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $property_id);

    if ($stmt->execute()) {
        echo "Property deleted successfully.";
        header("Location: property_listing.php");
        exit;
    } else {
        echo "Error deleting property: " . $stmt->error;
    }
} else {
    echo "No property ID provided.";
}
?>
