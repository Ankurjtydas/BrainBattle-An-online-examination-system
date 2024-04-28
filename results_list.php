<?php
session_status() == PHP_SESSION_ACTIVE? : session_start();
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] != true || $_SESSION["in_classroom"] == null){
    header("Location: index.php");
    exit;
}else{
    require "partials/_dbconnect.php";
    $sql = "select * from classrooms where classroom_id = '$_SESSION[in_classroom]'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $totalStudents = $row["no_of_students"];
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
        <div class="result-container">
            <?php
            $sql = "select * from exams where of_classroom = '$_SESSION[in_classroom]' order by exam_date_time desc";
            $result = mysqli_query($conn, $sql);
            $numRows = mysqli_num_rows($result);
            if($numRows > 0){
                $displayedResults = 0;
                date_default_timezone_set("Asia/Kolkata");
                for($i=0; $i<$numRows; $i++){
                    $row = mysqli_fetch_assoc($result);
                    $examId = $row["exam_id"];
                    $examDateTime = new DateTime($row["exam_date_time"]);
                    $currentDateTime = new DateTime();
                    // $currentDateTime->modify("-15 seconds");
                    $timeLeft = $examDateTime->diff($currentDateTime);
                    if($timeLeft->invert == 0){
                        $displayedResults++;
                        $sql2 = "select * from results where of_exam='$examId' and by_user='$_SESSION[user_id]'";
                        $result2 = mysqli_query($conn, $sql2);
                        $numRows2 = mysqli_num_rows($result2);
                        echo '
            <div class="test">';
                        if($_SESSION["role"] == "faculty"){
                            echo '<a href="result_faculty.php?result='.$examId.'" class="test-detail">';
                        }else{
                            if($numRows2 == 1){
                                $row2 = mysqli_fetch_assoc($result2);
                                $resultId = $row2["result_id"];
                                echo '<a href="result_student.php?result='.$resultId.'" class="test-detail">';
                            }else{
                                echo '<a href="" class="test-detail">';
                            }
                        }
                        echo '
                    <div class="detail">
                        <span class="test-title">' . $row["exam_title"] . '</span>
                        <p class="test-description m-0">' . $row["exam_description"] . '</p>
                    </div>
                    <div class="status">';
                        if($_SESSION["role"] == "faculty"){
                            $sql = "select * from results where of_exam = '$examId'";
                            $result = mysqli_query($conn, $sql);
                            $totalStudentsAppeared = mysqli_num_rows($result);
                            echo '<span class="remark">'. $totalStudentsAppeared.'/'. $totalStudents .' students appeared</span>';
                        }else{
                            if($numRows2 == 1){
                                echo '<span class="text-success">Appeared</span>';
                            }else{
                                echo '<span class="text-danger">Missed</span>';
                            }
                        }
                    echo '
                    </div>                 
                </a>
                <div class="test-control">
                    <span class="test-time">Scheduled at : </span><br>
                    <span class="date">' . date('jS F Y', strtotime($row["exam_date_time"])) . '</span><br>
                    <span class="time">' . date('h:i A', strtotime($row["exam_date_time"])) . '</span><br>
                </div>
            </div>';
                    }
                }
                if($displayedResults == 0){
                    echo '
                <div class="test justify-content-center">
                    <h4 class="text-center">No Results Available</h4>
                </div>';
                }
            } else {
                echo '
                <div class="test justify-content-center">
                    <h4 class="text-center">No Results Available</h4>
                </div>';
            }
            ?>
        </div>
    </div>

    <?php require "partials/_footer.php"?>
</body>
</html>