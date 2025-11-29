<?php
$current_page = basename($_SERVER['PHP_SELF']);
$page_title = 'Order Details';
?>
<?php require 'header.php'; ?>

<?php
// Get invoice_no from URL
$invoice_no = $_GET['invoice_no'] ?? '';
if (!$invoice_no) {
    echo "<h4>Invalid invoice number.</h4>";
    exit();
}

// Fetch courier tracking_code & get parcel status
$sql2 = "SELECT tracking_code FROM parcel_info WHERE invoice_no = '$invoice_no'";
$result2 = $conn->query($sql2);
$row2 = $result2->num_rows;

if ($row2 > 0) {
    $data = $result2->fetch_assoc();
    $is_tracking_code_set = 1;
    $tracking_code = $data['tracking_code'];
    $parcel_status = track_parcel($tracking_code);
} else {
    $is_tracking_code_set = 0;
    $parcel_status = 'Not Added';
}

// Fetch order with payment details
$sql = "SELECT 
    o.*, 
    p.payment_status, 
    p.acc_number, 
    p.transaction_id, 
    p.payment_date,
    u.user_fName,
    u.user_lName,
    pr.product_code,
    u.user_phone AS registered_phone,
    u.user_email AS registered_email,
    u.user_gender
FROM order_info o
LEFT JOIN payment_info p ON o.order_no = p.order_no
LEFT JOIN user_info u ON o.user_id = u.user_id
LEFT JOIN product_info pr ON pr.product_id = o.product_id
WHERE o.invoice_no = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $invoice_no);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "<h4>No orders found for this invoice.</h4>";
    exit();
}

$orders = $result->fetch_all(MYSQLI_ASSOC);
$order = $orders[0];
?>

<style>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

.minimal-order-page {
    background: #f8f9fa;
    padding: 3rem 0;
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
}

.order-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 2rem;
}

.order-header {
    background: #fff;
    border-radius: 12px;
    padding: 2.5rem;
    margin-bottom: 2rem;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
}

.order-header h1 {
    font-size: 2.5rem;
    font-weight: 700;
    letter-spacing: -1px;
    color: #1a1a1a;
    margin-bottom: 0.75rem;
}

.invoice-number {
    font-size: 1.125rem;
    color: #666;
    font-weight: 500;
    margin-bottom: 0.5rem;
}

.order-date {
    font-size: 0.875rem;
    color: #999;
}

.section {
    margin-bottom: 2rem;
}

.section-title {
    font-size: 0.875rem;
    text-transform: uppercase;
    letter-spacing: 2px;
    color: #1a1a1a;
    font-weight: 700;
    margin-bottom: 1.5rem;
}

.info-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1.5rem;
    background: #fff;
    padding: 2rem;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
}

.info-item {
    padding: 1rem 0;
}

.info-label {
    font-size: 0.75rem;
    text-transform: uppercase;
    letter-spacing: 1px;
    color: #999;
    margin-bottom: 0.5rem;
}

.info-value {
    font-size: 1.125rem;
    color: #1a1a1a;
    font-weight: 600;
}

.status-badge {
    display: inline-block;
    padding: 0.5rem 1.25rem;
    border-radius: 6px;
    font-size: 0.75rem;
    text-transform: uppercase;
    letter-spacing: 1px;
    font-weight: 600;
    background: #f0f0f0;
    color: #333;
}

.tracking-section {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 1.5rem;
    margin-bottom: 2rem;
}

.tracking-card {
    padding: 2rem;
    border-radius: 12px;
    position: relative;
    overflow: hidden;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.tracking-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 20px rgba(0,0,0,0.15);
}

