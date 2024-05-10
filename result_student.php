<?php
session_status() == PHP_SESSION_ACTIVE ?: session_start();
require "partials/_dbconnect.php";
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] != true || $_SESSION["in_classroom"] == null || $_SESSION["role"] != "student") {
    header("Location: index.php");
    exit;
}
if (isset($_GET["result"])) {
    $resultId = $_GET["result"];
    $sql = "select * from results where result_id = '$resultId'";
    $result = mysqli_query($conn, $sql);
    $numRows = mysqli_num_rows($result);

    // exit if the result id doesn't exist
    if ($numRows != 1) {
        $alert = "The result doesn't exist.";
        header("Location: index.php?success=false&alert=$alert");
        exit;
    }
    $row = mysqli_fetch_assoc($result);

    // check if this result id belongs to the user or not
    if ($_SESSION["user_id"] != $row["by_user"]) {
        header("Location: index.php");
        exit;
    }
    $markScored = $row["mark_obtained"];
    $totalMarks = $row["total_marks"];

    // retrieving the details of exam
    $sql = "select * from exams where exam_id = $row[of_exam]";
    $result2 = mysqli_query($conn, $sql);
    $exam = mysqli_fetch_assoc($result2);
} else {
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Result - Exam Title</title>
	<?php require "partials/_bootstrap_css.php"; ?>
	<link rel="stylesheet" href="css/navbar.css">
	<link rel="stylesheet" href="css/result_student.css">
</head>

<body>
    <?php require "partials/_header.php";?>
    <div class="container">
        <div class="profile">
            <div class="profile-image">
            </div>
            <h2 class="text-center profile-name"><?php echo $_SESSION["first_name"].' '. $_SESSION["last_name"]; ?></h2>
            <div class="details">
                <span>Name : <?php echo $_SESSION["first_name"].' '. $_SESSION["last_name"]; ?></span>
                <span>Exam title : <?php echo $exam["exam_title"]; ?></span>
                <span>Exam date : <?php echo date("j/m/y", strtotime($exam["exam_date_time"])); ?></span>
                <span>Score : You scored <span class="score"><?php echo $markScored; ?></span> out of <span class="score"><?php echo $totalMarks; ?></span></span>
            </div>
            <hr>
            <p class="note">Note: Please take a screenshot for backup.</p>

        </div>
    </div>
    <?php require "partials/_footer.php"; ?>
</body>

</html>