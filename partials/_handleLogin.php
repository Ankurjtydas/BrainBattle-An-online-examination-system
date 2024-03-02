<?php
    require "_dbconnect.php";
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $email = $_POST["email"];
        $password = $_POST["password"];

        $sql = "select * from users where email='$email' and password='$password'";
        $result = mysqli_query($conn, $sql);
        $numRows = mysqli_num_rows($result);

        if($numRows==1){
            $row = mysqli_fetch_assoc($result);
            session_start();
            //  setup session
            $_SESSION["loggedin"] = true;
            $_SESSION["user_id"] = $row["user_id"];
            $_SESSION["first_name"] = $row["first_name"];
            $_SESSION["last_name"] = $row["last_name"];
            $_SESSION["email"] = $row["email"];
            $_SESSION["in_classroom"] = $row["in_classroom"];
            if($_SESSION["in_classroom"] != null){

                // check if the user is faculty or student
                $sql = "select * from classrooms where classroom_id=$_SESSION[in_classroom]";
                $result = mysqli_query($conn, $sql);
                $row = mysqli_fetch_assoc($result);
                if($_SESSION["user_id"] == $row["classroom_faculty"]){
                  $_SESSION["role"] = "faculty";
                }else{
                    $_SESSION["role"] = "student";
                }
            }
            echo var_dump($_SESSION);
            header("Location: ../index.php");
        }else{
            $alert = "Invalid email and password.";
            header("Location: ../login.php?success=false&alert=$alert");
            exit;
        }
    }


?>