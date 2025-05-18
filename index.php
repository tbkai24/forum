<?php 
require "includes/header.php"; 
require "config/config.php"; 

// Fetch all topics with user avatar and reply counts
$topics = $conn->prepare("
    SELECT 
        topics.id,
        topics.title,
        topics.category,
        topics.user_name,
        users.avatar AS user_image,
        topics.body,
        topics.created_at,
        COUNT(DISTINCT replies.id) AS count_replies
    FROM topics 
    LEFT JOIN replies ON topics.id = replies.topics_id 
    LEFT JOIN users ON topics.user_name = users.username
    GROUP BY topics.id
    ORDER BY topics.created_at DESC
");
$topics->execute();
$allTopics = $topics->fetchAll(PDO::FETCH_OBJ);

// Function to create preview text with "See more"
function previewText($text, $maxLength = 200) {
    if(strlen($text) <= $maxLength) {
        return nl2br(htmlspecialchars($text));
    }
    $short = substr($text, 0, $maxLength);
    $lastSpace = strrpos($short, ' ');
    $short = substr($short, 0, $lastSpace);
    return nl2br(htmlspecialchars($short)) . '... <a href="#">See more</a>';
}
?>

<div class="container">
    <div class="row">
        <div class="col-md-8">
            <div class="main-col">
                <div class="block">
                    <h1 class="pull-left">Welcome to Forum</h1>
                    <div class="clearfix"></div>
                    <hr>
                    <ul id="topics" class="list-unstyled">
                        <?php if(count($allTopics) > 0): ?>
                            <?php foreach($allTopics as $topic): ?>
                            <li class="topic mb-4 p-3 border rounded" data-topic-id="<?php echo $topic->id; ?>">
                                <div class="row">
                                    <div class="col-md-2 text-center">
                                        <?php if (!empty($topic->user_image) && file_exists("img/" . $topic->user_image)): ?>
                                            <img class="avatar img-fluid rounded-circle" src="img/<?php echo htmlspecialchars($topic->user_image); ?>" alt="User Avatar" style="max-width: 80px;">
                                        <?php else: ?>
                                            <i class="fas fa-user-circle" style="font-size:80px; color:#ccc;"></i>
                                        <?php endif; ?>
                                    </div>
                                    <div class="col-md-10">
                                        <h3>
                                            <a href="<?php echo APPURL; ?>/topics/topic.php?id=<?php echo $topic->id; ?>">
                                                <?php echo htmlspecialchars($topic->title); ?>
                                            </a>
                                        </h3>
                                        <div class="topic-info mb-2">
                                            <a href="<?php echo APPURL; ?>/categories/show.php?name=<?php echo urlencode($topic->category); ?>">
                                                <?php echo htmlspecialchars($topic->category); ?>
                                            </a> &raquo; 
                                            <a href="<?php echo APPURL; ?>/users/profile.php?name=<?php echo urlencode($topic->user_name); ?>">
                                                <?php echo htmlspecialchars($topic->user_name); ?>
                                            </a> &raquo; 
                                            Posted on: <?php echo date('M d, Y', strtotime($topic->created_at)); ?>
                                            <span class="badge bg-primary float-end"><?php echo $topic->count_replies; ?> replies</span>
                                        </div>
                                        <p class="topic-preview">
                                            <?php echo previewText($topic->body); ?>
                                        </p>
                                    </div>
                                </div>
                            </li>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <li>No topics found.</li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </div>

<?php require "includes/footer.php"; ?>
