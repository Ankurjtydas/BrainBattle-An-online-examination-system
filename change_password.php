<?php
    session_status() == PHP_SESSION_ACTIVE?: session_start();
    if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] != true){
        header("Location: index.php");
        exit;
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change password</title>
    <?php require "partials/_bootstrap_css.php"; ?>
    <link rel="stylesheet" href="css/navbar.css">
    <link rel="stylesheet" href="css/change_password.css">
</head>

<body>
    <?php require "partials/_header.php"; ?>

    <div class="container">
        <div class="box col-5 px-4">
            <form action="partials/_handlePasswordChange.php" method="POST">
                <div class="col-12">
                    <h4 class="text-center mb-3">Change password</h4>
                    <div class="row mb-3">
                        <div class="col-3">
                            <label for="old_pass" class="col-form-label">Old Password</label>
                        </div>
                        <div class="col-9">
                            <input type="password" id="old_pass" name="old_pass" class="form-control"
                                aria-describedby="nameHelpInline" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-3">
                            <label for="new_pass" class="col-form-label">New Password</label>
                        </div>
                        <div class="col-9">
                            <input type="password" id="new_pass" name="new_pass" class="form-control"
                                aria-describedby="nameHelpInline" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-3">
                            <label for="cnew_pass" class="col-form-label">Confirm Password</label>
                        </div>
                        <div class="col-9">
                            <input type="password" id="cnew_pass" name="cnew_pass" class="form-control"
                                aria-describedby="emailHelpInline" required>
                                <span id="cpassword-label"></span>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <input type="submit" class="btn btn-primary" value="Save Changes">
                    </div>
                </div>
            </form>
        </div>
    </div>
    <?php require "partials/_footer.php"; ?>
</body>
<script>
    let password = document.getElementById("new_pass");
    let cpassword = document.getElementById("cnew_pass");
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