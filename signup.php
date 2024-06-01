<?php

    include ("connection.php");
    
    if($_SERVER["REQUEST_METHOD"]== "POST"){
        $όνομα = $_POST['όνομα'];
        $επίθετο = $_POST['επίθετο'];
        $username = $_POST['user'];
        $password = password_hash($_POST['pass'], PASSWORD_DEFAULT);
        $email = $_POST['email'];
        $keyy = $_POST['keyy'];
        

        if (strlen($password) < 6) {
            echo "Ο κωδικός πρόσβασης πρέπει να έχει τουλάχιστον 6 χαρακτήρες.";
            exit;
        }
        else{
            $query = "INSERT INTO signup VALUES (NULL, '$όνομα', '$επίθετο', '$username', '$password', '$email', '$keyy', 'FALSE')";
            $result = mysqli_query($conn, $query);
    
           echo "Sign Up Successful!";
    
           echo "<script> window.location.href = 'welcome.php'; </script>";
        }
        

    }
?>