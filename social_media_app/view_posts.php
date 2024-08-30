<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Posts</title>
    <link rel="stylesheet" type="text/css" href="/style.css">
</head>
<body>
    <div class="container">
        <h1>Posts</h1>
        <?php
        include 'db.php';
        session_start();

        if (!isset($_SESSION['user_id'])) {
            header("Location: login.php");
            exit();
        }

        $sql = "SELECT posts.id, posts.content, users.username FROM posts JOIN users ON posts.user_id = users.id ORDER BY posts.created_at DESC";
        $result = $conn->query($sql);

        while ($row = $result->fetch_assoc()) {
            echo "<div class='post'>";
            echo "<p class='content'><strong>{$row['username']}:</strong> {$row['content']}</p>";
            echo "<div class='actions'><a href='like_post.php?post_id={$row['id']}'>Like</a> | <a href='comment_post.php?post_id={$row['id']}'>Comment</a></div>";
            echo "</div>";
        }
        ?>
    </div>
</body>
</html>
