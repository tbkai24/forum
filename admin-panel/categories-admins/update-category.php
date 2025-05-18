<?php require "../layouts/header.php"; ?>
<?php require "../../config/config.php"; ?>

<?php 
if (!isset($_SESSION['adminname'])) {
    header("Location: " . ADMINURL . "/admins/login-admins.php");
    exit();
}

// Check if ID is set and valid
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "<script>alert('Invalid category ID.'); window.location.href = 'show-categories.php';</script>";
    exit();
}

$id = $_GET['id'];

// Fetch category details
$categoryQuery = $conn->prepare("SELECT * FROM categories WHERE id = :id");
$categoryQuery->execute([':id' => $id]);
$singleCategory = $categoryQuery->fetch(PDO::FETCH_OBJ);

// Check if category exists
if (!$singleCategory) {
    echo "<script>alert('Category not found.'); window.location.href = 'show-categories.php';</script>";
    exit();
}

// Update category
if (isset($_POST['submit'])) {
    if (empty($_POST['name'])) {
        echo "<script>alert('Category name cannot be empty.');</script>";
    } else {
        $name = htmlspecialchars($_POST['name']);

        $update = $conn->prepare("UPDATE categories SET name = :name WHERE id = :id");
        $update->execute([
            ':name' => $name,
            ':id' => $id
        ]);

        echo "<script>alert('Category updated successfully!'); window.location.href = 'show-categories.php';</script>";
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Category</title>
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
    <h3 class="mb-4 text-center">Update Category</h3>
    <a href="show-categories.php" class="btn btn-secondary mb-4 text-center float-right">
        <i class="fas fa-arrow-left"></i> Back
    </a>

    <form method="POST" action="">
        <div class="mb-4">
            <label class="form-label">Category Name</label>
            <input type="text" name="name" value="<?php echo htmlspecialchars($singleCategory->name); ?>" class="form-control" placeholder="Enter category name" required />
        </div>
        
        <button type="submit" name="submit" class="btn btn-primary">
            <i class="fas fa-edit"></i> Update
        </button>
    </form>
</div>

</body>
</html>

<?php require "../layouts/footer.php"; ?>
