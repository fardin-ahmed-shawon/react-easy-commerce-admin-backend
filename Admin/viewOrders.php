<?php
$current_page = basename($_SERVER['PHP_SELF']);
$page_title = 'View Orders';
?>
<?php require 'header.php'; ?>

<style>
.orders-container {
  max-width: 100%;
  margin: 0 auto;
  padding: 2rem;
  background: #ffffff;
}

.orders-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 2rem;
  padding-bottom: 1rem;
  border-bottom: 2px solid #000;
}

.orders-header h1 {
  font-size: 1.75rem;
  font-weight: 600;
  color: #000;
  margin: 0;
  letter-spacing: -0.5px;
}

.btn-manage {
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

.btn-manage:hover {
  background: #333;
  color: #fff;
  transform: translateY(-1px);
}

.table-container {
  overflow-x: auto;
  background: #fff;
  border: 1px solid #e0e0e0;
}

.orders-table {
  width: 100%;
  border-collapse: collapse;
  font-size: 0.9rem;
}

.orders-table thead {
  background: #000;
  color: #fff;
}

.orders-table thead th {
  padding: 1rem 0.75rem;
  text-align: left;
  font-weight: 600;
  font-size: 0.85rem;
  text-transform: uppercase;
  letter-spacing: 0.5px;
  border-right: 1px solid #333;
}

.orders-table thead th:last-child {
  border-right: none;
}

.orders-table tbody tr {
  border-bottom: 1px solid #e0e0e0;
  transition: background 0.2s ease;
}

.orders-table tbody tr:hover {
  background: #f8f8f8;
}

.orders-table tbody td {
  padding: 1rem 0.75rem;
  vertical-align: top;
  color: #333;
}

.orders-table tbody td:first-child {
  font-weight: 600;
  color: #000;
}

/* Truncate address */
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

.order-status {
  font-weight: 600;
  font-size: 0.85rem;
}

.product-list {
  list-style: none;
  padding: 0;
  margin: 0;
}

.product-list li {
  padding: 0.4rem 0;
  border-bottom: 1px solid #f0f0f0;
  font-size: 0.85rem;
  line-height: 1.5;
}

.product-list li:last-child {
  border-bottom: none;
}

.product-title {
  font-weight: 600;
  color: #000;
}

.product-details {
  color: #666;
  font-size: 0.8rem;
}

.total-price {
  font-weight: 700;
  font-size: 1rem;
  color: #000;
}

.btn-remove {
  padding: 0.5rem 1.25rem;
  background: #fff;
  color: #000;
  border: 2px solid #000;
  font-size: 0.85rem;
  font-weight: 600;
  cursor: pointer;
  transition: all 0.2s ease;
  text-transform: uppercase;
  letter-spacing: 0.5px;
}

.btn-remove:hover {
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

/* Responsive */
@media (max-width: 1200px) {
  .address-cell {
    max-width: 150px;
  }
}

@media (max-width: 768px) {
  .orders-container {
    padding: 1rem;
  }
  
  .orders-header {
    flex-direction: column;
    gap: 1rem;
    align-items: flex-start;
  }
  
  .orders-table {
    font-size: 0.8rem;
  }
  
  .orders-table thead th,
  .orders-table tbody td {
    padding: 0.75rem 0.5rem;
  }
  
  .address-cell {
    max-width: 120px;
  }
}
</style>

<div class="content-wrapper">

  <div class="page-header">
    <h3 class="page-title">
      <span class="page-title-icon bg-gradient-primary text-white me-2">
        <i class="mdi mdi-order-bool-descending-variant"></i>
      </span> Orders
    </h3>
  </div>

  <div class="orders-container">
    <div class="orders-header">
      <h1>Active Orders</h1>
      <div>
        <a class="btn btn-primary mx-3" href="pendingOrders.php">
          Pending Orders
          <span class="mdi mdi-timer-sand"></span>
        </a>
        <a class="btn-manage" href="order-management.php">
          Manage Orders
          <span class="mdi mdi-order-alphabetical-ascending"></span>
        </a>
      </div>
    </div>

    <div class="table-container">
      <table class="orders-table">
        <thead>
          <tr>
            <th style="width: 50px;">SL</th>
            <th style="width: 100px;">Invoice</th>
            <th style="width: 100px;">Order No</th>
            <th style="width: 150px;">Customer</th>
            <th style="width: 120px;">Phone</th>
            <th style="width: 200px;">Address</th>
            <th style="width: 100px;">Date</th>
            <th style="width: 120px;">Payment</th>
            <th style="width: 100px;">Status</th>
            <th>Products</th>
            <th style="width: 100px;">Total</th>
            <th style="width: 100px;">Action</th>
          </tr>
        </thead>
        <tbody>
        <?php
        $sql = "SELECT * FROM order_info 
                WHERE order_status!='Pending' 
                AND order_visibility='Show' 
                ORDER BY invoice_no DESC, order_no ASC";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $orders = [];
            while ($row = $result->fetch_assoc()) {
                $invoice = $row['invoice_no'];
                if (!isset($orders[$invoice])) {
                    $orders[$invoice] = [
                        'invoice_no' => $invoice,
                        'user_full_name' => $row['user_full_name'],
                        'user_phone' => $row['user_phone'],
                        'user_address' => $row['user_address'],
                        'order_date' => $row['order_date'],
                        'payment_method' => $row['payment_method'],
                        'order_status' => $row['order_status'],
                        'total_price' => 0,
                        'products' => [],
                        'order_nos' => []
                    ];
                }
                $orders[$invoice]['products'][] = [
                    'title' => $row['product_title'],
                    'size' => $row['product_size'],
                    'color' => $row['product_color'],
                    'quantity' => $row['product_quantity'],
                    'price' => $row['total_price']
                ];
                $orders[$invoice]['total_price'] += $row['total_price'];
                $orders[$invoice]['order_nos'][] = $row['order_no'];
            }

            // Display grouped orders
            $sl = 1;
            foreach ($orders as $order) {
                $orderNos = implode(", ", $order['order_nos']);
                echo "<tr>
                        <td>{$sl}</td>
                        <td><strong>{$order['invoice_no']}</strong></td>
                        <td>{$orderNos}</td>
                        <td>{$order['user_full_name']}</td>
                        <td>{$order['user_phone']}</td>
                        <td class='address-cell' title='{$order['user_address']}'>{$order['user_address']}</td>
                        <td>" . date('M d, Y', strtotime($order['order_date'])) . "</td>
                        <td>{$order['payment_method']}</td>
                        <td class='order-status'>{$order['order_status']}</td>
                        <td>
                          <ul class='product-list'>";
                          foreach ($order['products'] as $p) {
                            $size  = !empty($p['size']) ? " · {$p['size']}" : '';
                            $color = !empty($p['color']) ? " · {$p['color']}" : '';
                        
                            echo "<li>
                                    <span class='product-title'>{$p['title']}</span>
                                    <div class='product-details'>Qty: {$p['quantity']}{$size}{$color} — {$p['price']} Tk</div>
                                  </li>";
                        }
                        
                echo      "</ul>
                        </td>
                        <td class='total-price'>{$order['total_price']} Tk</td>
                        <td>
                          <a href='removeOrder.php?invoice_no={$order['invoice_no']}'>
                            <button class='btn-remove' onclick='return checkDelete(event)'>Remove</button>
                          </a>
                        </td>
                      </tr>";
                $sl++;
            }
        } else {
            echo "<tr>
                    <td colspan='12' class='empty-state'>
                      <i class='mdi mdi-package-variant'></i>
                      <p>No active orders found</p>
                    </td>
                  </tr>";
        }
        ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<script>
function checkDelete(event) {
  event.preventDefault();
  Swal.fire({
    title: 'Remove Order?',
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
      window.location.href = event.target.closest('a').href;
    }
  });
  return false;
}
</script>

<?php require 'footer.php'; ?>