<?php require "layouts/header.php"; ?>
<?php require "../config/config.php"; ?>
<?php

if(!isset($_SESSION['adminname'])) {
  header("location: ".ADMINURL."/admins/login-admins.php");
}

$topics = $conn->query("SELECT COUNT(*) AS count_topics FROM topics");
$topics->execute();
$allTopics = $topics->fetch(PDO::FETCH_OBJ);

$categories = $conn->query("SELECT COUNT(*) AS count_categories FROM categories");
$categories->execute();
$allCategories = $categories->fetch(PDO::FETCH_OBJ);

$admins = $conn->query("SELECT COUNT(*) AS count_admins FROM admins");
$admins->execute();
$allAdmins = $admins->fetch(PDO::FETCH_OBJ);

$replies = $conn->query("SELECT COUNT(*) AS count_replies FROM replies");
$replies->execute();
$allReplies = $replies->fetch(PDO::FETCH_OBJ);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
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
        .dashboard-container {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 800px;
        }
        .card {
            border: none;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .card-title {
            color: #28a745;
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <h3 class="mb-4 text-center">Admin Dashboard</h3>
        <div class="row">
            <div class="col-md-6 mb-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"><i class="fas fa-comments"></i> Topics</h5>
                        <p class="card-text">Number of topics: <?php echo $allTopics->count_topics; ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"><i class="fas fa-list"></i> Categories</h5>
                        <p class="card-text">Number of categories: <?php echo $allCategories->count_categories; ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"><i class="fas fa-user-shield"></i> Admins</h5>
                        <p class="card-text">Number of admins: <?php echo $allAdmins->count_admins; ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"><i class="fas fa-reply"></i> Replies</h5>
                        <p class="card-text">Number of replies: <?php echo $allReplies->count_replies; ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

<?php require "layouts/footer.php"; ?>
