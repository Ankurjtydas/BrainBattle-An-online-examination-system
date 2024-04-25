<?php
session_status() == PHP_SESSION_ACTIVE ?: session_start();
require "_dbconnect.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $examId = htmlspecialchars($_POST["examId"]);
    $examTitle = htmlspecialchars($_POST["examTitle"]);
    $examDescription = htmlspecialchars($_POST["examDescription"]);
    $noOfQuestions = htmlspecialchars($_POST["noOfQuestions"]);
    $examDateTime = htmlspecialchars($_POST["examDateTime"]);
    $timePerQuestion = htmlspecialchars($_POST["timePerQuestion"]);

    // update exam details to database
    $sql = "UPDATE `exams` SET `exam_title` = '$examTitle', `exam_description` = '$examDescription', `no_of_questions` = '$noOfQuestions', `exam_date_time` = '$examDateTime', `time_per_question` = '$timePerQuestion' WHERE `exam_id` = $examId";
    mysqli_query($conn, $sql);

    // delete all questions of this exam
    $sql = "DELETE FROM `questions` WHERE of_exam = $examId";
    mysqli_query($conn, $sql);

    // re-adding all questions in database using loop
    for ($i = 1; $i <= $noOfQuestions; $i++) {
        $question = htmlspecialchars($_POST["questionText" . $i]);
        $optionA = htmlspecialchars($_POST["optionA" . $i]);
        $optionB = htmlspecialchars($_POST["optionB" . $i]);
        $optionC = htmlspecialchars($_POST["optionC" . $i]);
        $optionD = htmlspecialchars($_POST["optionD" . $i]);
        $correctOption = htmlspecialchars($_POST["answer" . $i]);

        $sql = "INSERT INTO `questions` (`question_text`, `option_a`, `option_b`, `option_c`, `option_d`, `correct_option`, `of_exam`, `create_at`) VALUES ('$question', '$optionA', '$optionB', '$optionC', '$optionD', '$correctOption', '$examId', current_timestamp())";
        mysqli_query($conn, $sql);
    }
    $alert = "Exam updated successfully.";
    header("Location: ../faculty_dashboard.php?success=true&alert=$alert");
    exit;
}
header("Location: ../index.php");
?>