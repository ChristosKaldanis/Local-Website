<?php

require 'connection.php';


session_start();


if (!isset($_SESSION['id'])) {
    die("Παρακαλώ συνδεθείτε για να δείτε αυτή τη σελίδα.");
}

$user_id = $_SESSION['id'];

// Handle list creation
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    $title = htmlspecialchars($_POST['title']); 
    $created_at = date("Y-m-d H:i:s");

    // Prepare and bind the SQL statement
    $stmt = $conn->prepare("INSERT INTO task_lists (title, created_at, created_by) VALUES (?, ?, ?) ");
    $stmt->bind_param("sss", $title, $created_at, $user_id);

    // Execute the statement and check for success
    if ($stmt->execute()) {
        // Redirect to the task list page with a success message
        header("Location: tasklist.php?msg=List created successfully");
    } else {
        echo "Failed: " . $stmt->error;
    }
}
?>





<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
  <link rel="stylesheet" href="style4.css">

  <title>Create List</title>
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
            <li><a href="signout.php"> Sign Out</a></li>
        </ul>
  </nav>

  <div class="container">
    <h1>Δημιουργία Νέας Λίστας Εργασιών</h1>
    <form method="post" action="">
        <div class="mb-3">
            <label for="title" class="form-label">Τίτλος Λίστας</label>
            <input type="text" class="form-control" id="title" name="title" required>
        </div>
        <button type="submit" name="submit" class="btn btn-primary">Δημιουργία Λίστας</button>
    </form>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

</body>

</html>
