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
</style>

<!-- Dashboard Stats Area -->
<div class="row g-4">

  <!-- Total Products -->
  <div class="col-xl-3 col-md-6" onclick="window.location.href='viewProduct.php';" style="cursor: pointer;">
    <div class="stats-card stats-gradient-danger">
      <div class="stats-icon">
        <i class="mdi mdi-apps"></i>
      </div>
      <div class="stats-content">
        <h6 class="stats-label">Total Products</h6>
        <h2 class="stats-value">
          <?php
          $sql = "SELECT COUNT(product_id) AS total_products FROM product_info";
          $result = $conn->query($sql);
          $row = $result->fetch_assoc();
          echo $row['total_products'];
          ?>
        </h2>
      </div>
      <div class="stats-trend">
        <span class="trend-icon">↗</span>
      </div>
    </div>
  </div>

  <!-- Product Categories -->
  <div class="col-xl-3 col-md-6" onclick="window.location.href='viewCategory.php';" style="cursor: pointer;">
    <div class="stats-card stats-gradient-info">
      <div class="stats-icon">
        <i class="mdi mdi-order-bool-ascending"></i>
      </div>
      <div class="stats-content">
        <h6 class="stats-label">Product Categories</h6>
        <h2 class="stats-value">
          <?php
          $sql = "SELECT COUNT(main_ctg_id) AS total_categories FROM main_category";
          $result = $conn->query($sql);
          $row = $result->fetch_assoc();
          echo $row['total_categories'];
          ?>
        </h2>
      </div>
      <div class="stats-trend">
        <span class="trend-icon">→</span>
      </div>
    </div>
  </div>

  <?php if (isset($access['inventory']) && $access['inventory'] == 1) { ?>
    <!-- Total Stock -->
    <div class="col-xl-3 col-md-6" onclick="window.location.href='inventory.php';" style="cursor: pointer;">
      <div class="stats-card stats-gradient-success">
        <div class="stats-icon">
          <i class="mdi mdi-archive-clock-outline"></i>
        </div>
        <div class="stats-content">
          <h6 class="stats-label">Total Stock Unit</h6>
          <h2 class="stats-value">
            <?php
            $sql = "SELECT SUM(available_stock) AS total FROM product_info";
            $result = $conn->query($sql);
            $row = $result->fetch_assoc();
            echo number_format($row['total']);
            ?>
          </h2>
        </div>
        <div class="stats-trend">
          <span class="trend-icon">↗</span>
        </div>
      </div>
    </div>
  <?php } ?>

  <?php if (isset($access['customers']) && $access['customers'] == 1) { ?>
    <!-- Total Customers -->
    <div class="col-xl-3 col-md-6" onclick="window.location.href='viewCustomers.php';" style="cursor: pointer;">
      <div class="stats-card stats-gradient-primary">
        <div class="stats-icon">
          <i class="mdi mdi-account"></i>
        </div>
        <div class="stats-content">
          <h6 class="stats-label">Customers</h6>
          <h2 class="stats-value">
            <?php
            $sql = "SELECT COUNT(user_id) AS total_customers FROM user_info";
            $result = $conn->query($sql);
            $row = $result->fetch_assoc();
            echo number_format($row['total_customers']);
            ?>
          </h2>
        </div>
        <div class="stats-trend">
          <span class="trend-icon">↗</span>
        </div>
      </div>
    </div>
  <?php } ?>

  <?php if (isset($access['orders']) && $access['orders'] == 1) { ?>
    <!-- Total Purchased Unit -->
    <div class="col-xl-3 col-md-6" onclick="window.location.href='purchaseHistory.php';" style="cursor: pointer;">
      <div class="stats-card stats-gradient-primary">
        <div class="stats-icon">
          <i class="mdi mdi-cart-variant"></i>
        </div>
        <div class="stats-content">
          <h6 class="stats-label">Total Purchased Unit</h6>
          <h2 class="stats-value">
            <?php
            $sql = "SELECT SUM(product_quantity) AS total FROM order_info";
            $result = $conn->query($sql);
            $row = $result->fetch_assoc();
            echo number_format($row['total'] ?? 0);
            ?>
          </h2>
        </div>
        <div class="stats-trend">
          <span class="trend-icon">↗</span>
        </div>
      </div>
    </div>
  <?php } ?>

  <?php if (isset($access['accounts']) && $access['accounts'] == 1) { ?>
    <!-- Total Sales -->
    <div class="col-xl-3 col-md-6" onclick="window.location.href='total-collections.php';" style="cursor: pointer;">
      <div class="stats-card stats-gradient-success">
        <div class="stats-icon">
          <i class="mdi mdi-cash-check"></i>
        </div>
        <div class="stats-content">
          <h6 class="stats-label">Total Sales</h6>
          <h2 class="stats-value">
            <?php
            $sql = "SELECT SUM(total_price) AS total_collection FROM order_info WHERE order_status = 'Completed'";
            $result = $conn->query($sql);
            $row = $result->fetch_assoc();
            echo "৳ " . number_format($row['total_collection']);
            ?>
          </h2>
        </div>
        <div class="stats-trend">
          <span class="trend-icon">↗</span>
        </div>
      </div>
    </div>
  <?php } ?>

  <?php if (isset($access['orders']) && $access['orders'] == 1) { ?>
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

    <!-- Processing Orders -->
    <div class="col-xl-3 col-md-6" onclick="window.location.href='order-management.php';" style="cursor: pointer;">
      <div class="stats-card stats-gradient-info">
        <div class="stats-icon">
          <i class="mdi mdi-cart-outline"></i>
        </div>
        <div class="stats-content">
          <h6 class="stats-label">Processing Orders</h6>
          <h2 class="stats-value">
            <?php
            $sql = "SELECT COUNT(order_no) AS total_orders FROM order_info WHERE order_visibility='Show' AND order_status ='Processing'";
            $result = $conn->query($sql);
            $row = $result->fetch_assoc();
            echo $row['total_orders'];
            ?>
          </h2>
        </div>
        <div class="stats-badge badge-info">In Progress</div>
      </div>
    </div>

    <!-- Shipped Orders -->
    <div class="col-xl-3 col-md-6" onclick="window.location.href='order-management.php?search_query=&from_date=&to_date=&main_ctg=&filter=Shipped';" style="cursor: pointer;">
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
    <div class="col-xl-3 col-md-6" onclick="window.location.href='order-management.php?search_query=&from_date=&to_date=&main_ctg=&filter=Completed';" style="cursor: pointer;">
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
    <div class="col-xl-3 col-md-6" onclick="window.location.href='order-management.php?search_query=&from_date=&to_date=&main_ctg=&filter=Canceled';" style="cursor: pointer;">
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
    </div>
  <?php } ?>

</div>
<br>