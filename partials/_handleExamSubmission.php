<?php
session_status() == PHP_SESSION_ACTIVE ?: session_start();
require "_dbconnect.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $examId = htmlspecialchars($_POST["examId"]);

    // check if the user have already given this exam or not
    $sql = "select * from results where of_exam =$examId and by_user = $_SESSION[user_id]";
    $result = mysqli_query($conn, $sql);
    $numRows = mysqli_num_rows($result);
    if ($numRows != 0) {
        $alert = "You have already given this exam.";
        header("Location: ../student_dashboard.php?success=false&alert=$alert");
        exit;
    }

    $markScored = 0;
    $sql = "select * from questions where of_exam =$examId";
    $result = mysqli_query($conn, $sql);
    $numRows = mysqli_num_rows($result);
    for ($i = 1; $i <= $numRows; $i++) {
        $row = mysqli_fetch_assoc($result);
        $answer = $row["correct_option"];
        $submittedAnswer = isset($_POST["answer$i"]) ? $_POST["answer$i"] : "";
        if ($answer == $submittedAnswer) {
            $markScored++;
        }
    }
    // echo 'You scored '. $markScored .' out of '. $numRows;
    $insertSql = "INSERT INTO `results` (`of_exam`, `by_user`, `mark_obtained`, `total_marks`, `created_at`) VALUES ('$examId', '$_SESSION[user_id]', '$markScored', '$numRows', current_timestamp())";
    mysqli_query($conn, $insertSql);
    $sql = "select * from results where by_user = '$_SESSION[user_id]' order by created_at desc limit 1";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    header("Location: ../result_student.php?result=$row[result_id]");
    exit;
} else {
    header("Location: ../index.php");
    exit;
}
?>