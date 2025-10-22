<?php
// delete_mockup_product.php
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

// ---- Fetch product to delete images ----
$stmt = mysqli_prepare($conn, "SELECT product_img, product_img2, product_img3, product_img4 FROM mockup_products WHERE id = ? LIMIT 1");
mysqli_stmt_bind_param($stmt, 'i', $id);
mysqli_stmt_execute($stmt);
$res = mysqli_stmt_get_result($stmt);
$product = mysqli_fetch_assoc($res);
mysqli_stmt_close($stmt);

if (!$product) {
  echo json_encode(['success' => false, 'message' => 'Product not found']);
  exit;
}

// ---- Delete product ----
$del = mysqli_prepare($conn, "DELETE FROM mockup_products WHERE id = ? LIMIT 1");
mysqli_stmt_bind_param($del, 'i', $id);
$ok = mysqli_stmt_execute($del);
$err = mysqli_error($conn);
mysqli_stmt_close($del);

if ($ok) {
  // ---- Delete all product images if exist ----
  $imgFields = ['product_img', 'product_img2', 'product_img3', 'product_img4'];
  foreach ($imgFields as $imgField) {
    if (!empty($product[$imgField])) {
      $imgPath = __DIR__ . '/' . $product[$imgField];
      if (file_exists($imgPath)) {
        @unlink($imgPath);
      }
    }
  }

  echo json_encode(['success' => true, 'message' => 'Mockup product deleted successfully']);
} else {
  echo json_encode(['success' => false, 'message' => 'Delete failed: ' . $err]);
}
?>