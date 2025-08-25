<?php
header('Content-Type: application/json');
header('Cache-Control: no-cache, no-store, must-revalidate'); // Prevent caching
header('Pragma: no-cache'); // HTTP 1.0
header('Expires: 0'); // Proxies

// Include database connection file
require_once './database/dbConnection.php';

// Include functions file
include 'functions.php';

?>