<?php
session_status() == PHP_SESSION_ACTIVE ?: session_start();
require "_dbconnect.php";
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] != true || $_SESSION["in_classroom"] == null || $_SESSION["role"] != "faculty") {
    header("Location: ../index.php");
    exit;
}
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $classroomTitle = htmlspecialchars($_POST["classroomTitle"]);
    $classroomDesc = htmlspecialchars($_POST["classroomDescription"]);
    $classroomDescription = str_replace(" ", "&nbsp;", $classroomDesc);
    if($classroomTitle == ""){
        $alert = "Classroom title cannot be blank";
        header("Location: ../faculty_dashboard.php?success=false&alert=$alert");
        exit;
    }
    $sql = "UPDATE `classrooms` SET `classroom_name` = '$classroomTitle', `classroom_description` = '$classroomDescription' WHERE `classroom_id` = '$_SESSION[classroom_id]'";
    if(mysqli_query($conn, $sql)){
        $alert = "Classroom updated successfully.";
        header("Location: ../faculty_dashboard.php?success=true&alert=$alert");
        exit;
    }
}
header("Location: ../faculty_dashboard.php");