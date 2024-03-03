<?php
session_status() == PHP_SESSION_ACTIVE ?: session_start();
require "_dbconnect.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // $examTitle = $_POST["examTitle"];
    // $examDescription = $_POST["examDescription"];
    // $noOfQuestions = $_POST["noOfQuestions"];
    // $examDate = $_POST["examDate"];
    // $examTime = $_POST["examTime"];
    // $timePerQuestion = $_POST["timePerQuestion"];
    $noOfQuestions = $_POST["noOfQns"];

    // adding all question in database using loop
    for ($i = 1; $i <= $noOfQuestions; $i++) {
        $examId = $_POST["examId"];
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