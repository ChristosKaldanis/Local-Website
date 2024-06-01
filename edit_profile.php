
<?php
include "connection.php";

$id = $_GET["id"];

if (isset($_POST["submit"])) {
    $όνομα = $_POST['όνομα'];
    $επίθετο = $_POST['επίθετο'];
    $username = $_POST['user'];
    $password = password_hash($_POST['pass'], PASSWORD_DEFAULT);
    $email = $_POST['email'];
    $keyy = $_POST['keyy'];
    


    $query = "UPDATE `signup` SET `όνομα`='$όνομα',`επίθετο`='$επίθετο',`username`='$username',`password`='$password', `email`='$email', `keyy`='$keyy' WHERE `id` = '$id'";
    $result = mysqli_query($conn, $query);


  if ($result) {
    header("Location: welcome.php?msg=Data updated successfully");
  } else {
    echo "Failed: " . mysqli_error($conn);
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
  <link rel="stylesheet" href="style3.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

  <title>Επεξεργασία Προφίλ</title>
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

  <div class="signup-container">
    <div class="text-center mb-4">
      <h2>Επεξεργασία Στοιχείων</h2>
      <p class="text-muted">Κάνε κλικ μετά από ενημέρωση οποιασδήποτε πληροφορίας.</p>
    </div>
    

    <?php
    $sql = "SELECT * FROM `signup` WHERE id = $id LIMIT 1";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    ?>

    <div class="container d-flex justify-content-center">
      <form action="" method="post" style="width:50vw; min-width:300px;">
        <div class="row mb-3">
          <div class="col">
            <label class="form-label">Όνομα:</label>
            <input type="text" class="form-control" name="όνομα" value="<?php echo $row['όνομα'] ?>" unique>
          </div>

          <div class="col">
            <label class="form-label">Επίθετο:</label>
            <input type="text" class="form-control" name="επίθετο" value="<?php echo $row['επίθετο'] ?>">
          </div>
        </div>

        <div class="mb-3">
          <label class="form-label">Username:</label>
          <input type="text" class="form-control" name="user" value="<?php echo $row['username'] ?>" unique>
        </div>

        <div class="mb-3">
          <label class="form-label">Password:</label>
          <input type="password" class="form-control" name="pass" value="<?php echo $row['password'] ?>">
        </div>

        <div class="mb-3">
          <label class="form-label">Email:</label>
          <input type="email" class="form-control" name="email" value="<?php echo $row['email'] ?>">
        </div>

        <div class="mb-3">
          <label class="form-label">Push Key:</label>
          <input type="text" class="form-control" name="keyy" value="<?php echo $row['keyy'] ?>" unique>
        </div>

        <div>
          <button type="submit" class="btn btn-success" name="submit">Update</button>
          <a href="welcome.php" class="btn btn-danger">Cancel</a>
        </div>
      </form>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

</body>

</html>
