<?php
session_status() == PHP_SESSION_ACTIVE ?: session_start();
if ((isset($_SESSION["register"]) && $_SESSION["register"] == true) || (isset($_SESSION["updation"]) && $_SESSION["updation"] == true) || (isset($_SESSION["forgot"]) && $_SESSION["forgot"] == true)) {
    $tempUser = $_SESSION["temp_user"];
} else {
    header("Location: index.php");
    exit;
}
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Email Verification</title>
    <?php require "partials/_bootstrap_css.php"; ?>
    <link rel="stylesheet" href="css/navbar.css">
    <link rel="stylesheet" href="css/emailVerify.css">
</head>

<body>
    <?php include 'partials/_header.php'; ?>

    <div class="container">
        <div class="box col-5 px-4">
            <div class="col-12">
                <h4 class="text-center mb-3">Verify email</h4>
                <?php
                if (isset($_SESSION["register"])) {
                    echo '<form action="partials/_handleVerifyOtp.php" method="POST">';
                } elseif (isset($_SESSION["updation"])) {
                    echo '<form action="partials/_handleEmailUpdate.php" method="POST">';
                } elseif(isset($_SESSION["forgot"])) {
                    echo '<form action="reset_password.php" method="POST">';
                } else {
                    echo '<form action="" method="POST">';
                }
                ?>
                <div class="row mb-3">
                    <div class="col-3">
                        <label for="otp" class="col-form-label">OTP :</label>
                    </div>
                    <div class="col-9">
                        <input type="text" id="otp" name="otp" class="form-control" aria-describedby="nameHelpInline"
                            required>
                    </div>
                </div>
                <p>An OTP has been sent to your email <b><?php echo $tempUser["email"]; ?></b>. Expires in 5 minutes.
                </p>
                <div class="row mb-3">
                    <input type="submit" class="btn btn-primary" value="Verify">
                </div>
                </form>
                <?php
                if (isset($_SESSION["register"])) {
                    echo '<form action="partials/_resendRegisterOtp.php" method="post">';
                } elseif (isset($_SESSION["updation"])) {
                    echo '<form action="partials/_resendUpdateOtp.php" method="post">';
                } elseif (isset($_SESSION["forgot"])) {
                    echo '<form action="partials/_resendForgotOtp.php" method="post">';
                } else {
                    echo '<form action="" method="post">';
                }
                ?>
                <div class="row mb-1">
                    <button type="submit" id="resend" name="resend">Resend OTP</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <?php require "partials/_footer.php"; ?>

</body>

</html>