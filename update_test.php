<?php
session_status() == PHP_SESSION_ACTIVE ?: session_start();
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] != true || $_SESSION["in_classroom"] == null || $_SESSION["role"] != "faculty") {
    header("Location: index.php");
    exit;
}
require "partials/_dbconnect.php";

$examId;
if (isset($_GET["id"])) {
    $examId = $_GET["id"];
    $sql = "select * from exams where exam_id=$examId";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);

    // check if the exam belongs to the logged in user's class
    $of_classroom = $row["of_classroom"];
    if($_SESSION["in_classroom"] != $of_classroom){
        $alert = "This exam do not belong to your class";
        header("Location: index.php?success=false&alert=$alert");
        exit;
    }

    $examTitle = $row["exam_title"];
    $examDescription = $row["exam_description"];
    $noOfQuestions = $row["no_of_questions"];
    $examDateTime = $row["exam_date_time"];
    $timePerQuestion = $row["time_per_question"];
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $examId = htmlspecialchars($_POST["examId"]);
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
    <title>Update Exam</title>
</head>

<body>
    <?php require "partials/_header.php"; ?>

    <div class="container">
        <form action="update_test.php" method="post">
            <div class="head">
                <h2 class="text-center">Update Exam Details</h2>
                <div class="test-details">
                    <div class="body">
                        <?php echo '<input type="hidden" name="examId" value="'. $examId .'">'; ?>
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
                            <label for="examDateTime" class="form-label">Set Exam Date</label>
                            <?php 
                            if (!isset($examDateTime)) {
                                echo '<input type="datetime-local" class="form-control" id="examDateTime" name="examDateTime" required>';
                            } else {
                                echo '<input type="datetime-local" class="form-control" id="examDateTime" name="examDateTime" value="' . $examDateTime . '" required>';
                            }
                            ?>
                        </div>
                        <div class="detail-item">
                            <label for="timePerQuestion" class="form-label">Time per question (in second)</label>
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
        <form action="partials/_handleExamUpdation.php" method="post">
            <?php
            if (isset($noOfQuestions)) {
                $sql = "select * from questions where of_exam=$examId";
                $result = mysqli_query($conn, $sql);
                echo '
                <div class="test-questions">
                <hr>
                <h4 class="text-center mt-1">Set Questions</h4>';
                for ($i = 1; $i <= $noOfQuestions; $i++) {
                    if($row = mysqli_fetch_assoc($result)) {
                    echo '
                            <div class="test-item">
                                <div class="question">
                                    <span>Question no. ' . $i . ' : </span>
                                    <textarea oninput="auto_grow(this)" class="question-field" name="questionText' . $i . '" id="questionText' . $i . '">'. $row["question_text"] .'</textarea>
                                </div>
                                <div class="options">
                                    <div class="option-item">
                                        <span>Option A : </span><textarea oninput="auto_grow(this)" class="option-field" type="text" name="optionA' . $i . '" id="optionA' . $i . '">'. $row["option_a"] .'</textarea>
                                    </div>
                                    <div class="option-item">
                                        <span>Option B : </span><textarea oninput="auto_grow(this)" class="option-field" type="text" name="optionB' . $i . '" id="optionB' . $i . '">'. $row["option_b"] .'</textarea>
                                    </div>
                                    <div class="option-item">
                                        <span>Option C : </span><textarea oninput="auto_grow(this)" class="option-field" type="text" name="optionC' . $i . '" id="optionC' . $i . '">'. $row["option_c"] .'</textarea>
                                    </div>
                                    <div class="option-item">
                                        <span>Option D : </span><textarea oninput="auto_grow(this)" class="option-field" type="text" name="optionD' . $i . '" id="optionD' . $i . '">'. $row["option_d"] .'</textarea>
                                    </div>
                                    <div class="option-item">
                                        <label for="answer' . $i . '">Correct answer :</label>
                                        <select id="answer' . $i . '" name="answer' . $i . '" class="answer">';
                                            if($row["correct_option"] == "A") {
                                                echo '<option value="" selected>Select option</option>';
                                            } else{
                                                echo '<option value="">Select option</option>';
                                            }
                                            if($row["correct_option"] == "A") {
                                                echo '<hr>
                                                <option value="A" selected>Option A</option>';
                                            } else{
                                                echo '<hr>
                                                <option value="A">Option A</option>';
                                            }
                                            if($row["correct_option"] == "B") {
                                                echo '<hr>
                                                <option value="B" selected>Option B</option>';
                                            } else{
                                                echo '<hr>
                                                <option value="B">Option B</option>';
                                            }
                                            if($row["correct_option"] == "C") {
                                                echo '<hr>
                                                <option value="C" selected>Option C</option>';
                                            } else{
                                                echo '<hr>
                                                <option value="C">Option C</option>';
                                            }
                                            if($row["correct_option"] == "D") {
                                                echo '<hr>
                                                <option value="D" selected>Option C</option>';
                                            } else{
                                                echo '<hr>
                                                <option value="D">Option D</option>';
                                            }
                                echo '
                                        </select>
                                    </div>
                                </div>
                            </div>';
                    }else{
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
                }
                echo '
                            <input type="hidden" value="' . $examId . '" name="examId">
                            <input type="hidden" value="' . $examTitle . '" name="examTitle">
                            <input type="hidden" value="' . $examDescription . '" name="examDescription">
                            <input type="hidden" value="' . $noOfQuestions . '" name="noOfQuestions">
                            <input type="hidden" value="' . $examDateTime . '" name="examDateTime">
                            <input type="hidden" value="' . $timePerQuestion . '" name="timePerQuestion">
                            <button type="submit" class="btn btn-primary">Update</button>
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