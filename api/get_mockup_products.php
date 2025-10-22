<?php
session_start();
require_once './config.php';

// Set JSON error handler
set_exception_handler(function ($exception) {
    echo json_encode([
        "success" => false,
        "message" => $exception->getMessage()
    ]);
    exit();
});

// Get the action
$action = $_GET['action'] ?? '';

if ($action === '') {
    echo json_encode([
        "success" => false,
        "message" => "No action specified!"
    ]);
    exit();
}

//////////////////////////////////////////////////////////////////////////////////////
// ======================= GET MOCKUP PRODUCTS ===========================
//////////////////////////////////////////////////////////////////////////////////////
if ($action === 'get-mockup-products') {

    $sql = "SELECT 
                p.*, 
                c.category_name, 
                c.category_slug
            FROM 
                mockup_products p
            JOIN 
                mockup_category c ON p.category_id = c.id
            ORDER BY p.id DESC";

    $result = mysqli_query($conn, $sql);

    if (!$result) {
        throw new Exception("Database query failed: " . mysqli_error($conn));
    }

    $response = [];

    while ($row = mysqli_fetch_assoc($result)) {
        $response[] = [
            "id" => $row['id'],

            // Image with full URL
            "img"  => $row['product_img']  ? $site_link . 'Admin/' . $row['product_img']  : "",
            "img2" => $row['product_img2'] ? $site_link . 'Admin/' . $row['product_img2'] : "",
            "img3" => $row['product_img3'] ? $site_link . 'Admin/' . $row['product_img3'] : "",
            "img4" => $row['product_img4'] ? $site_link . 'Admin/' . $row['product_img4'] : "",

            "title" => $row['product_title'],
            "category" => $row['category_name'],
            "category_slug" => $row['category_slug'],
            "product_code" => $row['product_code'],
            "description" => $row['product_description'],
            "product_slug" => $row['product_slug'],
            "link" => '/mockup-product/' . $row['product_slug'],
            "created_at" => $row['created_at']
        ];
    }

    echo json_encode($response);
    exit();
}

//////////////////////////////////////////////////////////////////////////////////////
// ======================= INVALID ACTION ===========================
//////////////////////////////////////////////////////////////////////////////////////
else {
    echo json_encode([
        "success" => false,
        "message" => "Invalid action specified!"
    ]);
    exit();
}
?>