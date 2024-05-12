<?php
    session_status() == PHP_SESSION_ACTIVE ? : session_start();
   if(isset($_SESSION["verification"]) && $_SESSION["verification"] == true){
        $tempUser = $_SESSION["temp_user"];
    }else{
        // echo "no verification";
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        .container {
            width: 100vw;
            height: 100vh;
            padding-top: 3rem;
        }
        form{
            margin: 0 auto;
        }
        .verify-btn{
            margin: 10px 0;
        }
    </style>
</head>

<body>
    <?php include 'partials/_header.php'; ?>
    <div class="container">
        <form action="partials/_handleVerifyOtp.php" method="post">
            <h2>Verify your email Id</h2>
            <div class="input">
                <label for="otp" class="form-label">OTP :</label>
                <input type="text" class="form-control" id="otp" name="otp">
            </div>
            <p>An OTP has been sent to your email <?php echo $tempUser["email"];?>.</p>
            <button type="submit" class="btn btn-primary verify-btn">Verify</button>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</body>

</html>