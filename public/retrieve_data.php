<?php
header("Content-Type: application/json");

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "hygiene_monitor";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(["status" => "error", "message" => "Database connection failed: " . $conn->connect_error]));
}

// Retrieve handwash session data
$sql = "SELECT * FROM handwash_sessions ORDER BY reading_time DESC";
$result = $conn->query($sql);

// Prepare data for charts
$data = ["sessions" => 0, "soap_used" => 0, "tap_durations" => [], "dryer_used" => 0, "timestamps" => []];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data["sessions"]++;
        if ($row["soap_used"]) $data["soap_used"]++;
        if ($row["dryer_used"]) $data["dryer_used"]++;
        $data["tap_durations"][] = $row["tap_duration"];
        $data["timestamps"][] = $row["reading_time"];
    }
}

echo json_encode(["status" => "success", "data" => $data]);

$conn->close();
?>
