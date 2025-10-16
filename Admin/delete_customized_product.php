<?php
// delete_customized_product.php
require 'database/dbConnection.php';
header('Content-Type: application/json');

$input = json_decode(file_get_contents('php://input'), true);
if (!$input || !isset($input['id'])) {
  echo json_encode(['success' => false, 'message' => 'Invalid request']);
  exit;
}

$id = intval($input['id']);
if ($id <= 0) {
  echo json_encode(['success' => false, 'message' => 'Invalid product id']);
  exit;
}

// Optional: fetch product to remove image file from disk
$stmt = mysqli_prepare($conn, "SELECT product_img FROM customized_products WHERE id = ? LIMIT 1");
mysqli_stmt_bind_param($stmt, 'i', $id);
mysqli_stmt_execute($stmt);
$res = mysqli_stmt_get_result($stmt);
$imgPath = null;
if ($row = mysqli_fetch_assoc($res)) {
  $imgPath = $row['product_img'];
}
mysqli_stmt_close($stmt);

// Delete row (prepared)
$del = mysqli_prepare($conn, "DELETE FROM customized_products WHERE id = ? LIMIT 1");
mysqli_stmt_bind_param($del, 'i', $id);
$ok = mysqli_stmt_execute($del);
$err = mysqli_error($conn);
mysqli_stmt_close($del);

if ($ok) {
  // try to unlink image (optional)
  if ($imgPath && file_exists(__DIR__ . '/' . $imgPath)) {
    @unlink(__DIR__ . '/' . $imgPath);
  }
  echo json_encode(['success' => true, 'message' => 'Product deleted']);
} else {
  echo json_encode(['success' => false, 'message' => 'Delete failed: ' . $err]);
}