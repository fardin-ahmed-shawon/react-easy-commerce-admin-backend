<?php
$current_page = basename($_SERVER['PHP_SELF']);
$page_title = 'View Products';
?>
<?php require 'header.php'; ?>

<?php
// Build query with search, filter and sort
$whereClause = "1=1";
$orderBy = "p.product_id DESC";

// Search functionality
if (isset($_GET['search']) && !empty($_GET['search'])) {
  $searchQuery = $conn->real_escape_string($_GET['search']);
  $searchField = isset($_GET['search_field']) ? $_GET['search_field'] : 'p.product_title';
  $whereClause .= " AND $searchField LIKE '%$searchQuery%'";
}

// Category filters
if (isset($_GET['main_category']) && !empty($_GET['main_category'])) {
  $mainCat = $conn->real_escape_string($_GET['main_category']);
  $whereClause .= " AND p.main_ctg_id = '$mainCat'";
}

if (isset($_GET['sub_category']) && !empty($_GET['sub_category'])) {
  $subCat = $conn->real_escape_string($_GET['sub_category']);
  $whereClause .= " AND p.sub_ctg_id = '$subCat'";
}

// Stock filter
if (isset($_GET['stock_status']) && !empty($_GET['stock_status'])) {
  $stockStatus = $_GET['stock_status'];
  if ($stockStatus == 'in_stock') {
    $whereClause .= " AND p.available_stock > 0";
  } elseif ($stockStatus == 'out_of_stock') {
    $whereClause .= " AND p.available_stock = 0";
  } elseif ($stockStatus == 'low_stock') {
    $whereClause .= " AND p.available_stock > 0 AND p.available_stock <= 10";
  }
}

// Sort functionality
if (isset($_GET['sort_by']) && !empty($_GET['sort_by'])) {
  $sortBy = $conn->real_escape_string($_GET['sort_by']);
  $sortOrder = isset($_GET['sort_order']) ? $_GET['sort_order'] : 'ASC';
  $orderBy = "$sortBy $sortOrder";
}

$sql = "SELECT p.*, mc.main_ctg_name, sc.sub_ctg_name 
        FROM product_info p
        LEFT JOIN main_category mc ON p.main_ctg_id = mc.main_ctg_id
        LEFT JOIN sub_category sc ON p.sub_ctg_id = sc.sub_ctg_id
        WHERE $whereClause
        ORDER BY $orderBy";

$result = mysqli_query($conn, $sql);

// Fetch categories for filters
$main_categories = mysqli_query($conn, "SELECT * FROM main_category ORDER BY main_ctg_name");
$sub_categories = mysqli_query($conn, "SELECT * FROM sub_category ORDER BY sub_ctg_name");
?>

