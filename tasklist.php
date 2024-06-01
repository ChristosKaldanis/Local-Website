<?php
// Κάντε include τη σύνδεση με τη βάση δεδομένων και τυχόν άλλες απαραίτητες λειτουργίες
require 'connection.php'; // Βεβαιωθείτε ότι έχετε τη σωστή σύνδεση με τη βάση δεδομένων
require 'functiontasks.php'; // Για την προβολή λιστών και εργασιών

session_start();

define("SESSION_TIMEOUT", 240); //240 sec = 4 minutes
if (!isset($_SESSION['id'])) {
    die("Παρακαλώ συνδεθείτε για να δείτε αυτή τη σελίδα.");
}

// Check for session timeout
if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > SESSION_TIMEOUT)) {
    // Last request was more than SESSION_TIMEOUT seconds ago
    session_unset(); // Unset session variables
    session_destroy(); // Destroy the session
    header("Location: signin.php?msg=Η συνεδρία σας έχει λήξει. Παρακαλώ συνδεθείτε ξανά.");
    exit;
}

// Update last activity time
$_SESSION['LAST_ACTIVITY'] = time();

$user_id = $_SESSION['id'];



// Χειρισμός δημιουργίας νέας λίστας
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['deleteList'])) {
    // Ο κώδικάς σας για τη δημιουργία εργασίας

    // Ανακατεύθυνση σε άλλη σελίδα μετά τη δημιουργία εργασίας
    header("Location: delete_list.php");
    exit; // Επιβεβαιώνει ότι η ανακατεύθυνση ολοκληρώθηκε και αποτρέπει περαιτέρω εκτέλεση κώδικα

}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['createTask'])) {
    // Ο κώδικάς σας για τη δημιουργία εργασίας

    // Ανακατεύθυνση σε άλλη σελίδα μετά τη δημιουργία εργασίας
    header("Location: createtask.php");
    exit; // Επιβεβαιώνει ότι η ανακατεύθυνση ολοκληρώθηκε και αποτρέπει περαιτέρω εκτέλεση κώδικα

}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['createList'])) {
    // Ο κώδικάς σας για τη δημιουργία εργασίας

    // Ανακατεύθυνση σε άλλη σελίδα μετά τη δημιουργία εργασίας
    header("Location: createlist.php");
    exit; // Επιβεβαιώνει ότι η ανακατεύθυνση ολοκληρώθηκε και αποτρέπει περαιτέρω εκτέλεση κώδικα

}

// Χειρισμός διαγραφής λίστας
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_list'])) {
    $list_id = intval($_POST['list_id']); // Μετατρέψτε σε ακέραιο για ασφάλεια
    
    // Ελέγξτε αν η λίστα ανήκει στον τρέχοντα χρήστη
    $stmt = $conn->prepare("SELECT * FROM task_lists WHERE id = ? AND created_by = ?");
    $stmt->bind_param("ii", $list_id, $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $stmt = $conn->prepare("DELETE FROM task_lists WHERE id = ?");
        $stmt->bind_param("i", $list_id);
        $stmt->execute();
        
        echo "Η λίστα διαγράφηκε επιτυχώς!";
    } else {
        echo "Δεν επιτρέπεται να διαγράψετε αυτή τη λίστα.";
    }
}

