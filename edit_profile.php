<?php
session_status() == PHP_SESSION_ACTIVE ?: session_start();
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] != true) {
    header("Location: index.php");
    exit;
}
unset($_SESSION["register"]);
unset($_SESSION["updation"]);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <?php require "partials/_bootstrap_css.php"; ?>
    <link rel="stylesheet" href="css/navbar.css">
    <link rel="stylesheet" href="css/edit_profile.css">
</head>

<body>
    <?php require "partials/_header.php"; ?>

    <div class="container">
        <div class="box col-5 px-4">
            <form action="partials/_handleProfileEdit.php" method="POST">
                <div class="col-12">
                    <h4 class="text-center mb-3">Edit Profile</h4>
                    <div class="row mb-3">
                        <div class="col-3">
                            <label for="fname" class="col-form-label">First Name</label>
                        </div>
                        <div class="col-9">
                            <input type="text" id="fname" name="fname" class="form-control"
                                aria-describedby="nameHelpInline" value="<?php echo $_SESSION["first_name"]; ?>">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-3">
                            <label for="lname" class="col-form-label">Last Name</label>
                        </div>
                        <div class="col-9">
                            <input type="text" id="lname" name="lname" class="form-control"
                                aria-describedby="nameHelpInline" value="<?php echo $_SESSION["last_name"]; ?>">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-3">
                            <label for="email" class="col-form-label">Email Address</label>
                        </div>
                        <div class="col-9">
                            <input type="email" id="email" name="email" class="form-control"
                                aria-describedby="emailHelpInline" value="<?php echo $_SESSION["email"]; ?>">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <input type="submit" id="submit" class="btn btn-primary" value="Save Changes">
                    </div>
                </div>
            </form>
        </div>
    </div>
    <?php require "partials/_footer.php"; ?>
</body>

</html>