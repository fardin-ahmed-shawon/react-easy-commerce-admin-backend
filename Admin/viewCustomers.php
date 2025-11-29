<?php
$current_page = basename($_SERVER['PHP_SELF']);
$page_title = 'View Customers';
?>
<?php require 'header.php'; ?>

<?php
// Build query with search and sort
$whereClause = "1=1";
$orderBy = "user_id DESC";

// Search functionality
if (isset($_GET['search']) && !empty($_GET['search'])) {
    $searchQuery = $conn->real_escape_string($_GET['search']);
    $searchField = isset($_GET['search_field']) ? $_GET['search_field'] : 'user_fName';
    $whereClause .= " AND $searchField LIKE '%$searchQuery%'";
}

// Gender filter
if (isset($_GET['gender']) && !empty($_GET['gender'])) {
    $gender = $conn->real_escape_string($_GET['gender']);
    $whereClause .= " AND user_gender = '$gender'";
}

// Sort functionality
if (isset($_GET['sort_by']) && !empty($_GET['sort_by'])) {
    $sortBy = $conn->real_escape_string($_GET['sort_by']);
    $sortOrder = isset($_GET['sort_order']) ? $_GET['sort_order'] : 'ASC';
    $orderBy = "$sortBy $sortOrder";
}

$sql = "SELECT user_id, user_fName, user_lName, user_phone, user_email, user_gender FROM user_info WHERE $whereClause ORDER BY $orderBy";
$result = $conn->query($sql);
?>

<style>
.customers-container {
  max-width: 100%;
  margin: 0 auto;
  padding: 2rem;
  background: #ffffff;
}

.customers-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 2rem;
  padding-bottom: 1rem;
  border-bottom: 2px solid #000;
}

