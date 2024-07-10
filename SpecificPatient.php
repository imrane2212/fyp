<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Overview</title>
    <link rel="stylesheet" href="Spatient.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
</head>
<body>

<?php
// Enable error reporting for debugging
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

// SQL to fetch patient medication overview
$sql = "SELECT medication, last_taken, next_due FROM patient_medication_overview";
$result = $conn->query($sql);
?>

    <div class="sidebar">
        <button onclick="window.location.href='UpcomingMedication.html'"><i class="fas fa-capsules"></i> Upcoming Medication</button>
        <button onclick="window.location.href='MedicationHistory.html'"><i class="fas fa-book-medical"></i> Medication History</button>
        <button onclick="window.location.href='MedicationReminders.html'"><i class="fas fa-bell"></i> Medication Reminders</button>
        <button onclick="window.location.href='MedicationNotesP.php'"><i class="fas fa-notes-medical"></i> Medication Notes</button>
        <div class="sidebar-bottom">
            <button onclick="window.location.href='Settings.html'"><i class="fas fa-cog"></i> Settings</button>
            <button onclick="window.location.href='Login.php'"><i class="fas fa-sign-out-alt"></i> Log out</button>
        </div>
    </div>

    <div class="main-content">
        <h2 class="patient-heading">Patient Overview</h2>
        <table class="patient-list">
            <thead>
                <tr>
                    <th>Medication</th>
                    <th>Last Taken Medication</th>
                    <th>Next Due</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php while($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= htmlspecialchars($row["medication"]) ?></td>
                            <td><?= $row["last_taken"] ? date("H:i", strtotime($row["last_taken"])) : "NOT TAKEN" ?></td>
                            <td><?= date("H:i", strtotime($row["next_due"])) ?></td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr><td colspan="3">No medication records found</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
        <div class="button-container" style="text-align: center; margin-top: 20px;">
            <button onclick="window.location.href='PatientOverview.php'" class="button-back">
                <i class="fas fa-arrow-left"></i> Back
            </button>
            <button onclick="window.location.href='AdminAddMedication.php'" class="button">Add Medication</button>
        </div>
    </div>

<?php
$conn->close();
?>

</body>
</html>
