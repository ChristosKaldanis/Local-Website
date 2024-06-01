<?php
// login.php
include 'connection.php';

session_start();

// Get email and password from form submission
$email = $_POST['email'];
$password = $_POST['pass'];

// Prepare SQL query to retrieve user with matching email
$stmt = $conn->prepare("SELECT id, password FROM signup WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

// Check if a user with the given email exists
if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();

    // Verify if the plaintext password matches
    if (password_verify($password, $user['password'])) {
        // Successful login
        $_SESSION['id'] = $user['id']; // Store the user ID in session
        echo "Login successful!";
        echo "<script> window.location.href = 'welcome.php'; </script>";
    } else {
        echo "Incorrect password.";
    }
} else {
    echo "No user found with the given email.";
}


?>