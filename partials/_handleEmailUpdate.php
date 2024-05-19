<?php
session_status() == PHP_SESSION_ACTIVE ?: session_start();
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] != true || !isset($_SESSION["updation"]) || !isset($_SESSION["temp_user"])) {
    header("Location: ../index.php");
    exit;
}
require "_dbconnect.php";
date_default_timezone_set("Asia/Kolkata");
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $otp = htmlspecialchars($_POST["otp"]);
    $tempUser = $_SESSION["temp_user"];
    $new_email = $tempUser["email"];

    if ($otp == $tempUser["otp"]) {
        if (new DateTime() < new DateTime($tempUser["otp_expiry"])) {
            $sql = "UPDATE `users` SET `email` = '$new_email' WHERE email = '$_SESSION[email]'";
            mysqli_query($conn, $sql);
            $_SESSION["email"] = $new_email;
            unset($_SESSION["updation"]);
            unset($_SESSION["temp_user"]);
            $alert = "Email updated successfully.";
            header("Location: ../profile.php?success=true&alert=$alert");
        } else {
            // echo "The OTP has been expired.";
            unset($_SESSION["updation"]);
            unset($_SESSION["temp_user"]);
            $alert = "The OTP has been expired. Please re-submit the form.";
            header("Location: ../profile.php?success=false&alert=$alert");
            exit;
        }
    } else {
        // echo "Incorrect OTP. Re-submit the signup form to get and new OTP.";
        $alert = "Incorrect OTP. Try again!";
        header("Location: ../emailVerify.php?success=false&alert=$alert");
        exit;
    }
} else {
    header("Location: ../profile.php");
}
?>