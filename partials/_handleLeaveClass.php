<?php
session_status() == PHP_SESSION_ACTIVE ?: session_start();
require "_dbconnect.php";

if ($_SESSION["in_classroom"] != null) {
    if ($_SESSION["role"] == "student") {
        $sql = "UPDATE `users` SET `in_classroom` = null , `role` = null WHERE `user_id` = $_SESSION[user_id]";
        mysqli_query($conn, $sql);
        
        // get number of students in the classroom
        echo var_dump($_SESSION)."<br>";
        $sql = "select * from users where `in_classroom` = $_SESSION[in_classroom] and `role` = 'student'";
        $result = mysqli_query($conn, $sql);
        $numRows = mysqli_num_rows($result);
        echo $numRows;

        $sql2 = "UPDATE `classrooms` SET `no_of_students` = $numRows WHERE `classroom_id` = $_SESSION[in_classroom]";
        $result2 = mysqli_query($conn, $sql2);

        $_SESSION["in_classroom"] = null;
        $_SESSION["role"] = null;
    }
}
header("Location: ../index.php");

?>