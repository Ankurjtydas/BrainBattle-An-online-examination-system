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

    <hr>

    <div class="dashboard-container">

        <a href="create_test.php" id="create_test" class="dashboard-item">
            <div class="item-image">
                <img src="images/create.png" alt="">
            </div>
            <span>Create New Test</span>
        </a>
        <a href="people.php" class="dashboard-item">
            <div class="item-image">
                <img src="images/group.webp" alt="">
            </div>
            <span>People</span>
        </a>
        <a href="" class="dashboard-item">
            <div class="item-image">
                <img src="images/result.png" alt="">
            </div>
            <span>Result</span>
        </a>
        <a href="" class="dashboard-item">
            <div class="item-image">
                <img src="images/update.png" alt="">
            </div>
            <span>...</span>
        </a>
        <a href="" class="dashboard-item" data-bs-toggle="modal" data-bs-target="#deleteModal">
            <div class="item-image">
                <img src="images/trash.png" alt="">
            </div>
            <span>Delete Classroom</span>
        </a>
    </div>

    <hr>

    <div class="test-container">
        <h2 class="text-center">Scheduled Tests</h2>
        <?php
        $sql = "select * from exams where of_classroom='$_SESSION[in_classroom]' order by exam_date_time";
        $result = mysqli_query($conn, $sql);
        $numRows = mysqli_num_rows($result);
        if ($numRows > 0) {
            $displayedExams = 0;
            date_default_timezone_set("Asia/Kolkata");
            for ($i = 0; $i < $numRows; $i++) {
                $row = mysqli_fetch_assoc($result);
                $examId = $row["exam_id"];
                $examDateTime = new DateTime($row["exam_date_time"]);
                $currentDateTime = new DateTime();
                // echo $currentDateTime->format("H m s").'<br>';
                $currentDateTime->modify("-10 seconds");
                // echo $currentDateTime->format("H m s")."<br>";
                $timeLeft = $examDateTime->diff($currentDateTime);
                if( $timeLeft->invert == 1) {
                    $displayedExams++;
                echo '
        <div class="test" id="test'. $i .'">
            <div class="test-detail">
                <div class="detail">
                    <span class="test-title">' . $row["exam_title"] . '</span>
                    <p class="test-description m-0">' . $row["exam_description"] . '</p>
                </div>
                <div class="timer" id="timer'. $i .'">
                    <span id="timertext'. $i .'"></span>
                    <span class="time" id="time'. $i .'">
                        <script>
                            examDate'. $i .' = "'. $row["exam_date_time"].'";
                            ed'. $i .' = new Date(examDate'. $i .');
                            setInterval(()=>{
                                cd = new Date();
                                hoursLeft = Math.floor((ed'. $i .'.getTime()/(1000*60*60)-cd.getTime()/(1000*60*60))%60);
                                minutesLeft = Math.floor((ed'. $i .'.getTime()/(1000*60)-cd.getTime()/(1000*60))%60);
                                secondsLeft = Math.floor((ed'. $i .'.getTime()/1000-cd.getTime()/1000)%60);
                                if((ed'. $i .'.getDate() - cd.getDate()) == 0){
                                    document.getElementById("timer'. $i .'").style.display = "block";
                                    if(hoursLeft <1)
                                        document.getElementById("timer'. $i .'").style.color = "red";
                                    if(secondsLeft<=0){
                                        if(secondsLeft==0)
                                            location.reload();
                                        if(secondsLeft <= -10)
                                            location.reload();
                                        document.getElementById("time'. $i .'").innerText = "Exam has started. Disappearing in : "+(10+secondsLeft)+"seconds";
                                    }    
                                    else
                                        document.getElementById("time'. $i .'").innerText = "Starting in : "+hoursLeft+" : "+minutesLeft+" : "+secondsLeft;
                                }
                            },1000)
                        </script>
                    </span>
                </div>
            </div>
            <div class="test-control">
                <span class="test-time">Scheduled at : </span><br>
                    <span class="date">' . date('jS F Y', strtotime($row["exam_date_time"])) . '</span><br>
                    <span class="time">' . date('h:i A', strtotime($row["exam_date_time"])) . '</span><br>
                <a href="update_test.php?id='. $examId .'" style="color:black;"><i class="bi bi-pencil-fill update testUpdateBtn"></i></a>
                <i class="bi bi-trash-fill trash testDeleteBtn" data-bs-toggle="modal" data-bs-target="#deleteTest"><input type="hidden" value="' . $examId . '"></i>
            </div>
        </div>';
                }
            }
            if($displayedExams == 0){
                echo '
            <div class="test justify-content-center">
                <h4 class="text-center">No Scheduled Test</h4>
            </div>';
            }
        } else {
            echo '
            <div class="test justify-content-center">
                <h4 class="text-center">No Scheduled Test</h4>
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

    <!-- deleteTestModal -->
    <div class="modal fade" id="deleteTest" tabindex="-1" aria-labelledby="deleteTestLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="deleteTestLabel">Delete Test</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h6>Are you sure to delete the test. <span class="text-danger">Once you delete it cannot be
                            undone.</span></h6>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <a href="partials/_handleDeleteTest.php?" type="button" class="btn btn-primary"
                        id="cdeleteBtn">Delete</a>
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

    document.querySelectorAll(".testDeleteBtn").forEach((e) => {
        e.addEventListener("click", () => {
            document.getElementById("cdeleteBtn").addEventListener("click", (element) => {
                element.target.href +="id="+ e.querySelector("input").value;
            })
        })
    })


    // const d = new Date();
    // let timeout = Math.round(d.getTime() / 1000) + 10;
    // let interval = setInterval(function(){
    //     let n = new Date();
    //     let time = Math.round(n.getTime()/1000);
    //     document.getElementById("timer").innerText = (timeout-time);
    //     console.log(time);
    //     if((timeout-time)<=0){
    //         clearInterval(interval);
    //     }
    // },1000);
    </script>
</body>

</html>