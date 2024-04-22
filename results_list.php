<?php
session_status() == PHP_SESSION_ACTIVE? : session_start();
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] != true){
    header("Location: index.php");
    exit;
}else{
    require "partials/_dbconnect.php";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Results</title>
    <?php require "partials/_bootstrap_css.php"?>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/results_list.css">
</head>
<body>
    <?php require "partials/_header.php" ?>
    
    <div class="container">
        <div class="desc">
            <h1>Results</h1>
        </div>
        <div class="result_container">
            <?php
            $sql = "select * from exams where of_classroom = '$_SESSION[in_classroom]'";
            $result = mysqli_query($conn, $sql);
            $numRows = mysqli_num_rows($result);
            echo $numRows;
            for($i=0; $i<$numRows; $i++){
                $row = mysqli_fetch_assoc($result);
                echo '
            <div class="test" id="test">
                <div class="test-detail">
                        <span class="test-title">' . $row["exam_title"] . '</span>
                        <p class="test-description m-0">' . $row["exam_description"] . '</p>                    
                </div>
                <div class="test-control">
                    <span class="test-time">Scheduled at : </span><br>
                    <span class="date">' . date('jS F Y', strtotime($row["exam_date_time"])) . '</span><br>
                    <span class="time">' . date('h:i A', strtotime($row["exam_date_time"])) . '</span><br>
                </div>
            </div>';
            }
            //     echo '
            // <div class="test" id="test">
            //     <div class="test-detail">
            //         <!-- <input type="hidden" value="'. $examId .'"> -->
            //             <!-- <span class="test-title">' . $row["exam_title"] . '</span> -->
            //             <span class="test-title">Exam Title</span>
            //             <!-- <p class="test-description m-0">' . $row["exam_description"] . '</p> -->
            //             <p class="test-description m-0">Exam Description Lorem ipsum dolor sit amet consectetur, adipisicing elit. Qui, beatae.</p>                    
            //     </div>
            //     <div class="test-control">
            //         <span class="test-time">Scheduled at : </span><br>
            //         <!-- <span class="date">' . date('jS F Y', strtotime($row["exam_date_time"])) . '</span><br> -->
            //         <!-- <span class="time">' . date('h:i A', strtotime($row["exam_date_time"])) . '</span><br> -->
            //     </div>
            // </div>';
            
            ?>
        </div>
    </div>

    <?php require "partials/_footer.php"?>
</body>
</html>