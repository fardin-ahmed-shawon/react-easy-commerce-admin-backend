<?php
$site_link = "";
$servername = "localhost";

//--------------------------------------------------------------------

// For local development ---------------------------------------------

$username = "root";
$password = "";
$database_name = "easy_commerce_v9.3";

// For production -----------------------------------------------------

// $username = "easytechx";
// $password = "_^Mlr+NnZ=ga";
// $database_name = "easytechx_easy_commerce";

//---------------------------------------------------------------------

// Create connection
$conn = mysqli_connect($servername, $username, $password, $database_name);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

?>