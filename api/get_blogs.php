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
//////////////////////////// Handle the 'get-blogs' action ///////////////////////////
////////////////////////////////////////////////////////////////////////////////////
if ($action == 'get-blogs') {

    // Fetch all blogs
    $sql = "SELECT * FROM blogs";
    $result = mysqli_query($conn, $sql);

    $blogs = [];

    while ($blog = mysqli_fetch_assoc($result)) {

        $blogs[] = [
            "id" => $blog['id'],
            "title" => $blog['blog_title'],
            "img" => $site_link . "Admin/uploads/" . $blog['blog_img'],
            "description" => $blog['blog_description'],
            "date" => $blog['created_at']
        ];
    }

    echo json_encode($blogs);
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