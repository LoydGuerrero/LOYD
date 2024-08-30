<?php
include 'db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$post_id = $_GET['post_id'];

$sql = "INSERT INTO likes (user_id, post_id) VALUES ('$user_id', '$post_id')";
$conn->query($sql);

header("Location: view_posts.php");
?>
