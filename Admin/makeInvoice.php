<?php
$current_page = basename($_SERVER['PHP_SELF']); // Get the current page name
$page_title = 'Make Invoice'; // Set the page title
?>
<?php require 'header.php'; ?>

<?php
// Update order status to "Shipped" if the Mark As Shipped button is pressed
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["mark_shipped"])) {
  $invoice_no = $_POST["invoice_no"];
  $sql_update = "UPDATE order_info SET order_status = 'Shipped' WHERE invoice_no = '$invoice_no'";
  if ($conn->query($sql_update) === TRUE) {
      $msg = "Order status updated successfully";
  } else {
      $msg = "Error updating record: " . $conn->error;
  }
}

// Update order status to "Completed" if the Mark As Completed button is pressed
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["mark_completed"])) {
  $invoice_no = $_POST["invoice_no"];
  $sql_update = "UPDATE order_info SET order_status = 'Completed' WHERE invoice_no = '$invoice_no'";
  if ($conn->query($sql_update) === TRUE) {
      $msg = "Order status updated successfully";
  } else {
      $msg = "Error updating record: " . $conn->error;
  }
}

// Update order status to "Canceled" if the Mark As Canceled button is pressed
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["mark_canceled"])) {
  $invoice_no = $_POST["invoice_no"];
  $sql_update = "UPDATE order_info SET order_status = 'Canceled' WHERE invoice_no = '$invoice_no'";
  if ($conn->query($sql_update) === TRUE) {
      $msg = "Order status updated successfully";
  } else {
      $msg = "Error updating record: " . $conn->error;
  }
}

//------------------- For order_info & payment_info table both -----------------------------

// Update order status to "Shipped" if the Mark As Shipped button is pressed
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["mark_shipped_both"])) {
  $invoice_no = $_POST["invoice_no"];
  $sql_update = "UPDATE order_info, payment_info SET order_info.order_status = 'Shipped', payment_info.order_status = 'Shipped' WHERE order_info.invoice_no = '$invoice_no' AND payment_info.invoice_no = '$invoice_no'";
  if ($conn->query($sql_update) === TRUE) {
      $msg = "Order status updated successfully";
  } else {
      $msg = "Error updating record: " . $conn->error;
  }
}

// Update order status to "Completed" if the Mark As Completed button is pressed
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["mark_completed_both"])) {
  $invoice_no = $_POST["invoice_no"];
  $sql_update = "UPDATE order_info, payment_info SET order_info.order_status = 'Completed', payment_info.order_status = 'Completed' WHERE order_info.invoice_no = '$invoice_no' AND payment_info.invoice_no = '$invoice_no'";
  if ($conn->query($sql_update) === TRUE) {
      $msg = "Order status updated successfully";
  } else {
      $msg = "Error updating record: " . $conn->error;
  }
}

// Update order status to "Canceled" if the Mark As Canceled button is pressed
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["mark_canceled_both"])) {
  $invoice_no = $_POST["invoice_no"];
  $sql_update = "UPDATE order_info, payment_info SET order_info.order_status = 'Canceled', payment_info.order_status = 'Canceled' WHERE order_info.invoice_no = '$invoice_no' AND payment_info.invoice_no = '$invoice_no'";
  if ($conn->query($sql_update) === TRUE) {
      $msg = "Order status updated successfully";
  } else {
      $msg = "Error updating record: " . $conn->error;
  }
}
?>

<!--------------------------->
<!-- START MAIN AREA -->
<!--------------------------->
<div class="content-wrapper">
            <div class="page-header">
              <h3 class="page-title">
                <span class="page-title-icon bg-gradient-primary text-white me-2">
                  <i class="mdi mdi-home"></i>
                </span> Invoice
              </h3>
            </div>
            <div class="text-end">
              <a href="all-invoice.php" class="btn btn-dark">All Invoice</a>
            </div>
            <br><hr><br>
            