.customers-header h1 {
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

.table-info {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 1rem;
  padding: 0.75rem;
  background: #f8f8f8;
  border: 1px solid #e0e0e0;
  font-size: 0.9rem;
}

.total-count {
  font-weight: 600;
  color: #000;
}

.table-container {
  overflow-x: auto;
  background: #fff;
  border: 1px solid #e0e0e0;
  max-height: 600px;
  overflow-y: auto;
}

.customers-table {
  width: 100%;
  border-collapse: collapse;
  font-size: 0.9rem;
}

.customers-table thead {
  background: #000;
  color: #fff;
  position: sticky;
  top: 0;
  z-index: 10;
}

.customers-table thead th {
  padding: 1rem 0.75rem;
  text-align: left;
  font-weight: 600;
  font-size: 0.85rem;
  text-transform: uppercase;
  letter-spacing: 0.5px;
  border-right: 1px solid #333;
  white-space: nowrap;
}

.customers-table thead th:last-child {
  border-right: none;
}

.customers-table tbody tr {
  border-bottom: 1px solid #e0e0e0;
  transition: background 0.2s ease;
}

.customers-table tbody tr:hover {
  background: #f8f8f8;
}

.customers-table tbody td {
  padding: 1rem 0.75rem;
  vertical-align: middle;
  color: #333;
}

.customers-table tbody td:first-child {
  font-weight: 600;
  color: #000;
}

.gender-badge {
  display: inline-block;
  padding: 0.35rem 0.75rem;
  font-size: 0.8rem;
  font-weight: 600;
  text-transform: uppercase;
  letter-spacing: 0.5px;
  border: 1px solid #000;
  background: #fff;
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
  .customers-container {
    padding: 1rem;
  }
  
  .customers-header {
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
  
  .table-info {
    flex-direction: column;
    gap: 0.5rem;
    align-items: flex-start;
  }
  
  .customers-table {
    font-size: 0.8rem;
  }
}
</style>

<div class="content-wrapper">
  <div class="customers-container">
    <div class="customers-header">
      <h1>Your Customer List</h1>
      <button class="btn-export" onclick="exportToExcel()">
        <span class="mdi mdi-file-excel"></span>
        Export to Excel
      </button>
    </div>

    <!-- Search & Filter Section -->
    <div class="search-filters">
      <form method="GET" action="viewCustomers.php">
        <div class="filter-row">
          <div class="filter-group">
            <label>Search By</label>
            <select name="search_field" class="filter-select">
              <option value="user_fName" <?php echo (isset($_GET['search_field']) && $_GET['search_field'] == 'user_fName') ? 'selected' : ''; ?>>First Name</option>
              <option value="user_lName" <?php echo (isset($_GET['search_field']) && $_GET['search_field'] == 'user_lName') ? 'selected' : ''; ?>>Last Name</option>
              <option value="user_phone" <?php echo (isset($_GET['search_field']) && $_GET['search_field'] == 'user_phone') ? 'selected' : ''; ?>>Phone Number</option>
              <option value="user_email" <?php echo (isset($_GET['search_field']) && $_GET['search_field'] == 'user_email') ? 'selected' : ''; ?>>Email</option>
              <option value="user_id" <?php echo (isset($_GET['search_field']) && $_GET['search_field'] == 'user_id') ? 'selected' : ''; ?>>Customer ID</option>
            </select>
          </div>

          <div class="filter-group">
            <label>Search Value</label>
            <input type="text" name="search" class="filter-input" placeholder="Enter search term..." 
                   value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
          </div>

          <div class="filter-group">
            <label>Gender</label>
            <select name="gender" class="filter-select">
              <option value="">All Genders</option>
              <option value="Male" <?php echo (isset($_GET['gender']) && $_GET['gender'] == 'Male') ? 'selected' : ''; ?>>Male</option>
              <option value="Female" <?php echo (isset($_GET['gender']) && $_GET['gender'] == 'Female') ? 'selected' : ''; ?>>Female</option>
              <option value="Other" <?php echo (isset($_GET['gender']) && $_GET['gender'] == 'Other') ? 'selected' : ''; ?>>Other</option>
            </select>
          </div>

          <div class="filter-group">
            <label>Sort By</label>
            <select name="sort_by" class="filter-select">
              <option value="user_id" <?php echo (isset($_GET['sort_by']) && $_GET['sort_by'] == 'user_id') ? 'selected' : ''; ?>>Customer ID</option>
              <option value="user_fName" <?php echo (isset($_GET['sort_by']) && $_GET['sort_by'] == 'user_fName') ? 'selected' : ''; ?>>First Name</option>
              <option value="user_lName" <?php echo (isset($_GET['sort_by']) && $_GET['sort_by'] == 'user_lName') ? 'selected' : ''; ?>>Last Name</option>
              <option value="user_email" <?php echo (isset($_GET['sort_by']) && $_GET['sort_by'] == 'user_email') ? 'selected' : ''; ?>>Email</option>
            </select>
          </div>

          <div class="filter-group">
            <label>Sort Order</label>
            <select name="sort_order" class="filter-select">
              <option value="ASC" <?php echo (isset($_GET['sort_order']) && $_GET['sort_order'] == 'ASC') ? 'selected' : ''; ?>>Ascending</option>
              <option value="DESC" <?php echo (isset($_GET['sort_order']) && $_GET['sort_order'] == 'DESC') ? 'selected' : ''; ?>>Descending</option>
            </select>
          </div>
        </div>

        <div class="search-actions">
          <button type="submit" class="btn-search">
            <span class="mdi mdi-magnify"></span> Search
          </button>
          <a href="viewCustomers.php" class="btn-reset" style="text-decoration: none; display: inline-flex; align-items: center; justify-content: center;">
            <span class="mdi mdi-refresh"></span> Reset Filters
          </a>
        </div>
      </form>
    </div>

    <!-- Table Info -->
    <div class="table-info">
      <span class="total-count">
        <span class="mdi mdi-account-multiple"></span>
        Total Customers: <?php echo $result->num_rows; ?>
      </span>
      <span style="color: #666;">
        <?php 
        if (isset($_GET['search']) && !empty($_GET['search'])) {
            echo "Showing search results for: <strong>" . htmlspecialchars($_GET['search']) . "</strong>";
        }
        ?>
      </span>
    </div>

    <!-- Table -->
    <div class="table-container">
      <table class="customers-table" id="customersTable">
        <thead>
          <tr>
            <th style="width: 80px;">Serial</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Customer ID</th>
            <th>Phone</th>
            <th>Email</th>
            <th style="width: 100px;">Gender</th>
          </tr>
        </thead>
        <tbody>
        <?php
        if ($result->num_rows > 0) {
            $serialNo = 1;
            while($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$serialNo}</td>
                        <td>{$row['user_fName']}</td>
                        <td>{$row['user_lName']}</td>
                        <td><strong>{$row['user_id']}</strong></td>
                        <td>{$row['user_phone']}</td>
                        <td>{$row['user_email']}</td>
                        <td><span class='gender-badge'>{$row['user_gender']}</span></td>
                      </tr>";
                $serialNo++;
            }
        } else {
            echo "<tr>
                    <td colspan='7' class='empty-state'>
                      <i class='mdi mdi-account-off'></i>
                      <p>No customers found</p>
                    </td>
                  </tr>";
        }
        $conn->close();
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
  const table = document.getElementById('customersTable');
  
  // Create a workbook
  const wb = XLSX.utils.book_new();
  
  // Convert table to worksheet
  const ws = XLSX.utils.table_to_sheet(table);
  
  // Add worksheet to workbook
  XLSX.utils.book_append_sheet(wb, ws, 'Customers');
  
  // Generate filename with current date
  const date = new Date().toISOString().split('T')[0];
  const filename = `customers_${date}.xlsx`;
  
  // Save file
  XLSX.writeFile(wb, filename);
}
</script>

<?php require 'footer.php'; ?>