<?php

// bdbulksms.net SMS API integration
function sendSMS($to, $message) {
    
    $token = "109451845141733661914aa3b8fbd868b0da6e2a5c16939ee6f9a";

    $url = "https://api.bdbulksms.net/api.php?json";
    $data= array(
    'to'=>"$to",
    'message'=>"$message",
    'token'=>"$token"
    ); 
    $ch = curl_init(); 
    curl_setopt($ch, CURLOPT_URL,$url);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_ENCODING, '');
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $smsresult = curl_exec($ch);
    
    //Result
    echo $smsresult;
    
    //Error Display
    echo curl_error($ch);
}

// ******* Calculate Discount Amount ********* //
function calculate_discount_amount($invoice_no = '') {
    global $conn;

    if ($invoice_no != '') {
        $sql = "SELECT COALESCE(SUM(total_discount_amount), 0) AS total_amount 
                FROM order_discount_list 
                WHERE invoice_no = '$invoice_no'";
    } else {
        $sql = "SELECT COALESCE(SUM(total_discount_amount), 0) AS total_amount 
                FROM order_discount_list";
    }

    $result = $conn->query($sql);

    if ($result && $row = $result->fetch_assoc()) {
        return (float)$row['total_amount']; // returns 0.0 if no rows
    }

    return 0; 
}

// ******* Check Shipping Charge is free or not ********* //
function is_shipping_charge_free($invoice_no = '') {
    global $conn;
    $sql = "SELECT free_shipping FROM order_discount_list WHERE invoice_no = '$invoice_no'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    return $row['free_shipping'] ?? 0;
}

// ******* Find Shipping Charge ********* //
function find_shipping_charge($invoice_no = '') {
    global $conn;

    // Fetch website information
    $websiteInfoQuery = "SELECT inside_location, inside_delivery_charge, outside_delivery_charge  
                         FROM website_info 
                         WHERE id = 1 LIMIT 1";
    $websiteInfoResult = mysqli_query($conn, $websiteInfoQuery);
    $websiteInfo = mysqli_fetch_assoc($websiteInfoResult);

    // Delivery Information
    $inside_location = $websiteInfo['inside_location'] ?? 'Dhaka';
    $inside_delivery_charge = $websiteInfo['inside_delivery_charge'] ?? 80;
    $outside_delivery_charge = $websiteInfo['outside_delivery_charge'] ?? 150;

    $shipping_cost = 0;

    // Check if shipping is free
    if (is_shipping_charge_free($invoice_no) == 1) {
        return $shipping_cost;
    }

    // Fetch Order Info
    $orderInfoQuery = "SELECT city_address FROM order_info WHERE invoice_no = '$invoice_no' LIMIT 1";
    $orderInfoResult = mysqli_query($conn, $orderInfoQuery);
    $orderInfo = mysqli_fetch_assoc($orderInfoResult);

    // ---- FIX HERE: CHECK IF RESULT IS NULL ----
    if (!$orderInfo || empty($orderInfo['city_address'])) {
        return $shipping_cost;  // default 0 if data missing
    }

    // Match city address
    if ($orderInfo['city_address'] === 'Inside Dhaka') {
        $shipping_cost = $inside_delivery_charge;
    } 
    else if ($orderInfo['city_address'] === 'Outside Dhaka') {
        $shipping_cost = $outside_delivery_charge;
    }

    return $shipping_cost;
}

?>