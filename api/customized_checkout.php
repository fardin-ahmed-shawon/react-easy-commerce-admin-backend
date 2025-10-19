<?php
session_start();
require_once './config.php';

header('Content-Type: application/json');

// Set a custom error handler to return JSON for errors
set_exception_handler(function ($exception) {
    $response = array(
        "success" => false,
        "message" => $exception->getMessage()
    );
    echo json_encode($response);
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
//////////////////////// Handle the 'place-customized-order' action ///////////////////////
////////////////////////////////////////////////////////////////////////////////////
if ($action == 'place-customized-order') {

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        echo json_encode(["success" => false, "message" => "Only POST method is allowed!"]);
        exit();
    }

    $order = json_decode(file_get_contents("php://input"), true);

    if (!$order || !is_array($order)) {
        echo json_encode(["success" => false, "message" => "Invalid data!"]);
        exit();
    }

    $sql = "INSERT INTO customized_orders (
        user_id, user_full_name, user_phone, user_email, user_address,
        city_address, jersey_name, jersey_num, jersey_type, jersey_size, order_no, product_id, payment_method, acc_number,
        transaction_id, order_note, order_status, order_visibility
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'Pending', 'Show')";

    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        echo json_encode(["success" => false, "message" => "Prepare failed: " . $conn->error]);
        exit();
    }

    // Correct type string (12 parameters): i = int, s = string
    $bind_types = "issssssisssissss";

    $bind_params = [
        $order['user_id'] ?? 0,
        $order['user_full_name'] ?? '',
        $order['user_phone'] ?? '',
        $order['user_email'] ?? '',
        $order['user_address'] ?? '',
        $order['city_address'] ?? '',

        $order['jersey_name'] ?? '',
        $order['jersey_num'] ?? '',
        $order['jersey_type'] ?? '',
        $order['size'] ?? '',

        $order['order_no'] ?? '',
        $order['product_id'] ?? 0,
        $order['payment_method'] ?? 'Cash On Delivery',
        $order['acc_number'] ?? '',
        $order['transaction_id'] ?? '',
        $order['order_note'] ?? ''
    ];

    if (!$stmt->bind_param($bind_types, ...$bind_params)) {
        echo json_encode(["success" => false, "message" => "Bind failed: " . $stmt->error]);
        $stmt->close();
        exit();
    }

    if ($stmt->execute()) {
        $order_id = $conn->insert_id; // ✅ Fix: Get inserted order ID
        echo json_encode([
            "success" => true,
            "message" => "Order placed successfully!",
            "order_id" => $order_id,
            "order_no" => $order['order_no'] ?? ''
        ]);
    } else {
        echo json_encode(["success" => false, "message" => "Execute failed: " . $stmt->error]);
    }

    $stmt->close();
    exit();
}

//////////////////////////////////////////////////////////////////////////////////////
/////////////////////////// END /////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////

// Handle wrong/invalid action
else {
    echo json_encode([
        "success" => false,
        "message" => "Invalid action specified!"
    ]);
    exit();
}

?>