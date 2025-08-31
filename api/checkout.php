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
        product_size, total_price, payment_method, order_note, order_status, order_visibility
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'Pending', 'Show')";

    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        echo json_encode(["success"=>false, "message"=>"Prepare failed: ".$conn->error]);
        exit();
    }

    foreach ($orders as $order) {
        $stmt->bind_param(
            "issssssisisdss",
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
            $order['payment_method'],    // string
            $order['order_note']         // string
        );

        // START //
        if ($stmt->execute()) {

                if ($order['payment_method'] != "Cash On Delivery") {

                    $order_no = $conn->insert_id;

                    $sql_payment = "INSERT INTO payment_info (invoice_no, order_no, order_status, payment_method, acc_number, transaction_id, payment_status)
                    VALUES (?, ?, 'Pending', ?, ?, ?, 'Unpaid')";

                    $stmt_payment = $conn->prepare($sql_payment);

                    $stmt_payment->bind_param("sisss", $order['invoice_no'], $order_no, $order['payment_method'], $order['accNum'], $order['transactionID']);

                    $stmt_payment->execute();
                    $stmt_payment->close();
                }

                // Decrease product stock
                $sql_stock = "UPDATE product_info SET available_stock = available_stock - ? WHERE product_id = ?";
                $stmt_stock = $conn->prepare($sql_stock);
                $stmt_stock->bind_param("ii", $order['product_quantity'], $order['product_id']);
                $stmt_stock->execute();
                $stmt_stock->close();
                // END

                // Send a confirmation sms to the customer
                $phoneNumber = '88' . $order['user_phone'];
                $sms = "Dear {$order['user_full_name']}, your order with Invoice No: {$order['invoice_no']} has been placed successfully. Order Amount: {$order['total_price']} Tk. Thank you for shopping with us.";
                //echo send_sms_to_customer($phoneNumber, $sms);
                // end

        } else {
            echo json_encode(["success"=>false, "message"=>"Execute failed: ".$stmt->error]);
            exit();
        }
        // END

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