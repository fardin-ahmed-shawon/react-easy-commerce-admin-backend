<?php
$current_page = basename($_SERVER['PHP_SELF']); // Get the current page name
$page_title = 'Dashboard'; // Set the page title
?>
<?php require 'header.php'; ?>

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
<style>
  /* Modern Stats Card Styles */
  .stats-card {
    position: relative;
    padding: 24px;
    border-radius: 16px;
    background: #fff;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
    overflow: visible;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    height: 100%;
    border: 1px solid rgba(0, 0, 0, 0.05);
    min-height: 140px;
    display: flex;
    flex-direction: column;
  }

  .stats-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 24px rgba(0, 0, 0, 0.12);
    border-radius: 0 0 16px 16px;
  }

  .stats-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, var(--gradient-start), var(--gradient-end));
    opacity: 0;
    transition: opacity 0.3s ease;
    border-radius: 16px 16px 0 0;
  }

  .stats-card:hover::before {
    opacity: 1;
  }

  .stats-icon {
    position: absolute;
    top: 20px;
    right: 20px;
    width: 56px;
    height: 56px;
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, var(--gradient-start), var(--gradient-end));
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15);
  }

  .stats-icon i {
    font-size: 28px;
    color: #fff;
  }

  .stats-content {
    position: relative;
    z-index: 1;
    padding-right: 76px;
  }

  .stats-label {
    font-size: 15px;
    font-weight: 600;
    color: #64748b;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 12px;
  }

  .stats-value {
    font-size: 36px;
    font-weight: 700;
    color: #1e293b;
    margin: 0;
    line-height: 1.2;
    margin-bottom: 16px;
  }

  .stats-trend {
    margin-top: auto;
  }

  .trend-icon {
    font-size: 20px;
    color: #10b981;
    font-weight: bold;
  }

  .stats-badge {
    margin-top: auto;
    padding: 6px 14px;
    border-radius: 20px;
    font-size: 11px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    display: inline-block;
    width: fit-content;
  }

  .badge-warning {
    background: #fef3c7;
    color: #92400e;
  }

  .badge-info {
    background: #dbeafe;
    color: #1e40af;
  }

  .badge-success {
    background: #d1fae5;
    color: #065f46;
  }

  .badge-purple {
    background: #e9d5ff;
    color: #6b21a8;
  }

  .badge-dark {
    background: #e2e8f0;
    color: #334155;
  }

  /* Gradient Variants */
  .stats-gradient-danger {
    --gradient-start: #ef4444;
    --gradient-end: #dc2626;
  }

  .stats-gradient-info {
    --gradient-start: #3b82f6;
    --gradient-end: #2563eb;
  }

  .stats-gradient-success {
    --gradient-start: #10b981;
    --gradient-end: #059669;
  }

  .stats-gradient-primary {
    --gradient-start: #8b5cf6;
    --gradient-end: #7c3aed;
  }

  .stats-gradient-warning {
    --gradient-start: #f59e0b;
    --gradient-end: #d97706;
  }

  .stats-gradient-purple {
    --gradient-start: #a855f7;
    --gradient-end: #9333ea;
  }

  .stats-gradient-dark {
    --gradient-start: #64748b;
    --gradient-end: #475569;
  }

  /* Responsive adjustments */
  @media (max-width: 1199px) {
    .stats-value {
      font-size: 28px;
    }
    
    .stats-icon {
      width: 48px;
      height: 48px;
    }
    
    .stats-icon i {
      font-size: 24px;
    }
  }

  @media (max-width: 767px) {
    .stats-card {
      padding: 20px;
    }
    
    .stats-value {
      font-size: 24px;
    }
    
    .stats-icon {
      width: 44px;
      height: 44px;
      top: 16px;
      right: 16px;
    }
    
    .stats-icon i {
      font-size: 20px;
    }
  }
