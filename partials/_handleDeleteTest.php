<?php
session_status() == PHP_SESSION_ACTIVE ?: session_start();
require "_dbconnect.php";

if ($_SESSION["in_classroom"] != null) {
    if ($_SESSION["role"] == "faculty") {
        if (isset($_GET["id"])) {
            $examId = $_GET["id"];

            // delete exam with get Id
            $sql = "DELETE FROM  `exams` WHERE `exam_id` = '$examId'";
            $result = mysqli_query($conn, $sql);

            if ($result == 1) {
                // update questions table; remove questions of that exam
                $sql = "DELETE FROM  `questions` WHERE `of_exam` = '$examId'";
                mysqli_query($conn, $sql);
                $alert = "Exam successfully deleted";
                header("Location: ../faculty_dashboard.php?success=true&alert=$alert");
                exit;
            }
        }
    }
}

?>