<?php
session_status() == PHP_SESSION_ACTIVE ?: session_start();
date_default_timezone_set("Asia/Kolkata");
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] != true || $_SESSION["in_classroom"] == null || $_SESSION["role"] != "student") {
    header("Location: index.php");
    exit;
}
if($_SERVER["REQUEST_METHOD"] == "POST") {
    $examId = $_POST["examId"];
    require "partials/_dbconnect.php";
    $sql = "select * from exams where exam_id=$examId";
    $result = mysqli_query($conn, $sql);
    $numRows = mysqli_num_rows($result);
    if ($numRows == 1) {
        $row = mysqli_fetch_assoc($result);
        $examTitle = $row["exam_title"];
        $timePerQuestion = $row["time_per_question"];
    }
}else{
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?php echo $examTitle ?>
    </title>
    <?php require "partials/_bootstrap_css.php"; ?>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/appear_test.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

</head>
<script>

</script>

<body>
    <?php require "partials/_header.php"; ?>

    <div class="screen">
        <div class="test-container">
            <div class="waiting" id="waiting">
                <span id="waittime"></span>
                <?php
                $examDateTime = new DateTime($row["exam_date_time"]);
                $currentDateTime = new DateTime();
                $timeLeft = $examDateTime->diff($currentDateTime);
                if( $timeLeft->invert == 1) {
                echo '
                <script>
                    examDate = "'. $row["exam_date_time"] .'";
                    ed = new Date(examDate);
                    let t = setInterval(() => {
                        cd = new Date();
                        daysLeft = Math.floor((ed.getTime() / (1000 * 60 * 60 * 24) - cd.getTime() / (1000 * 60 * 60 * 24)))
                        hoursLeft = Math.floor((ed.getTime() / (1000 * 60 * 60) - cd.getTime() / (1000 * 60 * 60)) % 24);
                        minutesLeft = Math.floor((ed.getTime() / (1000 * 60) - cd.getTime() / (1000 * 60)) % 60);
                        secondsLeft = Math.floor((ed.getTime() / 1000 - cd.getTime() / 1000) % 60);

                        if (hoursLeft < 1)
                            document.getElementById("waittime").style.color = "red";

                        if (secondsLeft < 0) {
                            if(secondsLeft == -1)
                                location.reload();
                            document.getElementById("waittime").style.display = "none";
                            sessionStorage.remove("currentQuestion");
                            sessionStorage.remove("total");
                            sessionStorage.remove("now");
                        }
                        else
                            document.getElementById("waittime").innerText = "Starting in : " + daysLeft + "d : " + hoursLeft + "h : " + minutesLeft + "m : " + secondsLeft + "s";
                    }, 1000)
                </script>';
                }?>
            </div>
            <?php
            $examDateTime = new DateTime($row["exam_date_time"]);
            $currentDateTime = new DateTime();
            $timeLeft = $examDateTime->diff($currentDateTime);
            if( $timeLeft->invert == 0) {
                echo '<form action="partials/_handleExamSubmission.php" method="post">
                        <input type="hidden" name="examId" value="'. $examId .'">
                        <script> document.addEventListener("DOMContentLoaded", function(){start();}) </script>';
                $sql = "select * from questions where of_exam = $examId";
                $result2 = mysqli_query($conn, $sql);
                $numRows2 = mysqli_num_rows($result2);
                for ($i = 1; $i <= $numRows2; $i++) {
                    $row2 = mysqli_fetch_assoc($result2);
                    $question = $row2["question_text"];
                    $optionA = $row2["option_a"];
                    $optionB = $row2["option_b"];
                    $optionC = $row2["option_c"];
                    $optionD = $row2["option_d"];

                    echo '
                    <div class="test-box" id="' . $i . '">
                        <div class="test-header">
                            <span>Question No. ' . $i . '</span>
                            <span>'. $examTitle .'</span>
                            <div class="timer">
                                <span>Timer</span>
                                <div class="time" id="time' . $i . '">'. $timePerQuestion .'</div>
                            </div>
                        </div>
                        <div class="test-item">
                            <div class="question">
                                <span>Q. </span>
                                <p>'. $question .'</p>
                            </div>
                            <hr class="appear">
                            <div class="options">
                                <div class="option-item">
                                    <input type="radio" name="answer'. $i .'" id="optionA' . $i . '" value="A">
                                    <label for="optionA' . $i . '"><span> A: </span></label>
                                    <label for="optionA' . $i . '">'. $optionA .'</label>
                                </div>
                                <div class="option-item">
                                    <input type="radio" name="answer'. $i .'" id="optionB' . $i . '" value="B">
                                    <label for="optionB' . $i . '"><span> B: </span></label>
                                    <label for="optionB' . $i . '">'. $optionB .'</label>
                                </div>
                                <div class="option-item">
                                    <input type="radio" name="answer'. $i .'" id="optionC' . $i . '" value="C">
                                    <label for="optionC' . $i . '"><span> C: </span></label>
                                    <label for="optionC' . $i . '">'. $optionC .'</label>
                                </div>
                                <div class="option-item">
                                    <input type="radio" name="answer'. $i .'" id="optionD' . $i . '" value="D">
                                    <label for="optionD' . $i . '"><span> D: </span></label>
                                    <label for="optionD' . $i . '">'. $optionD .'</label>
                                </div>
                            </div>
                        </div>
                        <div class="test-footer">';
                        if ($i != $numRows2) {
                            echo '<button type="button" class="btn btn-primary next" value="next' . $i . '">Next</button>';
                        } else {
                            echo '<button type="button" class="btn btn-primary submit" id="submit">Submit</button>';
                        }
                        echo '
                        </div>
                    </div>';
                }
                echo '<button type="submit" class="btn btn-primary submit" id="submitAll">Submit</button>
                </form>';
            }
            ?>
        </div>
    </div>

    <?php require "partials/_footer.php"; ?>
    <script>
    let time;
    let n;
    let d;
    let interval;
    let currentQuestion;
    let totalTime;

    function start() {
        document.getElementById("submitAll").style.visibility = "hidden";
        if (JSON.parse(sessionStorage.getItem("total")) == null) {
            d = new Date();
            d.setTime(d.getTime() + <?php echo $timePerQuestion * 1000 ?>);
            sessionStorage.setItem("total", JSON.stringify(d));
        } else {
            d = new Date(JSON.parse(sessionStorage.getItem("total")));
        }

        totalTime = Math.round(d.getTime() / 1000);

        if (sessionStorage.getItem("currentQuestion") == null)
            currentQuestion = 1;
        else {
            currentQuestion = sessionStorage.getItem("currentQuestion");
        }

        if (currentQuestion > 1) {
            document.getElementById(currentQuestion).style.display = "block";
            timer(currentQuestion);
        } else {
            document.getElementById("waiting").innerText = "Starting...";
            setTimeout(() => {
                document.getElementById(currentQuestion).style.display = "block";
                timer(currentQuestion);
            }, 1000);
        }
    }

        function timer(id) {
            if (sessionStorage.getItem("total") == null) {
                totalTime = Math.round(d.getTime() / 1000);
            } else {
                d = new Date(JSON.parse(sessionStorage.getItem("total")));
                totalTime = Math.round(d.getTime() / 1000);
            }

            interval = setInterval(function() {

                if (sessionStorage.getItem("now") == null) {
                    n = new Date();
                } else {
                    n = new Date(JSON.parse(sessionStorage.getItem("now")));
                }

                time = Math.round(n.getTime() / 1000);
                if ((totalTime - time) < 0) {
                    clearInterval(interval);
                    document.getElementById(id).childNodes[5].firstChild.click();
                } else {
                    document.getElementById("time" + id).innerText = (totalTime - time);
                    n = new Date();
                    sessionStorage.setItem("now", JSON.stringify(n));
                }
            }, 1000);
        }

    document.querySelectorAll(".next").forEach((e) => {
        e.addEventListener("click", () => {
            console.log("Next question appears");
            let nextId = parseInt(e.parentNode.parentNode.id) + 1;
            currentQuestion = nextId;
            if (document.getElementById(nextId) != null) {
                e.parentNode.parentNode.style.display = "none";
                document.getElementById("waiting").innerText = "Please wait...";
                clearInterval(interval);
                setTimeout(() => {
                    document.getElementById(nextId).style.display = "block";
                    d = new Date();
                    d.setTime(d.getTime() + <?php echo $timePerQuestion * 1000 ?>);
                    sessionStorage.setItem("total", JSON.stringify(d));
                    n = new Date();
                    timer(nextId);
                }, 1000);
            }
        })
    })

        document.getElementById("submit").addEventListener("click", ()=>{
            document.getElementById("submit").parentNode.parentNode.style.display = "none";
            document.getElementById("waiting").innerText = "Submitting...";
            setTimeout(() => {
                console.log("Exam submitted");
                document.getElementById("submitAll").click();
            }, 1000);

        })

    window.onbeforeunload = function() {
        sessionStorage.setItem("currentQuestion", currentQuestion);
    }
    </script>

</body>

</html>