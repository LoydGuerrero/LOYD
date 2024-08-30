<?php
session_start();  // Start the session

// Include your database connection file
include 'db.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to login page if not logged in
    header("Location: login_register.php");
    exit();
}

// Fetch user data from the database
$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT username, email, profile_picture FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

// Check if user data is fetched successfully
if ($result->num_rows > 0) {
    // Fetch user data
    $user = $result->fetch_assoc();
} else {
    // Handle case where user data is not found
    echo "User not found.";
    exit();
}

// Handle photo upload
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["profile_picture"])) {
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["profile_picture"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Debugging information
    echo "<br>Target Directory: " . realpath($target_dir);
    echo "<br>Target File: " . realpath($target_file);
    echo "<br>Uploaded File Path: " . $_FILES["profile_picture"]["tmp_name"];

    // Check if uploads directory exists
    if (!is_dir($target_dir)) {
        echo "Uploads directory does not exist.";
        $uploadOk = 0;
    }

    // Check if file is an image
    $check = getimagesize($_FILES["profile_picture"]["tmp_name"]);
    if ($check === false) {
        echo "File is not an image.";
        $uploadOk = 0;
    }

    // Check file size (limit to 2MB)
    if ($_FILES["profile_picture"]["size"] > 2000000) {
        echo "File is too large.";
        $uploadOk = 0;
    }

    // Allow certain file formats
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        echo "Only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Your file was not uploaded.";
    } else {
        // Try to upload file
        if (move_uploaded_file($_FILES["profile_picture"]["tmp_name"], $target_file)) {
            // Update the database with the new profile picture path
            $stmt = $conn->prepare("UPDATE users SET profile_picture = ? WHERE id = ?");
            $stmt->bind_param("si", $target_file, $user_id);
            if ($stmt->execute()) {
                echo "The file ". htmlspecialchars(basename($_FILES["profile_picture"]["name"])). " has been uploaded.";
                // Reload the page to show updated profile picture
                header("Location: profile.php");
                exit();
            } else {
                echo "Error updating profile picture in database.";
            }
            $stmt->close();
        } else {
            // Output detailed error
            echo "There was an error uploading your file.";
            echo "<br>Error Details: " . error_get_last()['message'];
        }
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <div class="container">
        <h1>User Profile</h1>
        <p>Username: <?php echo htmlspecialchars($user['username']); ?></p>
        <p>Email: <?php echo htmlspecialchars($user['email']); ?></p>
        
        <!-- Display profile picture -->
        <?php if (!empty($user['profile_picture'])): ?>
            <img src="<?php echo htmlspecialchars($user['profile_picture']); ?>" alt="Profile Picture" style="width: 150px; height: 150px; border-radius: 50%;">
        <?php else: ?>
            <p>No profile picture uploaded.</p>
        <?php endif; ?>

        <!-- Upload form -->
        <form method="POST" enctype="multipart/form-data">
            <label for="profile_picture">Upload Profile Picture:</label>
            <input type="file" name="profile_picture" id="profile_picture" accept="image/*" required>
            <button type="submit">Upload</button>
        </form>

        <a href="logout.php">Logout</a>
        <br><br>
        <!-- Button to navigate to AngularJS app -->
        <a href="index.html" class="button">Go to Social media App</a>
    </div>
</body>
</html>
