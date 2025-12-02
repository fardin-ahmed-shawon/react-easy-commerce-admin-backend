<?php
  // Update order status to "Processing" if Accept button is pressed
  if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['accept_invoice'])) {
    $invoice_no = $_POST['invoice_no'];

    // Update order_info table
    $update_sql = "UPDATE order_info SET order_status='Processing' WHERE invoice_no=?";
    $stmt = $conn->prepare($update_sql);
    $stmt->bind_param("s", $invoice_no);
    $stmt->execute();
    $stmt->close();

    // Update payment_info table
    $update_sql = "UPDATE payment_info SET order_status='Processing' WHERE invoice_no=?";
    $stmt = $conn->prepare($update_sql);
    $stmt->bind_param("s", $invoice_no);
    $stmt->execute();
    $stmt->close();
  }
?>

<?php
// admin & autherized user can access this area
if ($_SESSION['role'] == 'Admin' || (isset($access['orders']) && $access['orders'] == 1)) {
?>
  <div class="col-lg-8">
    <!-- Latest pending orders Card -->
    <div class="card p-3">
      <div class="card-body">
        <h1 class="chart-title mb-1">Pending Orders</h1>
        <p>List of latest pending orders</p><br>
        <div class="table-responsive">
          <table class="table table-bordered">
            <tr>
              <th>SL</th>
              <th>Order No(s)</th>
              <th>Customer Phone</th>
              <th>Invoice No</th>
              <th>Products</th>
              <th>Total</th>
              <th>Order Date</th>
              <th colspan="2">Action</th>
            </tr>
            <tbody>
              <?php
              // Fetch grouped pending orders
              $sql = "SELECT 
                                            invoice_no,
                                            GROUP_CONCAT(order_no ORDER BY order_no) AS order_nos,
                                            GROUP_CONCAT(product_title SEPARATOR '<br>') AS products,
                                            SUM(total_price) AS total_price,
                                            user_phone,
                                            MIN(order_date) AS order_date
                                          FROM order_info
                                          WHERE order_status = 'Pending' 
                                            AND order_visibility = 'Show'
                                          GROUP BY invoice_no, user_phone
                                          ORDER BY MIN(order_no) DESC
                                          LIMIT 10";

              $result = $conn->query($sql);
              $sl = 1;

              if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                  echo "<tr>
                                                  <td>{$sl}</td>
                                                  <td>{$row['order_nos']}</td>
                                                  <td>{$row['user_phone']}</td>
                                                  <td>{$row['invoice_no']}</td>
                                                  <td>{$row['products']}</td>
                                                  <td>{$row['total_price']} Tk</td>
                                                  <td>" . date('Y-m-d', strtotime($row['order_date'])) . "</td>
                                                  <td>
                                                      <form method='post' action=''>
                                                        <input type='hidden' name='invoice_no' value='{$row['invoice_no']}'>
                                                        <button type='submit' name='accept_invoice' class='btn btn-dark'>Accept</button>
                                                      </form>
                                                    </td>
                                                  <td>
                                                    <a href='removeOrder.php?invoice_no={$row['invoice_no']}'>
                            <button class='btn btn-danger' onclick='return checkDelete(event)'>Declined</button>
                          </a>
                                                  </td>
                                                </tr>";
                  $sl++;
                }
              }
              ?>
            </tbody>
          </table>
        </div>
      </div>
      <a href="pendingOrders.php" class="p-3">
        <button class="btn btn-dark">See All Pending Orders</button>
      </a>
    </div>
  </div>
<?php
}
?>

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