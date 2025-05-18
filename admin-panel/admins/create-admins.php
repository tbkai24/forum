<?php require "../layouts/header.php"; ?>
<?php require "../../config/config.php"; ?>
<?php 

if(!isset($_SESSION['adminname'])) {
	header("location: ".ADMINURL."/admins/login-admins.php");
}

$admins = $conn->query("SELECT * FROM admins");
$admins->execute();
$allAdmins = $admins->fetchAll(PDO::FETCH_OBJ);

if(isset($_POST['submit'])){
    if(empty($_POST['email']) OR empty($_POST['adminname']) OR empty($_POST['password'])) {
        echo "<script>alert('One or more inputs are empty');</script>";
    } else {
        $email = $_POST['email'];
        $adminname = $_POST['adminname'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        
        $insert = $conn->prepare("INSERT INTO admins (email, adminname, password) VALUES(:email, :adminname, :password)");
        $insert->execute([
            ":email" => $email,
            ":adminname" => $adminname,
            ":password" => $password,
        ]);
        
        header("location: admins.php");
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Management</title>
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
        .admin-container {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 900px;
        }
        .table {
            border-radius: 10px;
            overflow: hidden;
        }
        .btn-primary {
            background-color: #28a745;
            border: none;
        }
        .btn-primary:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <div class="admin-container">
        <h3 class="mb-4 text-center">Admin List</h3>
       
        <table class="table table-striped table-bordered">
            <thead class="table-success">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Username</th>
                    <th scope="col">Email</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($allAdmins as $admin): ?>
                <tr>
                    <th scope="row"><?php echo $admin->id; ?></th>
                    <td><?php echo $admin->adminname; ?></td>
                    <td><?php echo $admin->email; ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        
        <h3 class="mt-5 text-center">Create Admin</h3>
        <form method="POST" action="create-admins.php">
            <div class="form-outline mb-4 mt-4">
                <input type="email" name="email" class="form-control" placeholder="Email" required />
            </div>
            <div class="form-outline mb-4">
                <input type="text" name="adminname" class="form-control" placeholder="Admin Name" required />
            </div>
            <div class="form-outline mb-4">
                <input type="password" name="password" class="form-control" placeholder="Password" required />
            </div>
            <button type="submit" name="submit" class="btn btn-primary w-100">Create</button>
        </form>
    </div>
</body>
</html>

<?php require "../layouts/footer.php"; ?>
