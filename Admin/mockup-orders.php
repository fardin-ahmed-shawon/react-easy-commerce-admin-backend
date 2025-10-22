<?php
$current_page = basename($_SERVER['PHP_SELF']);
$page_title = 'Mockup Orders';
?>
<?php require 'header.php'; ?>

<style>
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

  .badge-danger {
    background: linear-gradient(135deg, #fee2e2, #fecaca);
    color: #991b1b;
  }

  .status-badge {
    padding: 6px 14px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    display: inline-block;
  }

  .status-pending {
    background: linear-gradient(135deg, #fef3c7, #fde68a);
    color: #92400e;
  }

  .status-processing {
    background: linear-gradient(135deg, #dbeafe, #bfdbfe);
    color: #1e40af;
  }

  .status-completed {
    background: linear-gradient(135deg, #d1fae5, #a7f3d0);
    color: #065f46;
  }

  .status-cancelled {
    background: linear-gradient(135deg, #fee2e2, #fecaca);
    color: #991b1b;
  }

  .action-btn {
    padding: 8px 12px;
    border: none;
    border-radius: 6px;
    font-size: 12px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
  }

  .action-btn:hover {
    transform: translateY(-2px);
  }

  #orderModal {
    z-index: 999999999;
  }

  .modal-overlay {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.5);
    z-index: 1000;
    justify-content: center;
    align-items: center;
    padding: 20px;
  }

  .modal-overlay.active {
    display: flex;
  }

  .modal-content {
    background: white;
    border-radius: 12px;
    max-width: 600px;
    width: 100%;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
  }

  .modal-body {
    max-height: 70vh;
    overflow-y: auto;
    z-index: 999;
  }

  .modal-header {
    background: linear-gradient(135deg, #1e293b, #334155);
    color: white;
    padding: 24px;
    border-radius: 12px 12px 0 0;
    display: flex;
    justify-content: space-between;
    align-items: center;
    position: sticky;
    top: 0;
    z-index: 99999;
  }

  .modal-header h2 {
    margin: 0;
    font-size: 24px;
  }

  .modal-close {
    background: none;
    border: none;
    color: white;
    font-size: 28px;
    cursor: pointer;
    padding: 0;
    width: 32px;
    height: 32px;
    display: flex;
    align-items: center;
    justify-content: center;
  }

  .modal-body {
    padding: 24px;
  }

  .modal-section {
    margin-bottom: 24px;
    padding-bottom: 24px;
    border-bottom: 1px solid #e2e8f0;
  }

  .modal-section h3 {
    font-size: 18px;
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 16px;
  }

  .info-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 16px;
  }

  .info-item {
    display: flex;
    flex-direction: column;
  }

  .info-label {
    font-size: 12px;
    font-weight: 600;
    color: #64748b;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 4px;
  }

  .info-value {
    font-size: 16px;
    font-weight: 600;
    color: #1e293b;
  }

  .modal-footer {
    padding: 20px 24px;
    background: #f8fafc;
    border-top: 1px solid #e2e8f0;
    display: flex;
    gap: 12px;
    justify-content: flex-end;
  }

  .modal-btn {
    padding: 10px 20px;
    border: none;
    border-radius: 6px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
  }

  .modern-table {
    width: 100%;
    border-collapse: collapse;
  }

  .modern-table thead th {
    background: #1e293b;
    color: white;
    padding: 16px;
    text-align: left;
    font-weight: 700;
    font-size: 13px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
  }

  .modern-table tbody td {
    padding: 14px 16px;
    border-bottom: 1px solid #e2e8f0;
  }

  .modern-table tbody tr:hover {
    background: #f8fafc;
  }

  @media (max-width: 768px) {
    .info-grid {
      grid-template-columns: 1fr;
    }

    .stats-value {
      font-size: 28px;
    }

    .modal-overlay {
      padding: 10px;
    }

    .modal-content {
      border-radius: 8px;
    }
  }

  .table-responsive {
    max-height: 800px;
  }
</style>

<?php
// Handle Status Updates
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["update_status"])) {
  $id = intval($_POST["order_id"]);
  $new_status = $conn->real_escape_string($_POST["new_status"]);

  $update_sql = "UPDATE mockup_orders SET order_status = '$new_status' WHERE id = $id";

  if ($conn->query($update_sql)) {
    $msg = "Order status updated successfully!";
  } else {
    $msg = "Error: " . $conn->error;
  }
}

// Search & Filter Logic
$search_query = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';
$status_filter = isset($_GET['status']) ? $_GET['status'] : '';
$from_date = isset($_GET['from_date']) ? $conn->real_escape_string($_GET['from_date']) : '';
$to_date = isset($_GET['to_date']) ? $conn->real_escape_string($_GET['to_date']) : '';

// Build WHERE clause
$where = "WHERE 1=1";

if ($search_query) {
  $where .= " AND (mo.order_no LIKE '%$search_query%' OR mo.user_phone LIKE '%$search_query%')";
}

if ($status_filter) {
  $where .= " AND mo.order_status = '$status_filter'";
}

if ($from_date) {
  $where .= " AND DATE(mo.order_date) >= '$from_date'";
}

if ($to_date) {
  $where .= " AND DATE(mo.order_date) <= '$to_date'";
}

// Get stats
$stats = array();
foreach (['Pending', 'Processing', 'Completed', 'Cancelled'] as $status) {
  $sql = "SELECT COUNT(id) as count FROM mockup_orders WHERE order_status = '$status'";
  $result = $conn->query($sql);
  $row = $result->fetch_assoc();
  $stats[strtolower($status)] = $row['count'];
}

// Fetch orders with product and category details
$sql = "SELECT 
  mo.id,
  mo.order_no,
  mo.user_full_name,
  mo.user_phone,
  mo.user_email,
  mo.user_address,
  mo.city_address,
  mo.team_name,
  mo.quantity,
  mo.product_id,
  mo.payment_method,
  mo.order_note,
  mo.order_date,
  mo.order_status,
  mp.product_title,
  mp.product_code,
  mc.category_name
FROM mockup_orders mo
LEFT JOIN mockup_products mp ON mo.product_id = mp.id
LEFT JOIN mockup_category mc ON mp.category_id = mc.id
$where
ORDER BY mo.order_date DESC";

$result = $conn->query($sql);
$ordersData = [];
if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    $ordersData[] = $row;
  }
}
?>

