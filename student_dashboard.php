<?php
    session_status() == PHP_SESSION_ACTIVE?: session_start();
    if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] != true || $_SESSION["in_classroom"] == null || $_SESSION["role"] != "student"){
      header("Location: index.php");
      exit;
    }else if(isset($_GET["code"])){
      require "partials/_dbconnect.php";
      $sql = "select * from classrooms where classroom_code='$_GET[code]'";
      $result = mysqli_query($conn, $sql);
      $numRows = mysqli_num_rows($result);
      if($numRows == 1){
          $row = mysqli_fetch_assoc($result);
          if($_SESSION["in_classroom"] == $row["classroom_id"]){
            $_SESSION["classroom_id"] = $row["classroom_id"];
            $_SESSION["classroom_name"] = $row["classroom_name"];
            $_SESSION["classroom_description"] = $row["classroom_description"];
            $_SESSION["classroom_code"] = $row["classroom_code"];
          }else{
            $alert = "The classroom doesn't exist.";
            header("Location: ../index.php?success=false&alert=$alert");
            exit;
          }
      }
  }else{
    header("Location: index.php");
            exit;
  }
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Student Dashboard</title>
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
                <span class="classroom-title"><?php echo $_SESSION["classroom_name"] ?></span><br>
                <span class="classroom-desc"><?php echo $_SESSION["classroom_description"] ?></span>
            </div>
        </div>
        <!-- <div class="classroom-code">
            <span>Code : </span>
            <div id="code"> ei40d9</div>
            <i id="icon" class="bi bi-clipboard2"></i>
        </div> -->
    </div>

  <div class="dashboard-container">

    <a href="" class="dashboard-item">
      <div class="item-image">
        <img src="images/create.jpg" alt="">
      </div>
      <span> ...</span>
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
      <span>Results</span>
    </a>
    <a href="" class="dashboard-item">
      <div class="item-image">
        <img src="images/update.png" alt="">
      </div>
      <span>...</span>
    </a>
    <a href="" class="dashboard-item" data-bs-toggle="modal" data-bs-target="#leaveModal">
      <div class="item-image">
        <img src="images/leave.png" alt="">
      </div>
      <span>Leave Class</span>
    </a>

  </div>
  <div class="test-container">
    <h2 class="text-center">Scheduled Tests</h2>
    <div class="test">
      <a href="" class="test-detail">
        <span class="test-title">Class test-1</span>
        <p class="test-description m-0">Total marks - 25</p>
      </a>
      <div class="test-control">
        <span class="test-time">Scheduled at : </span><br>
      </div>
    </div>
    <div class="test">
      <div class="test-detail">
        <span class="test-title">Class test-1</span>
        <p class="test-description m-0">Total marks - 25</p>
      </div>
      <div class="test-control">
        <span class="test-time">Scheduled at : </span><br>
      </div>
    </div>
    <div class="test">
      <div class="test-detail">
        <span class="test-title">Class test-1</span>
        <p class="test-description m-0">Total marks - 25</p>
      </div>
      <div class="test-control">
        <span class="test-time">Scheduled at : </span><br>
      </div>
    </div>
    
  </div>

  <!-- leaveModal -->
    <div class="modal fade" id="leaveModal" tabindex="-1" aria-labelledby="leaveModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="leaveModalLabel">Leave Classroom</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h6>Are you sure to leave the classroom.</h6>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <a href="partials/_handleLeaveClass.php" type="button" class="btn btn-primary">Leave</a>
                </div>
            </div>
        </div>
    </div>
    <?php require "partials/_footer.php"; ?>
</body>

</html>