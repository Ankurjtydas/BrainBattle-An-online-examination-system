<?php
session_status() == PHP_SESSION_ACTIVE ?: session_start();
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] != true) {
    header("Location: index.php");
    exit;
}
if($_SERVER["REQUEST_METHOD"] == "POST"){
    require "_dbconnect.php";
    $new_first_name = $_POST["fname"];
    $new_last_name = $_POST["lname"];
    $new_email = $_POST["email"];

    if($new_first_name !== $_SESSION["first_name"]){
        $sql = "UPDATE `users` SET `first_name` = '$new_first_name' WHERE email = '$_SESSION[email]'";
        mysqli_query($conn, $sql);
        $_SESSION["first_name"] = $new_first_name;
    }
    if($new_last_name !== $_SESSION["last_name"]){
        $sql = "UPDATE `users` SET `last_name` = '$new_last_name' WHERE email = '$_SESSION[email]'";
        mysqli_query($conn, $sql);
        $_SESSION["last_name"] = $new_last_name;        
    }
    if($new_email !== $_SESSION["email"]){
        $sql = "UPDATE `users` SET `email` = '$email' WHERE email = '$_SESSION[email]'";
        mysqli_query($conn, $sql);
        $_SESSION["emai"] = $email;        
    }
    $alert = "Profile updated successfully.";
    header("Location: ../profile.php?success=true&alert=$alert");
    exit;
}
header("Location: ../profile.php");
?>