<?php
$current_page = basename($_SERVER['PHP_SELF']);
$page_title = 'Create Order';
require 'header.php';

// Generate a unique invoice number
function generateInvoiceNo() {
    $timestamp = microtime(true) * 10000;
    $uniqueString = 'INV-' . strtoupper(base_convert($timestamp, 10, 36));
    return $uniqueString;
}

// Get selected product_id from GET
$productId = isset($_GET['product_id']) ? intval($_GET['product_id']) : 0;

// Fetch product sizes for selected product
$product_sizes = [];
$product_price = 0;
if ($productId) {
    // Get sizes
    $size_query = "SELECT size FROM product_size_list WHERE product_id = ?";
    $size_stmt = $conn->prepare($size_query);
    $size_stmt->bind_param("i", $productId);
    $size_stmt->execute();
    $size_result = $size_stmt->get_result();
    while ($row = $size_result->fetch_assoc()) {
        $product_sizes[] = $row['size'];
    }
    $size_stmt->close();

    // Get product price
    $price_query = $conn->query("SELECT product_price FROM product_info WHERE product_id = $productId LIMIT 1");
    if ($price_row = $price_query->fetch_assoc()) {
        $product_price = intval($price_row['product_price']);
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['user_full_name'])) {
    $user_full_name = mysqli_real_escape_string($conn, $_POST['user_full_name']);
    $user_phone = mysqli_real_escape_string($conn, $_POST['user_phone']);
    $user_email = mysqli_real_escape_string($conn, $_POST['user_email']);
    $user_address = mysqli_real_escape_string($conn, $_POST['user_address']);
    $city_address = mysqli_real_escape_string($conn, $_POST['city_address']);
    $invoice_no = mysqli_real_escape_string($conn, $_POST['invoice_no']);
    $product_id = intval($_POST['product_id']);
    $product_quantity = intval($_POST['product_quantity']);
    $product_size = mysqli_real_escape_string($conn, $_POST['product_size']);
    $total_price = intval($_POST['total_price']);
    $payment_method = mysqli_real_escape_string($conn, $_POST['payment_method']);
    $order_status = mysqli_real_escape_string($conn, $_POST['order_status']);

    $product_title = '';
    $product_query = mysqli_query($conn, "SELECT product_title FROM product_info WHERE product_id = $product_id");
    if ($product_row = mysqli_fetch_assoc($product_query)) {
        $product_title = mysqli_real_escape_string($conn, $product_row['product_title']);
    }

    $user_id = 0;
    $order_visibility = "Show"; // default

    $sql = "INSERT INTO order_info (
        user_id, user_full_name, user_phone, user_email, user_address, city_address, invoice_no,
        product_id, product_title, product_quantity, product_size, total_price, payment_method,
        order_status, order_visibility
    ) VALUES (
        $user_id, '$user_full_name', '$user_phone', '$user_email', '$user_address', '$city_address', '$invoice_no',
        $product_id, '$product_title', $product_quantity, '$product_size', $total_price, '$payment_method',
        '$order_status', '$order_visibility'
    )";

    if (mysqli_query($conn, $sql)) {
        echo "<script>window.location.href='invoice.php?inv=" . $invoice_no . "';</script>";
        exit;
    } else {
        echo "<div class='alert alert-danger mt-3'>Error: " . mysqli_error($conn) . "</div>";
    }
}
?>

