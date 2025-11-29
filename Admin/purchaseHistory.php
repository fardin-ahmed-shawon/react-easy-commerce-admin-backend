<?php
$current_page = basename($_SERVER['PHP_SELF']);
$page_title = 'Purchase History';
?>
<?php require 'header.php'; ?>

<?php
// Fetch order history with advanced search
$searchQuery = "";
$searchField = isset($_GET['search_field']) ? $_GET['search_field'] : 'invoice_no';
$whereClause = "1=1";

if (isset($_GET['search']) && !empty($_GET['search'])) {
    $searchQuery = $conn->real_escape_string($_GET['search']);
    $whereClause = "$searchField LIKE '%$searchQuery%'";
}

// Date range filter
if (isset($_GET['date_from']) && !empty($_GET['date_from'])) {
    $dateFrom = $conn->real_escape_string($_GET['date_from']);
    $whereClause .= " AND order_date >= '$dateFrom'";
}
if (isset($_GET['date_to']) && !empty($_GET['date_to'])) {
    $dateTo = $conn->real_escape_string($_GET['date_to']);
    $whereClause .= " AND order_date <= '$dateTo'";
}

// Status filter
if (isset($_GET['status']) && !empty($_GET['status'])) {
    $status = $conn->real_escape_string($_GET['status']);
    $whereClause .= " AND order_status = '$status'";
}

$sql = "SELECT * FROM order_info WHERE $whereClause ORDER BY order_no DESC";
$result = $conn->query($sql);
?>

<style>
.history-container {
  max-width: 100%;
  margin: 0 auto;
  padding: 2rem;
  background: #ffffff;
}

.history-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 2rem;
  padding-bottom: 1rem;
  border-bottom: 2px solid #000;
}

.history-header h1 {
  font-size: 1.75rem;
  font-weight: 600;
  color: #000;
  margin: 0;
  letter-spacing: -0.5px;
}

.btn-export {
  padding: 0.65rem 1.5rem;
  background: #000;
  color: #fff;
  border: none;
  font-size: 0.9rem;
  font-weight: 500;
  cursor: pointer;
  transition: all 0.2s ease;
  text-decoration: none;
  display: inline-flex;
  align-items: center;
  gap: 0.5rem;
}

.btn-export:hover {
  background: #333;
  color: #fff;
  transform: translateY(-1px);
}

.search-filters {
  background: #f8f8f8;
  padding: 1.5rem;
  border: 1px solid #e0e0e0;
  margin-bottom: 2rem;
}

.filter-row {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
  gap: 1rem;
  margin-bottom: 1rem;
}

.filter-group {
  display: flex;
  flex-direction: column;
  gap: 0.5rem;
}

.filter-group label {
  font-size: 0.85rem;
  font-weight: 600;
  color: #000;
  text-transform: uppercase;
  letter-spacing: 0.5px;
}

.filter-input,
.filter-select {
  padding: 0.65rem;
  border: 1px solid #ccc;
  font-size: 0.9rem;
  background: #fff;
  transition: border-color 0.2s ease;
}

.filter-input:focus,
.filter-select:focus {
  outline: none;
  border-color: #000;
}

.search-actions {
  display: flex;
  gap: 0.75rem;
  margin-top: 1rem;
}

.btn-search,
.btn-reset {
  padding: 0.65rem 1.5rem;
  font-size: 0.9rem;
  font-weight: 600;
  cursor: pointer;
  transition: all 0.2s ease;
  border: none;
  text-transform: uppercase;
  letter-spacing: 0.5px;
}

.btn-search {
  background: #000;
  color: #fff;
}

.btn-search:hover {
  background: #333;
}

.btn-reset {
  background: #fff;
  color: #000;
  border: 2px solid #000;
}

.btn-reset:hover {
  background: #000;
  color: #fff;
}

