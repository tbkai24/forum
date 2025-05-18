<?php 
require "../includes/header.php"; 
require "../config/config.php"; 

if (isset($_SESSION['username'])) {
    header("location: " . APPURL);
    exit;
}

$errorMsg = '';
$successMsg = '';

// Show success message if registered
if (isset($_GET['registered']) && $_GET['registered'] === 'success') {
    $successMsg = "Registration successful! Please login.";
}

if (isset($_POST['submit'])) {

    if (empty($_POST['email']) || empty($_POST['password'])) {
        $errorMsg = "One or more inputs are empty.";
    } else {
        $email = $_POST['email'];
        $password = $_POST['password'];

        $login = $conn->prepare("SELECT * FROM users WHERE email = :email");
        $login->execute([':email' => $email]);
        $fetch = $login->fetch(PDO::FETCH_ASSOC);

        if ($login->rowCount() > 0) {
            if (password_verify($password, $fetch['password'])) {
                $_SESSION['username'] = $fetch['username'];
                $_SESSION['name'] = $fetch['name'];
                $_SESSION['user_id'] = $fetch['id'];
                $_SESSION['email'] = $fetch['email'];
                $_SESSION['user_image'] = $fetch['avatar'];

                header("location: " . APPURL);
                exit;
            } else {
                $errorMsg = "Email or password is wrong.";
            }
        } else {
            $errorMsg = "Email or password is wrong.";
        }
    }
}
?>

<div class="container">
    <div class="row">
        <div class="col-md-8">
            <div class="main-col">
                <div class="block">
                    <h1 class="pull-left">Login</h1>
                    <div class="clearfix"></div>
                    <hr>

                    <?php if ($successMsg): ?>
                        <div class="alert alert-success"><?php echo $successMsg; ?></div>
                    <?php endif; ?>

                    <?php if ($errorMsg): ?>
                        <div class="alert alert-danger"><?php echo $errorMsg; ?></div>
                    <?php endif; ?>

                    <form role="form" method="post" action="login.php">
                        <div class="form-group">
                            <label>Email Address*</label>
                            <input type="email" class="form-control" name="email" placeholder="Enter Your Email Address" required>
                        </div>

                        <div class="form-group">
                            <label>Password*</label>
                            <input type="password" class="form-control" name="password" placeholder="Enter A Password" required>
                        </div>

                        <input name="submit" type="submit" class="color btn btn-default" value="Login" />
                    </form>
                </div>
            </div>
        </div>

<?php require "../includes/footer.php"; ?>
