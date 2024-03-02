<?php
    session_status() == PHP_SESSION_ACTIVE?: session_start();
    if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] == true){
        header("Location: index.php");
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
    <link rel="stylesheet" href="css/register.css">
</head>

<body>
    <?php require "partials/_header.php"; ?>

    <div class="register-container">
        <div class="box col-5 px-4">
            <form action="partials/_handleRegister.php" method="POST">
                <div class="register col-12">
                    <h4 class="text-center mb-3">Register</h4>
                    <div class="row mb-3 justify-content-center">
                        <div class="col-3">
                            <label for="fname" class="col-form-label">First Name</label>
                        </div>
                        <div class="col-9">
                            <input type="text" id="fname" name="fname" class="form-control" aria-describedby="nameHelpInline">
                        </div>
                    </div>
                    <div class="row mb-3 justify-content-center">
                        <div class="col-3">
                            <label for="lname" class="col-form-label">Last Name</label>
                        </div>
                        <div class="col-9">
                            <input type="text" id="lname" name="lname" class="form-control" aria-describedby="nameHelpInline">
                        </div>
                    </div>
                    <div class="row mb-3 justify-content-center">
                        <div class="col-3">
                            <label for="email" class="col-form-label">Email Address</label>
                        </div>
                        <div class="col-9">
                            <input type="email" id="email" name="email" class="form-control" aria-describedby="emailHelpInline">
                        </div>
                    </div>
                    <div class="row mb-3 justify-content-center">
                        <div class="col-3">
                            <label for="password" class="col-form-label">Password</label>
                        </div>
                        <div class="col-9">
                            <input type="password" id="password" name="password" class="form-control"
                                aria-describedby="passwordHelpInline">
                        </div>
                    </div>
                    <div class="row mb-3 justify-content-center">
                        <div class="col-3">
                            <label for="cpassword" class="col-form-label">Confirm Password</label>
                        </div>
                        <div class="col-9">
                            <input type="password" id="cpassword" name="cpassword" class="form-control"
                                aria-describedby="cpasswordHelpInline">
                            </div>
                            <span id="cpassword-label"></span>
                    </div>
                    <div class="row mb-3 justify-content-center">
                        <input type="submit" class="justify-content-center btn btn-primary" value="Register">
                    </div>
                    <hr>
                    <p class="text-center mb-0">Already have an account? <a href="login.php">Login</a></p>
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

     cpassword.addEventListener("keyup", ()=>{
         if(cpassword.value != ""){
             label.style.display = "block";
            if(password.value == cpassword.value){
                label.innerText = "Password matched";
                label.style.color = "green";
            }else{
                label.innerText = "Password do not match";
                label.style.color = "red";
            }
        }else{
            label.style.display = "none";
        }
     })

</script>
</html>