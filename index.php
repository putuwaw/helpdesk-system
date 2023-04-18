<?php
require "db.php";
require "functions.php";

ob_start();
session_start();

if (isset($_COOKIE['username']) || isset($_SESSION['username'])) {
  if (!isset($_SESSION['remember'])) {
    setcookie("username", "",  time() - 3600);
  }
} else {
  echo "<script>window.location.href='login.php';</script>";
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Home</title>
  <link rel="stylesheet" href="public/styles/bootstrap.min.css">
  <link rel="stylesheet" href="public/styles/home.css">
  <script src="https://kit.fontawesome.com/d26e212e8f.js" crossorigin="anonymous"></script>
</head>

<body>
  <main class="d-flex">
    <div class="d-flex flex-column flex-shrink-0 p-3 bg-body-tertiary" style="width: 280px;">
      <a href="index.php" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-body-emphasis text-decoration-none">
        <svg class="bi pe-none me-2" width="40" height="32">
          <use xlink:href="#bootstrap" />
        </svg>
        <span class="fs-4"> <i class="fa-solid fa-headset"></i> Helpdesk</span>
      </a>
      <hr>
      <ul class="nav nav-pills flex-column mb-auto">
        <li>
          <a id="home" href="index.php" class="nav-link link-body-emphasis">
            <i class="pe-none me-2 fa-solid fa-house" width="16" height="16">
            </i> Home
          </a>
        </li>
        <li>
          <a id="ticket" href="index.php?p=ticket" class="nav-link link-body-emphasis">
            <i class="pe-none me-2 fa-solid fa-ticket" width="16" height="16">
            </i>
            New Ticket
          </a>
        </li>
        <li>
          <a id="history" href="index.php?p=history" class="nav-link link-body-emphasis">
            <i class="pe-none me-2 fa-solid fa-clock-rotate-left" width="16" height="16">
            </i>
            History
          </a>
        </li>
      </ul>
      <hr>
      <div class="dropdown">
        <a href="index.php" class="d-flex align-items-center link-body-emphasis text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
          <img src="https://github.com/dimatait.png" alt="" width="32" height="32" class="rounded-circle me-2">
          <strong>
            <?php
            if (isset($_SESSION['username'])) {
              echo $_SESSION['username'];
            } else {
              echo $_COOKIE['username'];
            }
            ?>
          </strong>
        </a>
        <ul class="dropdown-menu text-small shadow">
          <li><a class="dropdown-item disabled" href="#">Profile</a></li>
          <li>
            <hr class="dropdown-divider">
          </li>
          <li><a class="dropdown-item" href="logout.php">Sign out</a></li>
        </ul>
      </div>
    </div>
    <div class="w-100 min-vh-100 mx-3 p-4 bg-body-tertiary">
      <?php
      if (!empty($_GET["p"])) {
        $p = $_GET['p'];
        if ($p == 'ticket') {
          include 'pages/ticket.php';
        } else if ($p == 'history') {
          include 'pages/history.php';
        } else if ($p == 'detail') {
          include 'pages/detail.php';
        } else if ($p == 'information') {
          include 'pages/information.php';
        } else {
          include 'pages/home.php';
        }
      } else {
        include 'pages/home.php';
      }
      ?>
    </div>
  </main>
  <script src="public/scripts/bootstrap.bundle.min.js"></script>
  <script src="public/scripts/dashboard.js"></script>
</body>

</html>