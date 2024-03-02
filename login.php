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
  <title>Log in to BrainBattle</title>
  <?php require "partials/_bootstrap_css.php"; ?>
  <link rel="stylesheet" href="css/login.css">
</head>

<body>
    <?php require "partials/_header.php"; ?>

  <div class="login-container">
    <div class="box col-4 px-4">
      <form action="partials/_handleLogin.php" method="POST">
        <div class="login col-12">
          <h4 class="text-center mb-3">Login</h4>
          <div class="row mb-3 justify-content-center">
            <div class="col-3">
              <label for="email" class="col-form-label">Email</label>
            </div>
            <div class="col-9">
              <input type="email" id="email" name="email" class="form-control" aria-describedby="passwordHelpInline">
            </div>
          </div>
          <div class="row mb-3 justify-content-center">
            <div class="col-3">
              <label for="password" class="col-form-label">Password</label>
            </div>
            <div class="col-9">
              <input type="password" id="password" name="password" class="form-control" aria-describedby="passwordHelpInline">
              <a href="#">Forget Password?</a>
            </div>
          </div>
          <div class="row mb-3 justify-content-center">
            <input type="submit" class="btn btn-primary" value="Login">
          </div>
          <hr>
          <p class="text-center mb-0">New User? <a href="register.php">Register</a></p>
        </div>
      </form>
    </div>
  </div>
  <?php require "partials/_footer.php"; ?>
</body>

</html>