<?php
header("Content-Type: application/json");

// Database credentials
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sensor_readings";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname, 3306);

// Check connection
if ($conn->connect_error) {
    die(json_encode(["status" => "error", "message" => "Database connection failed: " . $conn->connect_error]));
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and validate POST data
    $soap_used = isset($_POST['soap_used']) ? intval($_POST['soap_used']) : 0;
    $tap_start_time = isset($_POST['tap_start_time']) ? $_POST['tap_start_time'] : null;
    $tap_duration = isset($_POST['tap_duration']) ? intval($_POST['tap_duration']) : 0;
    $dryer_used = isset($_POST['dryer_used']) ? intval($_POST['dryer_used']) : 0;
    $reading_time = isset($_POST['reading_time']) ? $_POST['reading_time'] : null;

    if (!is_null($tap_start_time) && !is_null($reading_time)) {
        // Secure insertion using prepared statements
        $stmt = $conn->prepare("INSERT INTO handwash_sessions (soap_used, tap_start_time, tap_duration, dryer_used, reading_time) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("isiss", $soap_used, $tap_start_time, $tap_duration, $dryer_used, $reading_time);

        if ($stmt->execute()) {
            echo json_encode(["status" => "success", "message" => "Data inserted successfully!"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Database insertion failed: " . $stmt->error]);
        }
        $stmt->close();
    } else {
        echo json_encode(["status" => "error", "message" => "Invalid input: Ensure all required fields are provided."]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "No POST data received."]);
}

// Close database connection
$conn->close();
?>
