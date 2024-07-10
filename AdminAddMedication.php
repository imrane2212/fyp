<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_k2111451";
$message = '';
$error = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $medicationName = $conn->real_escape_string($_POST['medicationName']);
    $lastTaken = !empty($_POST['lastTaken']) ? $conn->real_escape_string($_POST['lastTaken']) : NULL;
    $nextDue = $conn->real_escape_string($_POST['nextDue']);
    $sql = "INSERT INTO patient_medication_overview (medication, last_taken, next_due) VALUES (?, ?, ?)";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("sss", $medicationName, $lastTaken, $nextDue);
        if ($stmt->execute()) {
            $message = "Medication added successfully.";
        } else {
            $error = "Error adding medication: " . $stmt->error;
        }
        $stmt->close();
    } else {
        $error = "Error preparing statement: " . $conn->error;
    }
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Medication</title>
    <link rel="stylesheet" href="AddPatient.css"> 
</head>
<body>

<div class="main-content">
    <button onclick="window.location.href='SpecificPatient.php'" class="button-back">
        <i class="fas fa-arrow-left"></i> Back
    </button>
    <h2>Add Medication</h2>
    
    <?php if(!empty($message)): ?>
        <div class="alert success"><?= $message; ?></div>
    <?php endif; ?>
    <?php if(!empty($error)): ?>
        <div class="alert error"><?= $error; ?></div>
    <?php endif; ?>
    
    <form action="AdminAddMedication.php" method="post">
        <div class="form-group">
            <label for="medicationName">Medication Name:</label>
            <input type="text" id="medicationName" name="medicationName" required>
        </div>
        <div class="form-group">
            <label for="lastTaken">Last Taken Medication:</label>
            <input type="datetime-local" id="lastTaken" name="lastTaken">
        </div>
        <div class="form-group">
            <label for="nextDue">Next Due:</label>
            <input type="datetime-local" id="nextDue" name="nextDue" required>
        </div>
        <button type="submit" class="button">Add Medication</button>
    </form>
</div>

</body>
</html>
