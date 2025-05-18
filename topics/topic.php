<?php
require "../includes/header.php";
require "../config/config.php";

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch topic and user info using JOIN
    $topic = $conn->prepare("
       SELECT topics.*, users.username AS user_name, users.avatar AS user_image
        FROM topics
        JOIN users ON topics.user_id = users.id
        WHERE topics.id = :id
    ");
    $topic->execute(['id' => $id]);
    $singleTopic = $topic->fetch(PDO::FETCH_OBJ);

    if (!$singleTopic) {
        header("Location: " . APPURL . "/404.php");
        exit();
    }

    // Count user's topics
    $topicCount = $conn->prepare("SELECT COUNT(*) AS count_topics FROM topics WHERE user_id = :user_id");
    $topicCount->execute(['user_id' => $singleTopic->user_id]);
    $count = $topicCount->fetch(PDO::FETCH_OBJ);

    // Fetch replies for the topic (with user info)
    $reply = $conn->prepare("
        SELECT replies.*, users.username AS user_name, users.avatar AS user_image
        FROM replies
        JOIN users ON replies.user_id = users.id
        WHERE replies.topics_id = :topic_id
    ");
    $reply->execute(['topic_id' => $id]);
    $allReplies = $reply->fetchAll(PDO::FETCH_OBJ);
} else {
    header("Location: " . APPURL . "/404.php");
    exit();
}

// Handle reply submission
if (isset($_POST['submit'])) {
    if (!isset($_SESSION['user_id'])) {
        header("Location: " . APPURL . "/auth/login.php");
        exit();
    }

    if (empty($_POST['reply'])) {
        echo "<script>alert('Reply cannot be empty');</script>";
    } else {
        $insert = $conn->prepare("INSERT INTO replies (reply, user_id, topics_id) 
                                  VALUES (:reply, :user_id, :topics_id)");
        $insert->execute([
            ":reply" => $_POST['reply'],
            ":user_id" => $_SESSION['user_id'],
            ":topics_id" => $id
        ]);

        header("Location: " . APPURL . "/topics/topic.php?id=" . $id);
        exit();
    }
}
?>

<!-- Topic Display -->
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <div class="main-col">
                <div class="block">
                    <h1 class="pull-left"><?= htmlspecialchars($singleTopic->title); ?></h1>
                    <h4 class="pull-right">A Simple Forum</h4>
                    <div class="clearfix"></div>
                    <hr>
                    <ul id="topics">
                        <li id="main-topic" class="topic topic">
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="user-info text-center">
                                        <?php if (!empty($singleTopic->user_image) && file_exists("../img/" . $singleTopic->user_image)): ?>
                                            <img class="avatar img-fluid rounded-circle" src="../img/<?= htmlspecialchars($singleTopic->user_image); ?>" alt="User Avatar" style="max-width: 80px;">
                                        <?php else: ?>
                                            <i class="fas fa-user-circle" style="font-size:80px; color:#ccc;"></i>
                                        <?php endif; ?>
                                        <ul class="list-unstyled mt-2">
                                            <li><strong><?= htmlspecialchars($singleTopic->user_name); ?></strong></li>
                                            <li><?= $count->count_topics; ?> Posts</li>
                                            <li><a href="<?= APPURL; ?>/users/profile.php?name=<?= urlencode($singleTopic->user_name); ?>">Profile</a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-md-10">
                                    <div class="topic-content">
                                        <p><?= nl2br(htmlspecialchars($singleTopic->body)); ?></p>
                                        <?php if (isset($_SESSION['user_id']) && $singleTopic->user_id == $_SESSION['user_id']) : ?>
                                            <a class="btn btn-danger" href="delete.php?id=<?= $singleTopic->id; ?>">Delete</a>
                                            <a class="btn btn-warning" href="update.php?id=<?= $singleTopic->id; ?>">Update</a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </li>

                        <?php foreach ($allReplies as $reply): ?>
                            <li class="topic topic">
                                <div class="row">
                                    <div class="col-md-2 text-center">
                                        <?php if (!empty($reply->user_image) && file_exists("../img/" . $reply->user_image)): ?>
                                            <img class="avatar img-fluid rounded-circle" src="../img/<?= htmlspecialchars($reply->user_image); ?>" alt="User Avatar" style="max-width: 64px;">
                                        <?php else: ?>
                                            <i class="fas fa-user-circle" style="font-size:64px; color:#ccc;"></i>
                                        <?php endif; ?>
                                        <ul class="list-unstyled mt-2">
                                            <li><strong><?= htmlspecialchars($reply->user_name); ?></strong></li>
                                            <li><a href="<?= APPURL; ?>/users/profile.php?name=<?= urlencode($reply->user_name); ?>">Profile</a></li>
                                        </ul>
                                    </div>
                                    <div class="col-md-10">
                                        <div class="topic-content">
                                            <p><?= nl2br(htmlspecialchars($reply->reply)); ?></p>
                                            <?php if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == $reply->user_id): ?>
                                                <a class="btn btn-danger" href="../replies/delete.php?id=<?= $reply->id; ?>" onclick="return confirm('Are you sure you want to delete this reply?');">Delete</a>
                                                <a class="btn btn-warning" href="../replies/update.php?id=<?= $reply->id; ?>">Update</a>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        <?php endforeach; ?>
                    </ul>

                    <?php if (isset($_SESSION['user_id'])): ?>
                        <h3>Reply To Topic</h3>
                        <form method="POST" action="topic.php?id=<?= $id; ?>">
                            <div class="form-group">
                                <textarea id="reply" name="reply" rows="10" cols="80" class="form-control"></textarea>
                                <script>CKEDITOR.replace('reply');</script>
                            </div>
                            <button type="submit" name="submit" class="btn btn-default">Submit</button>
                        </form>
                    <?php else: ?>
                        <p>Please <a href="<?= APPURL; ?>/auth/login.php">login</a> to reply to this topic.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require "../includes/footer.php"; ?>
