<?php
$current_page = basename($_SERVER['PHP_SELF']);
$page_title = 'Add Coupon';
?>
<?php require 'header.php'; ?>

<?php
// Handle AJAX delete request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
    $delete_id = intval($_POST['delete_id']);
    $stmt = $conn->prepare("DELETE FROM coupon WHERE id = ?");
    $stmt->bind_param("i", $delete_id);
    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Coupon deleted successfully!']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to delete coupon.']);
    }
    $stmt->close();
    exit;
}

// Handle Add/Edit
if ($_SERVER['REQUEST_METHOD'] == 'POST' && !isset($_POST['delete_id'])) {
    $coupon_name = $_POST['coupon_name'];
    $coupon_code = $_POST['coupon_code'];
    $discount_price = $_POST['discount_price'];
    $edit_id = isset($_POST['edit_id']) ? intval($_POST['edit_id']) : 0;

    if (empty($coupon_name) || empty($coupon_code) || empty($discount_price)) {
        $error_message = "All fields are required.";
    } else {
        if ($edit_id > 0) {
            // Update existing coupon
            $sql = "UPDATE coupon SET coupon_name=?, coupon_code=?, coupon_discount=? WHERE id=?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssi", $coupon_name, $coupon_code, $discount_price, $edit_id);
            if ($stmt->execute()) {
                $success_message = "Coupon updated successfully!";
            } else {
                $error_message = "Error: " . $stmt->error;
            }
            $stmt->close();
        } else {
            // Insert new coupon
            $sql = "INSERT INTO coupon (coupon_name, coupon_code, coupon_discount, free_shipping, created_at) 
                    VALUES (?, ?, ?, '0', NOW())";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sss", $coupon_name, $coupon_code, $discount_price);
            if ($stmt->execute()) {
                $success_message = "Coupon added successfully!";
            } else {
                $error_message = "Error: " . $stmt->error;
            }
            $stmt->close();
        }
    }
}

// Fetch coupons
$result = $conn->query("SELECT * FROM coupon ORDER BY id DESC");
?>

<style>
.coupon-container {
  max-width: 100%;
  margin: 0 auto;
  padding: 2rem;
  background: #ffffff;
}

.coupon-header {
  margin-bottom: 2rem;
  padding-bottom: 1rem;
  border-bottom: 2px solid #000;
}

.coupon-header h1 {
  font-size: 1.75rem;
  font-weight: 600;
  color: #000;
  margin: 0;
  letter-spacing: -0.5px;
}

/* Alert Messages */
.alert-success {
  padding: 1rem 1.5rem;
  background: #D1E7DD;
  color: #0A3622;
  border-left: 4px solid #0A3622;
  margin-bottom: 2rem;
  font-weight: 500;
}

.alert-error {
  padding: 1rem 1.5rem;
  background: #F8D7DA;
  color: #842029;
  border-left: 4px solid #842029;
  margin-bottom: 2rem;
  font-weight: 500;
}

/* Grid Layout */
.coupon-grid {
  display: grid;
  grid-template-columns: 400px 1fr;
  gap: 2rem;
}

/* Form Section */
.form-section {
  background: #f8f8f8;
  border: 1px solid #ccc;
  padding: 2rem;
  height: fit-content;
}

.form-section h2 {
  font-size: 1.25rem;
  font-weight: 600;
  color: #000;
  margin-bottom: 2rem;
  letter-spacing: -0.5px;
  text-transform: uppercase;
}

.form-group {
  margin-bottom: 1.5rem;
}

.form-label {
  display: block;
  font-size: 0.9rem;
  font-weight: 600;
  color: #000;
  margin-bottom: 0.5rem;
  text-transform: uppercase;
  letter-spacing: 0.5px;
}

.form-input {
  width: 100%;
  padding: 0.75rem 1rem;
  border: 1px solid #ccc;
  background: #fff;
  font-size: 0.9rem;
  font-weight: 500;
  color: #000;
  transition: all 0.2s ease;
}

.form-input:focus {
  outline: none;
  background: #f8f8f8;
}

.form-input::placeholder {
  color: #999;
}

.form-input:read-only {
  background: #e0e0e0;
  cursor: not-allowed;
}

/* Code Generator */
.code-generator {
  display: flex;
  gap: 0.5rem;
}

.code-generator .form-input {
  flex: 1;
  font-family: monospace;
  font-weight: 700;
  font-size: 1rem;
  letter-spacing: 2px;
}

.btn-generate {
  padding: 0.75rem 1.25rem;
  background: #000;
  color: #fff;
  border: none;
  font-size: 0.85rem;
  font-weight: 600;
  cursor: pointer;
  transition: all 0.2s ease;
  text-transform: uppercase;
  letter-spacing: 0.5px;
  white-space: nowrap;
  display: flex;
  align-items: center;
  gap: 0.5rem;
}

