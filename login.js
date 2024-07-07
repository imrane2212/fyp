function validateLogin() {
    var email = document.getElementById("email").value;
    var password = document.getElementById("password").value;
    
    // Check for patient login
    if(email == "patient@example.com" && password == "1234") {
        window.location.href = "PDashboard.html";
        return false;
    } 
    // Check for admin login
    else if(email == "admin@example.com" && password == "1234") {
        window.location.href = "PatientOverview.html";
        return false;
    }
    // If credentials do not match either user
    else {
        alert("Invalid email or password. Please try again.");
        return false;
    }
}
