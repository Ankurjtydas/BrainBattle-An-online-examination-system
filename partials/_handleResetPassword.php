<?php
session_status() == PHP_SESSION_ACTIVE ?: session_start();
if (isset($_SESSION["loggedin"]) || !isset($_SESSION["forgot"])) {
    header("Location: ../index.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require "_dbconnect.php";
    $tempUser = $_SESSION["temp_user"];
    $email = $tempUser["email"];
    $password = htmlspecialchars($_POST["password"]);
    $cpassword = htmlspecialchars($_POST["cpassword"]);

    if ($password === $cpassword) {
        if ($password != "" && $cpassword != "") {
            $sql = "select * from users where email = '$email'";
            $result = mysqli_query($conn, $sql);
            $numRows = mysqli_num_rows($result);
            if ($numRows == 1) {
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                $sql = "UPDATE `users` SET `password` = '$hashed_password' WHERE email = '$email'";
                if (mysqli_query($conn, $sql)) {
                    unset($_SESSION["forgot"]);
                    $alert = "Password changed successfully.";
                    header("Location: ../login.php?success=true&alert=$alert");
                    exit;
                }
            } else {
                unset($_SESSION["forgot"]);
                $alert = "This email is not registered.";
                header("Location: ../forgotPassword.php?success=false&alert=$alert");
                exit;
            }
        } else {
            $alert = "Every field must be filled up.";
            header("Location: ../reset_password.php?success=false&alert=$alert");
            exit;
        }
    } else {
        $alert = "Password fields doesn't match";
        header("Location: ../reset_password.php?success=false&alert=$alert");
        exit;
    }
} else {
    header("Location: ../index.php");
}
?>