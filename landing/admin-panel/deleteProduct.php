<?php
include('../dbConnection.php');

if (isset($_GET['id'])) {
    $productId = $_GET['id'];
    $sql = "DELETE FROM product_info WHERE product_id = $productId";

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Product deleted successfully!'); window.location.href='viewProduct.php';</script>";
    } else {
        echo "<script>alert('Error deleting product.'); window.location.href='viewProduct.php';</script>";
    }
}
?>