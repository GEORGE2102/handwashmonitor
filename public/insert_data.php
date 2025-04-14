<?php
require_once '../includes/db_connect.php'; // DB connection

// Check if the POST data is available
if (isset($_POST['sensor1_value'], $_POST['sensor2_value'], $_POST['sensor3_value'])) {
    $sensor1 = (int) $_POST['sensor1_value'];
    $sensor2 = (int) $_POST['sensor2_value'];
    $sensor3 = (int) $_POST['sensor3_value'];
    $time = date('Y-m-d H:i:s');

    // Prepare SQL statement
    $sql = "INSERT INTO sensor_data (sensor1_value, sensor2_value, sensor3_value, reading_time)
            VALUES (?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iiis", $sensor1, $sensor2, $sensor3, $time);

    if ($stmt->execute()) {
        echo "Data inserted successfully";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "Invalid request";
}

$conn->close();
?>
