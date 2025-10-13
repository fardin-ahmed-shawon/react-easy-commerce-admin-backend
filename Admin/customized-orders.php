<?php
$current_page = basename($_SERVER['PHP_SELF']); // Get the current page name
$page_title = 'Customized Orders'; // Set the page title
?>
<?php require 'header.php'; ?>
<style>
  /* Modern Stats Card Styles */
  .stats-card {
    position: relative;
    padding: 24px;
    border-radius: 20px;
    background: #fff;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
    overflow: visible;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    height: 100%;
    border: 1px solid rgba(0, 0, 0, 0.05);
    min-height: 140px;
    display: flex;
    flex-direction: column;
  }

  .stats-card:hover {
    transform: translateY(-8px) scale(1.02);
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
    border-radius: 0 0 20px 20px;
  }

  .stats-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 5px;
    background: linear-gradient(90deg, var(--gradient-start), var(--gradient-end));
    opacity: 0;
    transition: opacity 0.3s ease;
    border-radius: 20px 20px 0 0;
  }

  .stats-card:hover::before {
    opacity: 1;
  }

  .stats-icon {
    position: absolute;
    top: 20px;
    right: 20px;
    width: 60px;
    height: 60px;
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, var(--gradient-start), var(--gradient-end));
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
    transition: all 0.3s ease;
  }

  .stats-card:hover .stats-icon {
    transform: rotate(10deg) scale(1.1);
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
    font-size: 14px;
    font-weight: 600;
    color: #64748b;
    text-transform: uppercase;
    letter-spacing: 0.8px;
    margin-bottom: 12px;
  }

  .stats-value {
    font-size: 36px;
    font-weight: 600;
    background: linear-gradient(135deg, var(--gradient-start), var(--gradient-end));
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    margin: 0;
    line-height: 1.2;
    margin-bottom: 16px;
  }

  .stats-trend {
    margin-top: auto;
  }

  .trend-icon {
    font-size: 22px;
    font-weight: bold;
    animation: bounce 2s infinite;
  }

  @keyframes bounce {

    0%,
    100% {
      transform: translateY(0);
    }

    50% {
      transform: translateY(-5px);
    }
  }

  .stats-badge {
    margin-top: auto;
    padding: 8px 16px;
    border-radius: 25px;
    font-size: 11px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.8px;
    display: inline-block;
    width: fit-content;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
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

  .action-btn {
    padding: 10px 20px;
    border: none;
    border-radius: 10px;
    font-size: 13px;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.3s ease;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
  }

  .action-btn:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
  }

  .btn-accept {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    color: #fff;
  }

  .btn-decline {
    background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
    color: #fff;
  }

  .view-all-btn {
    width: 100%;
    padding: 16px;
    border: none;
    border-radius: 12px;
    background: linear-gradient(135deg, #1e293b 0%, #334155 100%);
    color: #fff;
    font-size: 15px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 1px;
    cursor: pointer;
    transition: all 0.3s ease;
    margin-top: 20px;
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
  }

  .view-all-btn:hover {
    transform: translateY(-3px);
    box-shadow: 0 12px 30px rgba(0, 0, 0, 0.25);
  }

  /* Status Badge */
  .status-badge {
    padding: 6px 14px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    display: inline-block;
  }

  .status-primary {
    background: linear-gradient(135deg, #3b82f6, #2563eb);
    color: #fff;
    box-shadow: 0 4px 10px rgba(59, 130, 246, 0.3);
  }

  /* Responsive */
  @media (max-width: 1199px) {
    .stats-value {
      font-size: 28px;
    }

    .stats-icon {
      width: 50px;
      height: 50px;
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
      width: 46px;
      height: 46px;
      top: 16px;
      right: 16px;
    }

    .stats-icon i {
      font-size: 20px;
    }

    .chart-card,
    .modern-table-container {
      padding: 20px;
    }

    .time-filter {
      flex-wrap: wrap;
    }

    .chart-title {
      font-size: 18px;
    }

    .modern-table {
      font-size: 12px;
    }

    .modern-table thead th,
    .modern-table tbody td {
      padding: 12px 8px;
    }
  }


  /* Badge variants */
  .badge-warning {
    background: linear-gradient(135deg, #fef3c7, #fde68a);
    color: #92400e;
  }

  .badge-info {
    background: linear-gradient(135deg, #dbeafe, #bfdbfe);
    color: #1e40af;
  }

  .badge-success {
    background: linear-gradient(135deg, #d1fae5, #a7f3d0);
    color: #065f46;
  }

  .badge-purple {
    background: linear-gradient(135deg, #e9d5ff, #d8b4fe);
    color: #6b21a8;
  }

  .badge-dark {
    background: linear-gradient(135deg, #e2e8f0, #cbd5e1);
    color: #334155;
  }
</style>
<?php

// --------------------
// POST handlers (existing behaviour kept intact)
// --------------------
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


// --------------------
// Bulk Actions
// --------------------
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['selected_invoices'])) {
  $selected_invoices = $_POST['selected_invoices'];
  $inv_list = implode(",", $selected_invoices);

  if (isset($_POST['download_selected'])) {
    echo "<script>window.location.href = 'all-invoice.php?invoice=" . urlencode($inv_list) . "';</script>";
    exit;
  }
}
// END


// --- Search and Filter Logic ---
$search_query = isset($_GET['search_query']) ? $conn->real_escape_string($_GET['search_query']) : '';
$from_date = isset($_GET['from_date']) ? $conn->real_escape_string($_GET['from_date']) : '';
$to_date = isset($_GET['to_date']) ? $conn->real_escape_string($_GET['to_date']) : '';
$filter = isset($_GET['filter']) ? $_GET['filter'] : 'all';
$main_ctg = isset($_GET['main_ctg']) ? intval($_GET['main_ctg']) : 0; // NEW: selected main category id (0 => all)

// For Cash On Delivery
$where_cod = "WHERE payment_method = 'Cash On Delivery' AND order_status != 'Pending'";
if ($search_query) {
  $where_cod .= " AND (invoice_no LIKE '%$search_query%' OR user_phone LIKE '%$search_query%')";
}
if ($from_date && $to_date) {
  $where_cod .= " AND order_date BETWEEN '$from_date' AND '$to_date'";
}
if ($filter == 'Shipped') {
  $where_cod .= " AND order_status = 'Shipped'";
} elseif ($filter == 'Canceled') {
  $where_cod .= " AND order_status = 'Canceled'";
} elseif ($filter == 'Completed') {
  $where_cod .= " AND order_status = 'Completed'";
} elseif ($filter == 'SendToSteadfast') {
  $where_cod .= " AND invoice_no IN (SELECT invoice_no FROM parcel_info WHERE tracking_code IS NULL)";
}

// NEW: main category filter - restrict invoices to those that include at least one product from the selected main category
if ($main_ctg) {
  // Using a subquery to find invoice_no values that have product(s) in the chosen main category
  $where_cod .= " AND invoice_no IN (SELECT DISTINCT o.invoice_no FROM order_info o JOIN product_info p ON o.product_id = p.product_id WHERE p.main_ctg_id = $main_ctg)";
}

?>

<!--------------------------->
<!-- START MAIN AREA -->
<!--------------------------->
<div class="content-wrapper">
  <div class="page-header">
    <h3 class="page-title">
      <span class="page-title-icon bg-gradient-primary text-white me-2">
        <i class="mdi mdi-tshirt-crew-outline"></i>
      </span> Customized Orders
    </h3>
  </div>

  <br>

  <!-- STATS BOXES -->
  <div class="row g-4">
    <!-- Pending Orders -->
    <div class="col-xl-3 col-md-6" onclick="window.location.href='pendingOrders.php';" style="cursor: pointer;">
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
    <div class="col-xl-3 col-md-6" onclick="window.location.href='viewOrders.php';" style="cursor: pointer;">
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

    <!-- Shipped Orders -->
    <div class="col-xl-3 col-md-6" onclick="window.location.href='makeInvoice.php?search_query=&from_date=&to_date=&main_ctg=&filter=Shipped';" style="cursor: pointer;">
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
    <div class="col-xl-3 col-md-6" onclick="window.location.href='makeInvoice.php?search_query=&from_date=&to_date=&main_ctg=&filter=Completed';" style="cursor: pointer;">
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
    <!-- <div class="col-xl-3 col-md-6" onclick="window.location.href='makeInvoice.php?search_query=&from_date=&to_date=&main_ctg=&filter=Canceled';" style="cursor: pointer;">
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
        <div class="stats-badge badge-dark">Cancelled</div>
      </div>
    </div> -->
  </div>
  <!-- END -->

  <br>

  <!-- Search & Filter Controls -->
  <form method="get" class="row mb-3">
    <div class="row">

      <div class="col-md-3 mt-2 mt-md-0">
        <label for=""><b>Search</b></label>
        <input type="text" name="search_query" class="form-control" placeholder="Search Invoice No or Mobile" value="<?php echo isset($_GET['search_query']) ? htmlspecialchars($_GET['search_query']) : ''; ?>">
      </div>

      <div class="col-md-2 mt-2 mt-md-0">
        <label for=""><b>From</b></label>
        <input type="date" name="from_date" class="form-control" value="<?php echo isset($_GET['from_date']) ? htmlspecialchars($_GET['from_date']) : ''; ?>">
      </div>

      <div class="col-md-2 mt-2 mt-md-0">
        <label for=""><b>To</b></label>
        <input type="date" name="to_date" class="form-control" value="<?php echo isset($_GET['to_date']) ? htmlspecialchars($_GET['to_date']) : ''; ?>">
      </div>

      <!-- REPLACEMENT: Order Status Dropdown -->
      <div class="col-md-3 mt-2 mt-md-0">
        <label for=""><b>Status</b></label>
        <select name="filter" class="form-control">
          <option value="">All Status</option>
          <option value="Shipped" <?php echo (isset($_GET['filter']) && $_GET['filter'] == 'Shipped') ? 'selected' : ''; ?>>Shipped</option>
          <option value="Completed" <?php echo (isset($_GET['filter']) && $_GET['filter'] == 'Completed') ? 'selected' : ''; ?>>Completed</option>
          <option value="Canceled" <?php echo (isset($_GET['filter']) && $_GET['filter'] == 'Canceled') ? 'selected' : ''; ?>>Canceled</option>
          <option value="SendToSteadfast" <?php echo (isset($_GET['filter']) && $_GET['filter'] == 'SendToSteadfast') ? 'selected' : ''; ?>>Steadfast</option>
        </select>
      </div>

      <div class="col-md-2 mt-2 mt-md-0">
        <label for=""><b></b></label>
        <div class="d-flex align-items-center">
          <button type="submit" class="btn btn-dark me-2">Search</button>
          <a href="customized-orders.php" class="btn btn-secondary">Reset</a>
        </div>
      </div>

    </div>
  </form>

  <br>
  <hr><br>

  <!-- Bulk Selection Form -->
  <form method="post" id="bulkActionForm" action="">
    <div class="row">
      <h1>Order List</h1>
      <!-- Table Area -->
      <div style="overflow-y: auto;">
        <table class="table table-under-bordered">
          <tbody class="CODTable">
            <tr>
              <th><input type="checkbox" id="selectAllCod"></th>
              <th>Serial No</th>
              <th>Invoice No</th>
              <th>Phone</th>
              <th>Order No</th>
              <th>Order Amount</th>
              <th>Order Status</th>
              <th>Payment Method</th>
              <th>Date</th>
              <th>Courier</th>
              <th>Shipped</th>
              <th>Completed</th>
              <th>Canceled</th>
              <th>Invoice</th>
              <th colspan="2">Details</th>
              <th>Label</th>
            </tr>

            <?php
            // Fetch data from order_info table
            $sql = "SELECT invoice_no, GROUP_CONCAT(order_no ORDER BY order_no SEPARATOR ', ') as order_no, user_phone, order_status, order_visibility, payment_method
                          FROM order_info
                          $where_cod
                          GROUP BY invoice_no, order_status, payment_method";

            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
              $count = 1;
              while ($row = $result->fetch_assoc()) {
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

                  echo '<tr>';
                  echo "<td><input type='checkbox' name='selected_invoices[]' value='" . $row["invoice_no"] . "'></td>";
                  echo '
                            <td>' . $count . '</td>
                            <td>' . $row["invoice_no"] . '</td>
                            <td>' . $row["user_phone"] . '</td>
                            <td>' . $row["order_no"] . '</td>
                            <td>' . calculate_order_amount($row["invoice_no"]) . '</td>
                            <td class="order-status">' . $row["order_status"] . '</td>
                            <td>' . $row["payment_method"] . '</td>
                            <td>' . find_order_date($row["invoice_no"]) . '</td>
                            ';

                  if ($is_tracking_code_set == 0) {
                    echo '
                                  <td>
                                    <a href="steadfast_entry.php?invoice_no=' . $row["invoice_no"] . '" class="btn btn-primary">
                                      Send to Steadfast <span class="mdi mdi-send"></span>
                                    </a>
                                  </td>';
                  } else {
                    echo '
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
                                    <button type="submit" name="mark_completed" class="btn btn-info">Mark As Completed</button>
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
                              <a href="invoice.php?inv=' . $row['invoice_no'] . '" class="btn btn-dark">See Invoice</a>
                            </td>
                            <td>
                              <a class="btn btn-info" href="order_details.php?invoice_no=' . $row['invoice_no'] . '">
                                View Details <span class="mdi mdi-details"></span>
                              </a>
                            </td>

                            <td>
                              <a class="btn btn-dark" href="edit-order.php?invoice_no=' . $row['invoice_no'] . '">
                                Edit <span class="mdi mdi-text-box-edit-outline"></span>
                              </a>
                            </td>

                            <td>
                              <a class="btn btn-primary" href="generate_label.php?invoice_no=' . $row['invoice_no'] . '" target="_blank">
                                Generate Label <span class="mdi mdi-label"></span>
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

    <br>
    <hr>

    <!-- Bulk Action Buttons -->
    <div class="mt-5">
      <button type="submit" name="download_selected" class="m-1 btn btn-dark">Print Selected Invoices</button>
      <a href="all-invoice.php" class="btn btn-info">Print All Invoice</a>
    </div>
  </form>


</div>
<!--------------------------->
<!-- END MAIN AREA -->
<!--------------------------->
<script>
  // Select All for Cash On Delivery Table
  document.getElementById('selectAllCod').addEventListener('change', function() {
    let checkboxes = document.querySelectorAll('.CODTable input[name="selected_invoices[]"]');
    checkboxes.forEach(cb => cb.checked = this.checked);
  });

  // Select All for Mobile Banking Table
  document.getElementById('selectAllMb').addEventListener('change', function() {
    let checkboxes = document.querySelectorAll('.MbTable input[name="selected_invoices[]"]');
    checkboxes.forEach(cb => cb.checked = this.checked);
  });
</script>
<?php require 'footer.php'; ?>