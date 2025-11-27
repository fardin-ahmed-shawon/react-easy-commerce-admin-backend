<?php
// Get access rights from page_access
$access_sql = "SELECT * FROM page_access WHERE role_id = ?";
$access_stmt = $conn->prepare($access_sql);
$access_stmt->bind_param("i", $role_id);
$access_stmt->execute();
$access_result = $access_stmt->get_result();

if ($access_result->num_rows === 1) {
    $access = $access_result->fetch_assoc();
} else {
    die("Access rights not set for this role.");
}

// Mapping pages to column names
$pageAccessMap = [
    'index.php'               => 'dashboard',

    'addProduct.php'          => 'product',
    'viewProduct.php'         => 'product',
    'sizes.php'               => 'product',
 
    'insertCategory.php'      => 'categories',
    'viewCategory.php'        => 'categories',
    'deleteCategory.php'      => 'categories',

    'slider.php'              => 'slider',
    'banner.php'              => 'banner',
    'discounts.php'           => 'discounts',

    'add-coupons.php'         => 'coupons',
    'view-coupons.php'        => 'coupons',

    'viewCustomers.php'       => 'customers',

    'pendingOrders.php'       => 'orders',
    'viewOrders.php'          => 'orders',
    'create-order.php'        => 'orders',
    'edit-order.php'        => 'orders',
    'order-management.php'    => 'orders',

    'viewPayments.php'        => 'payments',

    'accounts-dashboard.php'  => 'accounts',
    'total-collections.php'   => 'accounts',
    'expense-category.php'    => 'accounts',
    'add-expense.php'         => 'accounts',
    'all-expenses.php'        => 'accounts',
    'statements.php'          => 'accounts',
    'view-statement.php'      => 'accounts',

    'inventory.php'           => 'inventory',

    'pos-invoice.php'         => 'invoice',
    'invoice.php'             => 'invoice',
    'generate_label.php'             => 'invoice',

    'courier.php'             => 'courier',
    'steadfast_entry.php'     => 'courier',
    'pathao-courier-list.php' => 'courier',
    'order_details.php'       => 'courier',
    'pathao_entry.php'        => 'courier',

    'purchaseHistory.php'     => 'history',
    'settings.php'            => 'settings'
];

// Get the current page filename
$current_page = basename($_SERVER['PHP_SELF']);

// Check if the current page is restricted
if (isset($pageAccessMap[$current_page])) {
    $page_key = $pageAccessMap[$current_page];

    // If the page access is not allowed
    if (!isset($access[$page_key]) || $access[$page_key] == 0) {
        echo "<script>alert('Access Denied to this page.'); window.location.href = 'index.php';</script>";
        exit();
    }
}
?>