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
//////////////////////////// Handle the 'get-orders' action ///////////////////////////
////////////////////////////////////////////////////////////////////////////////////
if ($action == 'get-orders') {

    $user_id = $_GET['user_id'] ?? '';

    if ($user_id === '' || $user_id == '0') {
        $response = array(
            "success" => false,
            "message" => "User ID is required."
        );
        echo json_encode($response);
        exit();
    }

    // Fetch all orders grouped by invoice_no
    $sql = "SELECT * FROM order_info WHERE user_id = '$user_id' ORDER BY order_no DESC";
    $result = mysqli_query($conn, $sql);

    $orders_grouped = [];

    // Group orders by invoice_no
    while ($order = mysqli_fetch_assoc($result)) {
        $invoice_no = $order['invoice_no'];
        
        // If this invoice doesn't exist in our array, create it
        if (!isset($orders_grouped[$invoice_no])) {

            $shipping = find_shipping_charge($invoice_no);
            $discount = calculate_discount_amount($invoice_no);

            $orders_grouped[$invoice_no] = [
                "invoice_no" => $order['invoice_no'],
                "date" => date('M j, Y', strtotime($order['order_date'])),
                "status" => $order['order_status'],
                "total_purchase_amount" => "0",
                "total_ordered_items" => "0",
                "shippingCharge" => (string)$shipping,
                "discountAmount" => (string)$discount,
                "final_amount" => "0",
                "order_note" => $order['order_note'] ?? '',
                "paymentMethod" => $order['payment_method'],
                "shippingAddress" => $order['user_address'],
                "items" => []
            ];
        }
        
        // Add item to this invoice
        $orders_grouped[$invoice_no]['items'][] = [
            "order_no" => $order['order_no'],
            "product_id" => $order['product_id'],
            "product_title" => $order['product_title'],
            "quantity" => $order['product_quantity'],
            "size" => $order['product_size'],
            "color" => $order['product_color'],
            "total_price" => $order['total_price']
        ];
        
        // Update totals
        $orders_grouped[$invoice_no]['total_purchase_amount'] = (string)((int)$orders_grouped[$invoice_no]['total_purchase_amount'] + (int)$order['total_price']);
        $orders_grouped[$invoice_no]['total_ordered_items'] = (string)((int)$orders_grouped[$invoice_no]['total_ordered_items'] + (int)$order['product_quantity']);
        $final_amount = (int)$orders_grouped[$invoice_no]['total_purchase_amount'] + (int)$orders_grouped[$invoice_no]['shippingCharge'] - (int)$orders_grouped[$invoice_no]['discountAmount'];
        $orders_grouped[$invoice_no]['final_amount'] = (string)$final_amount;
    }

    // Convert associative array to indexed array
    $orders = array_values($orders_grouped);

    echo json_encode($orders);
    exit();
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