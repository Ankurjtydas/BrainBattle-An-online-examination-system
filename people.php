<?php
session_status() == PHP_SESSION_ACTIVE ?: session_start();
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] != true || $_SESSION["in_classroom"] == null) {
    header("Location: index.php");
    exit;
} else {
    require "partials/_dbconnect.php";
    $sql = "select * from users where in_classroom=$_SESSION[in_classroom]";
    $result = mysqli_query($conn, $sql);
    $numRows = mysqli_num_rows($result);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>People</title>
    <?php require "partials/_bootstrap_css.php"?>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/people.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>

<body>
    <?php require "partials/_header.php" ?>
    <div class="container">
        <div class="desc">
            <?php
            $sql2 = "select * from classrooms where classroom_id=$_SESSION[in_classroom]";
            $result2 = mysqli_query($conn, $sql2);
            $row2 = mysqli_fetch_assoc($result2);
            echo '<h1>People in ' . $row2["classroom_name"] . '</h1>'
                ?>
        </div>
        <div class="faculty-container">
            <div class="heading">
                <h2>Faculty</h2>
            </div>
            <div class="item">
                <div class="name">
                    <img src="images/people.png" alt="Image">
                    <span>
                        <?php
                        $result3 = mysqli_query($conn, $sql);
                        $numRows3 = mysqli_num_rows($result3);
                        for($i = 0; $i < $numRows3; $i++){
                            $row3 = mysqli_fetch_assoc($result3);
                            if($row3["role"] == "faculty")
                                echo $row3["first_name"] . ' ' . $row3["last_name"];
                        }
                        ?>
                    </span>
                </div>
            </div>
        </div>
        <!-- <hr> -->
        <div class="student-container">
            <div class="heading">
                <h2>Students</h2>
                <div class="noOfStudents">
                    <span>
                        <?php echo $numRows - 1; ?>
                    </span>
                    <span><?php if(($numRows-1) == 1) echo 'student'; else echo 'students'?></span>
                </div>
            </div>
            <div class="students">
                <?php
                for ($i = 0; $i < $numRows; $i++) {
                    $row = mysqli_fetch_assoc($result);
                    if ($row["role"] == "student") {
                        echo '
                        <div class="item">
                            <div class="name">
                                <img src="images/people.png" alt="Image">
                                <span>' . $row["first_name"] . ' ' . $row["last_name"] . '</span>
                            </div>';
                            if($_SESSION["role"] == "faculty")
                                echo '<div class="control"><abbr title="Remove"><i class="bi bi-trash-fill removeBtn"></i></abbr></div>';
                        echo '</div>';
                    }
                }
                ?>
                <!-- <div class="item">
                    <div class="name">
                        <img src="images/people.png" alt="Image">
                        <span>Student name 1</span>
                    </div>
                    <div class="control"><abbr title="Remove"><i class="bi bi-trash-fill removeBtn"></i></abbr></div>
                </div> -->
            </div>
        </div>
    </div>
    <?php require "partials/_footer.php"?>
</body>

</html>