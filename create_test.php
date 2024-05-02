<?php
session_status() == PHP_SESSION_ACTIVE ?: session_start();
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] != true || $_SESSION["in_classroom"] == null || $_SESSION["role"] != "faculty") {
    header("Location: index.php");
    exit;
}
require "partials/_dbconnect.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $examTitle = htmlspecialchars($_POST["examTitle"]);
    $examDescription = htmlspecialchars($_POST["examDescription"]);
    $noOfQuestions = htmlspecialchars($_POST["noOfQuestions"]);
    $examDateTime = htmlspecialchars($_POST["examDateTime"]);
    $timePerQuestion = htmlspecialchars($_POST["timePerQuestion"]);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require "partials/_bootstrap_css.php"; ?>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/test_create.css">
    <title>Exam Creation</title>
</head>

<body>
    <?php require "partials/_header.php"; ?>

    <div class="container">
        <form action="create_test.php" method="post">
            <div class="head">
                <h2 class="text-center">Set Exam Details</h2>
                <div class="test-details">
                    <div class="body">
                        <div class="detail-item">
                            <label for="examTitle" class="form-label">Exam title</label>
                            <?php 
                            if (!isset($examTitle)) {
                                echo '<input type="text" class="form-control" id="examTitle" name="examTitle" placeholder="e.g. Mathematics Class-test 1" required>';
                            } else {
                                echo '<input type="text" class="form-control" id="examTitle" name="examTitle" placeholder="e.g. Mathematics Class-test 1" value="' . $examTitle . '" required>';
                            }
                            ?>
                        </div>
                        <div class="detail-item">
                            <label for="examDescription" class="form-label">Description description</label>
                            <?php 
                            if (!isset($examDescription)) {
                                echo '<textarea class="form-control desc" id="examDescription" name="examDescription"
                                placeholder="e.g. Total marks - 100; Pass marks - 35"></textarea>';
                            } else {
                                echo '<textarea class="form-control desc" id="examDescription" name="examDescription"
                                placeholder="e.g. Total marks - 100; Pass marks - 35">' . $examDescription . '</textarea>';
                            }
                            ?>
                            
                        </div>
                        <div class="detail-item">
                            <label for="noOfQuestions" class="form-label">No. of questions</label>
                            <?php 
                            if (!isset($noOfQuestions)) {
                                echo '<input type="number" min="1" value="1" class="form-control" id="noOfQuestions"
                                name="noOfQuestions">';
                            } else {
                                echo '<input type="number" min="1" class="form-control" id="noOfQuestions"
                                name="noOfQuestions" value="' . $noOfQuestions . '">';
                            }
                            ?>
                        </div>
                    </div>
                    <div class="body">
                        <div class="detail-item">
                            <label for="examDateTime" class="form-label">Set Exam Date & Time</label>
                            <?php 
                            if (!isset($examDateTime)) {
                                echo '
                                <input type="datetime-local" class="form-control" id="examDateTime" name="examDateTime" required>';
                            } else {
                                echo '<input type="datetime-local" class="form-control" id="examDateTime" name="examDateTime" value="' . $examDateTime . '" required>';
                            }
                            ?>
                        </div>
                        <div class="detail-item">
                            <label for="timePerQuestion" class="form-label">Time per question (in seconds)</label>
                            <?php 
                            if (!isset($timePerQuestion)) {
                                echo '<input type="number" min="10" value="10" class="form-control" id="timePerQuestion"
                                name="timePerQuestion">';
                            } else {
                                echo '<input type="number" min="10" value="' . $timePerQuestion . '" class="form-control" id="timePerQuestion"
                                name="timePerQuestion">';
                            }
                            ?>
                        </div>
                        <button type="submit" class="btn btn-primary">Apply</button>
                    </div>
                </div>
            </div>
        </form>
        <form action="partials/_handleExamCreation.php" method="post">
            <?php
            if (isset($noOfQuestions)) {
                echo '
                    <div class="test-questions">
                    <hr>
                    <h4 class="text-center mt-1">Set Questions</h4>';
                for ($i = 1; $i <= $noOfQuestions; $i++) {
                    echo '
                            <div class="test-item">
                                <div class="question">
                                    <span>Question no. ' . $i . ' : </span>
                                    <textarea oninput="auto_grow(this)" class="question-field" name="questionText' . $i . '" id="questionText' . $i . '"></textarea>
                                </div>
                                <div class="options">
                                    <div class="option-item">
                                        <span>Option A : </span><textarea oninput="auto_grow(this)" class="option-field" type="text" name="optionA' . $i . '" id="optionA' . $i . '"></textarea>
                                    </div>
                                    <div class="option-item">
                                        <span>Option B : </span><textarea oninput="auto_grow(this)" class="option-field" type="text" name="optionB' . $i . '" id="optionB' . $i . '"></textarea>
                                    </div>
                                    <div class="option-item">
                                        <span>Option C : </span><textarea oninput="auto_grow(this)" class="option-field" type="text" name="optionC' . $i . '" id="optionC' . $i . '"></textarea>
                                    </div>
                                    <div class="option-item">
                                        <span>Option D : </span><textarea oninput="auto_grow(this)" class="option-field" type="text" name="optionD' . $i . '" id="optionD' . $i . '"></textarea>
                                    </div>
                                    <div class="option-item">
                                        <label for="answer' . $i . '">Correct answer :</label>
                                        <select id="answer' . $i . '" name="answer' . $i . '" class="answer">
                                            <option value="">Select option</option>
                                            <hr>
                                            <option value="A">Option A</option>
                                            <hr>
                                            <option value="B">Option B</option>
                                            <hr>
                                            <option value="C">Option C</option>
                                            <hr>
                                            <option value="D">Option D</option>
                                        </select>
                                    </div>
                                </div>
                            </div>';
                }
                echo '
                            <input type="hidden" value="' . $examTitle . '" name="examTitle">
                            <input type="hidden" value="' . $examDescription . '" name="examDescription">
                            <input type="hidden" value="' . $noOfQuestions . '" name="noOfQuestions">
                            <input type="hidden" value="' . $examDateTime . '" name="examDateTime">
                            <input type="hidden" value="' . $timePerQuestion . '" name="timePerQuestion">
                            <button type="submit" class="btn btn-primary">Finish</button>
                            </div>';
                        }
            ?>
        </form>
    </div>
    <script>
        let number = document.getElementById("noOfQuestions");
        number.addEventListener("focusout", () => {
            console.log(number.value);
            if (number.value < 1 && number.value != "") {
                number.value = 1;
            }
        })

        let time = document.getElementById("timePerQuestion");
        time.addEventListener("focusout", () => {
            if (time.value < 10) {
                time.value = 10;
            }
        })

        function auto_grow(element) {
            element.style.height = "5px";
            element.style.height = (element.scrollHeight) + "px";
        }
    </script>
    <?php require "partials/_footer.php"; ?>
</body>

</html>