.btn-generate:hover {
  background: #333;
}

.form-hint {
  font-size: 0.8rem;
  color: #666;
  margin-top: 0.5rem;
}

.form-actions {
  display: flex;
  gap: 0.75rem;
}

.btn-submit,
.btn-cancel {
  padding: 0.75rem 1.5rem;
  font-size: 0.9rem;
  font-weight: 600;
  cursor: pointer;
  transition: all 0.2s ease;
  border: none;
  text-transform: uppercase;
  letter-spacing: 0.5px;
  flex: 1;
}

.btn-submit {
  background: #000;
  color: #fff;
}

.btn-submit:hover {
  background: #333;
}

.btn-cancel {
  background: #fff;
  color: #000;
  border: 1px solid #ccc;
}

.btn-cancel:hover {
  background: #000;
  color: #fff;
}

.d-none {
  display: none;
}

/* Table Section */
.table-section {
  background: #fff;
  border: 1px solid #ccc;
}

.table-header {
  background: #f8f8f8;
  padding: 1.5rem;
  border-bottom: 1px solid #e0e0e0;
}

.table-header h2 {
  font-size: 1.25rem;
  font-weight: 600;
  color: #000;
  margin: 0;
  text-transform: uppercase;
  letter-spacing: 0.5px;
}

.table-info {
  padding: 1rem 1.5rem;
  background: #f8f8f8;
  border-bottom: 1px solid #e0e0e0;
  font-size: 0.9rem;
  font-weight: 600;
  color: #000;
}

.table-container {
  overflow-x: auto;
  max-height: 500px;
  overflow-y: auto;
}

.coupon-table {
  width: 100%;
  border-collapse: collapse;
  font-size: 0.9rem;
}

.coupon-table thead {
  background: #000;
  color: #fff;
  position: sticky;
  top: 0;
  z-index: 10;
}

.coupon-table thead th {
  padding: 1rem 0.75rem;
  text-align: left;
  font-weight: 600;
  font-size: 0.85rem;
  text-transform: uppercase;
  letter-spacing: 0.5px;
  border-right: 1px solid #333;
}

.coupon-table thead th:last-child {
  border-right: none;
}

.coupon-table tbody tr {
  border-bottom: 1px solid #e0e0e0;
  transition: background 0.2s ease;
}

.coupon-table tbody tr:hover {
  background: #f8f8f8;
}

.coupon-table tbody td {
  padding: 1rem 0.75rem;
  vertical-align: middle;
  color: #333;
}

.coupon-table tbody td:first-child {
  font-weight: 600;
  color: #000;
}

.coupon-name {
  font-weight: 600;
  color: #000;
  font-size: 1rem;
}

.coupon-code {
  font-family: monospace;
  font-weight: 700;
  font-size: 0.95rem;
  color: #000;
  background: #f8f8f8;
  padding: 0.35rem 0.75rem;
  border: 1px solid #ccc;
  display: inline-block;
  letter-spacing: 2px;
}

.discount-badge {
  padding: 0.35rem 0.75rem;
  font-size: 0.85rem;
  font-weight: 700;
  background: #000;
  color: #fff;
  border: 1px solid #ccc;
  display: inline-block;
}

.action-buttons {
  display: flex;
  gap: 0.5rem;
}

.btn-edit,
.btn-delete {
  padding: 0.4rem 1rem;
  font-size: 0.8rem;
  font-weight: 600;
  cursor: pointer;
  transition: all 0.2s ease;
  text-transform: uppercase;
  letter-spacing: 0.5px;
  border: 1px solid #ccc;
  background: #fff;
  color: #000;
  text-decoration: none;
  display: inline-block;
}

.btn-edit:hover {
  background: #000;
  color: #fff;
}

.btn-delete {
  border-color: #dc3545;
  color: #dc3545;
}

.btn-delete:hover {
  background: #dc3545;
  color: #fff;
}

.empty-state {
  text-align: center;
  padding: 3rem 2rem;
  color: #999;
}

.empty-state i {
  font-size: 3rem;
  margin-bottom: 1rem;
  opacity: 0.5;
}

/* Responsive */
@media (max-width: 1200px) {
  .coupon-grid {
    grid-template-columns: 350px 1fr;
  }
}

@media (max-width: 992px) {
  .coupon-grid {
    grid-template-columns: 1fr;
  }
  
  .form-section {
    order: 1;
  }
  
  .table-section {
    order: 2;
  }
}

