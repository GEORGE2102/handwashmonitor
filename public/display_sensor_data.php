<?php
// Database connection credentials
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sensor_readings";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to fetch data from the `sensor_data` table
$sql = "SELECT id, sensor1_value, sensor2_value, sensor3_value, reading_time FROM sensor_data";
$result = $conn->query($sql);

?>
<!DOCTYPE html>
<html>
<head>
    <title>Sensor Data</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1>Sensor Data</h1>
    <table>
        <tr>
            <th>ID</th>
            <th>Sensor 1 Value</th>
            <th>Sensor 2 Value</th>
            <th>Sensor 3 Value</th>
            <th>Reading Time</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            // Output data of each row
            while($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>" . $row["id"] . "</td>
                        <td>" . $row["sensor1_value"] . "</td>
                        <td>" . $row["sensor2_value"] . "</td>
                        <td>" . $row["sensor3_value"] . "</td>
                        <td>" . $row["reading_time"] . "</td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='5'>No data available</td></tr>";
        }
        $conn->close();
        ?>
    </table>
</body>
</html>
