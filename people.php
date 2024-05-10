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
    <link rel="stylesheet" href="css/navbar.css">
    <link rel="stylesheet" href="css/people.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>

<body>
    <?php require "partials/_header.php" ?>
    <div class="container">
        <div class="desc">
            <?php
            $sqlForClassname = "select * from classrooms where classroom_id=$_SESSION[in_classroom]";
            $result2 = mysqli_query($conn, $sqlForClassname);
            $row2 = mysqli_fetch_assoc($result2);
            echo '<h2>People in ' . $row2["classroom_name"] . '</h2>'
                ?>
        </div>
        <div class="faculty-container">
            <div class="heading">
                <h3>Faculty</h3>
            </div>
            <div class="item">
                <div class="name">
                    <img src="images/icons/people.png" alt="Image">
                    <span>
                        <?php
                        $sqlForFaculty = "select * from users where in_classroom=$_SESSION[in_classroom] and role='faculty'";
                        $result3 = mysqli_query($conn, $sqlForFaculty);
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

        <div class="student-container">
            <div class="heading">
                <h3>Students</h3>
                <div class="noOfStudents">
                    <span>
                        <?php echo $numRows - 1; ?>
                    </span>
                    <span>
                        <?php if(($numRows-1) == 1) echo 'student'; else echo 'students';?>
                    </span>
                </div>
            </div>
            <div class="students">
                <?php
                for ($i = 0; $i < $numRows; $i++) {
                    $row = mysqli_fetch_assoc($result);
                    $studentId = $row["user_id"];
                    if ($row["role"] == "student") {
                        echo '
                        <div class="item">
                            <div class="name">
                                <img src="images/icons/people.png" alt="Image">
                                <span>' . $row["first_name"] . ' ' . $row["last_name"] . '</span>
                            </div>';
                            if($_SESSION["role"] == "faculty")
                                echo '<div class="control"><abbr title="Remove"><i class="bi bi-trash-fill removeBtn" data-bs-toggle="modal" data-bs-target="#removeStudent"><input type="hidden" value="' . $studentId . '"></i></abbr></div>';
                        echo '</div>';
                    }
                }
                ?>
            </div>
        </div>
    </div>
<?php
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] == true && $_SESSION["role"] == "faculty"){
    echo '
    <!-- RemoveStudentModal -->
    <div class="modal fade" id="removeStudent" tabindex="-1" aria-labelledby="removeStudentLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title" id="removeStudentLabel">Remove Student</h2>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h6>Are you sure to remove the student. <span class="text-danger">Once you remove it cannot be
                            undone.</span></h6>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <form action="partials/_handleRemoveStudent.php" method="post">
                        <input type="hidden" name="studentId" id="studentId" value="">
                        <button type="submit" class="btn btn-primary"
                            id="cremoveBtn">Remove</button>
                    </form>
                </div>
            </div>
        </div>
    </div>';
}
  ?>
  <?php require "partials/_footer.php"; ?>

    <script>
        document.querySelectorAll(".removeBtn").forEach((e)=>{
            e.addEventListener("click", ()=>{
                document.getElementById("studentId").value = e.childNodes[0].value;
            })
        })
    </script>
</body>

</html>