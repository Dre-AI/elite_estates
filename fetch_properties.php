<?php
include 'databaseconnect.php';

if (isset($_GET['type'])) {
    $type = $_GET['type'];
    $query = "SELECT * FROM properties WHERE type = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $type);
    $stmt->execute();
    $result = $stmt->get_result();

    $properties = [];
    while ($row = $result->fetch_assoc()) {
        $properties[] = $row;
    }

    echo json_encode($properties);
}
?>
