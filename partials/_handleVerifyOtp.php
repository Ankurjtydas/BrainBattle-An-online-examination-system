<?php
session_status() == PHP_SESSION_ACTIVE ?: session_start();
require "_dbconnect.php";
date_default_timezone_set("Asia/Kolkata");
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $otp = htmlspecialchars($_POST["otp"]);
    $tempUser = $_SESSION["temp_user"];

    $first_name = $tempUser["first_name"];
    $last_name = $tempUser["last_name"];
    $email = $tempUser["email"];
    $password = $tempUser["password"];

    if ($otp == htmlspecialchars($tempUser["otp"])) {
        if (new DateTime() < new DateTime($tempUser["otp_expiry"])) {
            $sql = "INSERT INTO `users` (`first_name`, `last_name`, `email`, `password`) VALUES ('$first_name', '$last_name', '$email', '$password')";
            $result = mysqli_query($conn, $sql);
            if ($result == 1) {
                $alert = "Email verified and register successfully. You can now login into you account.";
                header("Location: ../login.php?success=true&alert=$alert");
                exit;
            }
            // $sql = "INSERT INTO `users` (`email_id`, `password`, `time_stamp`) VALUES ('$tempUser[email_id]', '$tempUser[password]', current_timestamp())";
            // mysqli_query($conn, $sql);
            // unset($_SESSION["verification"]);
            // echo "User registered successfully.";
        } else {
            // echo "The OTP has been expired. Please re-submit the signup form.";
            $alert = "The OTP has been expired. Please re-submit the signup form.";
            header("Location: ..register.php?success=false&alert=$alert");
            exit;
        }
    } else {
        // echo "Incorrect OTP. Re-submit the signup form to get and new OTP.";
        $alert = "Incorrect OTP. Try again or re-submit the signup form to get a new OTP.";
        header("Location: ../emailVerify.php?success=false&alert=$alert");
        exit;
    }
} else {
    header("Location: ../index.php");
}