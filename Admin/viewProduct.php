<?php
$current_page = basename($_SERVER['PHP_SELF']); // Get the current page name
$page_title = 'View Products'; // Set the page title
?>
<?php require 'header.php'; ?>

<!--------------------------->
<!-- START MAIN AREA -->
<!--------------------------->
<div class="content-wrapper">
            <div class="page-header">
              <h3 class="page-title">
                <span class="page-title-icon bg-gradient-primary text-white me-2">
                  <i class="mdi mdi-home"></i>
                </span> Product
              </h3>
            </div>

            <div class="row">
              <h1>Product List</h1>
              <div class="container">
                
                <!-- Search Form -->
                <form method="GET" class="mb-4">
                  <div class="row">
                    <div class="col-md-6">
                      <label for="search"><b>Search Your Product:</b></label>
                      <div class="d-flex">
                        <input type="text" name="search" id="search" class="form-control me-2"
                              placeholder="Enter product title or code"
                              value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">

                        <button type="submit" class="btn btn-primary me-2">Search</button>

                        <!-- Reset Button -->
                        <?php if (isset($_GET['search']) && $_GET['search'] !== ''): ?>
                          <a href="<?php echo strtok($_SERVER["REQUEST_URI"], '?'); ?>" class="btn btn-dark d-flex align-items-center" title="Reset Search">
                            Reset
                          </a>
                        <?php endif; ?>
                      </div>
                    </div>
                  </div>
                </form>


                <!-- Table -->
                <div class="table-responsive">
                  <table class="table table-bordered table-hover">
                    <thead class="thead-dark">
                      <tr>
                        <td>ID</td>
                        <td>Image</td>
                        <td>Title</td>
                        <td>Code</td>
                        <td>Main Category</td>
                        <td>Sub Category</td>
                        <td>Available Quantity</td>
                        <td>Regular Price</td>
                        <td>Selling Price</td>
                        <td>Actions</td>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                        // Get search keyword
                        $search = isset($_GET['search']) ? trim($_GET['search']) : '';

                        // SQL query with optional search condition
                        $sql = "SELECT p.*, mc.main_ctg_name, sc.sub_ctg_name 
                                FROM product_info p
                                LEFT JOIN main_category mc ON p.main_ctg_id = mc.main_ctg_id
                                LEFT JOIN sub_category sc ON p.sub_ctg_id = sc.sub_ctg_id";

                        if (!empty($search)) {
                            $search_safe = mysqli_real_escape_string($conn, $search);
                            $sql .= " WHERE p.product_title LIKE '%$search_safe%' OR p.product_code LIKE '%$search_safe%'";
                        }

                        $sql .= " ORDER BY p.product_id DESC";
                        $result = mysqli_query($conn, $sql);

                        if (mysqli_num_rows($result) > 0) {
                          while ($item = mysqli_fetch_array($result)) {
                            echo "<tr>
                                    <td>{$item['product_id']}</td>
                                    <td><img src='../img/{$item['product_img1']}' alt='img' style='width: 50px; height: 50px;'></td>
                                    <td>{$item['product_title']}</td>
                                    <td>{$item['product_code']}</td>
                                    <td>{$item['main_ctg_name']}</td>
                                    <td>{$item['sub_ctg_name']}</td>
                                    <td>{$item['available_stock']}</td>
                                    <td>৳ {$item['product_regular_price']}</td>
                                    <td>৳ {$item['product_price']}</td>
                                    <td>
                                      <button class='btn btn-dark btn-sm' onclick='confirmEdit({$item['product_id']})'>
                                        <span>Edit</span> <span class='mdi mdi-square-edit-outline'></span>
                                      </button>
                                      <button class='btn btn-dark btn-sm' onclick='confirmDelete({$item['product_id']})'>
                                        <span>Delete</span> <span class='mdi mdi-trash-can-outline'></span>
                                      </button>
                                    </td>
                                  </tr>";
                          }
                        } else {
                          echo "<tr><td colspan='10' class='text-center text-danger'>No matching products found.</td></tr>";
                        }
                      ?>
                    </tbody>
                  </table>
                </div>

              </div>
            </div>
</div>
<!--------------------------->
<!-- END MAIN AREA -->
<!--------------------------->
<script>
      function confirmEdit(productId) {
        window.location.href = `editProduct.php?id=${productId}`;
      }

      function confirmDelete(productId) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = `deleteProduct.php?id=${productId}`;
            }
        });
      }
</script>
<?php require 'footer.php'; ?>
