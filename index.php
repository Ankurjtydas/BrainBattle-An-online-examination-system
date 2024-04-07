<?php
session_status() == PHP_SESSION_ACTIVE ?: session_start();
?>

<!doctype html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Home - BrainBattle</title>
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
			if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] == false) {
				// display when user is not logged in
				echo '<a href="login.php" class="px-4 py-2 my-2 btn">Get Started</a>';

			} else {
				if ($_SESSION["in_classroom"] != null) {
					$dashboard;
					if ($_SESSION["role"] == "faculty") {
						$dashboard = "faculty_dashboard.php";

					} else {
						$dashboard = "student_dashboard.php";

					}
					// display when user is already in a classroom
					echo '<a href="' . $dashboard . '" class="px-4 py-2 my-2 btn">Go to Dashboard</a>';

				} else {
					// display when user is logged in
					echo '<a class="btn" href="" data-bs-toggle="modal" data-bs-target="#createClassroomModal">Create Classroom</a>
            <a class="btn" href="" data-bs-toggle="modal" data-bs-target="#joinClassroomModal">Join Classroom</a>';

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

	<!-- createClassroomModal -->
	<div class="modal fade" id="createClassroomModal" tabindex="-1" aria-labelledby="createClassroomModalLabel"
		aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h1 class="modal-title fs-5" id="createClassroomModalLabel">Create Your Classroom</h1>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<form action="partials/_handleClassCreation.php" method="POST">
					<div class="modal-body">
						<div class="mb-3">
							<label for="classroomTitle" class="form-label">Classroom title</label>
							<input type="text" class="form-control" id="classroomTitle" name="classroomTitle"
								aria-describedby="classroomTitleHelp">
						</div>
						<div class="mb-3">
							<label for="classroomDescription" class="form-label">Classroom description</label>
							<textarea class="form-control" id="classroomDescription"
								name="classroomDescription"></textarea>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
						<button type="submit" class="btn btn-primary">Create</button>
					</div>
				</form>
			</div>
		</div>
	</div>

	<!-- joinClassroomModal -->
	<div class="modal fade" id="joinClassroomModal" tabindex="-1" aria-labelledby="joinClassroomModalLabel"
		aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h1 class="modal-title fs-5" id="joinClassroomModalLabel">Join a Classroom</h1>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<form action="partials/_handleClassJoining.php" method="POST">
					<div class="modal-body">
						<div class="mb-3">
							<label for="classroomCode" class="form-label">Enter code</label>
							<input type="text" class="form-control" style="display:inline; width: 40%;"
								id="classroomCode" name="classroomCode" aria-describedby="classroomCodeHelp">
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
						<button type="submit" class="btn btn-primary">Join</button>
					</div>
				</form>
			</div>
		</div>
	</div>

	<?php require "partials/_footer.php"; ?>
</body>

</html>