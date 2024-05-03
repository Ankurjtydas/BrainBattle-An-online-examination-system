<?php
// session_status() == PHP_SESSION_ACTIVE ?: session_start();
// date_default_timezone_set("Asia/Kolkata");
// if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] != true || $_SESSION["in_classroom"] == null || $_SESSION["role"] != "student") {
//     header("Location: index.php");
//     exit;
// }
// if($_SERVER["REQUEST_METHOD"] == "POST") {
//     $examId = htmlspecialchars($_POST["examId"]);
//     require "partials/_dbconnect.php";
//     $sql = "select * from exams where exam_id=$examId";
//     $result = mysqli_query($conn, $sql);
//     $numRows = mysqli_num_rows($result);
//     if ($numRows == 1) {
//         $row = mysqli_fetch_assoc($result);
//         $examTitle = $row["exam_title"];
//         $timePerQuestion = $row["time_per_question"];
//     }
// }else{
//     header("Location: index.php");
//     exit;
// }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
    </title>
    <?php require "partials/_bootstrap_css.php"; ?>
    <link rel="stylesheet" href="css/navbar.css">
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
                Timer
                <!-- <script>
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
                            sessionStorage.removeItem("currentQuestion");
                            sessionStorage.removeItem("total");
                            sessionStorage.removeItem("now");
                        }
                        else
                            document.getElementById("waittime").innerText = "Starting in : " + daysLeft + "d : " + hoursLeft + "h : " + minutesLeft + "m : " + secondsLeft + "s";
                    }, 1000)
                </script>'; -->
            </div>
            <form action="" method="post">
                <input type="hidden" name="examId" value="">
                <!-- <script> document.addEventListener("DOMContentLoaded", function () { start(); }) </script> -->

                <div class="test-box" id="">
                    <div class="test-header">
                        <span>Question No. 1</span>
                        <span>Class Test -1 </span>
                        <!-- <div class="timer"> -->
                            <!-- <span>Timer</span>
                            <div class="time" id="time">15</div> -->
                        

                    <div class="test-item">
                        <div class="question">
                            <span>Q. </span>
                            <p>What is your name? Why are you here in this world? What is your target</p>
                        </div>
                        <hr class="appear">
                        <div class="options">
                            <div class="option-item">
                                <input type="radio" name="answer" id="optionA" value="A">
                                <label for="optionA"><span> A: </span></label>
                                <label for="optionA">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Maxime,
                                    minima quaerat! Optio, necessitatibus sit ea architecto fugiat soluta est
                                    tempore.</label>
                            </div>
                            <div class="option-item">
                                <input type="radio" name="answer" id="optionB" value="B">
                                <label for="optionB"><span> B: </span></label>
                                <label for="optionB">Lorem ipsum dolor sit amet consectetur adipisicing elit. Odit,
                                    ea!</label>
                            </div>
                            <div class="option-item">
                                <input type="radio" name="answer" id="optionC" value="C">
                                <label for="optionC"><span> C: </span></label>
                                <label for="optionC">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Aliquam
                                    debitis mollitia aliquid quaerat culpa totam.</label>
                            </div>
                            <div class="option-item">
                                <input type="radio" name="answer" id="optionD" value="D">
                                <label for="optionD"><span> D: </span></label>
                                <label for="optionD">Lorem ipsum dolor sit amet consectetur adipisicing elit. Nemo,
                                    nostrum asperiores doloremque, fugiat quidem sequi, repellendus sunt aspernatur
                                    adipisci deleniti accusantium porro quaerat vitae saepe neque repudiandae quia nulla
                                    sit.</label>
                            </div>
                        </div>
                    </div>
                    <div class="test-footer">
                        <button type="button" class="btn btn-primary next" value="next">Next</button>';
                        <button type="button" class="btn btn-primary submit" id="submit">Submit</button>';

                    </div>
                    </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary submit" id="submitAll">Submit</button>
            </form>


        </div>
    </div>

    <?php require "partials/_footer.php"; ?>
    <!-- <script>
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
                d.setTime(d.getTime());
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

            interval = setInterval(function () {

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
                        d.setTime(d.getTime() +);
                        sessionStorage.setItem("total", JSON.stringify(d));
                        n = new Date();
                        timer(nextId);
                    }, 1000);
                }
            })
        })

        document.getElementById("submit").addEventListener("click", () => {
            document.getElementById("submit").parentNode.parentNode.style.display = "none";
            document.getElementById("waiting").innerText = "Submitting...";
            setTimeout(() => {
                console.log("Exam submitted");
                document.getElementById("submitAll").click();
            }, 1000);

        })

        window.onbeforeunload = function () {
            sessionStorage.setItem("currentQuestion", currentQuestion);
        }
    </script> -->

</body>

</html>