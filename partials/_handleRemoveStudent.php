<?php
session_status() == PHP_SESSION_ACTIVE?:session_start();
require "_dbconnect.php";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $studentId = $_POST["studentId"];
    $sql = "UPDATE users SET `in_classroom` = null, `role` = null WHERE user_id = $studentId";
    mysqli_query($conn, $sql);
    $alert = "Student removed successfully";
    header("Location: ../people.php?success=true&alert=$alert");
}else{
    header("Location: ../index.php");
    exit;
}
?>