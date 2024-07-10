<?php
// Start the session
session_start();

// Only process the POST request if it's submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Database connection variables
    $servername = "localhost";
    $username = "root"; // Use your MySQL username
    $password = ""; // Use your MySQL password
    $dbname = "db_k2111451"; // Use your database name

    // Create database connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Capture and sanitize form data
    $email = $conn->real_escape_string($_POST['email']);
    $formPassword = $conn->real_escape_string($_POST['password']); // This is the plain text password

    // SQL query to fetch the user by email
    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        // Compare passwords directly
        if ($formPassword === $row['password']) { // Direct comparison instead of password_verify()
            // Authentication successful
            $_SESSION['loggedin'] = true;
            $_SESSION['userid'] = $row['id'];
            $_SESSION['role'] = $row['role'];

            // Redirect based on role
            if ($row['role'] === 'admin') {
                header("Location: PatientOverview.php");
                exit;
            } else {
                header("Location: PDashboard.php");
                exit;
            }
        } else {
            // Incorrect password
            $_SESSION['error'] = 'Incorrect password.';
            header("Location: login.php"); // Redirect to login page to show error
            exit;
        }
    } else {
        // User not found
        $_SESSION['error'] = 'User not found.';
        header("Location: login.php"); // Redirect to login page to show error
        exit;
    }

    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="login-form">
        <h1>Welcome Back!</h1>
        <p>Sign in to stay on track with your medications.</p>
        
        <?php if (isset($_SESSION['error'])): ?>
            <div class="error-message"><?= htmlspecialchars($_SESSION['error']) ?></div>
            <?php unset($_SESSION['error']); // Clear the error message from session ?>
        <?php endif; ?>
        
        <form action="login.php" method="post">
            <label for="email">Enter your email address:</label>
            <input type="email" id="email" name="email" placeholder="example@example.com" required>
            
            <label for="password">Enter your password:</label>
            <input type="password" id="password" name="password" required>
            
            <button type="submit">Sign In</button>
        </form>
    </div>
</body>
</html>
