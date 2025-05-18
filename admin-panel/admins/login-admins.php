<?php require "../layouts/header.php"; ?>
<?php require "../../config/config.php"; ?>
<?php

if(isset($_SESSION['adminname'])) {
  header("location: ".ADMINURL." ");
}

if(isset($_POST['submit'])) {

  if(empty($_POST['email']) OR empty($_POST['password'])) {
    echo "<script>alert('one or more inputs are empty');</script>";
  } else {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $login = $conn->query("SELECT * FROM admins WHERE email='$email'");
    $login->execute();
    $fetch = $login->fetch(PDO::FETCH_ASSOC);

    if($login->rowCount() > 0) {
      if(password_verify($password, $fetch['password'])) {
        $_SESSION['adminname'] = $fetch['adminname'];
        $_SESSION['email'] = $fetch['email'];
        header("location: ".ADMINURL." ");
      } else{
        echo "<script>alert('email or password is wrong');</script>";
      }
    } else {
      echo "<script>alert('email or password is wrong');</script>";
    }
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            background-color: #28a745;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .login-container {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }
        .input-group-text {
            background-color: #28a745;
            color: white;
            border: none;
        }
        .btn-custom {
            background-color: #218838;
            border: none;
        }
        .btn-custom:hover {
            background-color: #1e7e34;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h3 class="mb-4">Admin Login</h3>
        <form method="POST" action="login-admins.php">
            <div class="mb-3 input-group">
                <span class="input-group-text"><i class="fas fa-user"></i></span>
                <input type="email" name="email" id="email" class="form-control" placeholder="Enter email" required>
            </div>
            <div class="mb-3 input-group">
                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                <input type="password" name="password" id="password" class="form-control" placeholder="Enter password" required>
            </div>
            <button type="submit" name="submit" class="btn btn-custom w-100">Login</button>
        </form>
    </div>
</body>
</html>

<?php require "../layouts/footer.php"; ?>
