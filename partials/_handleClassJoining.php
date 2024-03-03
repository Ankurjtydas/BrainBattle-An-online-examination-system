<?php
    session_status() == PHP_SESSION_ACTIVE?: session_start();
    require "_dbconnect.php";

    if($_SESSION["in_classroom"] != null){
        $alert = "Your are already in another class.";
        header("Location: ../index.php?success=false&alert=$alert");
        exit;
    }

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $classroomCode = $_POST["classroomCode"];
        
        $sql = "select * from classrooms where classroom_code='$classroomCode'";
        $result = mysqli_query($conn, $sql);
        $numRows = mysqli_num_rows($result);
        if($numRows == 1){
            $row = mysqli_fetch_assoc($result);
            $sql2 = "UPDATE `users` SET `in_classroom` = '$row[classroom_id]', `role` = 'student' WHERE `user_id` = $_SESSION[user_id]";
            $result2 = mysqli_query($conn, $sql2);
            if($result2 == 1){
                $_SESSION["in_classroom"] = $row["classroom_id"];
                $_SESSION["role"] = "student";
                header("Location: ../student_dashboard.php");
            }
            $sql2 = "select * from users where `in_classroom` = $row[classroom_id] and `role` = 'student'";
            $result2 = mysqli_query($conn, $sql2);
            $numRows2 = mysqli_num_rows($result2);
            $sql2 = "UPDATE `classrooms` SET `no_of_students` = $numRows2 WHERE `classroom_id` = $row[classroom_id]";
            $result2 = mysqli_query($conn, $sql2);

        }else{
            $alert = "The classroom doesn't exist.";
            header("Location: ../index.php?success=false&alert=$alert");
            exit;
        }
    }else{
        header("Location: ../index.php");
    }
?>