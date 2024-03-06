<?php
session_status() == PHP_SESSION_ACTIVE ?: session_start();
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] != true || $_SESSION["in_classroom"] == null || $_SESSION["role"] != "faculty") {
    header("Location: index.php");
    exit;
} else {
    require "partials/_dbconnect.php";
    $sql = "select * from classrooms where classroom_faculty=$_SESSION[user_id]";
    $result = mysqli_query($conn, $sql);
    $numRows = mysqli_num_rows($result);
    if ($numRows == 1) {
        $row = mysqli_fetch_assoc($result);
        $_SESSION["classroom_id"] = $row["classroom_id"];
        $_SESSION["classroom_name"] = $row["classroom_name"];
        $_SESSION["classroom_description"] = $row["classroom_description"];
        $_SESSION["classroom_code"] = $row["classroom_code"];
    } else {
        header("Location: index.php");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?php echo $_SESSION["classroom_name"] ?>
    </title>
    <?php require "partials/_bootstrap_css.php"; ?>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/dashboard.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>

<body>
    <?php require "partials/_header.php"; ?>

    <div class="classroom">
        <div class="classroom-details">
            <div class="faculty-image">
                <img src="" alt="Faculty Profile Image">
            </div>
            <div class="classroom-text">
                <span class="classroom-title">
                    <?php echo $_SESSION["classroom_name"] ?>
                </span><br>
                <span class="classroom-desc">
                    <?php echo nl2br($_SESSION["classroom_description"]); ?>
                </span>
            </div>
        </div>
        <div class="classroom-code">
            <span>Code : </span>
            <div style="display:flex;">
                <div id="code">
                    <?php echo $_SESSION["classroom_code"] ?>
                </div>
                <i id="icon" class="bi bi-clipboard2"></i>
            </div>
        </div>
    </div>

    <div class="dashboard-container">

        <a href="create_test.php" class="dashboard-item">
            <div class="item-image">
                <img src="images/create.jpg" alt="">
            </div>
            <span>Create New Test</span>
        </a>
        <a href="" class="dashboard-item">
            <div class="item-image">
                <img src="images/update.png" alt="">
            </div>
            <span>People</span>
        </a>
        <a href="" class="dashboard-item">
            <div class="item-image">
                <img src="images/update.png" alt="">
            </div>
            <span>Update Test</span>
        </a>
        <a href="" class="dashboard-item">
            <div class="item-image">
                <img src="images/update.png" alt="">
            </div>
            <span>Update Test</span>
        </a>
        <a href="" class="dashboard-item" data-bs-toggle="modal" data-bs-target="#deleteModal">
            <div class="item-image">
                <img src="images/delete.png" alt="">
            </div>
            <span>Delete Classroom</span>
        </a>

    </div>
    <div class="test-container">
        <h5 class="text-center">Scheduled Tests</h5>
        <?php
        $sql = "select * from exams where of_classroom='$_SESSION[in_classroom]'";
        $result = mysqli_query($conn, $sql);
        $numRows = mysqli_num_rows($result);
        if ($numRows > 0) {
            for ($i = 0; $i < $numRows; $i++) {
                $row = mysqli_fetch_assoc($result);
                echo '
        <div class="test">
            <a href="" class="test-detail">
                <span class="test-title">' . $row["exam_title"] . '</span>
                <p class="test-description m-0">' . $row["exam_description"] . '</p>
            </a>
            <div class="test-control">
                <span class="test-time">Scheduled at : </span><br>
                    <span class="date">' . date('jS F Y', strtotime($row["exam_date"])) . '</span><br>
                    <span class="time">' . date('h:i A', strtotime($row["exam_time"])) . '</span><br>
                <i class="bi bi-pencil-fill update"></i>
                <i class="bi bi-trash-fill trash"></i>
            </div>
        </div>';
            }
        } else {
            echo '
            <div class="">
                <h1 class="text-center">No Scheduled Test</h1>
            </div>';
        }
        ?>
    </div>

    <!-- deleteModal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="deleteModalLabel">Delete Classroom</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h6>Are you sure to delete the classroom. <span class="text-danger">Once you delete it cannot be
                            undone.</span></h6>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <a href="partials/_handleDeleteClass.php" type="button" class="btn btn-primary">Delete</a>
                </div>
            </div>
        </div>
    </div>

    <?php require "partials/_footer.php"; ?>
    <script>
        document.getElementById("icon").addEventListener("click", () => {
            let classroom_code = document.getElementById("code").innerText;
            navigator.clipboard.writeText(classroom_code);
            let list = document.getElementById("icon").classList;
            list.add("bi-clipboard2-check");
            list.remove("bi-clipboard2");
        })
    </script>
</body>

</html>