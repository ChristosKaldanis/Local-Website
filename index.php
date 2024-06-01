<?php

    include("connection.php");

    

    if(isset($_POST["submit"])){
        $όνομα = $_POST['όνομα'];
        $επίθετο = $_POST['επίθετο'];
        $username = $_POST['user'];
        $password = $_POST['pass'];
        $email = $_POST['email'];
        $keyy = $_POST['keyy'];
        


        $query = "INSERT INTO signup VALUES ($όνομα, $επίθετο, $username, $password, $email, $keyy)";
        
        mysqli_query($conn, $query);
        echo "Επιτυχία!";
    }
?>


<!DOCTYPE html>
<html lang="el">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Αρχική Σελίδα</title>
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
   <link rel="stylesheet" href="style4.css">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <header>
        <h1 class="main-heading">Department of Informatics</h1>
        <p>Ionian University</p>
    </header>
    <nav class = "navbar">
        <ul>
            <li><a href="index.php"> Home</a></li>
            <li><a href="about.php"> About</a></li>
        </ul>
    </nav>
    <main>
        <div class="signup-container">
            <h2>Sign Up</h2>
            <form name="form" action="signup.php" onsubmit="return isvalid()" method="post">
                <div class="form-group">
                    <label for="όνομα">Όνομα:</label>
                    <input type="text" id="όνομα" name="όνομα" required unique>
                </div>
                <div class="form-group">
                    <label for="επίθετο">Επίθετο:</label>
                    <input type="text" id="επίθετο" name="επίθετο" required>
                </div>
                <div class="form-group">
                    <label for="username">Username:</label>
                    <input type="text" id="username" name="user" required unique>
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="pass" required unique>
                </div>
                <div class="form-group">
                    <label for="key">Push Key</label>
                    <input type="text" id="key" name="keyy" unique>
                </div>
                <button type="submit">Sign Up</button>
            </form>
          
            <div class="login-link-container">
                <p>Έχεις ήδη λογαριασμό?</p>
                <a href="signin.php">Login εδώ!</a>
                
            </div>
        </div>
</main>
    <script src="https://cdn.jsdelivr.net/npm/darkmode-js@1.5.7/lib/darkmode-js.min.js"></script>
    <script src="script.js"></script>
</body>
</html>