.table-container {
  overflow-x: auto;
  background: #fff;
  border: 1px solid #e0e0e0;
  max-height: 600px;
  overflow-y: auto;
}

.history-table {
  width: 100%;
  border-collapse: collapse;
  font-size: 0.85rem;
}

.history-table thead {
  background: #000;
  color: #fff;
  position: sticky;
  top: 0;
  z-index: 10;
}

.history-table thead th {
  padding: 1rem 0.75rem;
  text-align: left;
  font-weight: 600;
  font-size: 0.8rem;
  text-transform: uppercase;
  letter-spacing: 0.5px;
  border-right: 1px solid #333;
  white-space: nowrap;
}

.history-table thead th:last-child {
  border-right: none;
}

.history-table tbody tr {
  border-bottom: 1px solid #e0e0e0;
  transition: background 0.2s ease;
}

.history-table tbody tr:hover {
  background: #f8f8f8;
}

.history-table tbody td {
  padding: 0.85rem 0.75rem;
  vertical-align: middle;
  color: #333;
}

.address-cell {
  max-width: 200px;
  overflow: hidden;
  text-overflow: ellipsis;
  white-space: nowrap;
  position: relative;
  cursor: help;
}

.address-cell:hover {
  overflow: visible;
  white-space: normal;
  background: #fff;
  box-shadow: 0 2px 8px rgba(0,0,0,0.1);
  z-index: 10;
  position: absolute;
  padding: 0.75rem;
  border: 1px solid #e0e0e0;
}

.total-price {
  font-weight: 700;
  color: #000;
}

.empty-state {
  text-align: center;
  padding: 4rem 2rem;
  color: #999;
}

.empty-state i {
  font-size: 3rem;
  margin-bottom: 1rem;
  opacity: 0.5;
}

@media (max-width: 768px) {
  .history-container {
    padding: 1rem;
  }
  
  .history-header {
    flex-direction: column;
    gap: 1rem;
    align-items: flex-start;
  }
  
  .filter-row {
    grid-template-columns: 1fr;
  }
  
  .search-actions {
    flex-direction: column;
  }
  
  .btn-search,
  .btn-reset {
    width: 100%;
  }
  
  .history-table {
    font-size: 0.75rem;
  }
  
  .address-cell {
    max-width: 120px;
  }
}
</style>

