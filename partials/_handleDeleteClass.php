<?php
    session_status() == PHP_SESSION_ACTIVE?: session_start();
    require "_dbconnect.php";

    if($_SESSION["in_classroom"] != null){
        // echo var_dump($_SESSION);
        if($_SESSION["role"] == "faculty"){

            // delete current classroom
            $sql = "DELETE FROM  `classrooms` WHERE `classroom_id` = $_SESSION[in_classroom]";
            $result = mysqli_query($conn, $sql);
            
            if($result  == 1){
                header("Location: ../index.php");
                
                // update users table; removing user from classroom
                $sql = "UPDATE `users` SET `in_classroom` = null, `role` = null WHERE `in_classroom` = $_SESSION[in_classroom]";
                mysqli_query($conn, $sql);
                $_SESSION["in_classroom"] = null;
                $_SESSION["role"] = null;
                $_SESSION["classroom_code"] = null;
                exit;
            }
        }
    }

?>