// Δημιουργία Εργασίας
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['createTask'])) {
    // Ο κώδικάς σας για τη δημιουργία εργασίας

    // Ανακατεύθυνση σε άλλη σελίδα μετά τη δημιουργία εργασίας
    header("Location: createtask.php");
    exit; // Επιβεβαιώνει ότι η ανακατεύθυνση ολοκληρώθηκε και αποτρέπει περαιτέρω εκτέλεση κώδικα
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['editTask'])) {
    // Ο κώδικάς σας για τη δημιουργία εργασίας

    // Ανακατεύθυνση σε άλλη σελίδα μετά τη δημιουργία εργασίας
    header("Location: edit_task.php");
    exit; // Επιβεβαιώνει ότι η ανακατεύθυνση ολοκληρώθηκε και αποτρέπει περαιτέρω εκτέλεση κώδικα
}


    


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['assign_task'])) {

    require 'connection.php';

    $assigned_to = htmlspecialchars($_POST['assigned_to']); // Προστασία από XSS
    $title = htmlspecialchars($_POST['title']); // Προστασία από XSS
    $task_list_id = intval($_POST['task_list_id']);

    
    // Βρείτε τον χρήστη με βάση το όνομα χρήστη που δόθηκε
    $stmt = $conn->prepare("SELECT id FROM signup WHERE username = ?");
    $stmt->bind_param("s", $assigned_to);
    $stmt->execute();
    $result = $stmt->get_result();
    
    // Εάν βρεθεί ο χρήστης, αναθέστε την εργασία σε αυτόν
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $assigned_to = $row['id'];
        
        // Εισαγωγή της εργασίας στη βάση δεδομένων
        $stmt = $conn->prepare("INSERT INTO tasks (title, task_list_id, assigned_to) VALUES (?, ?, ?)");
        $stmt->bind_param("sii", $title, $task_list_id, $assigned_to);
        $stmt->execute();
        
        echo "Η εργασία ανατέθηκε επιτυχώς στον χρήστη με όνομα χρήστη $assigned_to.";
        sendNotification($user_id, "Ανάθεση Εργασίας με τίτλο: $title");
    } else {
        echo "Δεν βρέθηκε χρήστης με το συγκεκριμένο όνομα χρήστη.";
    }
}
?>

<!DOCTYPE html>
<html lang="el">
<head>
    <meta charset="UTF-8">
    <title>Διαχείριση Λίστας Εργασιών</title>
    
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

    <link rel="stylesheet" href="style4.css">
    
    
</head>
<body>
<header>
        <h1 class="main-heading">Department of Informatics</h1>
        <p>Ionian University</p>
  </header>
  <nav class = "navbar">
        <ul>
            <li><a href="welcome.php"> Manage Profile</a></li>
            <li><a href="tasklist.php"> Lists and Tasks</a></li>
            <li><a href="search_list.php"> Search Lists </a></li>
            <li><a href="search_task.php"> Search Tasks </a></li>
            <li><a href="xml.php"> Export to XML </a></li>
            <li><a href="signout.php"> Sign Out</a></li>
        </ul>
  </nav>

    <h1>Διαχείριση Λίστας Εργασιών</h1>
    
    <!-- Φόρμα δημιουργίας νέας λίστας -->
    
    <div class="signup-container">
    <h2>Ανάθεση Εργασίας σε Άλλους Χρήστες</h2>
    <form method="post" action="">
        <label for="assigned_to">Username:</label>
        <input type="text" name="assigned_to" id="assigned_to" required>

        <label for="task_list_id">Επιλογή Λίστας:</label>
        <select name="task_list_id" id="task_list_id" required>
            <option value="">No list</option>
            <?php
            // Include the database connection file
            require 'connection.php';

            // Fetch all task lists from the database
            $sql = "SELECT id, title FROM task_lists";
            $result = $conn->query($sql);

            // Check if any task lists are found
            if ($result->num_rows > 0) {
                // Output data of each row
                while ($row = $result->fetch_assoc()) {
                    $list_id = htmlspecialchars($row['id']);
                    $list_title = htmlspecialchars($row['title']);
                    echo "<option value='$list_id'>$list_id - $list_title</option>";
                }
            } else {
                echo "<option value='' disabled>No task lists available</option>";
            }
            ?>
        </select>

        <label for="title">Τίτλος Εργασίας:</label>
        <input type="text" name="title" id="title" required>


        <button type="submit" name="assign_task">Ανάθεση Εργασίας</button>
    </form>
