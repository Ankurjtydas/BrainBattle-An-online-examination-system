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