
<?php
session_start();
define("APPURL", "http://localhost/forum");
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PTCian Corner</title>

    <!-- Bootstrap core CSS -->
    <link href="<?php echo APPURL; ?>/asset/css/bootstrap.css" rel="stylesheet">
    <link href="<?php echo APPURL; ?>/asset/css/custom.css" rel="stylesheet">
    <link href="<?php echo APPURL; ?>/asset/fontawesome/css/all.min.css" rel="stylesheet">
    <style>
        /* Fallback styles in case custom.css doesn't load */
        :root {
            --primary-green: #2E8B57;
            --secondary-green: #3CB371;
            --light-green: #98FB98;
            --dark-green: #006400;
            --bg-green: #F0FFF0;
        }
    </style>
  </head>

  <body>
    <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="<?php echo APPURL; ?>">
  <i class="fas fa-school fs-3"></i> PTCian Corner
</a>
        </div> 
        <div class="collapse navbar-collapse fs-2">
          <ul class="nav navbar-nav navbar-right">
          <li class="active"><a href="<?php echo APPURL; ?>">Home</a></li>
            <?php if(isset($_SESSION['username'])) : ?>
            
            
            <li><a href="<?php echo APPURL; ?>/topics/create.php">Create Topic</a></li>

            <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
            <?php echo $_SESSION['username']; ?>
          <span class="caret"></span></a>
          <ul class="dropdown-menu">

          <li><a href="<?php echo APPURL; ?>/users/profile.php?name=<?php echo $_SESSION['username']; ?>">Public Profile</a></li>
            <!-- <li><a href="#">Another action</a></li> -->
            <li><a href="<?php echo APPURL; ?>/auth/logout.php">Logout</a></li>
          
          </ul>
          </li>
         <?php else : ?>

          <li><a href="<?php echo APPURL; ?>/auth/register.php">Register</a></li>
          <li><a href="<?php echo APPURL; ?>/auth/login.php">Login</a></li>
         <?php endif; ?>

          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </div>