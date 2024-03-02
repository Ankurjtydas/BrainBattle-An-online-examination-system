<?php
    session_status() == PHP_SESSION_ACTIVE?: session_start();
    require "_dbconnect.php";

    if($_SESSION["in_classroom"] != null){
        if($_SESSION["role"] == "student"){
            $sql = "UPDATE `users` SET `in_classroom` = null WHERE `user_id` = $_SESSION[user_id]";
            mysqli_query($conn, $sql);
            $_SESSION["in_classroom"] = null;
            $_SESSION["role"] = null;
        }
    }
    header("Location: ../index.php");

?>