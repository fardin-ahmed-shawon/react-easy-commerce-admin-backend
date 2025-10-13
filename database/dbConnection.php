<?php
$servername = "localhost";

//--------------------------------------------------------------------
// For local development ---------------------------------------------
$site_link = "http://localhost/test/easy_tech_solutions/react-easy-commerce-admin-backend/";
$username = "root";
$password = "";
$database_name = "react_easy_commerce_v9_5";

// For production -----------------------------------------------------
// $site_link = "https://react-easy-commere.easytechsolutions.xyz/";
// $username = "easytec3";
// $password = "T9y9*5uO2kwU#G";
// $database_name = "easytec3_easy_commerce_react";

//---------------------------------------------------------------------

// Create connection
$conn = mysqli_connect($servername, $username, $password, $database_name);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

?>