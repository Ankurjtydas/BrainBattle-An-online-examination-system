<?php
session_status() == PHP_SESSION_ACTIVE?:session_start();
require "partials/_dbconnect.php";
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] != true || $_SESSION["in_classroom"] == null || $_SESSION["role"] != "student"){
    header("Location: index.php");
    exit;
}
if(isset($_GET["result"])){
    $resultId = $_GET["result"];
    $sql = "select * from results where result_id = '$resultId'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    if($_SESSION["user_id"] != $row["by_user"]){
        header("Location: index.php");
        exit;
    }
    $markScored = $row["mark_obtained"];
    $totalMarks = $row["total_marks"];
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
        /* background-color: rgb(240, 240, 240); */
        position: relative;
        display: flex;
        justify-content: center;
    }

    .container {
        width: 100%;
        height: 70%;
        border: 2px solid black;
        margin: 0 auto;
        margin-top: 150px;
        text-align: center;
        position: relative;
        padding: 20px;
    }

    .name {
        position: absolute;
        top: -17px;
        left: 50%;
        background-color: white;
        padding: 4px 7px;
    }

    .score {
        font-size: 1.2rem;
    }
</style>
<body>
    <div class="container">
        <div class="image"></div>   
        <h2 class="name"><?php echo $_SESSION["first_name"]." ".$_SESSION["first_name"]?></h2>
        <span class="score"><?php echo "Scored ".$markScored." out of ".$totalMarks;?></span>
    </div>
</body>
</html>