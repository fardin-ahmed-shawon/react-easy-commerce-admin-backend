<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}
// database connection
include('../dbConnection.php');
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
          <!-- START VIEW ORDERS AREA -->
          <!--------------------------->
          <div class="content-wrapper">
            <div class="page-header">
              <h3 class="page-title">
                <span class="page-title-icon bg-gradient-primary text-white me-2">
                  <i class="mdi mdi-home"></i>
                </span> Orders
              </h3>
            </div>
            <br>
            <div class="row">
              <h1>Active Orders</h1>
              <!-- <form class="form-group" action="#">
                <input type="search" name="search" id="search" placeholder="Search Order No" class="form-control">
              </form> -->
              <!-- Table Area -->
              <div style="overflow-y: auto;">
                <table class="table table-under-bordered">
                  <tbody>
                    <tr>
                      <th>Order No</th>
                      <th>Customer Phone</th>
                      <th>Invoice No</th>
                      <th>Product ID</th>
                      <th>Quantity</th>
                      <th>Total</th>
                      <th>Order Date</th>
                      <th>Payment Method</th>
                      <th>Status</th>
                      <th>Action</th>
                    </tr>
                    
                    <?php
                      // Fetch data from order_info table
                      $sql = "SELECT order_no, user_phone, invoice_no, product_id, product_quantity, total_price, payment_method, order_date, order_status, order_visibility FROM order_info WHERE order_status!='Pending' AND order_visibility='Show' ORDER BY order_no DESC";
                      $result = $conn->query($sql);

                      if ($result->num_rows > 0) {
                        echo "";
                        while($row = $result->fetch_assoc()) {
                          //if ($row["order_status"] != 'Pending') {
                            echo "<tr>
                                  <td>$row[order_no]</td>
                                  <td>$row[user_phone]</td>
                                  <td>$row[invoice_no]</td>
                                  <td>$row[product_id]</td>
                                  <td>$row[product_quantity]</td>
                                  <td>$row[total_price] Tk</td>
                                  <td>$row[order_date]</td>
                                  <td>$row[payment_method]</td>
                                  <td class='order-status'>$row[order_status]</td>
                                  <td>
                                    <a href='removeOrder.php? o_n=$row[order_no]'>
                                      <button class='btn btn-danger' onclick='return checkDelete()'>Remove</button>
                                    </a>
                                  </td>
                                </tr>";
                          //}
                        }
                      }
                    ?>

                  </tbody>
               </table>
              </div>
            </div>
            <br>
            <a href="#">
              <button class="btn btn-dark">Delete All Active Orders <span class="mdi mdi-delete"></span></button>
            </a>
          </div>
          <!--------------------------->
          <!-- END VIEW ORDERS AREA -->
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

    <script>
      function checkDelete() {
        return confirm('Are you sure you want to remove this data?');
      }
    </script>


  </body>
</html>