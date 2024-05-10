<?php
session_status() == PHP_SESSION_ACTIVE ?: session_start();
require "partials/_dbconnect.php";
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] != true) {
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>User Profile - <?php echo $_SESSION["first_name"] . ' ' . $_SESSION["last_name"]; ?></title>
    <?php require "partials/_bootstrap_css.php"; ?>
    <link rel="stylesheet" href="css/navbar.css">
    <link rel="stylesheet" href="css/profile.css">
</head>

<body>
    <?php require "partials/_header.php"; ?>
    <div class="container">
        <div class="profile">
            <div class="profile-image"></div>
            <h2 class="text-center profile-name">
                <?php echo $_SESSION["first_name"] . ' ' . $_SESSION["last_name"]; ?>
            </h2>
            <div class="details">
                <div class="item">
                    <label>Name : </label>
                    <span><?php echo $_SESSION["first_name"] . ' ' . $_SESSION["last_name"]; ?></span>
                </div>
                <div class="item">
                    <label>Email : </label>
                    <span><?php echo $_SESSION["email"]; ?></span>
                </div>
                <div class="item">
                    <label>Classroom : </label>
                    
                        <?php
                        if($_SESSION["in_classroom"] != null){
                            $sql = "select * from classrooms where classroom_id = '$_SESSION[in_classroom]'";
                            $result = mysqli_query($conn, $sql);
                            $row = mysqli_fetch_assoc($result);
                            echo '<span>'.$row["classroom_name"] . ' (' . $_SESSION["role"] . ')';
                        }else{
                            echo '<span class="text-danger">You are currently not in a class';
                        }
                        ?>
                    </span>
                </div>
            </div>
            <hr>
            <div class="buttons">
                <a href="change_password.php" class="btn btn-warning change-pass-btn">Change password</a>
                <a href="edit_profile.php" class="edit btn btn-primary">Edit profile</a>
            </div>
        </div>
    </div>
    <?php require "partials/_footer.php"; ?>
</body>

</html>