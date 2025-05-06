<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Handwash Monitoring Dashboard</title>
    <link rel="stylesheet" href="css/styles.css">
    <script defer src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script defer src="js/script.js"></script>
</head>
<body>

    <header>
        <h1>🚰 Handwash Monitoring Dashboard</h1>
        <button id="darkModeToggle">🌗 Toggle Dark Mode</button>
    </header>

    <div class="chart-container">
        <canvas id="handwashChart"></canvas>
        <canvas id="soapChart"></canvas>
        <canvas id="tapChart"></canvas>
        <canvas id="dryerChart"></canvas>
    </div>

</body>
</html>
