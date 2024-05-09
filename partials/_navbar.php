<?php
  session_status() == PHP_SESSION_ACTIVE?: session_start();
  
  echo '
  <nav class="navbar navbar-expand-md bg-dark navbar-dark">
    <div class="container-fluid">
      <a class="navbar-brand" href="index.php"><b>BrainBattle</b></a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
      aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav ms-auto mb-lg-0">';
          if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true){
            echo '
            <li class="nav-item">
              <a class="nav-link" href="login.php">Login</a>
              <hr class="line">
            </li>
            <li class="nav-item">
              <a class="nav-link" href="register.php">Register</a>
            </li>';
          }else{
            $first_name = $_SESSION["first_name"];
            $last_name = $_SESSION["last_name"];
            echo '
            <li class="nav-item profile">
              <div class="dropdown">
                <div class="profile-name p-name" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                  <span>'. strtoupper($first_name[0]) . strtoupper($last_name[0]) .'</span>
                </div>
                <ul class="dropdown-menu">
                  <li><a class="dropdown-item" href="profile.php">Profile</a></li>
                  <li><a class="dropdown-item" href="partials/_handleLogout.php">Logout</a></li>
                </ul>
              </div>
            </li>
            <li class="nav-item profile-list">
              <a class="nav-link" href="profile.php" style="display: flex; align-items: center;">Profile
                <div class="p-name" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                  <span>'. strtoupper($first_name[0]) . strtoupper($last_name[0]) .'</span>
                </div>
              </a>
              <hr class="line">
            </li>
            <li class="nav-item profile-list">
              <a class="nav-link" href="partials/_handleLogout.php">Logout</a>
            </li>';
          }
          echo '
        </ul>
      </div>
    </div>
  </nav>';
?>