@media (max-width: 768px) {
  .coupon-container {
    padding: 1rem;
  }
  
  .coupon-header h1 {
    font-size: 1.5rem;
  }
  
  .form-section,
  .table-section {
    padding: 1.5rem;
  }
  
  .code-generator {
    flex-direction: column;
  }
  
  .btn-generate {
    width: 100%;
    justify-content: center;
  }
  
  .form-actions {
    flex-direction: column;
  }
  
  .coupon-table {
    font-size: 0.8rem;
  }
  
  .coupon-table thead th,
  .coupon-table tbody td {
    padding: 0.75rem 0.5rem;
  }
  
  .action-buttons {
    flex-direction: column;
  }
}
</style>

<div class="content-wrapper">

  <div class="page-header">
    <h3 class="page-title">
      <span class="page-title-icon bg-gradient-primary text-white me-2">
        <i class="mdi mdi-ticket-percent"></i>
      </span> Coupon Management
    </h3>
  </div>

  <div class="coupon-container">
    
    <!-- Alert Messages -->
    <?php
      if (isset($success_message)) {
        echo '<div class="alert-success">'.$success_message.'</div>';
      } else if (isset($error_message)) {
        echo '<div class="alert-error">'.$error_message.'</div>';
      }
    ?>

    <div class="coupon-header">
      <h1>Manage Coupons</h1>
    </div>

    <div class="coupon-grid">
      
      <!-- Form Section -->
      <div class="form-section">
        <h2 id="form-title">Add New Coupon</h2>
        
        <form action="" method="POST" id="coupon-form">
          <input type="hidden" name="edit_id" id="edit_id">
          
          <div class="form-group">
            <label class="form-label" for="coupon_name">Coupon Name *</label>
            <input 
              type="text" 
              class="form-input" 
              id="coupon_name"
              name="coupon_name" 
              placeholder="e.g., Summer Sale 2024" 
              required>
            <div class="form-hint">Enter a descriptive name for the coupon</div>
          </div>

          <div class="form-group">
            <label class="form-label" for="couponCode">Coupon Code *</label>
            <div class="code-generator">
              <input 
                type="text" 
                class="form-input" 
                id="couponCode"
                name="coupon_code" 
                placeholder="XXXXXXXXXX"
                readonly
                required>
              <button type="button" class="btn-generate" id="generateCode">
                <span class="mdi mdi-reload"></span>
                Generate
              </button>
            </div>
            <div class="form-hint">Click generate to create a unique code</div>
          </div>

          <div class="form-group">
            <label class="form-label" for="discount_price">Discount Percentage *</label>
            <input 
              type="number" 
              class="form-input" 
              id="discount_price"
              name="discount_price" 
              placeholder="Enter percentage (e.g., 10)" 
              required
              min="0"
              max="100"
              step="1">
            <div class="form-hint">Enter value between 0-100%</div>
          </div>

          <div class="form-actions">
            <button type="submit" class="btn-submit" id="submit-btn">
              <span class="mdi mdi-plus-circle"></span> Add Coupon
            </button>
            <button type="button" class="btn-cancel d-none" id="cancel-edit">
              <span class="mdi mdi-close"></span> Cancel
            </button>
          </div>
        </form>
      </div>

      <!-- Table Section -->
      <div class="table-section">
        <div class="table-header">
          <h2>Active Coupons</h2>
        </div>
        
        <div class="table-info">
          <span class="mdi mdi-ticket-percent"></span>
          Total Coupons: <span id="total-count"><?php echo $result ? $result->num_rows : 0; ?></span>
        </div>

        <div class="table-container">
          <table class="coupon-table">
            <thead>
              <tr>
                <th style="width: 50px;">SL</th>
                <th style="width: 200px;">Coupon Name</th>
                <th style="width: 150px;">Code</th>
                <th style="width: 120px;">Discount</th>
                <th style="width: 150px;">Created At</th>
                <th style="width: 180px;">Actions</th>
              </tr>
            </thead>
            <tbody id="coupon-tbody">
              <?php
              if ($result && $result->num_rows > 0):
                  $i = 1;
                  while ($row = $result->fetch_assoc()):
              ?>
              <tr id="row-<?php echo $row['id']; ?>"
                  data-id="<?php echo $row['id']; ?>"
                  data-name="<?php echo htmlspecialchars($row['coupon_name']); ?>"
                  data-code="<?php echo htmlspecialchars($row['coupon_code']); ?>"
                  data-discount="<?php echo htmlspecialchars($row['coupon_discount']); ?>">
                <td><?php echo $i++; ?></td>
                <td>
                  <span class="coupon-name"><?php echo htmlspecialchars($row['coupon_name']); ?></span>
                </td>
                <td>
                  <span class="coupon-code"><?php echo htmlspecialchars($row['coupon_code']); ?></span>
                </td>
                <td>
                  <span class="discount-badge"><?php echo htmlspecialchars($row['coupon_discount']); ?>%</span>
                </td>
                <td><?php echo date('M d, Y', strtotime($row['created_at'])); ?></td>
                <td>
                  <div class="action-buttons">
                    <button class="btn-edit edit-btn">
                      <span class="mdi mdi-pencil"></span> Edit
                    </button>
                    <button class="btn-delete delete-coupon">
                      <span class="mdi mdi-delete"></span> Delete
                    </button>
                  </div>
                </td>
              </tr>
              <?php endwhile; else: ?>
              <tr>
                <td colspan="6" class="empty-state">
                  <i class="mdi mdi-ticket-percent-outline"></i>
                  <p>No coupons found. Add your first coupon above.</p>
                </td>
              </tr>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
      </div>

    </div>
  </div>
