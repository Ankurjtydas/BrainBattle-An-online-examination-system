<?php
    session_status() == PHP_SESSION_ACTIVE?: session_start();
    require "_dbconnect.php";

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $classroomTitle = htmlspecialchars($_POST["classroomTitle"]);
        $classroomDesc = htmlspecialchars($_POST["classroomDescription"]);
        $classroomDescription = str_replace(" ", "&nbsp;", $classroomDesc);
        if($classroomTitle == ""){
            $alert = "Classroom title cannot be blank";
            header("Location: ../index.php?success=false&alert=$alert");
            exit;
        }

        $characters = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $randomCode = "";
        while(1){
            // generate classroom_code
            for($i=0; $i<6; $i++){
                $randomCode .= $characters[rand(0, strlen($characters)-1)];
            }
            
            // check if the code is unique or not
            $sql = "select * from classrooms where classroom_code='$randomCode'";
            $result = mysqli_query($conn, $sql);
            $numRows = mysqli_num_rows($result);
            if($numRows == 0){
                break;
            }
        }
        
        // add classroom in database
        $sql = "INSERT INTO `classrooms` (`classroom_name`, `classroom_description`, `classroom_faculty`, `classroom_code`, `create_at`) VALUES ('$classroomTitle', '$classroomDescription', '$_SESSION[user_id]', '$randomCode', current_timestamp())";
        if(mysqli_query($conn, $sql)){

            // get id of currently created classroom
            $sql = "select * from classrooms where classroom_code='$randomCode'";
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_assoc($result);
            $_SESSION["in_classroom"] = $row["classroom_id"];
            $_SESSION["role"] = "faculty";
            $_SESSION["classroom_name"] =  $classroomTitle ;
            $_SESSION["classroom_description"] =  $classroomDescription ;


            // update classrooms table
            $sql = "UPDATE `classrooms` SET `classroom_faculty` = '$_SESSION[user_id]' WHERE `classroom_id` = $_SESSION[in_classroom]";
            mysqli_query($conn, $sql);

            // update users table
            $sql = "UPDATE `users` SET `in_classroom` = '$_SESSION[in_classroom]', `role` = 'faculty' WHERE `user_id` = $_SESSION[user_id]";
            mysqli_query($conn, $sql);
            header("Location: ../faculty_dashboard.php");
            exit;
        }
    }
    header("Location: ../index.php");

?>