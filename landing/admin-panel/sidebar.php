<nav class="sidebar sidebar-offcanvas" id="sidebar">
          <ul class="nav">
            <li class="nav-item nav-profile">
              <a href="#" class="nav-link">
                <div class="nav-profile-image">
                  <img src="img/admin.jpg" alt="profile" />
                  <span class="login-status online"></span>
                  <!--change to offline or busy as needed-->
                </div>
                <div class="nav-profile-text d-flex flex-column">
                  <span class="font-weight-bold mb-2">Admin</span>
                  <span class="text-secondary text-small">Owner</span>
                </div>
                <i class="mdi mdi-bookmark-check text-success nav-profile-badge"></i>
              </a>
            </li>

            <li class="nav-item">
              <a class="nav-link" href="index.php">
                <span class="menu-title">Dashboard</span>
                <i class="mdi mdi-home menu-icon"></i>
              </a>
            </li>
            
            
            <li class="nav-item">
              <a class="nav-link" data-bs-toggle="collapse" href="#product" aria-expanded="false" aria-controls="product">
                <span class="menu-title">Product</span>
                <i class="mdi mdi-format-list-bulleted menu-icon"></i>
              </a>
              <div class="collapse" id="product">
                <ul class="nav flex-column sub-menu">
                  <li class="nav-item">
                    <a class="nav-link" href="addProduct.php">Add Product</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="viewProduct.php">View Product</a>
                  </li>
                </ul>
              </div>
            </li>

            <li class="nav-item">
              <a class="nav-link" data-bs-toggle="collapse" href="#order" aria-expanded="false" aria-controls="order">
                <span class="menu-title">View Orders</span>
                <i class="mdi mdi-format-list-bulleted menu-icon"></i>
              </a>
              <div class="collapse" id="order">
                <ul class="nav flex-column sub-menu">
                  <li class="nav-item">
                    <a class="nav-link" href="pendingOrders.php">Pending Orders</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="viewOrders.php">Active Orders</a>
                  </li>
                </ul>
              </div>
            </li>

            <li class="nav-item">
              <a class="nav-link" href="viewPayments.php">
                <span class="menu-title">View Payments</span>
                <i class="mdi mdi-currency-usd menu-icon"></i>
              </a>
            </li>
            
            <li class="nav-item">
              <a class="nav-link" href="makeInvoice.php">
                <span class="menu-title">Make Invoice</span>
                <i class="mdi mdi-invoice-list-outline menu-icon"></i>
              </a>
            </li>
            
            <li class="nav-item">
              <a class="nav-link" href="purchaseHistory.php">
                <span class="menu-title">Purchase History</span>
                <i class="mdi mdi-history menu-icon"></i>
              </a>
            </li>

            <li class="nav-item">
              <a class="nav-link" href="settings.php">
                <span class="menu-title">Settings</span>
                <i class="mdi mdi-cog menu-icon"></i>
              </a>
            </li>

            <li class="nav-item">
              <a class="nav-link" href="logout.php">
                <span class="menu-title">Logout</span>
                <i class="mdi mdi-logout menu-icon"></i>
              </a>
            </li>

          </ul>
        </nav>