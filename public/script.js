document.addEventListener("DOMContentLoaded", function() {
    fetchData();

    document.getElementById("darkModeToggle").addEventListener("click", function() {
        document.body.classList.toggle("dark-mode");
    });
});

function fetchData() {
    fetch("retrieve_data.php")
        .then(response => response.json())
        .then(data => {
            if (data.status === "success") {
                let tableRows = "";
                data.data.forEach(session => {
                    tableRows += `<tr>
                        <td>${session.session_id}</td>
                        <td>${session.soap_used ? "✔️ Yes" : "❌ No"}</td>
                        <td>${session.tap_start_time}</td>
                        <td>${session.tap_duration} sec</td>
                        <td>${session.dryer_used ? "✔️ Yes" : "❌ No"}</td>
                        <td>${session.reading_time}</td>
                    </tr>`;
                });
                document.getElementById("sessionData").innerHTML = tableRows;
            }
        })
        .catch(error => console.error("Error fetching data:", error));
}

function filterTable() {
    let searchValue = document.getElementById("search").value.toLowerCase();
    let rows = document.getElementById("sessionData").getElementsByTagName("tr");

    for (let row of rows) {
        row.style.display = row.innerText.toLowerCase().includes(searchValue) ? "" : "none";
    }
}


document.addEventListener("DOMContentLoaded", function() {
    fetchData();

    document.getElementById("darkModeToggle").addEventListener("click", function() {
        document.body.classList.toggle("dark-mode");
    });
});

function fetchData() {
    fetch("retrieve_data.php")
        .then(response => response.json())
        .then(data => {
            if (data.status === "success") {
                updateCharts(data.data);
            }
        })
        .catch(error => console.error("Error fetching data:", error));
}

function updateCharts(stats) {
    new Chart(document.getElementById("handwashChart"), {
        type: "line",
        data: {
            labels: stats.timestamps,
            datasets: [{ label: "Handwashing Sessions", data: stats.sessions }]
        }
    });

    new Chart(document.getElementById("soapChart"), {
        type: "bar",
        data: {
            labels: stats.timestamps,
            datasets: [{ label: "Soap Usage", data: stats.soap_used }]
        }
    });

    new Chart(document.getElementById("tapChart"), {
        type: "line",
        data: {
            labels: stats.timestamps,
            datasets: [{ label: "Tap Duration (sec)", data: stats.tap_durations }]
        }
    });

    new Chart(document.getElementById("dryerChart"), {
        type: "bar",
        data: {
            labels: stats.timestamps,
            datasets: [{ label: "Dryer Usage", data: stats.dryer_used }]
        }
    });
}

