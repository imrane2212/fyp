<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$message = ''; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $servername = "localhost";
    $username = "root"; 
    $password = ""; 
    $dbname = "db_k2111451"; 

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        $message = "<p>Connection failed: " . $conn->connect_error . "</p>";
    } else {

        $stmt = $conn->prepare("INSERT INTO medication_notes (medication, side_effects) VALUES (?, ?)");
        $stmt->bind_param("ss", $medication, $sideEffects);

        $medication = $_POST['medication'];
        $sideEffects = $_POST['sideEffects'];

        if ($stmt->execute()) {
            $message = "<p>Record added successfully.</p>";
        } else {
            $message = "Error: " . $stmt->error;
        }

        $stmt->close();
        $conn->close();
    }
}
?>

<div class="main-content">
<link rel="stylesheet" href="AddMedNotes.css">

    <h2>Add Medication Note</h2>
    <form action="" method="POST">
        <div class="form-group">
            <label for="medication">Medication:</label>
            <input type="text" id="medication" name="medication" required>
        </div>
        <div class="form-group">
            <label for="sideEffects">Side Effects:</label>
            <textarea id="sideEffects" name="sideEffects" required></textarea>
        </div>
        <button type="submit" class="button">Add Note</button>
    </form>
    <?php if (!empty($message)) echo $message; ?> 
    <button onclick="window.location.href='MedicationNotes.php'" class="button-back">
        <i class="fas fa-arrow-left"></i> Back to Medication Notes
    </button>
</div>
