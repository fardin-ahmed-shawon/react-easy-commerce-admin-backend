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
                      <th colspan="3">Action</th>
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
                                                <button class='btn btn-secondary' onclick=\"checkFraud('{$row['user_phone']}')\">Check Fraud</button>
                                            </td>
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


<!-- Fraud Checker Modal -->
<div class="modal fade" id="fraudModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" style="max-width: 500px;">
    <div class="modal-content shadow-lg border-0 rounded-3">
      
      <!-- Header -->
      <div class="modal-header bg-dark text-white ">
        <h5 class="modal-title fw-bold">Fraud Checker</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>

      <!-- Body -->
      <div class="modal-body bg-light">

        <!-- Phone Info -->
        <div class="alert alert-secondary py-2 mb-4">
          <strong>Phone:</strong> <span id="fraudPhone" class="fw-bold text-dark"></span>
        </div>

        <!-- Table -->
        <div class="table-responsive mb-4">
          <table class="table table-bordered align-middle text-center mb-0">
            
            <tbody id="fraudTableBody">
              <!-- Data injected here -->
            </tbody>
          </table>
        </div>

        <!-- Summary Cards -->
        <div class="row g-3">
          <div class="col-12 col-sm-4">
            <div class="card text-center bg-info text-white rounded-3 shadow-sm">
              <div class="card-body p-3">
                <h6 class="mb-1 fw-bold">Total</h6>
                <span class="h5 mb-0" id="fraudTotal">0</span>
              </div>
            </div>
          </div>
          <div class="col-12 col-sm-4">
            <div class="card text-center bg-success text-white rounded-3 shadow-sm">
              <div class="card-body p-3">
                <h6 class="mb-1 fw-bold">Success</h6>
                <span class="h5 mb-0" id="fraudSuccess">0</span>
              </div>
            </div>
          </div>
          <div class="col-12 col-sm-4">
            <div class="card text-center bg-danger text-white rounded-3 shadow-sm">
              <div class="card-body p-3">
                <h6 class="mb-1 fw-bold">Cancel</h6>
                <span class="h5 mb-0" id="fraudCancel">0</span>
              </div>
            </div>
          </div>
        </div>

      </div> <!-- end modal-body -->

    </div>
  </div>
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

<script>
function checkFraud(phone) {
    // Reset modal
    document.getElementById("fraudPhone").textContent = phone;
    document.getElementById("fraudTableBody").innerHTML = "<tr><td colspan='4' class='text-center'>Loading...</td></tr>";
    document.getElementById("fraudTotal").textContent = "Loading...";
    document.getElementById("fraudSuccess").textContent = "Loading...";
    document.getElementById("fraudCancel").textContent = "Loading...";

    // Show modal
    var fraudModal = new bootstrap.Modal(document.getElementById('fraudModal'));
    fraudModal.show();

    // Prepare form data
    const formData = new FormData();
    formData.append('phone', phone);

    fetch('fraud_api.php', {
        method: 'POST',
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        // Handle API errors
        if (data.error) {
            document.getElementById("fraudTableBody").innerHTML = `<tr><td colspan='4' class='text-danger'>${data.error}</td></tr>`;
            document.getElementById("fraudTotal").textContent = "0";
            document.getElementById("fraudSuccess").textContent = "0";
            document.getElementById("fraudCancel").textContent = "0";
            return;
        }

        // Update summary cards
        document.getElementById("fraudTotal").textContent = data.total_parcels ?? 0;
        document.getElementById("fraudSuccess").textContent = data.total_delivered ?? 0;
        document.getElementById("fraudCancel").textContent = data.total_cancel ?? 0;

        // Define fixed courier list
        const couriers = ["Pathao", "Steadfast", "Redx", "PaperFly"];
        let tbody = '';

        // couriers.forEach(courier => {
        //     const c = data.apis[courier] || { total: 0, success: 0, cancel: 0 };
        //     let displayName = courier === "PaperFly" ? "Paperfly" : courier;
        //     tbody += `
        //         <tr>
        //             <td>${displayName}</td>
        //             <td>${c.total ?? 0}</td>
        //             <td>${c.success ?? 0}</td>
        //             <td>${c.cancel ?? 0}</td>
        //         </tr>`;
        // });

        // Update table
        document.getElementById("fraudTableBody").innerHTML = tbody;
    })
    .catch(err => {
        document.getElementById("fraudTableBody").innerHTML = `<tr><td colspan='4' class='text-danger'>Error: ${err}</td></tr>`;
        document.getElementById("fraudTotal").textContent = "0";
        document.getElementById("fraudSuccess").textContent = "0";
        document.getElementById("fraudCancel").textContent = "0";
    });
}
</script>
<?php require 'footer.php'; ?>