<?php
session_status() == PHP_SESSION_ACTIVE ?: session_start();
require "partials/_dbconnect.php";
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] != true || $_SESSION["role"] != "faculty" || $_SESSION["in_classroom"] == null) {
    header("Location: error.php");
    exit;
}
if (isset($_GET["exam"])) {
    $examId = $_GET["exam"];
    $sql = "select * from exams where exam_id = '$examId'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    if ($_SESSION["in_classroom"] != $row["of_classroom"]) {
        header("Location: error.php");
        exit;
    }
    $sql2 = "select classroom_name from classrooms where classroom_id = '$_SESSION[in_classroom]'";
    $result2 = mysqli_query($conn, $sql2);
    $row2 = mysqli_fetch_assoc($result2);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $row["exam_title"] . ' - Result'; ?></title>
    <?php include "partials/_bootstrap_css.php"; ?>
    <link rel="stylesheet" href="css/navbar.css">
    <link rel="stylesheet" href="css/result_faculty.css">
</head>

<body>
    <?php require "partials/_header.php"; ?>
    <div class="container">
        <div id="result">
            <div class="exam-detail">
                <?php
                echo '
                <textarea id="head" oninput="auto_grow(this)"
                    placeholder="Department&#10;Subject&#10;Date: exam date&#10;Other details"
                    readonly>' . $row2["classroom_name"] . '&#10;' . $row["exam_title"] . '&#10;Date: ' . date('j/m/y', strtotime($row["exam_date_time"])) . '</textarea>
                <div class="buttons">';
                ?>
                <button id="customize-btn" class="btn btn-sm btn-primary">Customize header</button>
                <button id="done-btn" class="btn btn-sm btn-primary">Done</button>
            </div>
        </div>
        <table class="result-table table table-bordered">
            <thead>
                <tr>
                    <th class="sl">Sl no.</th>
                    <th class="name">Name</th>
                    <th class="mark">Marks (<?php echo $row["no_of_questions"]; ?>)</th>
                </tr>
            </thead>
            <tbody class="table-group-divider">
                <?php
                $sql = "select * from users where in_classroom = '$_SESSION[in_classroom]' and role = 'student'";
                $result = mysqli_query($conn, $sql);
                $totalStudents = mysqli_num_rows($result);
                for ($i = 1; $i <= $totalStudents; $i++) {
                    $row = mysqli_fetch_assoc($result);
                    $sql = "select * from results where of_exam = '$examId' and by_user = '$row[user_id]'";
                    $result2 = mysqli_query($conn, $sql);
                    $numRows = mysqli_num_rows($result2);
                    echo '
                        <tr>
                            <td class="sl">' . $i . '</td>
                            <td class="name">' . $row["first_name"] . ' ' . $row["last_name"] . '</td>';
                    if ($numRows == 1) {
                        $row2 = mysqli_fetch_assoc($result2);
                        echo '<td class="mark">' . $row2["mark_obtained"] . '</td>';
                    }else{
                        echo '<td class="mark">F</td>';
                    }
                    echo '
                        </tr>';
                }
                ?>
                <!-- <tr>
                    <td class="sl">1</td>
                    <td class="name">ABC</td>
                    <td class="mark">14</td>
                </tr>
                <tr>
                    <td class="sl">2</td>
                    <td class="name">XYZ</td>
                    <td class="mark">12</td>
                </tr> -->
            </tbody>
        </table>
    </div>
    <button id="print-btn" class="btn btn-sm btn-danger">Print</button>
    </div>
    <?php require "partials/_footer.php"; ?>
    <script>

        document.getElementById("customize-btn").style.display = "block";
        document.getElementById("done-btn").style.display = "none";

        document.getElementById("print-btn").addEventListener("click", () => {
            if (document.getElementById("customize-btn").style.display == "block")
                window.print();
            else
                alert("Complete the editing first to print.")
        })

        function auto_grow(element) {
            element.style.height = "5px";
            element.style.height = (element.scrollHeight) + "px";
        }

        document.getElementById("customize-btn").addEventListener("click", (e) => {
            document.getElementById("head").removeAttribute("readonly");
            document.getElementById("head").style.outline = "2px solid lightblue";
            e.target.style.display = "none";
            document.getElementById("done-btn").style.display = "block";
        })

        document.getElementById("done-btn").addEventListener("click", (e) => {
            document.getElementById("head").setAttribute("readonly", null);
            document.getElementById("head").style.outline = "none";
            e.target.style.display = "none";
            document.getElementById("customize-btn").style.display = "block";
        })
    </script>
</body>

</html>