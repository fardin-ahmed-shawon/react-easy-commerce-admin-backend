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
//////////////////////////// Handle the 'order-tracking' action ///////////////////////////
////////////////////////////////////////////////////////////////////////////////////
if ($action == 'order-tracking') {
    // Get invoice_no from POST
    $invoice_no = $_POST['invoice_no'] ?? '';

    if (empty($invoice_no)) {
        echo json_encode([
            "success" => false,
            "message" => "Invoice number is required!"
        ]);
        exit();
    }

    // Sanitize
    $invoice_no = $conn->real_escape_string($invoice_no);

    // Query to fetch all order items for this invoice
    $sql = "SELECT * FROM order_info 
            WHERE invoice_no = '$invoice_no'
            ORDER BY order_no DESC";

    $result = $conn->query($sql);

    if (!$result) {
        echo json_encode([
            "success" => false,
            "message" => "Database query failed: " . $conn->error
        ]);
        exit();
    }

    if ($result->num_rows > 0) {
        $order_data = null;
        $items = [];
        $total_purchase_amount = 0;
        $total_ordered_items = 0;

        // Loop through all items
        while ($row = $result->fetch_assoc()) {
            // Set order-level data from first row (same for all items)
            if ($order_data === null) {
                $shipping = find_shipping_charge($invoice_no);
                $discount = calculate_discount_amount($invoice_no);

                $order_data = [
                    "invoice_no" => $row['invoice_no'],
                    "date" => date('M j, Y', strtotime($row['order_date'])),
                    "status" => $row['order_status'],
                    "order_note" => $row['order_note'] ?? '',
                    "paymentMethod" => $row['payment_method'],
                    "shippingAddress" => $row['user_address'],
                    "shippingCharge" => (string)$shipping,
                    "discountAmount" => (string)$discount,
                ];
            }

            // Add item to items array
            $items[] = [
                "order_no" => $row['order_no'],
                "product_id" => $row['product_id'],
                "product_title" => $row['product_title'],
                "quantity" => $row['product_quantity'],
                "size" => $row['product_size'],
                "color" => $row['product_color'],
                "total_price" => $row['total_price']
            ];

            // Update totals
            $total_purchase_amount += (int)$row['total_price'];
            $total_ordered_items += (int)$row['product_quantity'];
        }

        // Calculate final amount
        $final_amount = $total_purchase_amount + (int)$order_data['shippingCharge'] - (int)$order_data['discountAmount'];

        // Build final response
        $response = [
            "success" => true,
            "data" => array_merge($order_data, [
                "total_purchase_amount" => (string)$total_purchase_amount,
                "total_ordered_items" => (string)$total_ordered_items,
                "final_amount" => (string)$final_amount,
                "items" => $items
            ])
        ];

        echo json_encode($response);
        exit();
    } else {
        echo json_encode([
            "success" => false,
            "message" => "No orders found for this invoice number."
        ]);
        exit();
    }
}
////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////// END ///////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////



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