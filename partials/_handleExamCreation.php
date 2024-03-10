<?php
session_status() == PHP_SESSION_ACTIVE ?: session_start();
require "_dbconnect.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $examTitle = $_POST["examTitle"];
    $examDescription = $_POST["examDescription"];
    $noOfQuestions = $_POST["noOfQuestions"];
    $examDate = $_POST["examDate"];
    $examTime = $_POST["examTime"];
    $timePerQuestion = $_POST["timePerQuestion"];

    // add exam details to database
    $sql = "INSERT INTO `exams` (`exam_title`, `exam_description`, `no_of_questions`, `exam_date`, `exam_time`, `time_per_question`, `of_classroom`, `create_at`) VALUES ('$examTitle', '$examDescription', '$noOfQuestions', '$examDate', '$examTime', '$timePerQuestion', '$_SESSION[in_classroom]', current_timestamp())";
    $result = mysqli_query($conn, $sql);

    // get id of created exam
    $sql = "select * from exams where exam_id = (select max(exam_id) from exams)";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $examId = $row["exam_id"];

    // adding all questions in database using loop
    for ($i = 1; $i <= $noOfQuestions; $i++) {
        $question = $_POST["questionText". $i];
        $optionA = $_POST["optionA". $i];
        $optionB = $_POST["optionB". $i];
        $optionC = $_POST["optionC". $i];
        $optionD = $_POST["optionD". $i];
        $correctOption = $_POST["answer". $i];
        
        $sql = "INSERT INTO `questions` (`question_text`, `option_a`, `option_b`, `option_c`, `option_d`, `correct_option`, `of_exam`, `create_at`) VALUES ('$question', '$optionA', '$optionB', '$optionC', '$optionD', '$correctOption', '$examId', current_timestamp())";
        $result = mysqli_query($conn, $sql);
    }
    $alert = "Exam created successfully.";
    header("Location: ../faculty_dashboard.php?success=true&alert=$alert");
}
?>