</style>
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
            <div class="row g-4">

              <!-- Total Products -->
              <div class="col-xl-3 col-md-6">
                <div class="stats-card stats-gradient-danger">
                  <div class="stats-icon">
                    <i class="mdi mdi-apps"></i>
                  </div>
                  <div class="stats-content">
                    <h6 class="stats-label">Total Products</h6>
                    <h2 class="stats-value">
                      <?php
                      $sql = "SELECT COUNT(product_id) AS total_products FROM product_info";
                      $result = $conn->query($sql);
                      $row = $result->fetch_assoc();
                      echo $row['total_products'];
                      ?>
                    </h2>
                  </div>
                  <div class="stats-trend">
                    <span class="trend-icon">↗</span>
                  </div>
                </div>
              </div>

              <!-- Product Categories -->
              <div class="col-xl-3 col-md-6">
                <div class="stats-card stats-gradient-info">
                  <div class="stats-icon">
                    <i class="mdi mdi-order-bool-ascending"></i>
                  </div>
                  <div class="stats-content">
                    <h6 class="stats-label">Product Categories</h6>
                    <h2 class="stats-value">
                      <?php
                      $sql = "SELECT COUNT(main_ctg_id) AS total_categories FROM main_category";
                      $result = $conn->query($sql);
                      $row = $result->fetch_assoc();
                      echo $row['total_categories'];
                      ?>
                    </h2>
                  </div>
                  <div class="stats-trend">
                    <span class="trend-icon">→</span>
                  </div>
                </div>
              </div>

              <?php if (isset($access['inventory']) && $access['inventory'] == 1) { ?>
              <!-- Total Stock -->
              <div class="col-xl-3 col-md-6">
                <div class="stats-card stats-gradient-success">
                  <div class="stats-icon">
                    <i class="mdi mdi-archive-clock-outline"></i>
                  </div>
                  <div class="stats-content">
                    <h6 class="stats-label">Total Stock Unit</h6>
                    <h2 class="stats-value">
                      <?php
                      $sql = "SELECT SUM(available_stock) AS total FROM product_info";
                      $result = $conn->query($sql);
                      $row = $result->fetch_assoc();
                      echo number_format($row['total']);
                      ?>
                    </h2>
                  </div>
                  <div class="stats-trend">
                    <span class="trend-icon">↗</span>
                  </div>
                </div>
              </div>
              <?php } ?>

              <?php if (isset($access['customers']) && $access['customers'] == 1) { ?>
              <!-- Total Customers -->
              <div class="col-xl-3 col-md-6">
                <div class="stats-card stats-gradient-primary">
                  <div class="stats-icon">
                    <i class="mdi mdi-account"></i>
                  </div>
                  <div class="stats-content">
                    <h6 class="stats-label">Customers</h6>
                    <h2 class="stats-value">
                      <?php
                      $sql = "SELECT COUNT(user_id) AS total_customers FROM user_info";
                      $result = $conn->query($sql);
                      $row = $result->fetch_assoc();
                      echo number_format($row['total_customers']);
                      ?>
                    </h2>
                  </div>
                  <div class="stats-trend">
                    <span class="trend-icon">↗</span>
                  </div>
                </div>
              </div>
              <?php } ?>

              <?php if (isset($access['orders']) && $access['orders'] == 1) { ?>
              <!-- Total Purchased Unit -->
              <div class="col-xl-3 col-md-6">
                <div class="stats-card stats-gradient-primary">
                  <div class="stats-icon">
                    <i class="mdi mdi-cart-variant"></i>
                  </div>
                  <div class="stats-content">
                    <h6 class="stats-label">Total Purchased Unit</h6>
                    <h2 class="stats-value">
                      <?php
                      $sql = "SELECT SUM(product_quantity) AS total FROM order_info";
                      $result = $conn->query($sql);
                      $row = $result->fetch_assoc();
                      echo number_format($row['total'] ?? 0);
                      ?>
                    </h2>
                  </div>
                  <div class="stats-trend">
                    <span class="trend-icon">↗</span>
                  </div>
                </div>
              </div>
              <?php } ?>

              <?php if (isset($access['accounts']) && $access['accounts'] == 1) { ?>
              <!-- Total Sales -->
              <div class="col-xl-3 col-md-6">
                <div class="stats-card stats-gradient-success">
                  <div class="stats-icon">
                    <i class="mdi mdi-cash-check"></i>
                  </div>
                  <div class="stats-content">
                    <h6 class="stats-label">Total Sales</h6>
                    <h2 class="stats-value">
                      <?php
                      $sql = "SELECT SUM(total_price) AS total_collection FROM order_info WHERE order_status = 'Completed'";
                      $result = $conn->query($sql);
                      $row = $result->fetch_assoc();
                      echo "৳ " . number_format($row['total_collection']);
                      ?>
                    </h2>
                  </div>
                  <div class="stats-trend">
                    <span class="trend-icon">↗</span>
                  </div>
                </div>
              </div>
              <?php } ?>

              <?php if (isset($access['orders']) && $access['orders'] == 1) { ?>
              <!-- Pending Orders -->
              <div class="col-xl-3 col-md-6">
                <div class="stats-card stats-gradient-warning">
                  <div class="stats-icon">
                    <i class="mdi mdi-cart-arrow-down"></i>
                  </div>
                  <div class="stats-content">
                    <h6 class="stats-label">Pending Orders</h6>
                    <h2 class="stats-value">
                      <?php
                      $sql = "SELECT COUNT(order_no) AS total_orders FROM order_info WHERE order_visibility='Show' AND order_status='Pending'";
                      $result = $conn->query($sql);
                      $row = $result->fetch_assoc();
                      echo $row['total_orders'];
                      ?>
                    </h2>
                  </div>
                  <div class="stats-badge badge-warning">Action Required</div>
                </div>
              </div>

              <!-- Approved Orders -->
              <div class="col-xl-3 col-md-6">
                <div class="stats-card stats-gradient-info">
                  <div class="stats-icon">
                    <i class="mdi mdi-cart-arrow-up"></i>
                  </div>
                  <div class="stats-content">
                    <h6 class="stats-label">Approved Orders</h6>
                    <h2 class="stats-value">
                      <?php
                      $sql = "SELECT COUNT(order_no) AS total_orders FROM order_info WHERE order_visibility='Show' AND order_status !='Pending'";
                      $result = $conn->query($sql);
                      $row = $result->fetch_assoc();
                      echo $row['total_orders'];
                      ?>
                    </h2>
                  </div>
                  <div class="stats-trend">
                    <span class="trend-icon">↗</span>
                  </div>
                </div>
              </div>

              <!-- Processing Orders -->
              <div class="col-xl-3 col-md-6">
                <div class="stats-card stats-gradient-info">
                  <div class="stats-icon">
                    <i class="mdi mdi-cart-outline"></i>
                  </div>
                  <div class="stats-content">
                    <h6 class="stats-label">Processing Orders</h6>
                    <h2 class="stats-value">
                      <?php
                      $sql = "SELECT COUNT(order_no) AS total_orders FROM order_info WHERE order_visibility='Show' AND order_status ='Processing'";
                      $result = $conn->query($sql);
                      $row = $result->fetch_assoc();
                      echo $row['total_orders'];
                      ?>
                    </h2>
                  </div>
                  <div class="stats-badge badge-info">In Progress</div>
                </div>
              </div>

              <!-- Shipped Orders -->
              <div class="col-xl-3 col-md-6">
                <div class="stats-card stats-gradient-purple">
                  <div class="stats-icon">
                    <i class="mdi mdi-cart-arrow-right"></i>
                  </div>
                  <div class="stats-content">
                    <h6 class="stats-label">On The Way</h6>
                    <h2 class="stats-value">
                      <?php
                      $sql = "SELECT COUNT(order_no) AS total_orders FROM order_info WHERE order_visibility='Show' AND order_status = 'Shipped'";
                      $result = $conn->query($sql);
                      $row = $result->fetch_assoc();
                      echo $row['total_orders'];
                      ?>
                    </h2>
                  </div>
                  <div class="stats-badge badge-purple">Shipping</div>
                </div>
              </div>

              <!-- Delivered Orders -->
              <div class="col-xl-3 col-md-6">
                <div class="stats-card stats-gradient-success">
                  <div class="stats-icon">
                    <i class="mdi mdi-cart-check"></i>
                  </div>
                  <div class="stats-content">
                    <h6 class="stats-label">Delivered Orders</h6>
                    <h2 class="stats-value">
                      <?php
                      $sql = "SELECT COUNT(order_no) AS total_orders FROM order_info WHERE order_status ='Completed'";
                      $result = $conn->query($sql);
                      $row = $result->fetch_assoc();
                      echo $row['total_orders'];
                      ?>
                    </h2>
                  </div>
                  <div class="stats-badge badge-success">Completed</div>
                </div>
              </div>

              <!-- Cancelled Orders -->
              <div class="col-xl-3 col-md-6">
                <div class="stats-card stats-gradient-dark">
                  <div class="stats-icon">
                    <i class="mdi mdi-cart-remove"></i>
                  </div>
                  <div class="stats-content">
                    <h6 class="stats-label">Cancelled Orders</h6>
                    <h2 class="stats-value">
                      <?php
                      $sql = "SELECT COUNT(order_no) AS total_orders FROM order_info WHERE order_status ='Canceled'";
                      $result = $conn->query($sql);
                      $row = $result->fetch_assoc();
                      echo $row['total_orders'];
                      ?>
                    </h2>
                  </div>
                  <div class="stats-badge badge-dark">Void</div>
                </div>
              </div>
              <?php } ?>

            </div>
            <br>
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
                            <p>List of latest pending orders</p><br>
                            <div class="table-responsive">
                              <table class="table table-bordered">
                                <thead>
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
                                </thead>
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
                                      while($row = $result->fetch_assoc()) {
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

                                      $status = track_parcel($row['tracking_code']);
     

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
        <h5 class="modal-title fw-bold">ðŸ“Š Fraud Checker</h5>
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
            <thead class="table-dark">
              <tr>
                <th>Courier</th>
                <th>Total</th>
                <th class="text-success">Success</th>
                <th class="text-danger">Cancel</th>
              </tr>
            </thead>
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