<style>
  .products-container {
    max-width: 100%;
    margin: 0 auto;
    padding: 2rem;
    background: #ffffff;
  }

  .products-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 2rem;
    padding-bottom: 1rem;
    border-bottom: 2px solid #000;
  }

  .products-header h1 {
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

  .products-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 0.85rem;
  }

  .products-table thead {
    background: #000;
    color: #fff;
    position: sticky;
    top: 0;
    z-index: 10;
  }

  .products-table thead th {
    padding: 1rem 0.75rem;
    text-align: left;
    font-weight: 600;
    font-size: 0.8rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    border-right: 1px solid #333;
    white-space: nowrap;
  }

  .products-table thead th:last-child {
    border-right: none;
  }

  .products-table tbody tr {
    border-bottom: 1px solid #e0e0e0;
    transition: background 0.2s ease;
  }

  .products-table tbody tr:hover {
    background: #f8f8f8;
  }

  .products-table tbody td {
    padding: 0.85rem 0.75rem;
    vertical-align: middle;
    color: #333;
  }

  .product-img {
    width: 50px;
    height: 50px;
    object-fit: cover;
    border: 1px solid #e0e0e0;
  }

  .stock-badge {
    display: inline-block;
    padding: 0.35rem 0.75rem;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    border: 1px solid #000;
    background: #fff;
    color: #000;
  }

  .stock-low {
    border-color: #ff9800;
    color: #ff9800;
  }

  .stock-out {
    border-color: #f44336;
    color: #f44336;
  }

  .price-cell {
    font-weight: 700;
    color: #000;
  }

  .action-buttons {
    display: flex;
    gap: 0.5rem;
    flex-wrap: wrap;
  }

  .btn-edit,
  .btn-delete {
    padding: 0.4rem 0.85rem;
    font-size: 0.8rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s ease;
    border: none;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    display: inline-flex;
    align-items: center;
    gap: 0.35rem;
  }

  .btn-edit {
    background: #000;
    color: #fff;
  }

  .btn-edit:hover {
    background: #333;
  }

  .btn-delete {
    background: #fff;
    color: #000;
    border: 2px solid #000;
  }

  .btn-delete:hover {
    background: #000;
    color: #fff;
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
    .products-container {
      padding: 1rem;
    }

    .products-header {
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

    .products-table {
      font-size: 0.75rem;
    }
  }
</style>

<div class="content-wrapper">
  <div class="page-header">
    <h3 class="page-title">
      <span class="page-title-icon bg-gradient-primary text-white me-2">
        <i class="mdi mdi-package-variant"></i>
      </span> Product
    </h3>
  </div>
  <div class="products-container">
    <div class="products-header">
      <h1>Product List</h1>
      <button class="btn-export" onclick="exportToExcel()">
        <span class="mdi mdi-file-excel"></span>
        Export to Excel
      </button>
    </div>

    <!-- Search & Filter Section -->
    <div class="search-filters">
      <form method="GET" action="viewProduct.php">
        <div class="filter-row">
          <div class="filter-group">
            <label>Search By</label>
            <select name="search_field" class="filter-select">
              <option value="p.product_title" <?php echo (isset($_GET['search_field']) && $_GET['search_field'] == 'p.product_title') ? 'selected' : ''; ?>>Product Title</option>
              <option value="p.product_code" <?php echo (isset($_GET['search_field']) && $_GET['search_field'] == 'p.product_code') ? 'selected' : ''; ?>>SKU/Product Code</option>
              <option value="p.product_id" <?php echo (isset($_GET['search_field']) && $_GET['search_field'] == 'p.product_id') ? 'selected' : ''; ?>>Product ID</option>
            </select>
          </div>

          <div class="filter-group">
            <label>Search Value</label>
            <input type="text" name="search" class="filter-input" placeholder="Enter search term..."
              value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
          </div>

          <div class="filter-group">
            <label>Main Category</label>
            <select name="main_category" class="filter-select">
              <option value="">All Categories</option>
              <?php
              mysqli_data_seek($main_categories, 0);
              while ($cat = mysqli_fetch_assoc($main_categories)) {
                $selected = (isset($_GET['main_category']) && $_GET['main_category'] == $cat['main_ctg_id']) ? 'selected' : '';
                echo "<option value='{$cat['main_ctg_id']}' $selected>{$cat['main_ctg_name']}</option>";
              }
              ?>
            </select>
          </div>

          <div class="filter-group">
            <label>Sub Category</label>
            <select name="sub_category" class="filter-select">
              <option value="">All Sub Categories</option>
              <?php
              mysqli_data_seek($sub_categories, 0);
              while ($subcat = mysqli_fetch_assoc($sub_categories)) {
                $selected = (isset($_GET['sub_category']) && $_GET['sub_category'] == $subcat['sub_ctg_id']) ? 'selected' : '';
                echo "<option value='{$subcat['sub_ctg_id']}' $selected>{$subcat['sub_ctg_name']}</option>";
              }
              ?>
            </select>
          </div>

          <div class="filter-group">
            <label>Stock Status</label>
            <select name="stock_status" class="filter-select">
              <option value="">All Stock</option>
              <option value="in_stock" <?php echo (isset($_GET['stock_status']) && $_GET['stock_status'] == 'in_stock') ? 'selected' : ''; ?>>In Stock</option>
              <option value="low_stock" <?php echo (isset($_GET['stock_status']) && $_GET['stock_status'] == 'low_stock') ? 'selected' : ''; ?>>Low Stock (≤10)</option>
              <option value="out_of_stock" <?php echo (isset($_GET['stock_status']) && $_GET['stock_status'] == 'out_of_stock') ? 'selected' : ''; ?>>Out of Stock</option>
            </select>
          </div>

          <div class="filter-group">
            <label>Sort By</label>
            <select name="sort_by" class="filter-select">
              <option value="p.product_id" <?php echo (isset($_GET['sort_by']) && $_GET['sort_by'] == 'p.product_id') ? 'selected' : ''; ?>>Product ID</option>
              <option value="p.product_title" <?php echo (isset($_GET['sort_by']) && $_GET['sort_by'] == 'p.product_title') ? 'selected' : ''; ?>>Product Title</option>
              <option value="p.product_price" <?php echo (isset($_GET['sort_by']) && $_GET['sort_by'] == 'p.product_price') ? 'selected' : ''; ?>>Price</option>
              <option value="p.available_stock" <?php echo (isset($_GET['sort_by']) && $_GET['sort_by'] == 'p.available_stock') ? 'selected' : ''; ?>>Stock</option>
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
          <a href="viewProduct.php" class="btn-reset" style="text-decoration: none; display: inline-flex; align-items: center; justify-content: center;">
            <span class="mdi mdi-refresh"></span> Reset Filters
          </a>
        </div>
      </form>
    </div>

    <!-- Table Info -->
    <div class="table-info">
      <span class="total-count">
        <span class="mdi mdi-package-variant"></span>
        Total Products: <?php echo mysqli_num_rows($result); ?>
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
      <table class="products-table" id="productsTable">
        <thead>
          <tr>
            <th style="width: 60px;">ID</th>
            <th style="width: 80px;">Image</th>
            <th>Title</th>
            <th style="width: 120px;">SKU</th>
            <th style="width: 150px;">Main Category</th>
            <th style="width: 150px;">Sub Category</th>
            <th style="width: 100px;">Stock</th>
            <th style="width: 100px;">Regular Price</th>
            <th style="width: 100px;">Selling Price</th>
            <th style="width: 180px;">Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php
          if ($result && mysqli_num_rows($result) > 0) {
            while ($item = mysqli_fetch_assoc($result)) {
              $stock = (int)$item['available_stock'];
              $stockClass = '';
              $stockBadge = '';

              if ($stock == 0) {
                $stockClass = 'stock-out';
                $stockBadge = 'Out of Stock';
              } elseif ($stock <= 10) {
                $stockClass = 'stock-low';
                $stockBadge = 'Low Stock';
              } else {
                $stockBadge = 'In Stock';
              }

              echo '<tr>';
              echo '<td><strong>' . htmlspecialchars($item['product_id']) . '</strong></td>';
              echo '<td><img src="../img/' . htmlspecialchars($item['product_img1']) . '" alt="img" class="product-img"></td>';
              echo '<td>' . htmlspecialchars($item['product_title']) . '</td>';
              echo '<td>' . htmlspecialchars($item['product_code']) . '</td>';
              echo '<td>' . htmlspecialchars($item['main_ctg_name']) . '</td>';
              echo '<td>' . htmlspecialchars($item['sub_ctg_name']) . '</td>';
              echo '<td><span class="stock-badge ' . $stockClass . '">' . $stock . ' - ' . $stockBadge . '</span></td>';
              echo '<td class="price-cell">৳ ' . htmlspecialchars($item['product_regular_price']) . '</td>';
              echo '<td class="price-cell">৳ ' . htmlspecialchars($item['product_price']) . '</td>';
              echo '<td>';
              echo '<div class="action-buttons">';
              echo '<button class="btn-edit" onclick="confirmEdit(' . $item['product_id'] . ')"><span class="mdi mdi-pencil"></span> Edit</button>';
              echo '<button class="btn-delete" onclick="confirmDelete(' . $item['product_id'] . ')"><span class="mdi mdi-delete"></span> Delete</button>';
              echo '</div>';
              echo '</td>';
              echo '</tr>';
            }
          } else {
            echo "<tr><td colspan='10' class='empty-state'>
                  <i class='mdi mdi-package-variant-closed'></i>
                  <p>No products found</p>
                </td></tr>";
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
    // Clone the table to modify it for export
    const table = document.getElementById('productsTable').cloneNode(true);

    // Remove image column (column index 1)
    const rows = table.querySelectorAll('tr');
    rows.forEach(row => {
      const cells = row.querySelectorAll('td, th');
      if (cells[1]) cells[1].remove(); // Remove image column
    });

    // Create workbook
    const wb = XLSX.utils.book_new();

    // Convert table to worksheet
    const ws = XLSX.utils.table_to_sheet(table);

    // Add worksheet to workbook
    XLSX.utils.book_append_sheet(wb, ws, 'Products');

    // Generate filename with current date
    const date = new Date().toISOString().split('T')[0];
    const filename = `products_${date}.xlsx`;

    // Save file
    XLSX.writeFile(wb, filename);
  }

  function confirmEdit(productId) {
    window.location.href = `editProduct.php?id=${productId}`;
  }

  function confirmDelete(productId) {
    Swal.fire({
      title: 'Delete Product?',
      text: "This action cannot be undone",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#000',
      cancelButtonColor: '#999',
      confirmButtonText: 'Yes, Delete',
      cancelButtonText: 'Cancel',
      customClass: {
        popup: 'swal-minimal',
        confirmButton: 'swal-btn-confirm',
        cancelButton: 'swal-btn-cancel'
      }
    }).then((result) => {
      if (result.isConfirmed) {
        window.location.href = `deleteProduct.php?id=${productId}`;
      }
    });
  }
</script>

<?php require 'footer.php'; ?>