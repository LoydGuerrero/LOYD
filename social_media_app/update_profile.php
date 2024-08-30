<?php
include 'db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
if (isset($_FILES['profile_pic'])) {
    $file_name = $_FILES['profile_pic']['name'];
    $target = "uploads/" . basename($file_name);
    move_uploaded_file($_FILES['profile_pic']['tmp_name'], $target);

    $sql = "UPDATE users SET profile_pic='$file_name' WHERE id=$user_id";
    $conn->query($sql);

    header("Location: profile.php");
}
?>
