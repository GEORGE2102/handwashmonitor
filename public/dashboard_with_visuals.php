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
$sql = "SELECT id, sensor1_value, sensor2_value, sensor3_value, reading_time FROM sensor_data ORDER BY reading_time ASC";
$result = $conn->query($sql);

$data = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sensor Data Dashboard</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> <!-- Chart.js -->
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f9f9f9;
        }
        h1 {
            text-align: center;
            color: #333;
        }
        .table-container {
            margin-bottom: 30px;
            overflow-x: auto;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 8px;
            text-align: center;
        }
        th {
            background-color: #007BFF;
            color: white;
        }
        .charts-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
        }
        canvas {
            background: white;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
    <h1>Sensor Data Dashboard</h1>
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Sensor 1 Value</th>
                    <th>Sensor 2 Value</th>
                    <th>Sensor 3 Value</th>
                    <th>Reading Time</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($data as $row) {
                    echo "<tr>
                            <td>" . $row["id"] . "</td>
                            <td>" . $row["sensor1_value"] . "</td>
                            <td>" . $row["sensor2_value"] . "</td>
                            <td>" . $row["sensor3_value"] . "</td>
                            <td>" . $row["reading_time"] . "</td>
                          </tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
    <div class="charts-container">
        <canvas id="sensor1Chart"></canvas>
        <canvas id="sensor2Chart"></canvas>
        <canvas id="sensor3Chart"></canvas>
    </div>
    <script>
        // Fetch data from PHP
        const data = <?php echo json_encode($data); ?>;
        const labels = data.map(row => row.reading_time);
        const sensor1Values = data.map(row => row.sensor1_value);
        const sensor2Values = data.map(row => row.sensor2_value);
        const sensor3Values = data.map(row => row.sensor3_value);

        // Create charts
        function createChart(canvasId, label, dataValues, backgroundColor, borderColor) {
            const ctx = document.getElementById(canvasId).getContext('2d');
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: label,
                        data: dataValues,
                        backgroundColor: backgroundColor,
                        borderColor: borderColor,
                        borderWidth: 2,
                        tension: 0.4, // Smooth curves
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'top',
                            labels: {
                                font: {
                                    size: 14
                                }
                            }
                        }
                    },
                    scales: {
                        x: {
                            title: {
                                display: true,
                                text: 'Time',
                                color: '#333',
                                font: { size: 12 }
                            }
                        },
                        y: {
                            title: {
                                display: true,
                                text: 'Sensor Values',
                                color: '#333',
                                font: { size: 12 }
                            }
                        }
                    },
                    layout: {
                        padding: 10
                    }
                }
            });
        }

        // Charts for each sensor
        createChart("sensor1Chart", "Sensor 1 Values", sensor1Values, "rgba(75, 192, 192, 0.2)", "rgba(75, 192, 192, 1)");
        createChart("sensor2Chart", "Sensor 2 Values", sensor2Values, "rgba(255, 99, 132, 0.2)", "rgba(255, 99, 132, 1)");
        createChart("sensor3Chart", "Sensor 3 Values", sensor3Values, "rgba(54, 162, 235, 0.2)", "rgba(54, 162, 235, 1)");
    </script>
</body>
</html>
