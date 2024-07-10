<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medication Tracker</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <link rel="stylesheet" href="PDashboard.css">
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
?>

<main>
    <div class="sidebar">
        <button><i class="fas fa-capsules"></i> Upcoming Medication</button>
        <button><i class="fas fa-book-medical"></i> Medication History</button>
        <button><i class="fas fa-bell"></i> Medication Reminders</button>
        <button onclick="window.location.href='MedicationNotesP.php'"><i class="fas fa-notes-medical"></i> Medication Notes</button>
        <div class="sidebar-bottom">
            <button><i class="fas fa-cog"></i> Settings</button>
            <button onclick="window.location.href='Login.php'"><i class="fas fa-sign-out-alt"></i> Log out</button>
        </div>
    </div>

    <section class="content">
        <div class="good-morning">
            <h1>Good morning!</h1>
            <p>Track your medication progress and adherence.</p>
        </div>

        <div class="medications">
            <h2>My medications</h2>
            <table>
                <thead>
                    <tr>
                        <th><i class="fas fa-tablets"></i> Medication</th>
                        <th><i class="fas fa-prescription-bottle"></i> Dosage</th>
                        <th><i class="fas fa-clock"></i> Due</th>
                        <th><i class="fas fa-check-square"></i> Consumed</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT id, medication_name, dosage, due_time, consumed FROM medications";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0): 
                        while($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?= htmlspecialchars($row["medication_name"]) ?></td>
                                <td><?= htmlspecialchars($row["dosage"]) ?></td>
                                <td><?= htmlspecialchars($row["due_time"]) ?></td>
                                <td><input type='checkbox' <?= $row["consumed"] ? "checked" : "" ?> disabled></td>
                            </tr>
                        <?php endwhile;
                    else: ?>
                        <tr><td colspan='4'>No medications found</td></tr>
                    <?php endif; 
                    $conn->close();
                    ?>
                </tbody>
            </table>
        </div>

        <div class="medication-adherence">
            <h2>Total medication adherence</h2>
            <div class="adherence-chart">
                <!-- Chart could be implemented here -->
            </div>
        </div>
    </section>

    <aside class="schedule">
        <!-- Schedule or additional content could go here -->
    </aside>
</main>
</body>
</html>
