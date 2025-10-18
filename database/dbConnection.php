<?php
$servername = "localhost";

//--------------------------------------------------------------------
// For local development ---------------------------------------------
$site_link = "http://localhost/test/easy_tech_solutions/react-easy-commerce-admin-backend/";
$username = "root";
$password = "";
$database_name = "react_easy_commerce_v9_5";

// For production -----------------------------------------------------
// $site_link = "https://arentertainment.com.bd/";
// $username = "arentert";
// $password = "2p2zNQ19h(pF#U";
// $database_name = "arentert_easy_commerce";

//---------------------------------------------------------------------

// Create connection
$conn = mysqli_connect($servername, $username, $password, $database_name);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

?>