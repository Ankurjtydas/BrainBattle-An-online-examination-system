<?php
session_status() == PHP_SESSION_ACTIVE ?: session_start();
if (isset($_SESSION["loggedin"])) {
    header("Location: index.php");
    exit;
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Forgot Password</title>
    <?php require "partials/_bootstrap_css.php"; ?>
    <link rel="stylesheet" href="css/navbar.css">
    <link rel="stylesheet" href="css/emailVerify.css">
</head>

<body>
    <?php include 'partials/_header.php'; ?>

    <div class="container">
        <div class="box col-5 px-4">
            <div class="col-12">
                <h4 class="text-center mb-3">Forgot Password</h4>
                <form action="partials/_handleForgotPassword.php" method="POST">
                    <p>Enter your registered email Id where the verification code will be sent.</p>
                    <div class="row mb-3">
                        <div class="col-3">
                            <label for="email" class="col-form-label">Email :</label>
                        </div>
                        <div class="col-9">
                            <input type="email" id="email" name="email" class="form-control"
                                aria-describedby="nameHelpInline" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <input type="submit" class="btn btn-primary" value="Send code">
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php require "partials/_footer.php"; ?>

</body>

</html>