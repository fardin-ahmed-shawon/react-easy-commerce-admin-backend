<?php
session_start();
require_once './config.php';
header('Content-Type: application/json');

// Custom error handler
set_exception_handler(function ($exception) {
    echo json_encode([
        "success" => false,
        "message" => $exception->getMessage()
    ]);
    exit();
});

// Receive action
$action = $_GET['action'] ?? '';

if ($action === '') {
    echo json_encode([
        "success" => false,
        "message" => "No action specified!"
    ]);
    exit();
}

//////////////////////////////////////////////////////////////////////////////////////
// ================== Handle the 'place-mockup-order' action ========================
//////////////////////////////////////////////////////////////////////////////////////
if ($action === 'place-mockup-order') {

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        echo json_encode([
            "success" => false,
            "message" => "Only POST method is allowed!"
        ]);
        exit();
    }

    $order = json_decode(file_get_contents("php://input"), true);

    if (!$order || !is_array($order)) {
        echo json_encode([
            "success" => false,
            "message" => "Invalid data format!"
        ]);
        exit();
    }

    // SQL insert for mockup_orders table
    $sql = "INSERT INTO mockup_orders (
                user_id,
                user_full_name,
                user_phone,
                user_email,
                user_address,
                city_address,
                team_name,
                quantity,
                order_no,
                product_id,
                payment_method,
                order_note,
                order_status,
                order_visibility
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'Pending', 'Show')";

    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        echo json_encode([
            "success" => false,
            "message" => "Prepare failed: " . $conn->error
        ]);
        exit();
    }

    // Bind parameters (integer and string types)
    $bind_types = "issssssisis"; // corresponds to the 11 placeholders before fixed status/visibility

    $bind_params = [
        $order['user_id'] ?? 0,
        $order['user_full_name'] ?? '',
        $order['user_phone'] ?? '',
        $order['user_email'] ?? '',
        $order['user_address'] ?? '',
        $order['city_address'] ?? '',
        $order['team_name'] ?? '',
        $order['quantity'] ?? 1,
        $order['order_no'] ?? '',
        $order['product_id'] ?? 0,
        $order['payment_method'] ?? 'Cash On Delivery',
        $order['order_note'] ?? ''
    ];

    // Bind parameters safely
    if (!$stmt->bind_param($bind_types, ...$bind_params)) {
        echo json_encode([
            "success" => false,
            "message" => "Bind failed: " . $stmt->error
        ]);
        $stmt->close();
        exit();
    }

    // ✅ Execute the statement
    if ($stmt->execute()) {
        $order_id = $conn->insert_id;
        echo json_encode([
            "success" => true,
            "message" => "Order placed successfully!",
            "order_id" => $order_id,
            "order_no" => $order['order_no'] ?? ''
        ]);
    } else {
        echo json_encode([
            "success" => false,
            "message" => "Execute failed: " . $stmt->error
        ]);
    }

    $stmt->close();
    exit();
}

//////////////////////////////////////////////////////////////////////////////////////
// ============================ INVALID ACTION =====================================
//////////////////////////////////////////////////////////////////////////////////////
else {
    echo json_encode([
        "success" => false,
        "message" => "Invalid action specified!"
    ]);
    exit();
}
?>