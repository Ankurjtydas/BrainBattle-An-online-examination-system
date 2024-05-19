<?php
session_status() == PHP_SESSION_ACTIVE ?: session_start();
if(isset($_SESSION["loggedin"]) || !isset($_SESSION["forgot"])){
    header("Location: index.php");
    exit;
}
require "partials/_dbconnect.php";
date_default_timezone_set("Asia/Kolkata");
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $otp = htmlspecialchars($_POST["otp"]);
    $tempUser = $_SESSION["temp_user"];
    $email = $tempUser["email"];

    if ($otp == htmlspecialchars($tempUser["otp"])) {
        if (new DateTime() < new DateTime($tempUser["otp_expiry"])) {
            // Render HTML page
        } else {
            unset($_SESSION["forgot"]);
            $alert = "The OTP has been expired.";
            header("Location: login.php?success=false&alert=$alert");
            exit;
        }
    } else {
        // echo "Incorrect OTP. Re-submit the signup form to get and new OTP.";
        $alert = "Incorrect OTP. Try again!";
        header("Location: emailVerify.php?success=false&alert=$alert");
        exit;
    }
} else {
    header("Location: ../index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register to BrainBattle</title>
    <?php require "partials/_bootstrap_css.php"; ?>
    <link rel="stylesheet" href="css/navbar.css">
    <link rel="stylesheet" href="css/register.css">
</head>

<body>
    <?php require "partials/_header.php"; ?>

    <div class="register-container">
        <div class="box col-5 px-4">
            <form action="partials/_handleResetPassword.php" method="POST">
                <div class="register col-12">
                    <h4 class="text-center mb-3">Reset Password</h4>
                    <div class="row mb-3">
                        <div class="col-3">
                            <label for="password" class="col-form-label">New Password</label>
                        </div>
                        <div class="col-9">
                            <input type="password" id="password" name="password" class="form-control"
                                aria-describedby="passwordHelpInline" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-3">
                            <label for="cpassword" class="col-form-label">Confirm Password</label>
                        </div>
                        <div class="col-9 cpassword-status">
                            <input type="password" id="cpassword" name="cpassword" class="form-control"
                                aria-describedby="cpasswordHelpInline" required>
                            <span id="cpassword-label"></span>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <input type="submit" class="btn btn-primary" value="Reset">
                    </div>
                </div>
            </form>
        </div>
    </div>
    <?php require "partials/_footer.php"; ?>
</body>
<script>
    let password = document.getElementById("password");
    let cpassword = document.getElementById("cpassword");
    let label = document.getElementById("cpassword-label");

    cpassword.addEventListener("keyup", () => {
        if (cpassword.value != "") {
            label.style.display = "block";
            if (password.value == cpassword.value) {
                label.innerText = "Password matched";
                label.style.color = "green";
            } else {
                label.innerText = "Password do not match";
                label.style.color = "red";
            }
        } else {
            label.style.display = "none";
        }
    })

</script>

</html>