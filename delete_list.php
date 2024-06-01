<?php
include "connection.php";

session_start();
if (!isset($_SESSION['id'])) {
    die("Παρακαλώ συνδεθείτε για να δείτε αυτή τη σελίδα.");
}

$id = $_SESSION['id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["list_id"])) {
    $list_id = intval($_POST["list_id"]); // Μετατρέψτε σε ακέραιο για ασφάλεια

    // Προετοιμασία ερώτηματος διαγραφής με χρήση προετοιμασμένων δηλώσεων
    $stmt = $conn->prepare("DELETE FROM task_lists WHERE id = ? AND created_by = ?");
    $stmt->bind_param("ii", $list_id, $id);
    $result = $stmt->execute();
    
    if ($result) {
        // Ανακατεύθυνση σε σελίδα επιτυχίας με μήνυμα
        header("Location: tasklist.php?msg=List deleted successfully");
        exit; // Βεβαιωθείτε ότι η εκτέλεση σταματά εδώ
    } else {
        echo "Failed: " . $stmt->error;
    }
}
?>

