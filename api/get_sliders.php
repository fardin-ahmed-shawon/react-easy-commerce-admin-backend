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
//////////////////////////// Handle the 'get-sliders' action ///////////////////////////
////////////////////////////////////////////////////////////////////////////////////
if ($action == 'get-sliders') {

    // Query the sliders table for all records
    $sql = "SELECT * FROM slider";
    $result = mysqli_query($conn, $sql);

    if (!$result) {
        echo json_encode([
            "success" => false,
            "message" => "Database query failed: " . mysqli_error($conn)
        ]);
        exit();
    }

    // Fetch the single record
    $row = mysqli_fetch_assoc($result);
    
    if (!$row) {
        echo json_encode([
            "success" => false,
            "message" => "No sliders found"
        ]);
        exit();
    }

    // Prepare response
    $response = [
        "id" => $row['slider_id'],
        "img" => $site_link. 'api/'. $row['slider_img']
    ];

    echo json_encode([
        "success" => true,
        "data" => $response
    ]);
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