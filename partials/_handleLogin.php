<?php
    require "_dbconnect.php";
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $email = htmlspecialchars($_POST["email"]);
        $password = htmlspecialchars($_POST["password"]);

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
            $_SESSION["role"] = $row["role"];
            header("Location: ../index.php");
            exit;
        }else{
            $alert = "Invalid email and password.";
            header("Location: ../login.php?success=false&alert=$alert");
            exit;
        }
    }
    header("Location: ../index.php");
?>