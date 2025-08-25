<?php
session_start();
require_once './config.php';


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
    $response = array(
        "success" => false,
        "message" => "No action specified!"
    );
    echo json_encode($response);
    exit();
}



//////////////////////////////////////////////////////////////////////////////////////
//////////////////////// Handle the 'place-order' action ///////////////////////
////////////////////////////////////////////////////////////////////////////////////
if ($action == 'place-order') {
    $orders = json_decode(file_get_contents("php://input"), true);

    if (!$orders || !is_array($orders)) {
        echo json_encode(["success"=>false, "message"=>"Invalid data!"]);
        exit();
    }

    $sql = "INSERT INTO order_info (
        user_id, user_full_name, user_phone, user_email, user_address, 
        city_address, invoice_no, product_id, product_title, product_quantity, 
        product_size, total_price, payment_method, order_status, order_visibility
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'Pending', 'Show')";

    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        echo json_encode(["success"=>false, "message"=>"Prepare failed: ".$conn->error]);
        exit();
    }

    foreach ($orders as $order) {
        $stmt->bind_param(
            "issssssisisds",
            $order['user_id'],          // int
            $order['user_full_name'],   // string
            $order['user_phone'],       // string
            $order['user_email'],       // string
            $order['user_address'],     // string
            $order['city_address'],     // string
            $order['invoice_no'],       // string
            $order['product_id'],       // int
            $order['product_title'],    // string
            $order['product_quantity'], // int
            $order['product_size'],     // string
            $order['total_price'],      // decimal/double
            $order['payment_method']    // string
        );


        if (!$stmt->execute()) {
            echo json_encode(["success"=>false, "message"=>"Execute failed: ".$stmt->error]);
            exit();
        }
    }

    echo json_encode(["success"=>true, "message"=>"Order placed successfully!"]);
    exit();
}
//////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////// END /////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////



// Handle wrong/invalid action
else {
    $response = array(
        "success" => false,
        "message" => "Invalid action specified!"
    );
    echo json_encode($response);
    exit();
}

?>