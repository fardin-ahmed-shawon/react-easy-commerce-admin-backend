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
//////////////////////////// Handle the 'get_customized_categories' action ///////////////////////////
////////////////////////////////////////////////////////////////////////////////////
if ($action == 'get-customized-categories') {

    // Fetch all main categories
    $sql = "SELECT * FROM customized_category";
    $result = mysqli_query($conn, $sql);

    $categories = [];

    while ($main = mysqli_fetch_assoc($result)) {

        $categories[] = [
            "id" => $main['id'],
            "title" => $main['category_name'],
            "slug" => $main['category_slug']
        ];
    }

    echo json_encode($categories);
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