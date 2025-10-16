<?php
$current_page = basename($_SERVER['PHP_SELF']);
$page_title = 'Customized Product List';
require 'header.php';
?>

<div class="content-wrapper">
  <div class="container-fluid">
    <div class="page-header d-flex justify-content-between align-items-center mb-4">
      <h3 class="page-title mb-0">
        <span class="page-title-icon bg-gradient-primary text-white me-2">
          <i class="mdi mdi-tshirt-crew-outline"></i>
        </span> Customized Product List
      </h3>
      <a href="create_customized_product.php" class="btn btn-primary">
        <i class="mdi mdi-plus"></i> Add New Product
      </a>
    </div>

    <!-- optional search (simple) -->
    <form method="get" class="mb-4 row gx-2 gy-2 align-items-center">
      <div class="col-4">
        <input type="text" name="q" class="form-control" placeholder="Search title or code" value="<?php echo isset($_GET['q']) ? htmlspecialchars($_GET['q'], ENT_QUOTES) : ''; ?>">
      </div>
      <div class="col-3">
        <select name="category" class="form-control">
          <option value="">All Categories</option>
          <?php
          $catRes = mysqli_query($conn, "SELECT id, category_name FROM customized_category ORDER BY category_name ASC");
          while ($c = mysqli_fetch_assoc($catRes)) {
            $sel = (isset($_GET['category']) && $_GET['category'] == $c['id']) ? 'selected' : '';
            echo "<option value=\"" . htmlspecialchars($c['id']) . "\" $sel>" . htmlspecialchars($c['category_name']) . "</option>";
          }
          ?>
        </select>
      </div>
      <div class="col-3">
        <button class="btn btn-sm btn-dark p-3 px-4" type="submit">Filter</button>
      </div>
    </form>

    <div class="row">
      <?php
      // Build query with optional filters
      $where = [];
      $params = [];

      if (!empty($_GET['q'])) {
        $q = '%' . $_GET['q'] . '%';
        $where[] = "(p.product_title LIKE ? OR p.product_code LIKE ?)";
        $params[] = $q;
        $params[] = $q;
      }
      if (!empty($_GET['category'])) {
        $where[] = "p.category_id = ?";
        $params[] = intval($_GET['category']);
      }

      $sql = "SELECT p.*, c.category_name
              FROM customized_products p
              LEFT JOIN customized_category c ON p.category_id = c.id";

      if ($where) {
        $sql .= " WHERE " . implode(" AND ", $where);
      }

      $sql .= " ORDER BY p.id DESC";

      // Prepared statement
      $stmt = mysqli_prepare($conn, $sql);
      if ($stmt) {
        if (!empty($params)) {
          // build types string
          $types = '';
          foreach ($params as $pt) {
            $types .= is_int($pt) ? 'i' : 's';
          }
          mysqli_stmt_bind_param($stmt, $types, ...$params);
        }
        mysqli_stmt_execute($stmt);
        $res = mysqli_stmt_get_result($stmt);
      } else {
        // fallback when prepare fails
        $res = mysqli_query($conn, $sql);
      }

      if ($res && mysqli_num_rows($res) > 0):
        while ($row = mysqli_fetch_assoc($res)):
          $img = !empty($row['product_img']) ? htmlspecialchars($row['product_img']) : 'assets/img/placeholder.png';
      ?>
        <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
          <div class="card h-100 shadow-sm border-0">
            <img src="<?php echo $img; ?>" class="card-img-top" alt="<?php echo htmlspecialchars($row['product_title']); ?>" style="height:250px; object-fit:cover;">

            <div class="card-body d-flex flex-column">
              <span class="badge bg-gradient-primary mb-2" style="width:fit-content;">
                <?php echo htmlspecialchars($row['category_name'] ?? 'Uncategorized'); ?>
              </span>

              <h5 class="card-title fw-bold text-dark"><?php echo htmlspecialchars($row['product_title']); ?></h5>

              <p class="card-text text-muted mb-2" style="min-height:48px; overflow:hidden;">
                <?php echo htmlspecialchars(mb_substr(strip_tags($row['product_description']),0,80)); ?><?php echo (mb_strlen($row['product_description'])>80)?'...':''; ?>
              </p>

              <div class="mt-auto">
                <div class="d-flex justify-content-between align-items-center mb-2">
                  <small class="text-muted">Advance: ৳ <?php echo number_format(intval($row['advance_amount']), 2); ?></small>
                  <small class="text-muted">Code: <?php echo htmlspecialchars($row['product_code'] ?? '-'); ?></small>
                </div>

                <div class="d-flex gap-2">
                  
                  <a href="edit-customized-product.php?id=<?php echo $row['id']; ?>" class="btn btn-dark mb-0">
                    <i class="mdi mdi-pencil"></i> Edit
                  </a>
                  <button class="btn btn-danger" onclick="confirmDelete(<?php echo $row['id']; ?>)">
                    <i class="mdi mdi-delete"></i> Delete
                  </button>
                </div>
                
              </div>
            </div>
          </div>
        </div>
      <?php
        endwhile;
      else:
      ?>
        <div class="col-12 text-center py-5">
          <h5 class="text-muted">No customized products found.</h5>
          <a href="create_customized_product.php" class="btn btn-primary mt-3">Add Product</a>
        </div>
      <?php endif; ?>

    </div>
  </div>
</div>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function confirmDelete(id) {
  Swal.fire({
    title: 'Are you sure?',
    text: "This product will be permanently deleted!",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#d33',
    cancelButtonColor: '#3085d6',
    confirmButtonText: 'Yes, delete it!'
  }).then((result) => {
    if (result.isConfirmed) {
      // call delete endpoint
      fetch('delete_customized_product.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/json'},
        body: JSON.stringify({ id: id })
      })
      .then(res => res.json())
      .then(json => {
        if (json.success) {
          Swal.fire({ icon: 'success', title: 'Deleted', text: json.message, timer: 1200, showConfirmButton: false })
            .then(() => location.reload());
        } else {
          Swal.fire('Error', json.message || 'Could not delete', 'error');
        }
      })
      .catch(() => Swal.fire('Error','Request failed','error'));
    }
  });
}
</script>

<style>
.card { transition: transform .25s ease, box-shadow .25s ease; border-radius: 10px; }
.card:hover { transform: translateY(-6px); box-shadow: 0 10px 20px rgba(0,0,0,0.08) !important; }
</style>

<?php require 'footer.php'; ?>