<?php
require 'connection.php';


// Λειτουργία για την προβολή εργασιών σε κάθετη ανάπτυξη
function displayTasks($taskListId) {
    global $conn;
    
    // Ερώτημα για την ανάκτηση εργασιών μιας λίστας με αντίστροφη χρονολογική σειρά
    $stmt = $conn->prepare("SELECT * FROM tasks WHERE task_list_id = ? ORDER BY created_at DESC");
    $stmt->bind_param("i", $taskListId);
    $stmt->execute();
    $result = $stmt->get_result();

    // Έξοδος με μορφοποίηση για την κατάσταση των εργασιών
    echo "<ul>";
    while ($task = $result->fetch_assoc()) {
        $title = htmlspecialchars($task['title']);
        $status = htmlspecialchars($task['status']);

        // Διακριτή μορφοποίηση με βάση την κατάσταση
        $statusClass = '';
        switch ($status) {
            case 'Σε αναμονή':
                $statusClass = 'pending';
                break;
            case 'Σε εξέλιξη':
                $statusClass = 'in-progress';
                break;
            case 'Ολοκληρωμένη':
                $statusClass = 'completed';
                break;
        }

        echo "<li class='$statusClass'>$title ($status)</li>";
    }
    echo "</ul>";
}




// Δημιουργία Εργασίας
function createTask($title, $taskListId, $assignedTo = null) {
    global $conn;
    $stmt = $conn->prepare("INSERT INTO tasks (title, task_list_id, assigned_to) VALUES (?, ?, ?)");
    $stmt->bind_param("sii", $title, $taskListId, $assignedTo);
    $stmt->execute();
    return $stmt->insert_id;
}


// Λειτουργία για την ανάκτηση λιστών εργασιών που δημιούργησε ένας χρήστης
function getTaskListsByUser($userId) {
    global $conn;

    $stmt = $conn->prepare("SELECT * FROM task_lists WHERE created_by = ? ORDER BY created_at DESC");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();

    return $result->fetch_all(MYSQLI_ASSOC);
}

// Λειτουργία για την ανάκτηση εργασιών που έχουν ανατεθεί σε έναν χρήστη
function getAssignedTasks($userId) {
    global $conn;

    $stmt = $conn->prepare("SELECT * FROM tasks WHERE assigned_to = ? ORDER BY created_at DESC");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();

    return $result->fetch_all(MYSQLI_ASSOC);
}

// Προβολή των λιστών εργασιών που έχουν δημιουργηθεί από έναν χρήστη και αυτών με ανατεθειμένες εργασίες
function displayUserTaskLists($userId) {
    global $conn;

    // Προβολή των λιστών εργασιών που έχουν δημιουργηθεί από τον χρήστη
    $userTaskLists = getTaskListsByUser($userId);
    
    echo "<h3>Λίστες Εργασιών που Δημιούργησες:</h3>";
    
    foreach ($userTaskLists as $taskList) {
        $taskListId = $taskList['id'];
        $taskListTitle = htmlspecialchars($taskList['title']);
        
        echo "<h4>$taskListTitle</h4>";
        
        // Προβολή εργασιών στη συγκεκριμένη λίστα
        displayTasks($taskListId); // Κατακόρυφη ανάπτυξη
        
        echo "<hr>";
    }
    
    // Προβολή εργασιών που έχουν ανατεθεί σε άλλους
    $assignedTasks = getAssignedTasks($userId);
    
    echo "<h3>Λίστες Εργασιών με Ανατεθειμένες Εργασίες:</h3>";
    
    foreach ($assignedTasks as $task) {
        $taskListId = $task['task_list_id'];
        
        // Βρείτε το όνομα της λίστας εργασιών
        $stmt = $conn->prepare("SELECT title FROM task_lists WHERE id = ?");
        $stmt->bind_param("i", $taskListId);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $taskListTitle = $result->fetch_assoc()['title'];
        }
        
        echo "<h4>$taskListTitle</h4>";
        
        // Προβολή των εργασιών με τον κατάλληλο χρωματισμό κατάστασης
        displayTasks($taskListId);
        
        echo "<hr>";
    }
}


// Ανάθεση Εργασίας σε Άλλο Χρήστη
function assignTaskToUser($taskId, $username) {
    global $conn;
    // Αναζήτηση του χρήστη βάσει username
    $stmt = $conn->prepare("SELECT id FROM signup WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows == 0) {
        die("User not found");
    }
    
    $user = $result->fetch_assoc();
    $userId = $user['id'];
    
    // Ανάθεση εργασίας
    $stmt = $conn->prepare("UPDATE tasks SET assigned_to = ? WHERE id = ?");
    $stmt->bind_param("ii", $userId, $taskId);
    $stmt->execute();
}

// Διαγραφή Εργασίας
function deleteTask($taskId) {
    global $conn;
    $stmt = $conn->prepare("DELETE FROM tasks WHERE id = ?");
    $stmt->bind_param("i", $taskId);
    $stmt->execute();
}

function sendNotification($userId, $message) {
    require 'connection.php';

    // Fetch the user's Simplepush key
    $stmt = $conn->prepare("SELECT keyy FROM signup WHERE id = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $stmt->bind_result($simplepushKey);
    $stmt->fetch();
    $stmt->close();

    // Check if the user has a Simplepush key
    if ($simplepushKey) {
        $url = "https://api.simplepush.io/send";
        $data = array(
            'key' => $simplepushKey,
            'title' => 'New Task',
            'msg' => $message
        );

        $options = array(
            'http' => array(
                'header' => "Content-Type: application/json\r\n",
                'method' => 'POST',
                'content' => json_encode($data),
            ),
        );

        $context = stream_context_create($options);
        $result = file_get_contents($url, false, $context);

        if ($result === FALSE) {
            // Handle error
            echo "Notification failed to send.";
        }
    } else {
        // Handle case where user does not have a Simplepush key
        echo "User does not have a Simplepush key.";
    }
}


function getAssignedTasksByList($list_id, $user_id) {
    global $conn;

    $stmt = $conn->prepare("SELECT * FROM tasks WHERE task_list_id = ? AND assigned_to = ? ORDER BY created_at DESC");
    $stmt->bind_param("ii", $list_id, $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    return $result->fetch_all(MYSQLI_ASSOC);
}


?>