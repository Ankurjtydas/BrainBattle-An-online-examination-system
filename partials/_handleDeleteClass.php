<?php
    session_status() == PHP_SESSION_ACTIVE?: session_start();
    require "_dbconnect.php";
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $classId = htmlspecialchars($_POST["classId"]);
    if($_SESSION["in_classroom"] != null){
        // echo var_dump($_SESSION);
        if($_SESSION["role"] == "faculty"){
            // check if the user is faculty of this classroom or not
            $sql = "select * from classrooms where `classroom_id` = $classId";
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_assoc($result);
            if($row["classroom_faculty"] != $_SESSION["user_id"]){
                header("Location: ../index.php");
                exit;
            }

            // delete current classroom
            $sql = "DELETE FROM  `classrooms` WHERE `classroom_id` = $classId";
            $result = mysqli_query($conn, $sql);
            
            if($result  == 1){
                header("Location: ../index.php");
                
                // update users table; removing user from classroom
                $sql = "UPDATE `users` SET `in_classroom` = null, `role` = null WHERE `in_classroom` = $classId";
                mysqli_query($conn, $sql);
                $_SESSION["in_classroom"] = null;
                $_SESSION["role"] = null;
                exit;
            }
        }
    }
}
header("Location: ../index.php");
?>