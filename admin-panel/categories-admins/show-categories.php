<?php require "../layouts/header.php"; ?>
<?php require "../../config/config.php"; ?>

<?php 
if (!isset($_SESSION['adminname'])) {
    header("location: " . ADMINURL . "/admins/login-admins.php");
    exit();
}

$categories = $conn->query("SELECT * FROM categories");
$categories->execute();
$allCategories = $categories->fetchAll(PDO::FETCH_OBJ);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Category Management</title>
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
    <h3 class="mb-4 text-center">Category List</h3>
    <a href="<?php echo ADMINURL; ?>/categories-admins/create-category.php" class="btn btn-primary mb-4 text-center float-right">
        <i class="fas fa-plus-circle"></i> Create Category
    </a>
    <table class="table table-striped table-bordered">
        <thead class="table-success">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col">Update</th>
                <th scope="col">Delete</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($allCategories as $category) : ?>
                <tr>
                    <th scope="row"><?php echo htmlspecialchars($category->id); ?></th>
                    <td><?php echo htmlspecialchars($category->name); ?></td>
                    <td><a href="update-category.php?id=<?php echo $category->id; ?>" class="btn btn-warning text-white">Update</a></td>
                    <td><a href="delete-category.php?id=<?php echo $category->id; ?>" class="btn btn-danger">Delete</a></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

</body>
</html>

<?php require "../layouts/footer.php"; ?>
