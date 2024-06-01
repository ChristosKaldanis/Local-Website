<?php
include "connection.php";

session_start();

define("SESSION_TIMEOUT", 240); //240 sec = 4 minutes
// Check if the user is logged in
if (!isset($_SESSION['id'])) {
  header("Location: signin.php?msg=Παρακαλώ συνδεθείτε για να συνεχίσετε.");
  exit;
}


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
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
  <link rel="stylesheet" href="style3.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

  <title>Διαχείριση Προφίλ</title>
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
    <div class="text-center mb-4">
      <h2>Διαχείριση Στοιχείων Προφίλ</h2>
      <p class="text-muted">Κάνε κλικ για να ενημερώσεις οποιαδήποτε πληροφορία.</p>
    </div>
    <?php
    if (isset($_GET["msg"])) {
      $msg = $_GET["msg"];
      echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
      ' . $msg . '
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>';
    }
    ?>
    

    <table class="table table-hover text-center">
      <thead class="table-dark">
        <tr>
          <th scope="col">ID</th>
          <th scope="col">Όνομα</th>
          <th scope="col">Επίθετο</th>
          <th scope="col">Username</th>
          <th scope="col">Password</th>
          <th scope="col">Email</th>
          <th scope="col">Push Key</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $sql = "SELECT * FROM `signup` WHERE `id` = $user_id";
        $result = mysqli_query($conn, $sql);
        while ($row = mysqli_fetch_assoc($result)) {
        ?>
          <tr>
            <td><?php echo $row["id"] ?></td>
            <td><?php echo $row["όνομα"] ?></td>
            <td><?php echo $row["επίθετο"] ?></td>
            <td><?php echo $row["username"] ?></td>
            <td><?php echo $row["password"] ?></td>
            <td><?php echo $row["email"] ?></td>
            <td><?php echo $row["keyy"] ?></td>
            <td>
              <a href="edit_profile.php?id=<?php echo $row["id"] ?>" class="link-dark"><i class="fa-solid fa-pen-to-square fs-5 me-3"></i></a>
              <a href="delete_profile.php?id=<?php echo $row["id"] ?>" class="link-dark"><i class="fa-solid fa-trash fs-5"></i></a>
            </td>
          </tr>
        <?php
        }
        ?>
      </tbody>
    </table>
  </div>
  
  <!-- Bootstrap -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/darkmode-js@1.5.7/lib/darkmode-js.min.js"></script>
  <script src="script.js"></script>
</body>

</html>