<?php
include 'db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $post_id = $_POST['post_id'];
    $comment = $_POST['comment'];
    $user_id = $_SESSION['user_id'];

    $sql = "INSERT INTO comments (user_id, post_id, comment) VALUES ('$user_id', '$post_id', '$comment')";
    $conn->query($sql);

    header("Location: view_posts.php");
}
?>

<form method="POST" action="comment_post.php">
    <input type="hidden" name="post_id" value="<?php echo $_GET['post_id']; ?>">
    Comment: <textarea name="comment" required></textarea><br>
    <button type="submit">Comment</button>
</form>