<form method="get" action="all-invoice.php" target="_blank">
        
            <div class="row">
              <h1>Cash On Delivery</h1>
              
              <!-- Table Area -->
              <div style="overflow-y: auto;">
        
                <table class="table table-under-bordered">
                  <tbody>
                      <tr>
                        <th>Select</th>
                        <th>Serial No</th>
                        <th>Invoice No</th>
                        <th>Order No</th>
                        <th>Order Status</th>
                        <th>Payment Method</th>
                        <th>Courier</th>
                        <th>Shipped</th>
                        <th>Completed</th>
                        <th>Canceled</th>
                        <th>Invoice</th>
                        <th>Details</th>
                      </tr>

                      <?php
                      // Fetch data from order_info table

                      // Grouping the same Invoice No at Order No Column
                      $sql = "SELECT invoice_no, GROUP_CONCAT(order_no ORDER BY order_no SEPARATOR ', ') as order_no, order_status, order_visibility, payment_method
                      FROM order_info
                      WHERE payment_method = 'Cash On Delivery' AND order_status != 'Pending'
                      GROUP BY invoice_no, order_status, payment_method";

                      $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                          $count = 1;
                          while($row = $result->fetch_assoc()) {
                            if ($row["payment_method"] == "Cash On Delivery" && $row["order_status"] != "Pending" && $row["order_visibility"] == "Show") {


                              // Fetch courier tracking_code & get parcel status
                              $invoice_no = $row['invoice_no'];

                              $sql2 = "SELECT tracking_code FROM parcel_info WHERE invoice_no   = '$invoice_no'";
                              $result2 = $conn->query($sql2);
                              $row2 = $result2->num_rows;

                              if ($row2 > 0) {
                                $data = $result2->fetch_assoc();

                                $is_tracking_code_set = 1;

                              } else {

                                $is_tracking_code_set = 0;
                                
                              }
                              // End

                              echo '<tr>
                                <td><input type="checkbox" name="invoice[]" value="' . $row["invoice_no"] . '"></td>
                                <td>' . $count . '</td>
                                <td>' . $row["invoice_no"] . '</td>
                                <td>' . $row["order_no"] . '</td>
                                <td class="order-status">' . $row["order_status"] . '</td>
                                <td>' . $row["payment_method"] . '</td>

                                ';
                                
                                if ($is_tracking_code_set == 0) {
                                  echo'
                                      <td>
                                        <a href="steadfast_entry.php?invoice_no='. $row["invoice_no"] .'" class="btn btn-primary">
                                          Send to Steadfast <span class="mdi mdi-send"></span>
                                        </a>
                                      </td>';
                                } else {
                                  echo'
                                    <td>
                                      <span class="btn btn-muted">
                                        Consignment Sent <span class="mdi mdi-send-check"></span>
                                      </span>
                                    </td>
                                    ';
                                }

                                echo '

                                <td class="shipped-button">
                                    <form method="post" action="">
                                        <input type="hidden" name="order_no" value="' . $row["order_no"] . '">
                                        <input type="hidden" name="invoice_no" value="' . $row["invoice_no"] . '">
                                        <button type="submit" name="mark_shipped" class="btn btn-success">Mark As Shipped</button>
                                    </form>
                                </td>
                                
                                <td class="completed-button">
                                  <form method="post" action="">
                                        <input type="hidden" name="order_no" value="' . $row["order_no"] . '">
                                        <input type="hidden" name="invoice_no" value="' . $row["invoice_no"] . '">
                                        <button type="submit" name="mark_completed" class="btn btn-success">Mark As Completed</button>
                                  </form>
                                </td>
                                <td class="canceled-button">
                                  <form method="post" action="">
                                        <input type="hidden" name="order_no" value="' . $row["order_no"] . '">
                                        <input type="hidden" name="invoice_no" value="' . $row["invoice_no"] . '">
                                        <button type="submit" name="mark_canceled" class="btn btn-danger">Mark As Canceled</button>
                                  </form>
                                </td>
                                
                                <td class="invoice-button">
                                  <a href="invoice.php?inv='.$row['invoice_no'].'" class="btn btn-dark">See Invoice</a>
                                </td>
                                <td>
                                  <a class="btn btn-info" href="order_details.php?invoice_no='.$row['invoice_no'].'">
                                    View Details <span class="mdi mdi-details"></span>
                                  </a>
                                </td>
                              </tr>';
                              $count++;
                            }
                          }
                        } 
                      ?>
                  </tbody>
               </table>
               
             
              </div>
            </div>
            <br><hr><br>
            <div class="row">
                <h1>Mobile Banking</h1>
                
                <!-- Table Area -->
                <div style="overflow-y: auto;">
                  <table class="table table-under-bordered">
                    <tbody>
                        <tr>
                          <th>Select</th>
                          <th>Serial No</th>
                          <th>Invoice No</th>
                          <th>Order No</th>
                          <th>Order Status</th>
                          <th>Payment Method</th>
                          <th>Courier</th>
                          <th>Shipped</th>
                          <th>Completed</th>
                          <th>Canceled</th>
                          <th>Invoice</th>
                          <th>Details</th>
                        </tr>

                        <?php
                          // Query to retrieve data from payment_info table
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
                                  GROUP BY invoice_no";
                          $result = $conn->query($sql);

                          $count = 1;
                          if ($result->num_rows > 0) {
                              while ($row = $result->fetch_assoc()) {
                                  if ($row["payment_status"] == "Paid") {

                                    // Fetch courier tracking_code & get parcel status
                                    $invoice_no = $row['invoice_no'];

                                    $sql2 = "SELECT tracking_code FROM parcel_info WHERE invoice_no   = '$invoice_no'";
                                    $result2 = $conn->query($sql2);
                                    $row2 = $result2->num_rows;

                                    if ($row2 > 0) {
                                      $data = $result2->fetch_assoc();

                                      $is_tracking_code_set = 1;

                                    } else {

                                      $is_tracking_code_set = 0;
                                      
                                    }
                                    // End


                                      echo "<tr>";
                                      echo '<td><input type="checkbox" name="invoice[]" value="' . $row["invoice_no"] . '"></td>';
                                      echo "<td>" . $count . "</td>";
                                      echo "<td>" . $row["invoice_no"] . "</td>";
                                      echo "<td>" . $row["order_no"] . "</td>";
                                      echo "<td class='order-status'>" . $row["order_status"] . "</td>";
                                      echo "<td>" . $row["payment_method"] . "</td>";

                                      if ($is_tracking_code_set == 0) {
                                        echo'
                                            <td>
                                              <a href="steadfast_entry.php?invoice_no='. $row["invoice_no"] .'" class="btn btn-primary">
                                                Send to Steadfast <span class="mdi mdi-send"></span>
                                              </a>
                                            </td>';
                                      } else {
                                        echo'
                                          <td>
                                            <span class="btn btn-muted">
                                              Consignment Sent <span class="mdi mdi-send-check"></span>
                                            </span>
                                          </td>
                                          ';
                                      }

                                      echo '
                                          <td class="shipped-button">
                                            <form method="post" action="">
                                                <input type="hidden" name="order_no" value="' . $row["order_no"] . '">
                                                <input type="hidden" name="invoice_no" value="' . $row["invoice_no"] . '">
                                                <button type="submit" name="mark_shipped_both" class="btn btn-success">Mark As Shipped</button>
                                            </form>
                                          </td>
                                      
                                          <td class="completed-button">
                                            <form method="post" action="">
                                                  <input type="hidden" name="order_no" value="' . $row["order_no"] . '">
                                                  <input type="hidden" name="invoice_no" value="' . $row["invoice_no"] . '">
                                                  <button type="submit" name="mark_completed_both" class="btn btn-success">Mark As Completed</button>
                                            </form>
                                          </td>
                                          <td class="canceled-button">
                                            <form method="post" action="">
                                                  <input type="hidden" name="order_no" value="' . $row["order_no"] . '">
                                                  <input type="hidden" name="invoice_no" value="' . $row["invoice_no"] . '">
                                                  <button type="submit" name="mark_canceled_both" class="btn btn-danger">Mark As Canceled</button>
                                            </form>
                                          </td>
                                          ';


                                    echo '<td class="invoice-button">
                                      <a href="invoice.php?inv='.$row['invoice_no'].'" class="btn btn-dark">See Invoice</a>
                                      </td>';

                                    echo '<td>
                                            <a class="btn btn-info" href="order_details.php?invoice_no='.$row['invoice_no'].'">
                                            View Details <span class="mdi mdi-details"></span>
                                            </a>
                                          </td>';
                                      echo "</tr>";
                                      $count++;
                                  }
                              }
                          }
                          ?>

                    </tbody>
                 </table>
                </div>
            </div>
            
            <br>
            <div class="mt-3">
            <button type="submit" class="btn btn-dark">
              Download Selected Invoices
            </button>
          </div>
</form>

            
</div>
<!--------------------------->
<!-- END MAIN AREA -->
<!--------------------------->

<?php require 'footer.php'; ?>