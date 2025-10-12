<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}
// database connection
include('database/dbConnection.php');

if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "<p>Invalid blog ID.</p>";
    exit;
}

$blog_id = intval($_GET['id']);

// Fetch the blog to remove its image
$query = "SELECT blog_img FROM blogs WHERE id = $blog_id LIMIT 1";
$result = mysqli_query($conn, $query);
if (mysqli_num_rows($result) > 0) {
    $blog = mysqli_fetch_assoc($result);
    if (!empty($blog['blog_img']) && file_exists('uploads/' . $blog['blog_img'])) {
        unlink('uploads/' . $blog['blog_img']); // Delete image file
    }
}

// Delete the blog
$delete_query = "DELETE FROM blogs WHERE id = $blog_id";
if (mysqli_query($conn, $delete_query)) {
    header("Location: blogs.php");
    exit;
} else {
    echo "<p style='color:red;'>Error deleting blog: " . mysqli_error($conn) . "</p>";
}
?>