<div class="content-wrapper">
  <div class="page-header">
    <h3 class="page-title">
      <span class="page-title-icon bg-gradient-primary text-white me-2">
        <i class="mdi mdi-image-multiple-outline"></i>
      </span> Mockup Orders
    </h3>
  </div>

  <br>

  <!-- Stats Cards -->
  <div class="row g-4">
    <div class="col-xl-3 col-md-6">
      <div class="stats-card stats-gradient-warning">
        <div class="stats-icon">
          <i class="mdi mdi-clock-outline"></i>
        </div>
        <div class="stats-content">
          <h6 class="stats-label">Pending</h6>
          <h2 class="stats-value"><?php echo $stats['pending']; ?></h2>
        </div>
        <div class="stats-badge badge-warning">Action Required</div>
      </div>
    </div>

    <div class="col-xl-3 col-md-6">
      <div class="stats-card stats-gradient-info">
        <div class="stats-icon">
          <i class="mdi mdi-progress-clock"></i>
        </div>
        <div class="stats-content">
          <h6 class="stats-label">Processing</h6>
          <h2 class="stats-value"><?php echo $stats['processing']; ?></h2>
        </div>
        <div class="stats-badge badge-info">In Progress</div>
      </div>
    </div>

    <div class="col-xl-3 col-md-6">
      <div class="stats-card stats-gradient-success">
        <div class="stats-icon">
          <i class="mdi mdi-check-circle-outline"></i>
        </div>
        <div class="stats-content">
          <h6 class="stats-label">Completed</h6>
          <h2 class="stats-value"><?php echo $stats['completed']; ?></h2>
        </div>
        <div class="stats-badge badge-success">Done</div>
      </div>
    </div>

    <div class="col-xl-3 col-md-6">
      <div class="stats-card stats-gradient-danger">
        <div class="stats-icon">
          <i class="mdi mdi-close-circle-outline"></i>
        </div>
        <div class="stats-content">
          <h6 class="stats-label">Cancelled</h6>
          <h2 class="stats-value"><?php echo $stats['cancelled']; ?></h2>
        </div>
        <div class="stats-badge badge-danger">Cancelled</div>
      </div>
    </div>
  </div>

  <br>
  <hr><br>

  <!-- Filter Form -->
  <div class="card mb-4">
    <div class="card-body p-4">
      <form method="GET" action="" class="row g-3">
        <div class="col-md-3">
          <label for="search" class="form-label"><b>Search</b></label>
          <input type="text" name="search" id="search" class="form-control" placeholder="Order No or Phone" value="<?php echo htmlspecialchars($search_query); ?>">
        </div>

        <div class="col-md-2">
          <label for="from_date" class="form-label"><b>From Date</b></label>
          <input type="date" name="from_date" id="from_date" class="form-control" value="<?php echo htmlspecialchars($from_date); ?>">
        </div>

        <div class="col-md-2">
          <label for="to_date" class="form-label"><b>To Date</b></label>
          <input type="date" name="to_date" id="to_date" class="form-control" value="<?php echo htmlspecialchars($to_date); ?>">
        </div>

        <div class="col-md-3">
          <label for="status" class="form-label"><b>Status</b></label>
          <select name="status" id="status" class="form-control">
            <option value="">All Status</option>
            <option value="Pending" <?php echo $status_filter === 'Pending' ? 'selected' : ''; ?>>Pending</option>
            <option value="Processing" <?php echo $status_filter === 'Processing' ? 'selected' : ''; ?>>Processing</option>
            <option value="Completed" <?php echo $status_filter === 'Completed' ? 'selected' : ''; ?>>Completed</option>
            <option value="Cancelled" <?php echo $status_filter === 'Cancelled' ? 'selected' : ''; ?>>Cancelled</option>
          </select>
        </div>

        <div class="col-md-2">
          <label class="form-label">&nbsp;</label>
          <div class="d-flex gap-2">
            <button type="submit" class="btn btn-dark w-100 mb-0">Filter</button>
            <a href="mockup-orders.php" class="btn btn-secondary">Reset</a>
          </div>
        </div>
      </form>
    </div>
  </div>

  <!-- Orders Table -->
  <div class="card">
    <div class="table-responsive">
      <table class="table modern-table">
        <thead>
          <tr>
            <th>Order No</th>
            <th>Customer</th>
            <th>Phone</th>
            <th>Product</th>
            <th>Category</th>
            <th>Team Name</th>
            <th>Quantity</th>
            <th>Date</th>
            <th>Payment</th>
            <th>Status</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php
          if (count($ordersData) > 0) {
            foreach ($ordersData as $row) {
              $status_class = 'status-' . strtolower($row['order_status']);
              echo '<tr>';
              echo '<td><strong>' . htmlspecialchars($row['order_no']) . '</strong></td>';
              echo '<td>' . htmlspecialchars($row['user_full_name']) . '</td>';
              echo '<td>' . htmlspecialchars($row['user_phone']) . '</td>';
              echo '<td>' . htmlspecialchars($row['product_title']) . '</td>';
              echo '<td>' . htmlspecialchars($row['category_name']) . '</td>';
              echo '<td>' . htmlspecialchars($row['team_name']) . '</td>';
              echo '<td><strong>' . $row['quantity'] . '</strong></td>';
              echo '<td>' . date('d M Y', strtotime($row['order_date'])) . '</td>';
              echo '<td>' . htmlspecialchars($row['payment_method']) . '</td>';
              echo '<td><span class="status-badge ' . $status_class . '">' . $row['order_status'] . '</span></td>';
              echo '<td>';
              ?>
              <button class="action-btn btn btn-info btn-sm" onclick="openModal(<?php echo $row['id']; ?>)">View</button>
              <?php
              echo '</td>';
              echo '</tr>';
            }
          } else {
            echo '<tr><td colspan="11" class="text-center text-muted py-4">No orders found</td></tr>';
          }
          ?>
        </tbody>
      </table>
    </div>
  </div>

