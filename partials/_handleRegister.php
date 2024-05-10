<?php
    $alert = "";
    require "_dbconnect.php";

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $first_name = htmlspecialchars($_POST["fname"]);
        $last_name = htmlspecialchars($_POST["lname"]);
        $email = htmlspecialchars($_POST["email"]);
        $password = htmlspecialchars($_POST["password"]);
        $cpassword = htmlspecialchars($_POST["cpassword"]);

        if($password === $cpassword){
            if($first_name!="" && $last_name!="" && $email!="" && $password!="" && $cpassword!=""){

                $sql = "select * from users where email='$email'";
                $result = mysqli_query($conn, $sql);
                $numRows = mysqli_num_rows($result);
                if($numRows > 0){
                    $alert = "This email is already register";
                    header("Location: ../register.php?success=false&alert=$alert");
                    exit;
                }else{
                    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                    $sql = "INSERT INTO `users` (`first_name`, `last_name`, `email`, `password`) VALUES ('$first_name', '$last_name', '$email', '$hashed_password')";
                    $result = mysqli_query($conn, $sql);
                    if($result==1){
                        $alert = "You have register successfully. You can now login into you account.";
                        header("Location: ../login.php?success=true&alert=$alert");
                        exit;
                    }
                }
            }else{
                $alert = "Every field must be filled up.";
                header("Location: ../register.php?success=false&alert=$alert");
                exit;
            }
        }else{
            $alert = "Password fields doesn't match";
            header("Location: ../register.php?success=false&alert=$alert");
            exit;
        }
    }
    header("Location: ../index.php");
?>