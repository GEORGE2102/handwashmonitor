<?php
$servername = "localhost";
$username = "root";  // Default for local servers
$password = "";      // Default is empty in XAMPP
$dbname = "sensor_data";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT sensor1_value, sensor2_value, sensor3_value, reading_time FROM sensor_readings ORDER BY reading_time DESC LIMIT 100";
$result = $conn->query($sql);

$sensor1 = [];
$sensor2 = [];
$sensor3 = [];
$timestamps = [];

while ($row = $result->fetch_assoc()) {
    $sensor1[] = $row['sensor1_value'];
    $sensor2[] = $row['sensor2_value'];
    $sensor3[] = $row['sensor3_value'];
    $timestamps[] = $row['reading_time'];
}

$data = [
    'sensor1' => array_reverse($sensor1),
    'sensor2' => array_reverse($sensor2),
    'sensor3' => array_reverse($sensor3),
    'timestamps' => array_reverse($timestamps)
];

header('Content-Type: application/json');
echo json_encode($data);
$conn->close();
?>
