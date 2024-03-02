<?php
  session_status() == PHP_SESSION_ACTIVE?: session_start();
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Welcome to BrainBattle</title>
    <?php require "partials/_bootstrap_css.php"; ?>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <?php require "partials/_header.php"; ?>
    <section id="header-section">
        <div class="container">
            <h2>An Online Examination System For Seamless, Fair, and Efficient Online Exams</h2>
            <p class="mark bg-dark text-light p1">A Robust Online Testing Platform For Conducting Remote Online
                Examinations</p>
            <p class="p2">In the evolving landscape of education, BrainBattle stands as a beacon of innovation,
                transforming how exams are conducted, experienced, and leveraged for continuous learning. Our platform
                offers a
                comprehensive, secure, and user-friendly online examination environment designed to cater to the needs
                of both
                educators and learners.</p>
            <?php
        if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] == false){
          // display when user is not logged in
          echo '<a href="login.php" class="px-4 py-2 my-2">Get Started</a>';

        }else{
          if($_SESSION["in_classroom"] != null){
            $dashboard;
            if($_SESSION["role"] == "faculty"){
              $dashboard = "faculty_dashboard.php";

            }else{
              $dashboard = "student_dashboard.php";
              
            }
            // display when user is already in a classroom
            echo '<a href="'.$dashboard.'" class="px-4 py-2 my-2">Go to Dashboard</a>';

          }else{
            // display when user is logged in
            echo '<a href="" data-bs-toggle="modal" data-bs-target="#createClassroomModal">Create Classroom</a>
            <a href="" data-bs-toggle="modal" data-bs-target="#joinClassroomModal">Join Classroom</a>';

          }
        }
      ?>
        </div>
    </section>
    <hr>
    <section id="body-section">
        <div class="container mt-2">
            <h2 class="text-center">We Conduct Virtual Test And Entrance Exams Worldwide, Using Our Robust Online Exam
                Platform</h2>
        </div>
    </section>

    <?php require "partials/_footer.php"; ?>
</body>

</html>