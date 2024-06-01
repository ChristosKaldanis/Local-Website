<?php
// Include the database connection file
require 'connection.php';
require 'functiontasks.php';

// Start the session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['id'])) {
    die("Παρακαλώ συνδεθείτε για να δείτε αυτή τη σελίδα.");
}

$user_id = $_SESSION['id'];

// Handle list creation
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    $list_id = htmlspecialchars($_POST['list_id']);
    $title = htmlspecialchars($_POST['title']);
    $created_at = date("Y-m-d H:i:s");
    $status = htmlspecialchars($_POST['status']);  

    // Prepare and bind the SQL statement
    $stmt = $conn->prepare("INSERT INTO tasks (title, created_at, status, task_list_id, assigned_to ) VALUES (?, ?, ?, ?, ?) ");
    $stmt->bind_param("sssii", $title, $created_at, $status, $list_id, $user_id);

    if ($stmt->execute()) {

        sendNotification($user_id, "Δημιουργήθηκε Εργασία με τίτλο: $title");

        // Redirect to the task list page with a success message
        header("Location: tasklist.php?msg=Task created successfully");
    } else {
        echo "Failed: " . $stmt->error;
    }
}
?>


