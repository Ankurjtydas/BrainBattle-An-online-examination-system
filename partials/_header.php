<?php
    require "_navbar.php";
    session_status() == PHP_SESSION_ACTIVE?: session_start();
    // $user_id = $_SESSION["user_id"];

    if(isset($_GET["success"]) && $_GET["success"]=="false"){
        echo '
        <div class="alert alert-warning alert-dismissible fade show" role="alert" style="margin:0">
            <strong>Failed!</strong> '. $_GET["alert"] .'
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
    }elseif(isset($_GET["success"]) && $_GET["success"]=="true"){
        echo '
        <div class="alert alert-success alert-dismissible fade show" role="alert" style="margin:0">
            <strong>Success!</strong> '. $_GET["alert"] .'
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
    }
    if(isset($_GET["cls"]) && $_GET["cls"]=="n"){
        echo '
        <div class="alert alert-warning alert-dismissible fade show" role="alert" style="margin:0">
            <strong>Failed!</strong> '. $_GET["alert"] .' <a href="partials/_handleLeaveClass.php">Resolve</a>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
    }
    ?>

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
                        <input type="text" class="form-control" id="classroomTitle" name="classroomTitle" aria-describedby="classroomTitleHelp">
                    </div>
                    <div class="mb-3">
                        <label for="classroomDescription" class="form-label">Classroom description</label>
                        <textarea class="form-control" id="classroomDescription" name="classroomDescription"></textarea>
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
                        <input type="text" class="form-control" style="display:inline; width: 40%;" id="classroomCode" name="classroomCode" aria-describedby="classroomCodeHelp">
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