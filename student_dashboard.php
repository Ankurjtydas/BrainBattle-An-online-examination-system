<?php
session_status() == PHP_SESSION_ACTIVE ?: session_start();
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] != true || $_SESSION["in_classroom"] == null || $_SESSION["role"] != "student") {
    header("Location: index.php");
    exit;
}

require "partials/_dbconnect.php";
$sql = "select * from classrooms where classroom_id=$_SESSION[in_classroom]";
$result = mysqli_query($conn, $sql);
$numRows = mysqli_num_rows($result);
if ($numRows == 1) {
    $row = mysqli_fetch_assoc($result);
    if ($_SESSION["in_classroom"] == $row["classroom_id"]) {
        $_SESSION["classroom_name"] = $row["classroom_name"];
        $_SESSION["classroom_description"] = $row["classroom_description"];
    }
} else {
    $alert = "The classroom have been deleted.";
    header("Location: index.php?cls=n&alert=$alert");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
    <?php require "partials/_bootstrap_css.php"; ?>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/dashboard.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>

<body>
    <?php require "partials/_header.php"; ?>

    <div class="classroom">
        <div class="classroom-details">
            <div class="faculty-image">
                <img src="" alt="Faculty Profile Image">
            </div>
            <div class="classroom-text">
                <span class="classroom-title">
                    <?php echo $_SESSION["classroom_name"] ?>
                </span><br>
                <span class="classroom-desc">
                    <?php echo $_SESSION["classroom_description"] ?>
                </span>
            </div>
        </div>
    </div>

    <hr>

    <div class="dashboard-container">

        <a href="" class="dashboard-item">
            <div class="item-image">
                <img src="images/create.png" alt="">
            </div>
            <span> ...</span>
        </a>
        <a href="" class="dashboard-item">
            <div class="item-image">
                <img src="images/group.webp" alt="">
            </div>
            <span>People</span>
        </a>
        <a href="" class="dashboard-item">
            <div class="item-image">
                <img src="images/update.png" alt="">
            </div>
            <span>Results</span>
        </a>
        <a href="" class="dashboard-item">
            <div class="item-image">
                <img src="images/update.png" alt="">
            </div>
            <span>...</span>
        </a>
        <a href="" class="dashboard-item" data-bs-toggle="modal" data-bs-target="#leaveModal">
            <div class="item-image">
                <img src="images/leave.png" alt="">
            </div>
            <span>Leave Class</span>
        </a>
    </div>

    <hr>

    <div class="test-container">
        <h2 class="text-center">Scheduled Tests</h2>
        <?php
        $sql = "select * from exams where of_classroom='$_SESSION[in_classroom]' order by exam_date_time";
        $result = mysqli_query($conn, $sql);
        $numRows = mysqli_num_rows($result);
        if ($numRows > 0) {
            $displayedExams = 0;
            date_default_timezone_set("Asia/Kolkata");
            for ($i = 0; $i < $numRows; $i++) {
                $row = mysqli_fetch_assoc($result);
                $examId = $row["exam_id"];
                $noOfQuestions = $row["no_of_questions"];
                $timePerQuestion = $row["time_per_question"];
                $examDateTime = new DateTime($row["exam_date_time"]);
                $currentDateTime = new DateTime();
                // echo $currentDateTime->format("%H %m %s");
                $currentDateTime->modify("-15 seconds");
                // echo $currentDateTime->format("%H %m %s");
                $timeLeft = $examDateTime->diff($currentDateTime);
                if( $timeLeft->invert == 1) {
                    $displayedExams++;
                echo '
        <div class="test" id="test'. $i .'">
            <div class="test-detail" style="cursor: pointer;" data-bs-toggle="modal" data-bs-target="#appearExamModal">
                <input type="hidden" value="'. $examId .'">
                <input type="hidden" value="'. $noOfQuestions .'">
                <input type="hidden" value="'. $timePerQuestion .'">
                <div class="detail">
                    <span class="test-title">' . $row["exam_title"] . '</span>
                    <p class="test-description m-0">' . $row["exam_description"] . '</p>
                </div>
                <div class="timer" id="timer'. $i .'">
                    <span id="timertext'. $i .'"></span>
                    <span class="time" id="time'. $i .'">
                        <script>
                            examDate'. $i .' = "'. $row["exam_date_time"].'";
                            ed'. $i .' = new Date(examDate'. $i .');
                            setInterval(()=>{
                                cd = new Date();
                                hoursLeft = Math.floor((ed'. $i .'.getTime()/(1000*60*60)-cd.getTime()/(1000*60*60))%60);
                                minutesLeft = Math.floor((ed'. $i .'.getTime()/(1000*60)-cd.getTime()/(1000*60))%60);
                                secondsLeft = Math.floor((ed'. $i .'.getTime()/1000-cd.getTime()/1000)%60);
                                if((ed'. $i .'.getDate() - cd.getDate()) == 0){
                                    document.getElementById("timer'. $i .'").style.display = "block";
                                    if(hoursLeft <1)
                                        document.getElementById("timer'. $i .'").style.color = "red";
                                    if(secondsLeft<=0){
                                        if(secondsLeft==0)
                                            location.reload();
                                        if(secondsLeft <= -15)
                                            location.reload();
                                        document.getElementById("time'. $i .'").innerText = "Exam has started. Join Before : "+(15+secondsLeft)+" seconds";
                                    }else
                                        document.getElementById("time'. $i .'").innerText = "Starting in : "+hoursLeft+" : "+minutesLeft+" : "+secondsLeft;
                                }
                            },1000)
                        </script>
                    </span>
                </div>
            </div>
            <div class="test-control">
                <span class="test-time">Scheduled at : </span><br>
                <span class="date">' . date('jS F Y', strtotime($row["exam_date_time"])) . '</span><br>
                <span class="time">' . date('h:i A', strtotime($row["exam_date_time"])) . '</span><br>
            </div>
        </div>';
        echo '
            ';
                }
            }
            if($displayedExams == 0){
                echo '
            <div class="test justify-content-center">
                <h4 class="text-center">No Scheduled Test</h4>
            </div>';
            }
        } else {
            echo '
            <div class="test justify-content-center">
                <h4 class="text-center">No Scheduled Test</h4>
            </div>';
        }
        ?>

    </div>

    <!-- leaveModal -->
    <div class="modal fade" id="leaveModal" tabindex="-1" aria-labelledby="leaveModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="leaveModalLabel">Leave Classroom</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h6>Are you sure to leave the classroom.</h6>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <a href="partials/_handleLeaveClass.php" type="button" class="btn btn-primary">Leave</a>
                </div>
            </div>
        </div>
    </div>
    
    <!-- appearExamModal -->
    <div class="modal fade" id="appearExamModal" tabindex="-1" aria-labelledby="appearExamLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="appearExamLabel">Join Exam</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="appear_test.php" method="post">
                        <div class="modal-body">
                            <input type="hidden" name="examId" id="examId" value="">
                            <h6>Instructions for the Exam</h6>
                            <ul>
                            <li>Total no. of questions : <span id="totalQuestions"></span></li>
                            <li>Time for each question : <span id="seconds"></span> seconds</li>
                            </ul>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Join</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    <?php require "partials/_footer.php"; ?>
    <script>
        document.querySelectorAll(".test-detail").forEach((e)=>{
            e.addEventListener("click", ()=>{
                let eId = e.childNodes[1].value;
                let noOfQuestions = e.childNodes[3].value;
                let timePerQuestion = e.childNodes[5].value;
                document.getElementById("examId").value = eId;
                document.getElementById("totalQuestions").innerText = noOfQuestions;
                document.getElementById("seconds").innerText = timePerQuestion;
                sessionStorage.clear();
            })
        })
    </script>

</body>

</html>