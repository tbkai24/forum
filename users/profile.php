<?php
require "../includes/header.php";
require "../config/config.php";

if (!isset($_SESSION['username'])) {
    header("location: " . APPURL);
    exit;
}

$userId = $_SESSION['user_id'];

// Fetch user data
$select = $conn->prepare("SELECT * FROM users WHERE id = :id");
$select->execute([':id' => $userId]);
$user = $select->fetch(PDO::FETCH_OBJ);

if (!$user) {
    echo "<p>User not found.</p>";
    exit;
}

// Handle profile update
if (isset($_POST['submit'])) {
    $email = trim($_POST['email']);
    $about = trim($_POST['about']);

    if (empty($email) || empty($about)) {
        $error = "Email and About fields cannot be empty.";
    } else {
        $avatar = $user->avatar;

        if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK) {
            $fileTmpPath = $_FILES['avatar']['tmp_name'];
            $fileName = $_FILES['avatar']['name'];
            $fileNameCmps = explode(".", $fileName);
            $fileExtension = strtolower(end($fileNameCmps));
            $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];

            if (in_array($fileExtension, $allowedExtensions)) {
                $newFileName = md5(time() . $fileName) . '.' . $fileExtension;
                $uploadFileDir = __DIR__ . '/../img/';
                $destPath = $uploadFileDir . $newFileName;

                if (move_uploaded_file($fileTmpPath, $destPath)) {
                    if (!empty($user->avatar) && file_exists($uploadFileDir . $user->avatar)) {
                        unlink($uploadFileDir . $user->avatar);
                    }
                    $avatar = $newFileName;
                } else {
                    $error = "Error moving the uploaded avatar file.";
                }
            } else {
                $error = "Invalid avatar file type. Allowed: jpg, jpeg, png, gif.";
            }
        }

        if (!isset($error)) {
            $update = $conn->prepare("UPDATE users SET email = :email, about = :about, avatar = :avatar WHERE id = :id");
            $update->execute([
                ':email' => $email,
                ':about' => $about,
                ':avatar' => $avatar,
                ':id' => $userId,
            ]);

            $_SESSION['success'] = "Profile updated successfully.";
            header("Location: profile.php");
            exit;
        }
    }
}
?>

<div class="container">

    <!-- Success or Error Message -->
    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success alert-dismissible fade show mt-3"
             role="alert"
             style="background-color: #28a745 !important;
                    color: #fff !important;
                    font-weight: bold !important;
                    font-size: 18px;
                    border: 2px solid #1e7e34;
                    border-radius: 8px;
                    padding: 15px;">
            <?php echo $_SESSION['success']; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"
                    style="filter: brightness(200%);"></button>
        </div>
        <?php unset($_SESSION['success']); ?>
    <?php elseif (isset($error)): ?>
        <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
            <?php echo $error; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="row">

        <!-- User Profile Display -->
        <div class="col-md-4">
            <div class="block user-info mt-4">
                <?php 
                $avatarPath = "../img/" . $user->avatar;
                if (!empty($user->avatar) && file_exists($avatarPath)): ?>
                    <img class="avatar img-responsive" src="<?php echo APPURL; ?>/img/<?php echo htmlspecialchars($user->avatar); ?>" alt="User Avatar" />
                <?php else: ?>
                    <i class="fas fa-user-circle" style="font-size:100px; color:#ccc;"></i>
                <?php endif; ?>

                <h3><?php echo htmlspecialchars($user->name); ?></h3>
                <p><strong>Username:</strong> <?php echo htmlspecialchars($user->username); ?></p>
                <p><strong>Member since:</strong> <?php echo date('M Y', strtotime($user->created_at)); ?></p>
                <p><?php echo nl2br(htmlspecialchars($user->about)); ?></p>
            </div>
        </div>

        <!-- User Profile Edit Form -->
        <div class="col-md-8">
            <div class="block mt-4">
                <h2>Edit Profile</h2>
                <form method="POST" enctype="multipart/form-data" action="profile.php">
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" value="<?php echo htmlspecialchars($user->email); ?>" name="email" class="form-control" required>
                    </div>

                    <div class="form-group mt-3">
                        <label>About Me</label>
                        <textarea name="about" rows="6" class="form-control" required><?php echo htmlspecialchars($user->about); ?></textarea>
                    </div>

                    <div class="form-group mt-3">
                        <label>Change Avatar</label>
                        <input type="file" name="avatar" accept="image/*" class="form-control">
                        <small class="text-muted">Allowed file types: jpg, jpeg, png, gif</small>
                    </div>

                    <button type="submit" name="submit" class="btn btn-primary mt-4">Update Profile</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require "../includes/footer.php"; ?>
