<?php
session_status() == PHP_SESSION_ACTIVE ?: session_start();
require "partials/_dbconnect.php";
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] != true || $_SESSION["in_classroom"] == null || $_SESSION["role"] != "student") {
    header("Location: index.php");
    exit;
}
if (isset($_GET["result"])) {
    $resultId = $_GET["result"];
    $sql = "select * from results where result_id = '$resultId'";
    $result = mysqli_query($conn, $sql);
    $numRows = mysqli_num_rows($result);

    // exit if the result id doesn't exist
    if ($numRows != 1) {
        $alert = "The result doesn't exist.";
        header("Location: index.php?success=false&alert=$alert");
        exit;
    }
    $row = mysqli_fetch_assoc($result);

    // check if this result id belongs to the user or not
    if ($_SESSION["user_id"] != $row["by_user"]) {
        header("Location: index.php");
        exit;
    }
    $markScored = $row["mark_obtained"];
    $totalMarks = $row["total_marks"];
} else {
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Result - Exam Title</title>
</head>
<style>
    * {
        margin: 0;
        padding: 0;
    }

    body {
        width: 100vw;
        height: 100vh;
        position: relative;
        overflow: hidden;
    }

    body::before {
        content: "";
        background: url(images/result_background.jpeg);
        position: absolute;
        height: 100vh;
        width: 100%;
        top: 0;
        left: 0;
        z-index: -1;
        opacity: 1;
        background-repeat: no-repeat;
        background-position: center 0vh;
        filter: brightness(50%);
    }

    .container {
        border: 2px solid lightblue;
        width: 100%;

    }

    .profile {
        //border: 2px solid brown;
        width: 500px;
        padding: 30px;
        margin-left: auto;
        margin-right: auto;
        height: fit-content;
        margin-top: 110px;
        background-color: white;
        border-radius: 45px;
    }

    .profile-image {
        border: 2px solid lightblue;
        width: 100px;
        height: 100px;
        border-radius: 50%;
        margin-left: auto;
        margin-right: auto;
        background: url(images/profile.png);
        background-size: cover;
    }

    h2 {
        width: fit-content;
        margin: 15px auto;
        margin-bottom: 50px;
        font-size: 25px;
    }

    span {
        display: block;
        margin: 10px 0;

    }

    .details {
        margin: 20px 0;
        font-size: 20px;
    }
    .score{
        display: inline;
        font-weight: bold;
        font-size: larger;
    }
</style>

<body>
    <div class="container">
        <div class="profile">
            <div class="profile-image">
            </div>
            <h2>hunmely hansepi</h2>
            <div class="details">
                <span>Name: Hunmely Hansepi</span>
                <span>Exam title: CNS</span>
                <span>Score: <span class="score">10</span> out of <span class="score">15</span></span>

            </div>
            <p>Note: Lorem ipsum dolor sit amet consectetur adipisicing elit. Aliquam quasi temporibus possimus, rerum
                laudantium eveniet!</p>

        </div>
    </div>
</body>

</html>