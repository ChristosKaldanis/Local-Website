<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Αναζήτησε Λίστες</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="style3.css" rel="stylesheet">
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

    <div class="container">
        <h2 class="mt-5 mb-4">Αναζήτησε Λίστες Εργασιών</h2>
        <form action="" method="post" class="mb-4">
            <div class="row">
                <div class="col-md-6">
                    <div class="input-group">
                        <input type="text" class="form-control" name="title" placeholder="Search by Title">
                        <button class="btn btn-primary" type="submit" name="submit">Search</button>
                    </div>
                </div>
            </div>
        </form>
        <?php
            include "connection.php";

            session_start();

            if (!isset($_SESSION['id'])) {
                die("Παρακαλώ συνδεθείτε για να δείτε αυτή τη σελίδα.");
            }

            // Check for session timeout
            if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 60)) {
                // Last request was more than SESSION_TIMEOUT seconds ago
                session_unset(); // Unset session variables
                session_destroy(); // Destroy the session
                header("Location: signin.php?msg=Η συνεδρία σας έχει λήξει. Παρακαλώ συνδεθείτε ξανά.");
                exit;
            }

            // Update last activity time
            $_SESSION['LAST_ACTIVITY'] = time();

            if (isset($_POST["submit"])) {
                $title = $_POST["title"];

                $query = "SELECT * FROM `task_lists` WHERE `title` LIKE ?";
                $stmt = $conn->prepare($query);
                $search_title = "%$title%";
                $stmt->bind_param("s", $search_title);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    echo "<h2>Searched Results:</h2>";
                    while ($row = $result->fetch_assoc()) {
                        echo "<p>Title: " . $row['title'] . "</p>";
                        echo "<p>Created at: " . $row['created_at'] . "</p>";
                        
                    }
                } else {
                        echo "<p>No results found.</p>";
                }
            }
        ?>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/darkmode-js@1.5.7/lib/darkmode-js.min.js"></script>
    <script src="script.js"></script>
</body>

</html>
