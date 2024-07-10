<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Patients List</title>
<link rel="stylesheet" type="text/css" href="Poverview.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
</head>
<body>

<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection settings
$servername = "localhost";
$username = "root"; // Replace with your MySQL username
$password = ""; // Replace with your MySQL password
$dbname = "db_k2111451"; // Replace with your database name

// Create database connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL to fetch patients
$sql = "SELECT name, title, location, last_seen FROM patients";
$result = $conn->query($sql);
?>

<div class="sidebar">
    <button><i class="fas fa-capsules"></i> Upcoming Medication</button>
    <button><i class="fas fa-book-medical"></i> Medication History</button>
    <button><i class="fas fa-bell"></i> Medication Reminders</button>
    <button onclick="window.location.href='MedicationNotes.php'"><i class="fas fa-notes-medical"></i> Medication Notes</button>
    <div class="sidebar-bottom">
        <button><i class="fas fa-cog"></i> Settings</button>
        <button onclick="window.location.href='Login.php'"><i class="fas fa-sign-out-alt"></i> Log out</button>
    </div>
</div>

<div class="main-content">
    <header>
        <div class="welcome-back">
            <i class="fas fa-user-md"></i>
            <span>Welcome back, Doctor</span>
        </div>
        <input type="text" id="patientSearch" placeholder="Search patients..." onkeyup="searchPatients()">
        <button onclick="window.location.href='AddPatient.php'" class="add-patient-btn" style="float: right; margin-right: 20px;">
            <i class="fas fa-user-plus"></i> Add Patient
        </button>
    </header>

    <div class="patients-list">
        <h1>Patients</h1>
        <table class="patients-table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Title</th>
                    <th>Location</th>
                    <th>Last Seen</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php while($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= htmlspecialchars($row["name"]) ?></td>
                            <td><?= htmlspecialchars($row["title"]) ?></td>
                            <td><?= htmlspecialchars($row["location"]) ?></td>
                            <td><?= htmlspecialchars($row["last_seen"]) ?></td>
                            <td><button onclick="window.location.href='SpecificPatient.php'">Details</button></td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr><td colspan="5">No patients found</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <footer>
    </footer>
</div>

<script>
function searchPatients() {
    var input, filter, table, tr, td, i, txtValue;
    input = document.getElementById("patientSearch");
    filter = input.value.toUpperCase();
    table = document.querySelector(".patients-table");
    tr = table.getElementsByTagName("tr");

    for (i = 0; i < tr.length; i++) {
        td = tr[i].getElementsByTagName("td")[0];
        if (td) {
            txtValue = td.textContent || td.innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                tr[i].style.display = "";
            } else {
                tr[i].style.display = "none";
            }
        }
    }
}
</script>

<?php
$conn->close();
?>

</body>
</html>
