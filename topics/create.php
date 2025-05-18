<?php
require "../includes/header.php";
require "../config/config.php";

if (!isset($_SESSION['username'])) {
    header("location: " . APPURL);
    exit(); // Stop script execution after redirect
}

// Fetch categories from database
$categories_query = $conn->query("SELECT * FROM categories ORDER BY name ASC");
$categories = $categories_query->fetchAll(PDO::FETCH_OBJ);

if (isset($_POST['submit'])) {
    if (empty($_POST['title']) || empty($_POST['category']) || empty($_POST['body'])) {
        echo "<script>alert('One or more inputs are empty');</script>";
    } else {
        $title = $_POST['title'];
        $category = $_POST['category'];
        $body = $_POST['body'];
        $user_id = $_SESSION['user_id']; // Ensure user_id is set
        $user_name = $_SESSION['username']; // Match session naming convention
        $user_image = $_SESSION['user_image'];

        $insert = $conn->prepare("INSERT INTO topics (title, category, body, user_id, user_name, user_image) 
        VALUES(:title, :category, :body, :user_id, :user_name, :user_image)");

        $insert->execute([
            ":title" => $title,
            ":category" => $category,
            ":body" => $body,
            ":user_id" => $user_id, // Include user_id
            ":user_name" => $user_name,
            ":user_image" => $user_image,
        ]);

        header("location: " . APPURL);
    }
}
?>

<div class="container">
    <div class="row">
        <div class="col-md-8">
            <div class="main-col">
                <div class="block">
                    <h1 class="pull-left">Create A Topic</h1>
                    <div class="clearfix"></div>
                    <hr>
                    <form role="form" method="POST" action="create.php">
                        <div class="form-group">
                            <label>Topic Title</label>
                            <input type="text" class="form-control" name="title" placeholder="Enter Post Title">
                        </div>
                        <div class="form-group">
                            <label>Category</label>
                            <select name="category" class="form-control">
                                <?php foreach ($categories as $category) : ?>
                                    <option value="<?php echo htmlspecialchars($category->name); ?>">
                                        <?php echo htmlspecialchars($category->name); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Topic Body</label>
                            <textarea id="body" rows="10" cols="80" class="form-control" name="body"></textarea>
                            <script>CKEDITOR.replace('body');</script>
                        </div>
                        <button type="submit" name="submit" class="color btn btn-default">Create</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php require "../includes/footer.php"; ?>