.tracking-card.steadfast {
    background: linear-gradient(135deg, #34a487 0%, #2d8f74 100%);
}

.tracking-card.pathao {
    background: linear-gradient(135deg, #e83434 0%, #d42a2a 100%);
}

.tracking-card::before {
    content: '';
    position: absolute;
    top: 0;
    right: 0;
    width: 150px;
    height: 150px;
    background: rgba(255,255,255,0.1);
    border-radius: 50%;
    transform: translate(50%, -50%);
}

.courier-logo {
    font-size: 0.75rem;
    text-transform: uppercase;
    letter-spacing: 2px;
    font-weight: 700;
    margin-bottom: 1rem;
    color: rgba(255,255,255,0.9);
}

.tracking-status {
    font-size: 1.5rem;
    font-weight: 700;
    margin-bottom: 1.5rem;
    color: #fff;
    text-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.track-btn {
    display: inline-block;
    padding: 0.875rem 2rem;
    background: #fff;
    color: #1a1a1a;
    text-decoration: none;
    font-size: 0.813rem;
    text-transform: uppercase;
    letter-spacing: 1px;
    font-weight: 600;
    border-radius: 8px;
    transition: all 0.3s ease;
    box-shadow: 0 2px 8px rgba(0,0,0,0.15);
}

.track-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.2);
}

.tracking-card.steadfast .track-btn:hover {
    background: #34a487;
    color: #fff;
}

.tracking-card.pathao .track-btn:hover {
    background: #e83434;
    color: #fff;
}

.card {
    background: #fff;
    border-radius: 12px;
    padding: 2rem;
    margin-bottom: 1.5rem;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
}

.card-title {
    font-size: 0.875rem;
    text-transform: uppercase;
    letter-spacing: 1.5px;
    font-weight: 700;
    margin-bottom: 1.5rem;
    color: #1a1a1a;
    padding-bottom: 1rem;
    border-bottom: 2px solid #f0f0f0;
}

.address-box,
.payment-box {
    padding: 1.5rem;
    background: #f8f9fa;
    border-radius: 8px;
}

.detail-row {
    display: flex;
    justify-content: space-between;
    padding: 0.75rem 0;
    border-bottom: 1px solid #e8e8e8;
    font-size: 0.875rem;
}

.detail-row:last-child {
    border-bottom: none;
}

.detail-label {
    color: #666;
    font-weight: 500;
}

.detail-value {
    color: #1a1a1a;
    font-weight: 600;
    text-align: right;
}

.note-section {
    background: #fff3cd;
    border-left: 4px solid #ffc107;
    padding: 1.5rem;
    border-radius: 8px;
    margin: 2rem 0;
}

.note-label {
    font-size: 0.75rem;
    text-transform: uppercase;
    letter-spacing: 1px;
    font-weight: 700;
    margin-bottom: 0.5rem;
    color: #856404;
}

.note-text {
    color: #856404;
    line-height: 1.6;
}

.table-container {
    background: #fff;
    /* border-radius: 12px; */
    overflow: hidden;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
}

.minimal-table {
    width: 100%;
    border-collapse: collapse;
}

.minimal-table thead {
    background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%);
}

.minimal-table th {
    padding: 1.25rem 1rem;
    text-align: left;
    font-size: 0.75rem;
    text-transform: uppercase;
    letter-spacing: 1px;
    font-weight: 600;
    color: #fff;
}

.minimal-table td {
    padding: 1rem;
    border-bottom: 1px solid #f0f0f0;
    font-size: 0.875rem;
    color: #333;
}

.minimal-table tbody tr:hover {
    background: #f8f9fa;
}

.minimal-table tbody tr:last-child td {
    border-bottom: none;
}

.table-total-row {
    background: #f8f9fa;
    font-weight: 600;
}

.table-final-row {
    font-weight: 700;
}

.table-final-row td {
    border-bottom: none;
    font-size: 1rem;
}

