<?php

require "connection.php";
$id = $_GET["id"];

    
$randomName = 'Anonymous User';
$randomSurname = 'User'; 
$randomUsername = 'Anonymous User';
$randomPassword = 'AnonymousUser111222333!!!';
$randomEmail = 'anonymous@example.com';
$randomKey = 'yt4536';
$deleted = TRUE;
    
$sql = "UPDATE signup SET όνομα = '$randomName', επίθετο = '$randomSurname', username = '$randomUsername', password = '$randomPassword', email = '$randomEmail', keyy = '$randomKey', is_deleted = '$deleted' WHERE id = '$id'";
$result = mysqli_query($conn, $sql);


if ($result) {
  header("Location: signout.php?msg=Data deleted successfully");
  exit;
} 