<div class="content-wrapper">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white">
                        <h1 class="mb-0 p-3">Create New Order</h1>
                    </div>
                    <div class="card-body p-5">
                        <form method="POST" id="orderForm">
                            <div class="mb-3">
                                <label class="form-label">Product</label>
                                <select name="product_id" id="product_id" class="form-select" required onchange="location.href='?product_id='+this.value;">
                                    <option value="">Select Product</option>
                                    <?php
                                    $result = mysqli_query($conn, "SELECT product_id, product_title FROM product_info");
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        $selected = ($productId == $row['product_id']) ? 'selected' : '';
                                        echo "<option value='{$row['product_id']}' $selected>{$row['product_title']}</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Size</label>
                                <select name="product_size" id="product_size" class="form-select">
                                    <option value="">Select Size</option>
                                    <?php
                                    foreach ($product_sizes as $size) {
                                        $selected = (isset($_POST['product_size']) && $_POST['product_size'] == $size) ? 'selected' : '';
                                        echo "<option value=\"$size\" $selected>$size</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Quantity</label>
                                <input type="number" name="product_quantity" id="product_quantity" class="form-control" min="1" required value="<?php echo isset($_POST['product_quantity']) ? htmlspecialchars($_POST['product_quantity']) : ''; ?>">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Total Price</label>
                                <input type="number" name="total_price" id="total_price" class="form-control" required value="<?php echo isset($_POST['total_price']) ? htmlspecialchars($_POST['total_price']) : ($product_price ?: ''); ?>">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Payment Method</label>
                                <select name="payment_method" class="form-select" required>
                                    <option value="Cash On Delivery" <?php echo (isset($_POST['payment_method']) && $_POST['payment_method'] == 'Cash On Delivery') ? 'selected' : ''; ?>>Cash On Delivery</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Invoice No</label>
                                <input type="text" name="invoice_no" id="invoice_no" class="form-control" required readonly value="<?php echo isset($_POST['invoice_no']) ? htmlspecialchars($_POST['invoice_no']) : generateInvoiceNo(); ?>">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Full Name</label>
                                <input type="text" name="user_full_name" class="form-control" required value="<?php echo isset($_POST['user_full_name']) ? htmlspecialchars($_POST['user_full_name']) : ''; ?>">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Phone</label>
                                <input type="text" name="user_phone" class="form-control" required value="<?php echo isset($_POST['user_phone']) ? htmlspecialchars($_POST['user_phone']) : ''; ?>">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" name="user_email" class="form-control" value="<?php echo isset($_POST['user_email']) ? htmlspecialchars($_POST['user_email']) : ''; ?>">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Address</label>
                                <textarea name="user_address" class="form-control" required><?php echo isset($_POST['user_address']) ? htmlspecialchars($_POST['user_address']) : ''; ?></textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Delivery Location</label>
                                <select name="city_address" class="form-select" required>
                                    <option value="Inside Dhaka" <?php echo (isset($_POST['city_address']) && $_POST['city_address']=='Inside Dhaka') ? 'selected' : ''; ?>>Inside Dhaka</option>
                                    <option value="Outside Dhaka" <?php echo (isset($_POST['city_address']) && $_POST['city_address']=='Outside Dhaka') ? 'selected' : ''; ?>>Outside Dhaka</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Status</label>
                                <select name="order_status" class="form-select">

                                    <option value="Pending" <?php echo (isset($_POST['order_status']) && $_POST['order_status'] == 'Pending') ? 'selected' : ''; ?>>Pending</option>

                                    <option value="Shipped" <?php echo (isset($_POST['order_status']) && $_POST['order_status'] == 'Shipped') ? 'selected' : ''; ?>>Shipped</option>

                                    <option value="Completed" <?php echo (isset($_POST['order_status']) && $_POST['order_status'] == 'Completed') ? 'selected' : ''; ?>>Completed</option>

                                    <option value="Canceled" <?php echo (isset($_POST['order_status']) && $_POST['order_status'] == 'Canceled') ? 'selected' : ''; ?>>Cancelled</option>

                                </select>
                            </div>
                            <button type="submit" class="btn btn-success w-100">Create Order</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Auto-calc total price based on quantity × product_price
document.addEventListener("DOMContentLoaded", function() {
    const qtyInput = document.getElementById("product_quantity");
    const totalPriceInput = document.getElementById("total_price");
    const basePrice = <?php echo $product_price ?: 0; ?>;

    if(qtyInput && totalPriceInput){
        qtyInput.addEventListener("input", function(){
            const qty = parseInt(qtyInput.value) || 0;
            totalPriceInput.value = basePrice * qty;
        });
    }
});
</script>

<?php require 'footer.php'; ?>