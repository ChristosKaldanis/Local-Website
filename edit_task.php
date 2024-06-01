<?php
// Include the database connection file
require 'connection.php';

// Start the session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['id'])) {
    die("Παρακαλώ συνδεθείτε για να δείτε αυτή τη σελίδα.");
}

$user_id = $_SESSION['id'];

// Handle list creation
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    $list_id = htmlspecialchars($_POST['task_id']);
    $title = htmlspecialchars($_POST['title']);
    $created_at = date("Y-m-d H:i:s");
    $status = htmlspecialchars($_POST['status']);    

    // Prepare and bind the SQL statement
    $stmt = $conn->prepare("UPDATE tasks SET title = ?, status = ? WHERE assigned_to = ? AND id = ?");
    $stmt->bind_param("ssii", $title, $status, $user_id, $list_id);

    if ($stmt->execute()) {
        // Redirect to the task list page with a success message
        header("Location: tasklist.php?msg=Task updated successfully");
    } else {
        echo "Failed: " . $stmt->error;
    }
}
?>

