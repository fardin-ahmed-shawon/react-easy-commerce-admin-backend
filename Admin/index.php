<?php
$current_page = basename($_SERVER['PHP_SELF']); // Get the current page name
$page_title = 'Dashboard'; // Set the page title
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
                </span> Dashboard
              </h3>
            </div>

            <!-- Dashboard Stats Area -->
            <div class="row">

              <!-- Total Products -->
              <div class="col-md-3 stretch-card grid-margin">
                <div class="card bg-gradient-danger card-img-holder text-white">
                  <div class="card-body">
                    <img src="assets/images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image" />
                    <h4 class="font-weight-normal mb-3">Total Products <i class="mdi mdi-apps mdi-24px float-end"></i>
                    </h4>
                    <h1 class="mb-5">
                      <?php
                      // Fetch total products from product_info table
                      $sql = "SELECT COUNT(product_id) AS total_products FROM product_info";
                      $result = $conn->query($sql);
                      $row = $result->fetch_assoc();
                      echo $row['total_products'];
                      ?>
                    </h1>
                  </div>
                </div>
              </div>

              <!-- Total Categories -->
              <div class="col-md-3 stretch-card grid-margin">
                <div class="card bg-gradient-info card-img-holder text-white">
                  <div class="card-body">
                    <img src="assets/images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image" />
                    <h4 class="font-weight-normal mb-3">Product Categories <i class="mdi mdi mdi-order-bool-ascending mdi-24px float-end mdi-24px float-end"></i>
                    </h4>
                    <h1 class="mb-5">
                      <?php
                      // Fetch total categories from category_info table
                      $sql = "SELECT COUNT(main_ctg_id) AS total_categories FROM main_category";
                      $result = $conn->query($sql);
                      $row = $result->fetch_assoc();
                      echo $row['total_categories'];
                      ?>
                    </h1>
                  </div>
                </div>
              </div>

              
              <?php
              if (isset($access['inventory']) && $access['inventory'] == 1) {
                ?>

              <!-- Total Stock -->
              <div class="col-md-3 stretch-card grid-margin">
                <div class="card bg-gradient-success card-img-holder text-white">
                  <div class="card-body">
                    <img src="assets/images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image" />
                    <h4 class="font-weight-normal mb-3">Total Stock Unit <i class="mdi mdi-archive-clock-outline mdi-24px float-end"></i>
                    </h4>
                    <h1 class="mb-5">
                      <?php
                      // Fetch total categories from category_info table
                      $sql = "SELECT SUM(available_stock) AS total FROM product_info";
                      $result = $conn->query($sql);
                      $row = $result->fetch_assoc();
                      echo $row['total'];
                      ?>
                    </h1>
                  </div>
                </div>
              </div>

                <?php
              }
              ?>
              

              <?php
              if (isset($access['customers']) && $access['customers'] == 1) {
                ?>

              <!-- Total Customer -->
              <div class="col-md-3 stretch-card grid-margin">
                <div class="card bg-gradient-primary card-img-holder text-white">
                  <div class="card-body">
                    <img src="assets/images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image" />
                    <h4 class="font-weight-normal mb-3">Customers 
                      <i class="mdi mdi-account mdi-24px float-end"></i>
                    </h4>
                    <h1 class="mb-5">
                      <?php
                      // Fetch total customers from user_info table
                      $sql = "SELECT COUNT(user_id) AS total_customers FROM user_info";
                      $result = $conn->query($sql);
                      $row = $result->fetch_assoc();
                      echo $row['total_customers'];
                      ?>
                    </h1>
                  </div>
                </div>
              </div>

                <?php
              }
              ?>


              <?php
                if (isset($access['orders']) && $access['orders'] == 1) {
                  ?>

              <!-- Total Purchased Unit -->
              <div class="col-md-3 stretch-card grid-margin">
                <div class="card bg-gradient-primary card-img-holder text-white">
                  <div class="card-body">
                    <img src="assets/images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image" />
                    <h4 class="font-weight-normal mb-3">Total Purchased Unit <i class="mdi mdi-cart-variant mdi-24px float-end"></i>
                    </h4>
                    <h1 class="mb-5">
                      <?php
                      // Fetch total categories from category_info table
                      $sql = "SELECT SUM(product_quantity) AS total FROM order_info";
                      $result = $conn->query($sql);
                      $row = $result->fetch_assoc();
                      echo $row['total'] ?? '0';
                      ?>
                    </h1>
                  </div>
                </div>
              </div>

                  <?php
                }
              ?>
              
              <?php
              if (isset($access['accounts']) && $access['accounts'] == 1) {
                ?>
                  <!-- Total Collections -->
                  <div class="col-md-3 stretch-card grid-margin">
                    <div class="card bg-gradient-success card-img-holder text-white">
                      <div class="card-body">
                        <img src="assets/images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image" />
                        <h4 class="font-weight-normal mb-3">Total Sales <i class="mdi mdi-cash-check mdi-24px float-end"></i>
                        </h4>
                        <h1 class="mb-5">
                          <?php
                          // Fetch total categories from category_info table
                          $sql = "SELECT SUM(total_price) AS total_collection FROM order_info WHERE order_status = 'Completed'";

                          $result = $conn->query($sql);
                          $row = $result->fetch_assoc();

                          echo "৳".number_format($row['total_collection']);
                          
                          ?>
                        </h1>
                      </div>
                    </div>
                  </div>

                <?php
              }
              ?>

              <?php
                if (isset($access['orders']) && $access['orders'] == 1) {
                  ?>

              <!-- Total Pending Orders -->
              <div class="col-md-3 stretch-card grid-margin">
                <div class="card bg-gradient-info card-img-holder text-white">
                  <div class="card-body">
                    <img src="assets/images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image" />
                    <h4 class="font-weight-normal mb-3">Pending Orders <i class="mdi mdi-cart-arrow-down mdi-24px float-end"></i>
                    </h4>
                    <h1 class="mb-5">
                      <?php
                      // Fetch total pending orders from order_info table
                      $sql = "SELECT COUNT(order_no) AS total_orders FROM order_info WHERE order_visibility='Show' AND order_status='Pending'";
                      $result = $conn->query($sql);
                      $row = $result->fetch_assoc();
                      echo $row['total_orders'];
                      ?>
                    </h1>
                  </div>
                </div>
              </div>

              <!-- Total Approved Orders -->
              <div class="col-md-3 stretch-card grid-margin">
                <div class="card bg-gradient-danger card-img-holder text-white">
                  <div class="card-body">
                    <img src="assets/images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image" />
                    <h4 class="font-weight-normal mb-3">Approved Orders <i class="mdi  mdi-cart-arrow-up mdi-24px float-end"></i>
                    </h4>
                    <h1 class="mb-5">
                      <?php
                      // Fetch total active orders from order_info table
                      $sql = "SELECT COUNT(order_no) AS total_orders FROM order_info WHERE order_visibility='Show' AND order_status !='Pending'";
                      $result = $conn->query($sql);
                      $row = $result->fetch_assoc();
                      echo $row['total_orders'];
                      ?>
                    </h1>
                  </div>
                </div>
              </div>

              <!-- Total Processing Orders -->
              <div class="col-md-3 stretch-card grid-margin">
                <div class="card bg-gradient-info card-img-holder text-white">
                  <div class="card-body">
                    <img src="assets/images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image" />
                    <h4 class="font-weight-normal mb-3">Processing Orders <i class="mdi mdi-cart-outline mdi-24px float-end"></i>
                    </h4>
                    <h1 class="mb-5">
                      <?php
                      // Fetch total active orders from order_info table
                      $sql = "SELECT COUNT(order_no) AS total_orders FROM order_info WHERE order_visibility='Show' AND order_status ='Processing'";
                      $result = $conn->query($sql);
                      $row = $result->fetch_assoc();
                      echo $row['total_orders'];
                      ?>
                    </h1>
                  </div>
                </div>
              </div>

              <!-- Total Shipped Orders -->
              <div class="col-md-3 stretch-card grid-margin">
                <div class="card bg-gradient-danger card-img-holder text-white">
                  <div class="card-body">
                    <img src="assets/images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image" />
                    <h4 class="font-weight-normal mb-3">On The Way Orders <i class="mdi mdi-cart-arrow-right mdi-24px float-end"></i>
                    </h4>
                    <h1 class="mb-5">
                      <?php
                      // Fetch total active orders from order_info table
                      $sql = "SELECT COUNT(order_no) AS total_orders FROM order_info WHERE order_visibility='Show' AND order_status = 'Shipped'";
                      $result = $conn->query($sql);
                      $row = $result->fetch_assoc();
                      echo $row['total_orders'];
                      ?>
                    </h1>
                  </div>
                </div>
              </div>

              <!-- Total Completed Orders -->
              <div class="col-md-3 stretch-card grid-margin">
                <div class="card bg-gradient-success card-img-holder text-white">
                  <div class="card-body">
                    <img src="assets/images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image" />
                    <h4 class="font-weight-normal mb-3">Delivered Orders <i class="mdi mdi-cart-check mdi-24px float-end"></i>
                    </h4>
                    <h1 class="mb-5">
                      <?php
                      // Fetch total completed orders from order_info table
                      $sql = "SELECT COUNT(order_no) AS total_orders FROM order_info WHERE order_status ='Completed'";
                      $result = $conn->query($sql);
                      $row = $result->fetch_assoc();
                      echo $row['total_orders'];
                      ?>
                    </h1>
                  </div>
                </div>
              </div>

              <!-- Total Cancelled Orders -->
              <div class="col-md-3 stretch-card grid-margin">
                <div class="card bg-gradient-dark card-img-holder text-white">
                  <div class="card-body">
                    <img src="assets/images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image" />
                    <h4 class="font-weight-normal mb-3">Cancelled Orders <i class="mdi mdi-cart-remove mdi-24px float-end"></i>
                    </h4>
                    <h1 class="mb-5">
                      <?php
                      // Fetch total Cancelled orders from order_info table
                      $sql = "SELECT COUNT(order_no) AS total_orders FROM order_info WHERE order_status ='Canceled'";
                      $result = $conn->query($sql);
                      $row = $result->fetch_assoc();
                      echo $row['total_orders'];
                      ?>
                    </h1>
                  </div>
                </div>
              </div>

                  <?php
                }
              ?>
              

            </div><br>
            <!-- End -->

            <!-- Charts Area -->
            <!-- <div class="container row">
              <div class="col-md-6">
                <canvas id="myChart"></canvas>
              </div>
            </div><br> -->
            <!-- End -->


            <!-- Latest Pending Orders & Latest Parcel Area -->
            <div class="row">
            <?php 
              // admin & autherized user can access this area
              if ($_SESSION['role'] == 'Admin' || (isset($access['orders']) && $access['orders'] == 1)) {
                ?>
                    <div class="col-md-8">
                      <!-- Latest pending orders Card -->
                      <div class="card p-3">
                        <div class="card-body">
                          <h1 class="py-3 mb-0">Pending Orders</h1>
                          <p>
                            List of latest pending orders
                          </p><br>
                          <div class="table-responsive">
                            <table class="table table-bordered">
                                <tr>
                                  <th>Order No</th>
                                  <th>Customer Phone</th>
                                  <th>Invoice No</th>
                                  <th>Total</th>
                                  <th>Order Date</th>
                                  <th colspan="3">Action</th>
                                </tr>
                              <tbody>
                                <?php
                                // Fetch data from order_info table
                                $sql = "SELECT * FROM order_info WHERE order_status = 'Pending' AND order_visibility = 'Show' ORDER BY order_no DESC LIMIT 10";
                                $result = $conn->query($sql);

                                if ($result->num_rows > 0) {
                                    while($row = $result->fetch_assoc()) {

                                        echo "<tr>
                                            <td>{$row['order_no']}</td>
                                            <td>{$row['user_phone']}</td>

                                            <td>{$row['invoice_no']}</td>

                                            <td>{$row['total_price']} Tk</td>
                                            <td>" . date('Y-m-d', strtotime($row['order_date'])) . "</td>
                                            
                                            <td>
                                                <button class='btn btn-secondary' onclick=\"checkFraud('{$row['user_phone']}')\">Check Fraud</button>
                                            </td>


                                            <td>
                                                <form method='post' action=''>
                                                    <input type='hidden' name='order_no' value='{$row['order_no']}'>
                                                    <button type='submit' name='accept_order' class='btn btn-dark'>Accept</button>
                                                </form>
                                            </td>
                                            <td>
                                                <a href='removeOrder.php?o_n={$row['order_no']}'>
                                                
                                        <button class='btn btn-danger' onclick='return checkDelete(event)'>Declined</button>
                                                </a>
                                            </td>
                                        </tr>";
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

            <?php 
              if ($_SESSION['role'] == 'Admin' || (isset($access['courier']) && $access['courier'] == 1)) {
                ?>
                    <div class="col-md-4 mt-4 mt-md-0">
                      <!-- Latest parcel Card -->
                      <div class="card p-3">
                        <div class="card-body">
                          <h1 class="py-3 mb-0">Latest Parcel</h1>
                          <p>
                            List of latest parcels
                          </p><br>
                          <div class="table-responsive">
                            <table class="table table-bordered">
                                <tr>
                                  <th>Invoice No</th>
                                  <th>Status</th>
                                </tr>
                              <tbody>
                                <?php
                                // Fetch data from parcel_info table
                                $sql = "SELECT parcel_info.* 
                                      FROM parcel_info
                                      JOIN order_info ON parcel_info.invoice_no = order_info.invoice_no
                                      WHERE order_info.order_status != 'Pending' 
                                        AND order_info.order_visibility = 'Show'
                                      GROUP BY order_info.invoice_no
                                      ORDER BY parcel_info.parcel_id DESC 
                                      LIMIT 10
                                      ";

                                $result = $conn->query($sql);

                                if ($result->num_rows > 0) {
                                    while($row = $result->fetch_assoc()) {

                                      //$status = track_parcel($row['tracking_code']);
                                      $status = "Not Set";

                                      echo "
                                      <tr>
                                        <td>{$row['invoice_no']}</td>
                                        <td class='text-primary'>{$status}</td>
                                      </tr>";
                                    }
                                }
                                ?>
                              </tbody>
                            </table> 
                          </div> 
                          

                        </div>  
                        <a href="courier.php" class="p-3">
                          <button class="btn btn-dark">See All Parcel</button>
                        </a>     
                      </div>
                    </div>
                  
                <?php
              }
            ?>
            </div>   
            <!-- End -->   

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