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
//////////////////////////// Handle the 'get-customized-products' action ///////////////////////////
////////////////////////////////////////////////////////////////////////////////////
if ($action == 'get-customized-products') {

    $sql = "SELECT 
                p.*, 
                c.category_name, 
                c.category_slug
            FROM 
                customized_products p
            JOIN 
                customized_category c ON p.category_id = c.id
            ORDER BY p.id DESC";

    $result = mysqli_query($conn, $sql);

    $response = array();

    while ($row = mysqli_fetch_assoc($result)) {

        $response[] = array(
            "id" => $row['id'],

            // Image with base URL check
            "img" => $row['product_img'] ? $site_link . 'Admin/' . $row['product_img'] : "",

            "title" => $row['product_title'],

            "category" => $row['category_name'],

            "category_slug" => $row['category_slug'],

            "advance_amount" => $row['advance_amount'],

            "product_code" => $row['product_code'],

            "description" => $row['product_description'],

            "product_slug" => $row['product_slug'],

            "link" => '/customized-product/' . $row['product_slug'],

            "created_at" => $row['created_at']
        );
    }

    echo json_encode($response);
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