</div>

<!-- Order Details Modal -->
<div id="orderModal" class="modal-overlay">
  <div class="modal-content">
    <div class="modal-header">
      <div>
        <h2>Order Details</h2>
        <p id="modalOrderNo" style="color: #cbd5e1; margin: 4px 0 0 0; font-size: 14px;"></p>
      </div>
      <button class="modal-close" onclick="closeModal()">&times;</button>
    </div>
    <div class="modal-body">
      <div class="modal-section">
        <h3>Status</h3>
        <form method="POST" action="">
          <input type="hidden" name="order_id" id="modalOrderId">
          <div class="info-grid">
            <div>
              <label class="info-label">Current Status</label>
              <p id="modalCurrentStatus" class="info-value"></p>
            </div>
            <div>
              <label class="info-label">Update Status</label>
              <select name="new_status" class="form-control" required>
                <option value="Pending">Pending</option>
                <option value="Processing">Processing</option>
                <option value="Completed">Completed</option>
                <option value="Cancelled">Cancelled</option>
              </select>
            </div>
          </div>
          <button type="submit" name="update_status" class="btn btn-success mt-3">Update Status</button>
        </form>
      </div>

      <div class="modal-section">
        <h3>Customer Information</h3>
        <div class="info-grid">
          <div class="info-item">
            <span class="info-label">Full Name</span>
            <span class="info-value" id="modalFullName"></span>
          </div>
          <div class="info-item">
            <span class="info-label">Phone</span>
            <span class="info-value" id="modalPhone"></span>
          </div>
          <div class="info-item">
            <span class="info-label">Email</span>
            <span class="info-value" id="modalEmail"></span>
          </div>
          <div class="info-item">
            <span class="info-label">City</span>
            <span class="info-value" id="modalCity"></span>
          </div>
          <div class="info-item" style="grid-column: 1/-1;">
            <span class="info-label">Address</span>
            <span class="info-value" id="modalAddress"></span>
          </div>
        </div>
      </div>

      <div class="modal-section">
        <h3>Product & Order Details</h3>
        <div class="info-grid">
          <div class="info-item">
            <span class="info-label">Product</span>
            <span class="info-value" id="modalProduct"></span>
          </div>
          <div class="info-item">
            <span class="info-label">Category</span>
            <span class="info-value" id="modalCategory"></span>
          </div>
          <div class="info-item">
            <span class="info-label">Product Code</span>
            <span class="info-value" id="modalProductCode"></span>
          </div>
          <div class="info-item">
            <span class="info-label">Team Name</span>
            <span class="info-value" id="modalTeamName"></span>
          </div>
          <div class="info-item">
            <span class="info-label">Quantity</span>
            <span class="info-value" style="color: #3b82f6;" id="modalQuantity"></span>
          </div>
          <div class="info-item">
            <span class="info-label">Order Date</span>
            <span class="info-value" id="modalOrderDate"></span>
          </div>
        </div>
      </div>

      <div class="modal-section">
        <h3>Payment Information</h3>
        <div class="info-grid">
          <div class="info-item">
            <span class="info-label">Payment Method</span>
            <span class="info-value" id="modalPaymentMethod"></span>
          </div>
        </div>
      </div>

      <div class="modal-section">
        <h3>Order Note</h3>
        <p id="modalOrderNote" style="color: #475569; line-height: 1.6;"></p>
      </div>
    </div>

    <div class="modal-footer">
      <button type="button" class="modal-btn btn-dark" onclick="closeModal()">Close</button>
    </div>
  </div>
