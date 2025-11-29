<?php
$current_page = basename($_SERVER['PHP_SELF']);
$page_title = 'Add Discount';
?>
<?php require 'header.php'; ?>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $purchase_amount = $_POST['purchase_amount'];
    $discount_amount = $_POST['discount_amount'];
    $free_shipping = isset($_POST['free_shipping']) ? 1 : 0;

    if (empty($purchase_amount) || empty($discount_amount)) {
        $error_message = "All fields are required.";
    } else {
        $sql = "INSERT INTO discount (purchase_amount, discount_amount, free_shipping, created_at) 
                VALUES (?, ?, ?, NOW())";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iii", $purchase_amount, $discount_amount, $free_shipping);

        if ($stmt->execute()) {
            $success_message = "Discount added successfully!";
        } else {
            $error_message = "Error: " . $stmt->error;
        }
        $stmt->close();
    }
}
?>

<style>
.discount-container {
  max-width: 100%;
  margin: 0 auto;
  padding: 2rem;
  background: #ffffff;
}

.discount-header {
  margin-bottom: 2rem;
  padding-bottom: 1rem;
  border-bottom: 2px solid #000;
}

.discount-header h1 {
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
.discount-grid {
  display: grid;
  grid-template-columns: 400px 1fr;
  gap: 2rem;
}

/* Form Section */
.form-section {
  background: #fff;
border: 1px solid #e0e0e0;
  padding: 2rem;
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

/* Checkbox */
.checkbox-group {
  display: flex;
  align-items: center;
  gap: 0.75rem;
  padding: 1rem;
  background: #fff;
  border: 1px solid #ccc;
  cursor: pointer;
  transition: all 0.2s ease;
}

.checkbox-group:hover {
  background: #f8f8f8;
}

.checkbox-group input[type="checkbox"] {
  width: 20px;
  height: 20px;
  cursor: pointer;
  accent-color: #000;
}

.checkbox-label {
  font-size: 0.9rem;
  font-weight: 600;
  color: #000;
  text-transform: uppercase;
  letter-spacing: 0.5px;
  cursor: pointer;
}

.btn-submit {
  padding: 0.75rem 2.5rem;
  background: #000;
  color: #fff;
  border: none;
  font-size: 0.9rem;
  font-weight: 600;
  cursor: pointer;
  transition: all 0.2s ease;
  text-transform: uppercase;
  letter-spacing: 0.5px;
  width: 100%;
}

.btn-submit:hover {
  background: #333;
  transform: translateY(-1px);
}

/* Table Section */
.table-section {
  background: #fff;
  border: 1px solid #e0e0e0;
  padding: 2rem;
}

.table-section h2 {
  font-size: 1.25rem;
  font-weight: 600;
  color: #000;
  margin-bottom: 2rem;
  letter-spacing: -0.5px;
  text-transform: uppercase;
}

.table-container {
  overflow-x: auto;
  background: #fff;
  border: 1px solid #e0e0e0;
}

.discount-table {
  width: 100%;
  border-collapse: collapse;
  font-size: 0.9rem;
}

.discount-table thead {
  background: #000;
  color: #fff;
}

.discount-table thead th {
  padding: 1rem 0.75rem;
  text-align: left;
  font-weight: 600;
  font-size: 0.85rem;
  text-transform: uppercase;
  letter-spacing: 0.5px;
  border-right: 1px solid #333;
}

.discount-table thead th:last-child {
  border-right: none;
}

.discount-table tbody tr {
  border-bottom: 1px solid #e0e0e0;
  transition: background 0.2s ease;
}

.discount-table tbody tr:hover {
  background: #f8f8f8;
}

.discount-table tbody td {
  padding: 1rem 0.75rem;
  vertical-align: middle;
  color: #333;
}

.discount-table tbody td:first-child {
  font-weight: 600;
  color: #000;
}

.badge {
  padding: 0.35rem 0.75rem;
  font-size: 0.75rem;
  font-weight: 600;
  text-transform: uppercase;
  letter-spacing: 0.5px;
  border: 1px solid;
}

.badge-success {
  background: #D1E7DD;
  color: #0A3622;
  border-color: #0A3622;
}

.badge-secondary {
  background: #f8f8f8;
  color: #666;
  border-color: #666;
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
  margin-right: 0.5rem;
  margin-bottom: 0.5rem;
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
  .discount-grid {
    grid-template-columns: 350px 1fr;
  }
}

@media (max-width: 992px) {
  .discount-grid {
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
  .discount-container {
    padding: 1rem;
  }
  
  .discount-header h1 {
    font-size: 1.5rem;
  }
  
  .form-section,
  .table-section {
    padding: 1.5rem;
  }
  
  .discount-table {
    font-size: 0.8rem;
  }
  
  .discount-table thead th,
  .discount-table tbody td {
    padding: 0.75rem 0.5rem;
  }
}
</style>

<div class="content-wrapper">

  <div class="page-header">
    <h3 class="page-title">
      <span class="page-title-icon bg-gradient-primary text-white me-2">
        <i class="mdi mdi-sale"></i>
      </span> Discount Management
    </h3>
  </div>

  <div class="discount-container">
    
    <!-- Alert Messages -->
    <?php
      if (isset($success_message)) {
        echo '<div class="alert-success">'.$success_message.'</div>';
      } else if (isset($error_message)) {
        echo '<div class="alert-error">'.$error_message.'</div>';
      }
    ?>

    <div class="discount-header">
      <h1>Manage Discounts</h1>
    </div>

    <div class="discount-grid">
      
      <!-- Form Section -->
      <div class="form-section">
        <h2>Add New Discount</h2>
        
        <form action="" method="POST">
          
          <div class="form-group">
            <label class="form-label" for="purchase_amount">Purchase Amount *</label>
            <input 
              type="number" 
              class="form-input" 
              id="purchase_amount"
              name="purchase_amount" 
              placeholder="Enter purchase amount" 
              required
              step="0.01"
              min="0">
          </div>

          <div class="form-group">
            <label class="form-label" for="discount_amount">Discount Amount *</label>
            <input 
              type="number" 
              class="form-input" 
              id="discount_amount"
              name="discount_amount" 
              placeholder="Enter discount amount" 
              required
              step="0.01"
              min="0">
          </div>

          <div class="form-group">
            <label class="checkbox-group">
              <input 
                type="checkbox" 
                id="free_shipping" 
                name="free_shipping" 
                value="1">
              <span class="checkbox-label">Free Shipping</span>
            </label>
          </div>

          <button type="submit" class="btn-submit">Add Discount</button>
        </form>
      </div>

      <!-- Table Section -->
      <div class="table-section">
        <h2>Active Discounts</h2>
        
        <div class="table-container">
          <table class="discount-table">
            <thead>
              <tr>
                <th style="width: 50px;">SL</th>
                <th style="width: 150px;">Purchase Amount</th>
                <th style="width: 150px;">Discount Amount</th>
                <th style="width: 120px;">Free Shipping</th>
                <th style="width: 150px;">Created At</th>
                <th style="width: 180px;">Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $result = $conn->query("SELECT * FROM discount ORDER BY id DESC");
              if ($result && $result->num_rows > 0):
                  $i = 1;
                  while ($row = $result->fetch_assoc()):
              ?>
              <tr>
                <td><?php echo $i++; ?></td>
                <td><?php echo htmlspecialchars($row['purchase_amount']); ?> Tk</td>
                <td><?php echo htmlspecialchars($row['discount_amount']); ?> Tk</td>
                <td>
                  <?php echo $row['free_shipping'] == 1 
                    ? '<span class="badge badge-success">Yes</span>' 
                    : '<span class="badge badge-secondary">No</span>'; ?>
                </td>
                <td><?php echo date('M d, Y', strtotime($row['created_at'])); ?></td>
                <td>
                  <a href="edit-discount.php?id=<?php echo $row['id']; ?>" class="btn-edit">Edit</a>
                  <a href="javascript:void(0);" class="btn-delete delete-discount" data-id="<?php echo $row['id']; ?>">Delete</a>
                </td>
              </tr>
              <?php endwhile; else: ?>
              <tr>
                <td colspan="6" class="empty-state">
                  <i class="mdi mdi-sale-outline"></i>
                  <p>No discounts found. Add your first discount above.</p>
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
// SweetAlert and AJAX for Delete
document.querySelectorAll('.delete-discount').forEach(function(btn) {
    btn.addEventListener('click', function() {
        var discountId = this.getAttribute('data-id');
        Swal.fire({
            title: 'Remove Discount?',
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
                fetch('delete-discount-ajax.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ id: discountId })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        Swal.fire({
                          title: 'Deleted!',
                          text: data.message,
                          icon: 'success',
                          confirmButtonColor: '#000'
                        });
                        btn.closest('tr').remove();
                    } else {
                        Swal.fire({
                          title: 'Error!',
                          text: data.message,
                          icon: 'error',
                          confirmButtonColor: '#000'
                        });
                    }
                })
                .catch(error => {
                    Swal.fire({
                      title: 'Error!',
                      text: 'Something went wrong.',
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