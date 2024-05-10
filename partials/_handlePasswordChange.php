<?php
session_status() == PHP_SESSION_ACTIVE ?: session_start();
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] != true) {
    header("Location: index.php");
    exit;
}
if($_SERVER["REQUEST_METHOD"] == "POST"){
    require "_dbconnect.php";
    $oldPass = htmlspecialchars($_POST["old_pass"]);
    $pass = $_POST["old_pass"];
    $newPass = htmlspecialchars($_POST["new_pass"]);
    $cnewPass = htmlspecialchars($_POST["cnew_pass"]);

    if($newPass === $cnewPass){
        if($oldPass != "" && $newPass != "" && $cnewPass != ""){
            $sql = "select * from users where user_id = '$_SESSION[user_id]'";
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_assoc($result);
            if(password_verify($oldPass, $row["password"])){
                $hashed_password = password_hash($newPass, PASSWORD_DEFAULT);
                $sql = "UPDATE `users` SET `password` = '$hashed_password' WHERE user_id = '$_SESSION[user_id]'";
                if(mysqli_query($conn, $sql)){
                    $alert = "Password changed successfully.";
                    header("Location: ../profile.php?success=true&alert=$alert");
                    exit; 
                }
            }else{
                $alert = "Incorrect password.";
                header("Location: ../profile.php?success=false&alert=$alert");
                exit; 
            }
        }else{
            $alert = "Every fields must be filled up.";
            header("Location: ../profile.php?success=false&alert=$alert");
            exit; 
        }
    }else{
        $alert = "Passwords do not match.";
        header("Location: ../profile.php?success=false&alert=$alert");
        exit;        
    }
}
header("Location: ../profile.php");
?>