<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}
// database connection
include('../dbConnection.php');

// Update payment status to "Paid" if the Mark As Paid button is pressed
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["mark_paid"])) {
  $invoice_no = $_POST["invoice_no"];
  $sql_update = "UPDATE payment_info SET payment_status = 'Paid' WHERE invoice_no = '$invoice_no'";
  if ($conn->query($sql_update) === TRUE) {
      $msg = "Order status updated successfully";
  } else {
      $msg = "Error updating record: " . $conn->error;
  }
}

// Update order status to "Canceled" if the Cancel button is pressed
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['mark_cancel'])) {
  // Upddate order_info table
  $order_no = $_POST['order_no'];
  $update_sql = "UPDATE order_info SET order_status='Canceled' WHERE order_no=?";
  $stmt = $conn->prepare($update_sql);
  $stmt->bind_param("i", $order_no);
  $stmt->execute();
  $stmt->close();

  // Update payment_info table
  $update_sql = "UPDATE payment_info SET order_status='Canceled' WHERE order_no=?";
  $stmt = $conn->prepare($update_sql);
  $stmt->bind_param("i", $order_no);
  $stmt->execute();
  $stmt->close();
  //
  $invoice_no = $_POST["invoice_no"];
  $sql_update = "UPDATE payment_info SET payment_status = 'Not Available' WHERE invoice_no = '$invoice_no'";
  if ($conn->query($sql_update) === TRUE) {
      $msg = "Order status updated successfully";
  } else {
      $msg = "Error updating record: " . $conn->error;
  }
}

?>
<!DOCTYPE html>
<html lang="en">
  <head>
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
          <!-- START VIEW PAYMENTS AREA -->
          <!--------------------------->
          <div class="content-wrapper">
            <div class="page-header">
              <h3 class="page-title">
                <span class="page-title-icon bg-gradient-primary text-white me-2">
                  <i class="mdi mdi-home"></i>
                </span> Payments
              </h3>
            </div>
            <br>
            <div class="row">
              <h1>All Payments</h1>
              <!-- <form class="form-group" action="#">
                <input type="search" name="search" id="search" placeholder="Search Invoice No" class="form-control">
              </form> -->
              <!-- Table Area -->
              <div style="overflow-y: auto;">
                <table class="table table-under-bordered">
                  <tbody>
                      <tr>
                        <th>Serial No</th>
                        <th>Invoice No</th>
                        <th>Order No</th>
                        <th>Order Status</th>
                        <th>Payment Method</th>
                        <th>Account Number</th>
                        <th>Transaction ID</th>
                        <th>Payment Date</th>
                        <th>Payment Status</th>
                        <th>Action</th>
                        <!-- <th colspan="2">Action</th> -->
                      </tr>

                      <?php
                        $sql = "SELECT invoice_no, 
                                GROUP_CONCAT(CASE 
                                            WHEN order_status != 'Pending' AND order_visibility = 'Show' 
                                            THEN order_no 
                                            END SEPARATOR ', ') as order_no, 
                                serial_no, 
                                order_status, 
                                order_visibility,
                                payment_method, 
                                acc_number, 
                                transaction_id, 
                                payment_date, 
                                payment_status 
                                FROM payment_info 
                                WHERE order_visibility = 'Show'
                                GROUP BY invoice_no
                                ORDER BY serial_no DESC";

                                
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            while($row = $result->fetch_assoc()) {
                                if ($row["order_status"] != "Pending") {
                                    echo "<tr>";
                                    echo "<td>" . $row["serial_no"] . "</td>";
                                    echo "<td>" . $row["invoice_no"] . "</td>";
                                    echo "<td>" . $row["order_no"] . "</td>";
                                    echo "<td class='order-status'>" . $row["order_status"] . "</td>";
                                    echo "<td>" . $row["payment_method"] . "</td>";
                                    echo "<td>" . $row["acc_number"] . "</td>";
                                    echo "<td>" . $row["transaction_id"] . "</td>";
                                    echo "<td>" . $row["payment_date"] . "</td>";
                                    echo "<td class='payment-status'>" . $row["payment_status"] . "</td>";
                                    echo '<td class="paid-btn">
                                            <form method="post" action="">
                                              <input type="hidden" name="order_no" value="' . $row["order_no"] . '">
                                              <input type="hidden" name="invoice_no" value="' . $row["invoice_no"] . '">
                                              <button type="submit" name="mark_paid" class="btn btn-dark">Mark As Paid</button>
                                            </form>
                                          </td>';

                                    // echo '<td class="cancel-btn">
                                    //         <form method="post" action="">
                                    //           <input type="hidden" name="order_no" value="' . $row["order_no"] . '">
                                    //           <input type="hidden" name="invoice_no" value="' . $row["invoice_no"] . '">
                                    //           <button type="submit" name="mark_cancel" class="btn btn-danger">Cancel</button>
                                    //         </form>
                                    //     </td>';

                                    echo "</tr>";
                                }
                            }
                        }
                        ?>

                  </tbody>
               </table>
              </div>
            </div>
          </div>
          <!--------------------------->
          <!-- END VIEW PAYMENTS AREA -->
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