<div class="content-wrapper">
  <div class="history-container">
    <div class="history-header">
      <h1>Purchase History</h1>
      <button class="btn-export" onclick="exportToExcel()">
        <span class="mdi mdi-file-excel"></span>
        Export to Excel
      </button>
    </div>

    <!-- Advanced Search Filters -->
    <div class="search-filters">
      <form method="GET" action="purchaseHistory.php">
        <div class="filter-row">
          <div class="filter-group">
            <label>Search By</label>
            <select name="search_field" class="filter-select">
              <option value="invoice_no" <?php echo (isset($_GET['search_field']) && $_GET['search_field'] == 'invoice_no') ? 'selected' : ''; ?>>Invoice No</option>
              <option value="user_full_name" <?php echo (isset($_GET['search_field']) && $_GET['search_field'] == 'user_full_name') ? 'selected' : ''; ?>>Customer Name</option>
              <option value="user_phone" <?php echo (isset($_GET['search_field']) && $_GET['search_field'] == 'user_phone') ? 'selected' : ''; ?>>Phone Number</option>
              <option value="user_email" <?php echo (isset($_GET['search_field']) && $_GET['search_field'] == 'user_email') ? 'selected' : ''; ?>>Email</option>
              <option value="order_no" <?php echo (isset($_GET['search_field']) && $_GET['search_field'] == 'order_no') ? 'selected' : ''; ?>>Order No</option>
            </select>
          </div>

          <div class="filter-group">
            <label>Search Value</label>
            <input type="text" name="search" class="filter-input" placeholder="Enter search term..." 
                   value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
          </div>

          <div class="filter-group">
            <label>From Date</label>
            <input type="date" name="date_from" class="filter-input" 
                   value="<?php echo isset($_GET['date_from']) ? htmlspecialchars($_GET['date_from']) : ''; ?>">
          </div>

          <div class="filter-group">
            <label>To Date</label>
            <input type="date" name="date_to" class="filter-input" 
                   value="<?php echo isset($_GET['date_to']) ? htmlspecialchars($_GET['date_to']) : ''; ?>">
          </div>

          <div class="filter-group">
            <label>Order Status</label>
            <select name="status" class="filter-select">
              <option value="">All Statuses</option>
              <option value="Pending" <?php echo (isset($_GET['status']) && $_GET['status'] == 'Pending') ? 'selected' : ''; ?>>Pending</option>
              <option value="Processing" <?php echo (isset($_GET['status']) && $_GET['status'] == 'Processing') ? 'selected' : ''; ?>>Processing</option>
              <option value="Shipped" <?php echo (isset($_GET['status']) && $_GET['status'] == 'Shipped') ? 'selected' : ''; ?>>Shipped</option>
              <option value="Delivered" <?php echo (isset($_GET['status']) && $_GET['status'] == 'Delivered') ? 'selected' : ''; ?>>Delivered</option>
              <option value="Cancelled" <?php echo (isset($_GET['status']) && $_GET['status'] == 'Cancelled') ? 'selected' : ''; ?>>Cancelled</option>
            </select>
          </div>
        </div>

        <div class="search-actions">
          <button type="submit" class="btn-search">
            <span class="mdi mdi-magnify"></span> Search
          </button>
          <a href="purchaseHistory.php" class="btn-reset" style="text-decoration: none; display: inline-flex; align-items: center; justify-content: center;">
            <span class="mdi mdi-refresh"></span> Reset Filters
          </a>
        </div>
      </form>
    </div>

    <!-- Table -->
    <div class="table-container">
      <table class="history-table" id="historyTable">
        <thead>
          <tr>
            <th>Order No</th>
            <th>Invoice No</th>
            <th>Customer Name</th>
            <th>Phone</th>
            <th>Email</th>
            <th>Address</th>
            <th>Product ID</th>
            <th>Quantity</th>
            <th>Total</th>
            <th>Order Date</th>
            <th>Payment</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td><strong>{$row['order_no']}</strong></td>
                        <td><strong>{$row['invoice_no']}</strong></td>
                        <td>{$row['user_full_name']}</td>
                        <td>{$row['user_phone']}</td>
                        <td>{$row['user_email']}</td>
                        <td class='address-cell' title='{$row['user_address']}'>{$row['user_address']}</td>
                        <td>{$row['product_id']}</td>
                        <td>{$row['product_quantity']}</td>
                        <td class='total-price'>{$row['total_price']} Tk</td>
                        <td>" . date('M d, Y', strtotime($row['order_date'])) . "</td>
                        <td>{$row['payment_method']}</td>
                        <td class='order-status'>{$row['order_status']}</td>
                      </tr>";
            }
        } else {
            echo "<tr>
                    <td colspan='12' class='empty-state'>
                      <i class='mdi mdi-package-variant'></i>
                      <p>No orders found</p>
                    </td>
                  </tr>";
        }
        ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
<script>
function exportToExcel() {
  // Get the table
  const table = document.getElementById('historyTable');
  
  // Create a workbook
  const wb = XLSX.utils.book_new();
  
  // Convert table to worksheet
  const ws = XLSX.utils.table_to_sheet(table);
  
  // Add worksheet to workbook
  XLSX.utils.book_append_sheet(wb, ws, 'Purchase History');
  
  // Generate filename with current date
  const date = new Date().toISOString().split('T')[0];
  const filename = `purchase_history_${date}.xlsx`;
  
  // Save file
  XLSX.writeFile(wb, filename);
}
</script>

<?php require 'footer.php'; ?>