<?php require "../includes/header.php"; ?>
<?php require "../config/config.php"; ?>

<?php
if (!isset($_SESSION['username'])) {
    header("location: " . APPURL . "");
    exit;
}

// Fetch categories from database
$categories_query = $conn->query("SELECT * FROM categories ORDER BY name ASC");
$categories = $categories_query->fetchAll(PDO::FETCH_OBJ);

// Grab the topic to edit
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $select = $conn->query("SELECT * FROM topics WHERE id='$id'");
    $select->execute();

    $topic = $select->fetch(PDO::FETCH_OBJ);
}

if (isset($_POST['submit'])) {
    if (empty($_POST['title']) || empty($_POST['category']) || empty($_POST['body'])) {
        $error = "One or more inputs are empty.";
    } else {
        $title = $_POST['title'];
        $category = $_POST['category'];
        $body = $_POST['body'];
        $user_name = $_SESSION['name'];

        $update = $conn->prepare("UPDATE topics SET title = :title, category = :category,
            body = :body, user_name = :user_name WHERE id = :id");

        $update->execute([
            ":title" => $title,
            ":category" => $category,
            ":body" => $body,
            ":user_name" => $user_name,
            ":id" => $id
        ]);

        $_SESSION['success'] = "Topic updated successfully!";
        header("Location: update.php?id=" . $id);
        exit;
    }
}
?>

<div class="container">
    <div class="row">
        <div class="col-md-8">
            <div class="main-col">
                <div class="block">
                    <h1 class="pull-left">Update Topic</h1>
                    <h4 class="pull-right">A Simple Forum</h4>
                    <div class="clearfix"></div>
                    <hr>

                    <!-- Show Success or Error Alert -->
                    <?php if (isset($_SESSION['success'])): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert"
                             style="background-color: #198754 !important; color: white !important; font-weight: bold;">
                            <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php elseif (isset($error)): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <?php echo $error; ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>

                    <form role="form" method="POST" action="update.php?id=<?php echo $id; ?>">
                        <div class="form-group">
                            <label>Topic Title</label>
                            <input type="text" value="<?php echo htmlspecialchars($topic->title); ?>" class="form-control" name="title" placeholder="Enter Post Title">
                        </div>
                        <div class="form-group">
                            <label>Category</label>
                            <select name="category" class="form-control">
                                <?php foreach ($categories as $category): ?>
                                    <option value="<?php echo htmlspecialchars($category->name); ?>"
                                        <?php echo ($category->name == $topic->category) ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars($category->name); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Topic Body</label>
                            <textarea id="body" rows="10" cols="80" class="form-control" name="body"><?php echo htmlspecialchars($topic->body); ?></textarea>
                            <script>CKEDITOR.replace('body');</script>
                        </div>
                        <button type="submit" name="submit" class="color btn btn-default">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require "../includes/footer.php"; ?>