</div>

<script>
// Generate unique coupon code
document.getElementById('generateCode').addEventListener('click', function() {
    const characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    let couponCode = '';
    for (let i = 0; i < 10; i++) {
        couponCode += characters.charAt(Math.floor(Math.random() * characters.length));
    }
    document.getElementById('couponCode').value = couponCode;
});

// Edit coupon
document.querySelectorAll('.edit-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        const row = this.closest('tr');
        const id = row.getAttribute('data-id');
        const name = row.getAttribute('data-name');
        const code = row.getAttribute('data-code');
        const discount = row.getAttribute('data-discount');

        document.getElementById('edit_id').value = id;
        document.getElementById('coupon_name').value = name;
        document.getElementById('couponCode').value = code;
        document.getElementById('discount_price').value = discount;
        document.getElementById('form-title').innerText = "Edit Coupon";
        document.getElementById('submit-btn').innerHTML = '<span class="mdi mdi-check"></span> Update Coupon';
        document.getElementById('cancel-edit').classList.remove('d-none');

        // Scroll to form
        document.querySelector('.form-section').scrollIntoView({
            behavior: 'smooth'
        });
    });
});

// Cancel edit
document.getElementById('cancel-edit').addEventListener('click', function() {
    document.getElementById('edit_id').value = '';
    document.getElementById('coupon_name').value = '';
    document.getElementById('couponCode').value = '';
    document.getElementById('discount_price').value = '';
    document.getElementById('form-title').innerText = "Add New Coupon";
    document.getElementById('submit-btn').innerHTML = '<span class="mdi mdi-plus-circle"></span> Add Coupon';
    this.classList.add('d-none');
});

// Delete coupon with SweetAlert
document.querySelectorAll('.delete-coupon').forEach(function(btn) {
    btn.addEventListener('click', function() {
        const row = this.closest('tr');
        const couponId = row.getAttribute('data-id');
        
        Swal.fire({
            title: 'Remove Coupon?',
            text: "This action cannot be undone",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#000',
            cancelButtonColor: '#999',
            confirmButtonText: 'Yes, Remove',
            cancelButtonText: 'Cancel',
            customClass: {
              popup: 'swal-minimal',
              confirmButton: 'swal-btn-confirm',
              cancelButton: 'swal-btn-cancel'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                fetch('', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: 'delete_id=' + couponId
                })
                .then(response => {
                    // Check if response is ok
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.text();
                })
                .then(text => {
                    // Try to parse JSON
                    let data;
                    try {
                        data = JSON.parse(text);
                    } catch (e) {
                        console.error('Response was not JSON:', text);
                        throw new Error('Invalid JSON response');
                    }
                    
                    if (data.status === 'success') {
                        Swal.fire({
                          title: 'Deleted!',
                          text: data.message,
                          icon: 'success',
                          confirmButtonColor: '#000'
                        }).then(() => {
                            row.remove();
                            
                            // Update count
                            const totalCount = document.getElementById('total-count');
                            const currentCount = parseInt(totalCount.textContent);
                            totalCount.textContent = currentCount - 1;
                            
                            // Check if table is empty
                            const tbody = document.getElementById('coupon-tbody');
                            if (tbody.children.length === 0) {
                                tbody.innerHTML = `
                                    <tr>
                                        <td colspan="6" class="empty-state">
                                            <i class="mdi mdi-ticket-percent-outline"></i>
                                            <p>No coupons found. Add your first coupon above.</p>
                                        </td>
                                    </tr>
                                `;
                            }
                        });
                    } else {
                        Swal.fire({
                          title: 'Error!',
                          text: data.message || 'Failed to delete coupon',
                          icon: 'error',
                          confirmButtonColor: '#000'
                        });
                    }
                })
                .catch(error => {
                    console.error('Delete error:', error);
                    Swal.fire({
                      title: 'Error!',
                      text: 'Something went wrong. Please try again.',
                      icon: 'error',
                      confirmButtonColor: '#000'
                    });
                });
            }
        });
    });
});
</script>

<?php require 'footer.php'; ?>