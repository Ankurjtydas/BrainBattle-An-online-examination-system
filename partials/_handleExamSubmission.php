<?php
session_status() == PHP_SESSION_ACTIVE ? : session_start();
require "_dbconnect.php";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $examId = htmlspecialchars($_POST["examId"]);
    $markScored = 0;
    $sql = "select * from questions where of_exam =$examId";
    $result = mysqli_query($conn, $sql);
    $numRows = mysqli_num_rows($result);
    for($i = 1; $i <= $numRows; $i++){
        $row = mysqli_fetch_assoc($result);
        $answer = $row["correct_option"];
        $submittedAnswer = isset($_POST["answer$i"])? $_POST["answer$i"] : "";
        if($answer == $submittedAnswer){
            $markScored++;
        }
    }
    // echo 'You scored '. $markScored .' out of '. $numRows;
    $insertSql = "INSERT INTO `results` (`of_exam`, `by_user`, `mark_obtained`, `total_marks`) VALUES ('$examId', '$_SESSION[user_id]', '$markScored', '$numRows')";
    mysqli_query($conn, $insertSql);
    header("Location: ../result.php");
    exit;
}else{
    header("Location: ../index.php");
    exit;
}
?>