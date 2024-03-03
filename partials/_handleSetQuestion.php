<?php
session_status() == PHP_SESSION_ACTIVE ? : session_start();
require "_dbconnect.php";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    switch($_POST["submit"]){
        case "apply":
            $examTitle = $_POST["examTitle"];
            $examDescription = $_POST["examDescription"];
            $noOfQuestions = $_POST["noOfQuestions"];
            $examDate = $_POST["examDate"];
            $examTime = $_POST["examTime"];
            $timePerQuestion = $_POST["timePerQuestion"];
        break;
        case "create":

        break;
}
}
?>