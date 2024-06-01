<?php
include "connection.php";

session_start();
if (!isset($_SESSION['id'])) {
    die("Παρακαλώ συνδεθείτε για να δείτε αυτή τη σελίδα.");
}

$id = $_SESSION['id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["task_id"])) {
    $list_id = $_POST["task_id"]; // Μετατρέψτε σε ακέραιο για ασφάλεια

    // Προετοιμασία ερώτηματος διαγραφής με χρήση προετοιμασμένων δηλώσεων
    $stmt = $conn->prepare("DELETE FROM tasks WHERE assigned_to = ? AND id = ?");
    $stmt->bind_param("ii", $id, $list_id);
    $result = $stmt->execute();
    
    if ($result) {
        // Ανακατεύθυνση σε σελίδα επιτυχίας με μήνυμα
        header("Location: tasklist.php?msg=Task deleted successfully");
        exit; // Βεβαιωθείτε ότι η εκτέλεση σταματά εδώ
    } else {
        echo "Failed: " . $stmt->error;
    }
}
?>

