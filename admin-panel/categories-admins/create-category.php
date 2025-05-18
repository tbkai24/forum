<?php require "../layouts/header.php"; ?>
<?php require "../../config/config.php"; ?>

<?php 
if (!isset($_SESSION['adminname'])) {
    header("location: " . ADMINURL . "/admins/login-admins.php");
    exit();
}

if (isset($_POST['submit'])) {
    if (empty($_POST['name'])) {
        echo "<script>alert('Category name cannot be empty!');</script>";
    } else {
        $name = htmlspecialchars($_POST['name']); // Prevent XSS
        $insert = $conn->prepare("INSERT INTO categories (name) VALUES (:name)");
        $insert->execute([":name" => $name]);

        echo "<script>alert('Category created successfully!');</script>";
        echo "<script>window.location.href = 'show-categories.php';</script>";
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Category</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            background-color: #28a745;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            flex-direction: column;
        }
        .category-container {
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

<div class="category-container">
    <h3 class="mb-4 text-center">Create Category</h3>
    <a href="show-categories.php" class="btn btn-secondary mb-4 text-center float-right">
        <i class="fas fa-arrow-left"></i> Back
    </a>
    <table class="table table-striped table-bordered">
        <thead class="table-success">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Category Name</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th scope="row">New</th>
                <td>
                    <form method="POST" action="create-category.php">
                        <input type="text" name="name" class="form-control" placeholder="Enter category name" required />
                </td>
                <td>
                    <button type="submit" name="submit" class="btn btn-primary">
                        <i class="fas fa-plus-circle"></i> Create
                    </button>
                    </form>
                </td>
            </tr>
        </tbody>
    </table>
</div>

</body>
</html>

<?php require "../layouts/footer.php"; ?>
