<?php
session_start();
require_once './config.php';

// Set a custom error handler to return JSON for errors
set_exception_handler(function ($exception) {
    echo json_encode([
        "success" => false,
        "message" => $exception->getMessage()
    ]);
    exit();
});

// Receive the action type
$action = $_GET['action'] ?? '';

// Check if the 'action' parameter is set in the URL
if ($action == '') {
    echo json_encode([
        "success" => false,
        "message" => "No action specified!"
    ]);
    exit();
}

//////////////////////////////////////////////////////////////////////////////////////
// =================== Handle the 'get-mockup-categories' action ====================
//////////////////////////////////////////////////////////////////////////////////////
if ($action === 'get-mockup-categories') {

    $sql = "SELECT * FROM mockup_category ORDER BY id DESC";
    $result = mysqli_query($conn, $sql);

    if (!$result) {
        throw new Exception("Database query failed: " . mysqli_error($conn));
    }

    $categories = [];

    while ($row = mysqli_fetch_assoc($result)) {
        $categories[] = [
            "id" => $row['id'],
            "title" => $row['category_name'],
            "slug" => $row['category_slug'],
            "created_at" => $row['created_at']
        ];
    }

    echo json_encode($categories);
    exit();
}

//////////////////////////////////////////////////////////////////////////////////////
// =========================== INVALID ACTION ======================================
//////////////////////////////////////////////////////////////////////////////////////
else {
    echo json_encode([
        "success" => false,
        "message" => "Invalid action specified!"
    ]);
    exit();
}
?>