</div>
    
    
   
    <?php

    $user_task_lists = getTaskListsByUser($user_id);
    
    if (count($user_task_lists) > 0) {
        echo "<ul>";
        foreach ($user_task_lists as $task_list) {
            $task_list_title = htmlspecialchars($task_list['title']); // Προστασία από XSS
            $task_list_id = $task_list['id'];
            
            echo "<h2>Οι Λίστες σου:$task_list_title";
            echo "<li>";
            echo "<form method='post' action='delete_list.php' style='display: inline-block;'>";
            echo "<input type='hidden' name='list_id' value='$task_list_id'>";
            echo "<button type='submit' name='submit' style='background-color: #ff4c4c' onclick='return confirm(\"Είστε σίγουροι;\");'>Delete</button>";
            echo "</form>";
            echo "<form method='post' action='createlist.php' style='display: inline-block; margin-left: 10px;'>";
            echo "<input type='hidden' name='list_id' value='$task_list_id'>";
            echo "<label for='title' class='form-label'>Τίτλος Λίστας</label>";
            echo "<input type='text' class='form-control' id='title' name='title' required>";
            echo "<button type='submit' name='submit' style='background-color: #4caf50' onclick='return confirm(\"Είστε σίγουροι;\");'>Create</button>";
            echo "</form>";
            echo "</li>";
            
        }
        echo "</ul>";
    } else {
        echo "Δεν υπάρχουν λίστες εργασιών.";
    }

    
    
    $user_tasks = getAssignedTasks($user_id);


    
        
    if (count($user_tasks) > 0) {
        echo "<ul>";
        foreach ($user_task_lists as $task_list) {
            $task_list_id = $task_list['id'];
            echo "<h2>Οι Εργασίες σου στη Λίστα: {$task_list['title']}</h2>";
            echo "<li>";
            $tasks = getAssignedTasksByList($task_list_id, $user_id);
         foreach ($tasks as $task) {
                $task_id = $task['id'];
                $task_title = htmlspecialchars($task['title']);
                $task_status = htmlspecialchars($task['status']); // Protect against XSS
                
                // Display task details
                echo "<li>$task_title</li>";
                echo "<li>$task_status</li>";
                echo "<form method='post' action='delete_task.php' style='display: inline-block;'>";
                echo "<input type='hidden' name='list_id' value='$task_list_id'>";
                echo "<input type='hidden' name='task_id' value='$task_id'>";
                echo "<button type='submit' name='submit' style='background-color: #ff4c4c' onclick='return confirm(\"Είστε σίγουροι;\");'>Delete</button>";
                echo "</form>";
                echo "<form method='post' action='edit_task.php' style='display: inline-block; margin-left: 10px;'>";
                echo "<input type='hidden' name='list_id' value='$task_list_id'>";
                echo "<input type='hidden' name='task_id' value='$task_id'>";
                echo "<label for='title' class='form-label'>Τίτλος Εργασίας</label>";
                echo "<input type='text' class='form-control' id='title' name='title' required>";
                echo "<label for='status' class='form-label'>Κατάσταση</label>";
                echo "<input type='text' class='form-control' id='status' name='status' required>";
                echo "<button type='submit' name='submit' style='background-color: #007bff' onclick='return confirm(\"Είστε σίγουροι;\");'>Edit</button>";
                echo "</form>";
                echo "<form method='post' action='createtask.php' style='display: inline-block; margin-left: 10px;'>";
                echo "<input type='hidden' name='list_id' value='$task_list_id'>";
                echo "<label for='title' class='form-label'>Τίτλος Εργασίας</label>";
                echo "<input type='text' class='form-control' id='title' name='title' required>";
                echo "<label for='status' class='form-label'>Κατάσταση</label>";
                echo "<input type='text' class='form-control' id='status' name='status' required>";
                echo "<button type='submit' name='submit' style='background-color: #4caf50' onclick='return confirm(\"Είστε σίγουροι;\");'>Create</button>";
                echo "</form>";
                echo "</li>";}
            
        }
        echo "</ul>";
    } else {
        echo "Δεν υπάρχουν εργασίες.";
    }

    

    ?>
    
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/darkmode-js@1.5.7/lib/darkmode-js.min.js"></script>
    <script src="script.js"></script>
</body>
</html>
