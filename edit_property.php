<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Property</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<?php
include 'databaseconnect.php'; // Include your database connection

// Check if the property ID is passed
if (isset($_GET['id'])) {
    $property_id = $_GET['id'];

    // Fetch the property details from the database
    $query = "SELECT * FROM properties WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $property_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $property = $result->fetch_assoc();

    if (!$property) {
        echo "Property not found.";
        exit;
    }
}

// Check if the form is submitted to update the property
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the updated data from the form
    $name = $_POST['name'];
    $location = $_POST['location'];
    $size = $_POST['size'];
    $type = $_POST['type'];
    $price = $_POST['price'];
    $agent_name = $_POST['agent_name'];
    $agent_contact = $_POST['agent_contact'];
    $image = $property['image'];


    if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
        $image_tmp_name = $_FILES['image']['tmp_name'];
        $image_name = basename($_FILES['image']['name']);
        $image_upload_path = "uploads/" . $image_name;

        if (!move_uploaded_file($image_tmp_name, $image_upload_path)) {
            echo "Failed to upload image.";
            exit;
        }

        $image = $image_upload_path;
    }


    // Update the property in the database
    $update_query = "UPDATE properties SET name = ?, location = ?, size = ?, type = ?, price = ?, agent_name = ?, agent_contact = ?, image = ? WHERE id = ?";
    $stmt = $conn->prepare($update_query);

    if ($stmt === false) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("ssssssisi", $name, $location, $size, $type, $price, $agent_name, $agent_contact, $image, $property_id);

    if ($stmt->execute()) {
        echo "Property updated successfully.";
        header("Location: property_listing.php");
        exit;
    } else {
        echo "Error updating property: " . $stmt->error;
    }
}
?>

<div class="container mt-5">

    <form method="POST" enctype="multipart/form-data">


        <div class="mb-3">
            <label for="name">Name:</label>
            <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($property['name']); ?>" required>
        </div>

        <div class="mb-3">
            <label for="location">Location:</label>
            <input type="text" class="form-control" id="location" name="location" value="<?php echo htmlspecialchars($property['location']); ?>" required>
        </div>

        <div class="mb-3">
            <label for="size">Size:</label>
            <input type="text" class="form-control" id="size" name="size" value="<?php echo htmlspecialchars($property['size']); ?>" required>
        </div>

        <div class="mb-3">
            <label for="status">Type:</label>
            <input type="text" class="form-control" id="type" name="type" value="<?php echo htmlspecialchars($property['type']); ?>" required>
        </div>

        <div class="mb-3">
            <label for="price">Price:</label>
            <input type="text" class="form-control" id="price" name="price" value="<?php echo htmlspecialchars($property['price']); ?>" required>
        </div>

        <div class="mb-3">
            <label for="agent">Agent:</label>
            <input type="text" class="form-control" id="agent" name="agent_name" value="<?php echo htmlspecialchars($property['agent_name']); ?>" required>
        </div>

        <div class="mb-3">
            <label for="contact">Contact:</label>
            <input type="text" class="form-control" id="contact" name="agent_contact" value="<?php echo htmlspecialchars($property['agent_contact']); ?>" required>
        </div>


        <div class="mb-3">
            <label for="image" class="form-label">Upload Image</label>
            <input type="file" class="form-control" id="image" name="image" accept="image/*">
        </div>

        <button class="btn btn-primary" type="submit">Update Property</button>
    </form>
</div>