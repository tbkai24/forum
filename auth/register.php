<?php 
require "../includes/header.php"; 
require "../config/config.php";

if (isset($_SESSION['username'])) {
    header("location: " . APPURL);
    exit;
}

if (isset($_POST['submit'])) {
    if (
        !empty($_POST['name']) &&
        !empty($_POST['email']) &&
        !empty($_POST['username']) &&
        !empty($_POST['password']) &&
        !empty($_POST['confirm_password']) &&
        !empty($_POST['about'])
    ) {
        if ($_POST['password'] !== $_POST['confirm_password']) {
            echo "<div class='alert alert-danger'>Passwords do not match.</div>";
        } else {
            $name = $_POST['name'];
            $email = $_POST['email'];
            $username = $_POST['username'];
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $about = $_POST['about'];

            $avatar = '';

            // Check if avatar file is uploaded without errors
            if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK) {
                $fileTmpPath = $_FILES['avatar']['tmp_name'];
                $fileName = $_FILES['avatar']['name'];
                $fileSize = $_FILES['avatar']['size'];
                $fileType = $_FILES['avatar']['type'];
                $fileNameCmps = explode(".", $fileName);
                $fileExtension = strtolower(end($fileNameCmps));

                // Allowed extensions
                $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];

                if (in_array($fileExtension, $allowedExtensions)) {
                    // Sanitize file name
                    $newFileName = md5(time() . $fileName) . '.' . $fileExtension;

                    // Directory where the file will be stored
                    $uploadFileDir = __DIR__ . '/../img/';
                    $destPath = $uploadFileDir . $newFileName;

                    if (move_uploaded_file($fileTmpPath, $destPath)) {
                        $avatar = $newFileName;
                    } else {
                        echo "<div class='alert alert-danger'>There was an error moving the uploaded file.</div>";
                    }
                } else {
                    echo "<div class='alert alert-danger'>Upload failed. Allowed file types: " . implode(', ', $allowedExtensions) . "</div>";
                }
            }

            // Insert user data into database
            $insert = $conn->prepare("INSERT INTO users (name, email, username, password, about, avatar) 
                                      VALUES(:name, :email, :username, :password, :about, :avatar)");
            $insert->execute([
                ":name" => $name,
                ":email" => $email,
                ":username" => $username,
                ":password" => $password,
                ":about" => $about,
                ":avatar" => $avatar,
            ]);

            header("location: login.php?registered=success");
            exit;
        }
    } else {
        echo "<div class='alert alert-danger'>Please fill in all required fields.</div>";
    }
}
?>

<div class="container">
    <div class="row">
        <div class="col-md-8">
            <div class="main-col">
                <div class="block">
                    <h1 class="pull-left">Register</h1>
                    <div class="clearfix"></div>
                    <hr>
                    <form role="form" enctype="multipart/form-data" method="post" action="register.php">
                        <div class="form-group">
                            <label>Name*</label>
                            <input type="text" class="form-control" name="name" placeholder="Enter Your Name" required>
                        </div>

                        <div class="form-group">
                            <label>Email Address*</label>
                            <input type="email" class="form-control" name="email" placeholder="Enter Your Email Address" required>
                        </div>

                        <div class="form-group">
                            <label>Choose Username*</label>
                            <input type="text" class="form-control" name="username" placeholder="Create A Username" required>
                        </div>

                        <div class="form-group">
                            <label>Password*</label>
                            <input type="password" class="form-control" name="password" placeholder="Enter A Password" required>
                        </div>

                        <div class="form-group">
                            <label>Confirm Password*</label>
                            <input type="password" class="form-control" name="confirm_password" placeholder="Confirm Your Password" required>
                        </div>

                        <div class="form-group">
                            <label>Upload Avatar</label>
                            <input type="file" name="avatar" class="form-control" accept="image/*">
                        </div>

                        <div class="form-group">
                            <label>About Me*</label>
                            <textarea id="about" rows="6" class="form-control" name="about" placeholder="Tell us about yourself" required></textarea>
                        </div>

                        <input name="submit" type="submit" class="color btn btn-default" value="Register" />
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require "../includes/footer.php"; ?>
