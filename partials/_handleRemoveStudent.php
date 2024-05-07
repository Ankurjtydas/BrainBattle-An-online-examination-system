<?php
session_status() == PHP_SESSION_ACTIVE?:session_start();
require "_dbconnect.php";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $studentId = htmlspecialchars($_POST["studentId"]);
    // update user's detail
    $sql = "UPDATE users SET `in_classroom` = null, `role` = null WHERE user_id = $studentId";
    mysqli_query($conn, $sql);
    // update classroom detail
    $sql = "select * from classrooms where classroom_id = $_SESSION[in_classroom]";;
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $sql = "UPDATE classrooms SET `no_of_students` = $row[no_of_students]-1 WHERE classroom_id = $_SESSION[in_classroom]";
    mysqli_query($conn, $sql);

    $alert = "Student removed successfully";
    header("Location: ../people.php?success=true&alert=$alert");
    exit;
}else{
    header("Location: ../index.php");
    exit;
}
?>