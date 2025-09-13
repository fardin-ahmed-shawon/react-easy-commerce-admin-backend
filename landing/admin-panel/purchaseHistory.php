<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

// Database connection
include('../dbConnection.php');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch order history
$searchQuery = "";
if (isset($_GET['search']) && !empty($_GET['search'])) {
    $searchQuery = $conn->real_escape_string($_GET['search']);
    $sql = "SELECT * FROM order_info WHERE order_no LIKE '%$searchQuery%' ORDER BY order_date DESC";
} else {
    $sql = "SELECT * FROM order_info ORDER BY order_date DESC";
}

$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Admin</title>

    <!-- plugins:css -->
    <link rel="stylesheet" href="assets/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="assets/vendors/ti-icons/css/themify-icons.css">
    <!-- Layout styles -->
    <link rel="stylesheet" href="assets/css/style.css">
    <!-- End layout styles -->
    <link rel="shortcut icon" href="assets/images/favicon.png" />

    <!-- Custom CSS-->
    <link rel="stylesheet" href="css/style.css">

  </head>
  <body>
    <div class="container-scroller">
      <!-- partial:partials/_navbar.php -->
      <?php include('navbar.php'); ?>
      <!-- partial -->
      <div class="container-fluid page-body-wrapper">
        
        <!-- partial:partials/_sidebar.php -->
        <?php include('sidebar.php'); ?>
        <div class="main-panel">


          <!--------------------------->
          <!-- START PURCHASE HISTORY AREA -->
          <!--------------------------->
          <div class="content-wrapper">
            <div class="page-header">
              <h3 class="page-title">
                <span class="page-title-icon bg-gradient-primary text-white me-2">
                  <i class="mdi mdi-home"></i>
                </span> Purchase History
              </h3>
            </div>
            <br>
            <div class="row">
              <h1>Purchase History</h1>
              <!-- <form class="form-group" action="#">
                <input type="search" name="search" id="search" placeholder="Search Order No" class="form-control">
              </form> -->
              <div style="overflow-y: auto;">
                <table class="table table-under-bordered">
                  <tbody>
                    <tr>
                      <th>Order No</th>
                      <th>Customer Phone</th>
                      <th>Shipping Address</th>
                      <th>Invoice No</th>
                      <th>Product ID</th>
                      <th>Quantity</th>
                      <th>Total</th>
                      <th>Order Date</th>
                      <th>Payment Method</th>
                      <th>Order Status</th>
                      <!-- <th>Action</th> -->
                    </tr>
                                    <?php
                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {
                                            echo "<tr>
                                                <td>{$row['order_no']}</td>
                                                <td>{$row['user_phone']}</td>
                                                <td>{$row['user_address']}</td>
                                                <td>{$row['invoice_no']}</td>
                                                <td>{$row['product_id']}</td>
                                                <td>{$row['product_quantity']}</td>
                                                <td>{$row['total_price']} Tk</td>
                                                <td>{$row['order_date']}</td>
                                                <td>{$row['payment_method']}</td>
                                                <td class='order-status'>{$row['order_status']}</td>
                                                <!--
                                                <td><button class='btn btn-danger'>Delete</button></td>
                                                -->
                                            </tr>";
                                        }
                                    } else {
                                        echo "<tr><td colspan='12'>No orders found</td></tr>";
                                    }
                                    ?>
                </tbody>
               </table>
              </div>
            </div>
            <br>
              <!-- <a href="#">
                <button class="btn btn-dark">Delete All History <span class="mdi mdi-delete"></span></button>
              </a> -->
          </div>
          <!--------------------------->
          <!-- END PURCHASE HISTORY AREA -->
          <!--------------------------->


          <!-- partial:partials/_footer.php -->
          <?php include('footer.php'); ?>
        </div>
      </div>
      <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->

    <!-- JS FILES  -->
    <!-- plugins:js -->
    <script src="assets/vendors/js/vendor.bundle.base.js"></script>
    <script src="assets/js/off-canvas.js"></script>
    <script src="assets/js/misc.js"></script>
    <script src="js/main.js"></script>

  </body>
</html>