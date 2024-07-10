<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Patient</title>
    <link rel="stylesheet" href="AddPatient.css"> 
</head>
<body>

<?php
session_start(); 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $servername = "localhost";
    $username = "root"; 
    $password = ""; 
    $dbname = "db_k2111451";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        $_SESSION['message'] = "Connection failed: " . $conn->connect_error;
        header("Location: AddPatient.php");
        exit;
    }

    $stmt = $conn->prepare("INSERT INTO patients (name, title, location, last_seen) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $patientName, $patientTitle, $patientLocation, $lastSeen);

    
    $patientName = $_POST['patientName'];
    $patientTitle = $_POST['patientTitle'];
    $patientLocation = $_POST['patientLocation'];
    $lastSeen = $_POST['lastSeen'];

    if ($stmt->execute()) {
        $_SESSION['message'] = "New record created successfully. Redirecting to patient list...";
        header("refresh:5;url=PatientOverview.php");
        exit;
    } else {
        $_SESSION['message'] = "Error: " . $stmt->error;
        header("Location: AddPatient.php"); 
        exit;
    }

    $stmt->close();
    $conn->close();
} else {

    if(isset($_SESSION['message'])) {
        echo "<p>".$_SESSION['message']."</p>";
        unset($_SESSION['message']);
    }
?>

<div class="main-content">
    <button onclick="window.location.href='PatientOverview.php'" class="button-back">
        <i class="fas fa-arrow-left"></i> Back
    </button>
    <h2>Add Patient</h2>
    <form id="addPatientForm" action="" method="POST">
        <div class="form-group">
            <label for="patientName">Name:</label>
            <input type="text" id="patientName" name="patientName" required>
        </div>
        <div class="form-group">
            <label for="patientTitle">Title:</label>
            <input type="text" id="patientTitle" name="patientTitle">
        </div>
        <div class="form-group">
            <label for="patientLocation">Location:</label>
            <input type="text" id="patientLocation" name="patientLocation" required>
        </div>
        <div class="form-group">
            <label for="lastSeen">Last Seen:</label>
            <input type="datetime-local" id="lastSeen" name="lastSeen">
        </div>
        <button type="submit" class="button">Add Patient</button>
    </form>
</div>

<?php
} 
?>

</body>
</html>
