<?php

session_start();
define("ADMINURL","http://localhost/forum/admin-panel");



?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <!-- This file has been downloaded from Bootsnipp.com. Enjoy! -->
    <title>Admin Panel</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="<?php echo ADMINURL; ?>asset/css/bootstrap.min.css" rel="stylesheet">
        <link href="<?php echo ADMINURL; ?>asset/css/custom.css" rel="stylesheet">
        <link href="<?php echo ADMINURL; ?>asset/fontawesome/css/all.min.css" rel="stylesheet">
  
</head>
<body>
<div id="wrapper">
    <nav class="navbar header-top fixed-top navbar-expand-lg  navbar-dark bg-dark">
      <div class="container">
      <a class="navbar-brand" href="index.php">PTCians Corner</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText"
        aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarText">
      <?php if(isset($_SESSION['adminname'])) : ?>
        <ul class="navbar-nav side-nav" >

       
          <li class="nav-item">
            <a class="nav-link text-white" style="margin-left: 10px;" href="<?php echo ADMINURL; ?>">Home
              <span class="sr-only"></span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?php echo ADMINURL; ?>/admins/admins.php" style="margin-left: 10px;">Admins</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?php echo ADMINURL; ?>/categories-admins/show-categories.php" style="margin-left: 10px;">Categories</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?php echo ADMINURL; ?>/topics-admins/show-topics.php" style="margin-left: 10px;">Topics</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?php echo ADMINURL; ?>/replies-admins/show-replies.php" style="margin-left: 10px;">Replies</a>
          </li>
        </ul>
        <?php endif; ?>
        <ul class="navbar-nav ml-md-auto d-md-flex">
          <?php if(!isset($_SESSION['adminname'])) : ?>

        <li class="nav-item">
            <a class="nav-link" href="<?php echo ADMINURL; ?>/admins/login-admins.php">
              <span class="sr-only"></span>
            </a>
          </li>
          <?php else : ?>

        
         
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <?php echo $_SESSION['adminname']; ?>
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
              <a class="dropdown-item" href="<?php echo ADMINURL; ?>/admins/logout.php">Logout</a>
              
          </li>
              <?php endif; ?>            
          
        </ul>
      </div>
    </div>
    </nav>
    <div class="container-fluid"></div>