@media (max-width: 768px) {
    .order-container {
        padding: 0 1rem;
    }
    
    .order-header {
        padding: 1.5rem;
    }
    
    .order-header h1 {
        font-size: 1.75rem;
    }
    
    .info-grid {
        grid-template-columns: 1fr;
        gap: 0;
        padding: 1.5rem;
    }
    
    .tracking-section {
        grid-template-columns: 1fr;
    }
    
    .card {
        padding: 1.5rem;
    }
    
    .minimal-table {
        font-size: 0.75rem;
    }
    
    .minimal-table th,
    .minimal-table td {
        padding: 0.75rem 0.5rem;
    }
}
</style>

<div class="content-wrapper">
    <div class="order-container card card-body">
        <!-- Order Header -->
        <div class="order-header">
            <h1>Order Details</h1>
            <div class="invoice-number">Invoice #<?= htmlspecialchars($order['invoice_no']) ?></div>
            <div class="order-date"><?= date('F j, Y', strtotime($order['order_date'])) ?></div>
        </div>

        <!-- Order Summary -->
        <div class="section">
            <div class="section-title">Order Summary</div>
            <div class="info-grid">
                <div class="info-item">
                    <div class="info-label">Order Amount</div>
                    <div class="info-value">৳ <?= calculate_order_amount($order['invoice_no']) ?></div>
                </div>
                <div class="info-item">
                    <div class="info-label">Order Status</div>
                    <div class="info-value">
                        <span class="status-badge"><?= htmlspecialchars($order['order_status']) ?></span>
                    </div>
                </div>
                <div class="info-item">
                    <div class="info-label">Payment Method</div>
                    <div class="info-value"><?= htmlspecialchars($order['payment_method']) ?></div>
                </div>
                <div class="info-item">
                    <div class="info-label">Payment Status</div>
                    <div class="info-value">
                        <span class="status-badge"><?= htmlspecialchars($order['payment_status'] ?? 'N/A') ?></span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tracking Section -->
        <div class="section">
            <div class="section-title">Shipment Tracking</div>
            <div class="tracking-section">
                <div class="tracking-card steadfast">
                    <div class="courier-logo">Steadfast Courier</div>
                    <div class="tracking-status"><?= $parcel_status ?></div>
                    <?php if ($is_tracking_code_set == 1): ?>
                        <a href="https://steadfast.com.bd/t/<?= $tracking_code ?>" class="track-btn" target="_blank">
                            Track Parcel
                        </a>
                    <?php endif; ?>
                </div>
                <div class="tracking-card pathao">
                    <div class="courier-logo">Pathao Courier</div>
                    <div class="tracking-status">Check Status</div>
                    <?php if (get_consignment_id($invoice_no) != 'Consignment Not Found!'): ?>
                        <a href="<?= get_track_parcel_url($invoice_no) ?>" class="track-btn" target="_blank">
                            Track Parcel
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Order Note -->
        <?php if (!empty($order['order_note'])): ?>
        <div class="note-section">
            <div class="note-label">Order Note</div>
            <div class="note-text"><?= htmlspecialchars($order['order_note']) ?></div>
        </div>
        <?php endif; ?>

        <!-- Shipping & Payment Info -->
        <div class="section">
            <div class="section-title">Customer Information</div>
            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-title">Shipping Address</div>
                        <div class="address-box">
                            <div class="detail-row">
                                <span class="detail-label">Name</span>
                                <span class="detail-value"><?= htmlspecialchars($order['user_full_name']) ?></span>
                            </div>
                            <div class="detail-row">
                                <span class="detail-label">Phone</span>
                                <span class="detail-value"><?= htmlspecialchars($order['user_phone']) ?></span>
                            </div>
                            <div class="detail-row">
                                <span class="detail-label">Email</span>
                                <span class="detail-value"><?= htmlspecialchars($order['user_email']) ?></span>
                            </div>
                            <div class="detail-row">
                                <span class="detail-label">Address</span>
                                <span class="detail-value"><?= htmlspecialchars($order['user_address']) ?></span>
                            </div>
                            <div class="detail-row">
                                <span class="detail-label">City</span>
                                <span class="detail-value"><?= htmlspecialchars($order['city_address']) ?></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-title">Payment Details</div>
                        <div class="payment-box">
                            <div class="detail-row">
                                <span class="detail-label">Method</span>
                                <span class="detail-value"><?= htmlspecialchars($order['payment_method']) ?></span>
                            </div>
                            <div class="detail-row">
                                <span class="detail-label">Status</span>
                                <span class="detail-value"><?= htmlspecialchars($order['payment_status'] ?? 'N/A') ?></span>
                            </div>
                            <div class="detail-row">
                                <span class="detail-label">Account Number</span>
                                <span class="detail-value"><?= htmlspecialchars($order['acc_number'] ?? 'N/A') ?></span>
                            </div>
                            <div class="detail-row">
                                <span class="detail-label">Transaction ID</span>
                                <span class="detail-value"><?= htmlspecialchars($order['transaction_id'] ?? 'N/A') ?></span>
                            </div>
                            <div class="detail-row">
                                <span class="detail-label">Payment Date</span>
                                <span class="detail-value"><?= $order['payment_date'] ? date('F j, Y', strtotime($order['payment_date'])) : 'N/A' ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Products Section -->
        <div class="section">
            <div class="section-title">Ordered Products</div>
            <div class="table-container">
                <table class="minimal-table">
                    <thead>
                        <tr>
                            <th>Sr</th>
                            <th>Product</th>
                            <th>SKU</th>
                            <th>Qty</th>
                            <th>Size</th>
                            <th>Color</th>
                            <th>Unit Price</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $total = 0;
                        foreach ($orders as $i => $row):
                            $unit_price = $row['product_quantity'] > 0 ? $row['total_price'] / $row['product_quantity'] : 0;
                            $total += $row['total_price'];
                        ?>
                        <tr>
                            <td><?= $i + 1 ?></td>
                            <td><?= htmlspecialchars($row['product_title']) ?></td>
                            <td><?= htmlspecialchars($row['product_code']) ?></td>
                            <td><?= $row['product_quantity'] ?></td>
                            <td><?= htmlspecialchars($row['product_size']) ?></td>
                            <td><?= htmlspecialchars($row['product_color'] ?? 'Default') ?></td>
                            <td>৳ <?= number_format($unit_price) ?></td>
                            <td>৳ <?= number_format((float)$row['total_price'], 2) ?></td>
                        </tr>
                        <?php endforeach; ?>
                        <tr class="table-total-row">
                            <td colspan="7" style="text-align: right;">Subtotal</td>
                            <td>৳ <?= number_format((float)$total, 2) ?></td>
                        </tr>
                        <tr class="table-total-row">
                            <td colspan="7" style="text-align: right;">Discount</td>
                            <td>- ৳ <?= number_format((float)calculate_discount_amount($invoice_no), 2) ?></td>
                        </tr>
                        <tr class="table-total-row">
                            <td colspan="7" style="text-align: right;">Shipping</td>
                            <td>৳ <?= number_format((float)find_shipping_charge($invoice_no), 2) ?></td>
                        </tr>
                        <tr class="table-final-row">
                            <td colspan="7" style="text-align: right;">TOTAL</td>
                            <td>৳ <?= number_format((float)$total + (float)find_shipping_charge($invoice_no) - (float)calculate_discount_amount($invoice_no), 2) ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="section">
          <div class="section-title">Download Invoices</div>
          <div class="d-flex gap-3">
            <a class="btn btn-dark mb-0" href="pos-invoice.php?inv=<?= $invoice_no ?>">POS Invoice</a>
            <a class="btn btn-dark mb-0" href="invoice.php?inv=<?= $invoice_no ?>">Regular Invoice</a>
            <a class="btn btn-dark" href="generate_label.php?invoice_no=<?= $invoice_no ?>">Shipping Label</a>
          </div>
        </div>
    </div>
</div>

<?php require 'footer.php'; ?>