</div>

<script>
  const ordersData = <?php echo json_encode($ordersData); ?>;

  function openModal(orderId) {
    const modal = document.getElementById('orderModal');
    const order = ordersData.find(o => o.id == orderId);

    if (order) {
      document.getElementById('modalOrderId').value = order.id;
      document.getElementById('modalOrderNo').textContent = '#' + order.order_no;
      document.getElementById('modalCurrentStatus').textContent = order.order_status;
      document.getElementById('modalFullName').textContent = order.user_full_name;
      document.getElementById('modalPhone').textContent = order.user_phone;
      document.getElementById('modalEmail').textContent = order.user_email;
      document.getElementById('modalCity').textContent = order.city_address;
      document.getElementById('modalAddress').textContent = order.user_address;
      document.getElementById('modalProduct').textContent = order.product_title || 'N/A';
      document.getElementById('modalCategory').textContent = order.category_name || 'N/A';
      document.getElementById('modalProductCode').textContent = order.product_code || 'N/A';
      document.getElementById('modalTeamName').textContent = order.team_name;
      document.getElementById('modalQuantity').textContent = order.quantity;
      document.getElementById('modalOrderDate').textContent = new Date(order.order_date).toLocaleDateString('en-BD');
      document.getElementById('modalPaymentMethod').textContent = order.payment_method;
      document.getElementById('modalOrderNote').textContent = order.order_note || 'No notes';

      modal.classList.add('active');
    }
  }

  function closeModal() {
    document.getElementById('orderModal').classList.remove('active');
  }

  window.onclick = function(event) {
    const modal = document.getElementById('orderModal');
    if (event.target === modal) {
      closeModal();
    }
  }
</script>

<?php require 'footer.php'; ?>