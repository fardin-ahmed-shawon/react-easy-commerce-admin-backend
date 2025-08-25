<?php
$current_page = basename($_SERVER['PHP_SELF']); // Get the current page name
$page_title = 'Pending Orders'; // Set the page title
?>
<?php require 'header.php'; ?>

<?php
// Update order status to "Processing" if the Accept button is pressed
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['accept_order'])) {
  // Upddate order_info table
  $order_no = $_POST['order_no'];
  $update_sql = "UPDATE order_info SET order_status='Processing' WHERE order_no=?";
  $stmt = $conn->prepare($update_sql);
  $stmt->bind_param("i", $order_no);
  $stmt->execute();
  $stmt->close();

  // Update payment_info table
  $update_sql = "UPDATE payment_info SET order_status='Processing' WHERE order_no=?";
  $stmt = $conn->prepare($update_sql);
  $stmt->bind_param("i", $order_no);
  $stmt->execute();
  $stmt->close();
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
                </span> Orders
              </h3>
            </div>
            <br>
            <div class="row">
              <h1>Pending Orders</h1>
              <!-- <form class="form-group" action="#">
                <input type="search" name="search" id="search" placeholder="Search Order No" class="form-control">
              </form> -->
              <!-- Table Area -->
              <div style="overflow-y: auto;">
                <table class="table table-under-bordered">
                  <tbody>
                    <tr>
                      <th>Order No</th>
                      <th>User ID</th>
                      <th>Customer Name</th>
                      <th>Customer Phone</th>
                      <th>Address</th>
                      <th>Invoice No</th>
                      <th>Product ID</th>
                      <th>Size</th>
                      <th>Quantity</th>
                      <th>Total</th>
                      <th>Order Date</th>
                      <th>Payment Method</th>
                      <th>Status</th>
                      <th colspan="2">Action</th>
                    </tr>
                    
                    <?php
                    // Fetch data from order_info table
                    $sql = "SELECT * FROM order_info WHERE order_status = 'Pending' AND order_visibility = 'Show' ORDER BY order_no DESC LIMIT 10";
                    $result = $conn->query($sql);

                      if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {

                            echo "<tr>
                                <td>{$row['order_no']}</td>
                                <td>{$row['user_id']}</td>
                                <td>{$row['user_full_name']}</td>
                                <td>{$row['user_phone']}</td>

                                <td>{$row['user_address']}</td>
                                
                                <td>$row[invoice_no]</td>
                                <td>$row[product_id]</td>
                                <td>$row[product_size]</td>
                                <td>$row[product_quantity]</td>
                                <td>$row[total_price] Tk</td>
                                <td>$row[order_date]</td>
                                <td>$row[payment_method]</td>
                                <td class='text-primary'>$row[order_status]</td>
                                <td>
                                  <form method='post' action=''>
                                    <input type='hidden' name='order_no' value='$row[order_no]'>
                                    <button type='submit' name='accept_order' class='btn btn-dark'>Accept</button>
                                  </form>
                                </td>
                                <td>
                                  <a href='removeOrder.php?o_n={$row['order_no']}'>
                                    <button class='btn btn-danger' onclick='return checkDelete(event)'>Declined</button>
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
            <!-- <a href="#">
              <button class="btn btn-dark">Delete All Pending Orders <span class="mdi mdi-delete"></span></button>
            </a> -->
</div>
<!--------------------------->
<!-- END MAIN AREA -->
<!--------------------------->
<script>
      function checkDelete(event) {
        event.preventDefault(); // Prevent the default action of the button
        Swal.fire({
          title: 'Are you sure?',
          text: "You won't be able to revert this!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes, decline it!'
        }).then((result) => {
          if (result.isConfirmed) {
            // Redirect to the removeOrder.php page
            window.location.href = event.target.closest('a').href;
          }
        });
        return false; // Prevent the default form submission
      }
</script>
<?php require 'footer.php'; ?>