<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

include 'database/dbConnection.php';

// Get order_no from GET
$order_no = $_GET['order_no'] ?? '';
if (!$order_no) die('Order number missing.');

// Fetch order header from customized_orders
$stmtOrder = $conn->prepare("SELECT * FROM customized_orders WHERE order_no = ? LIMIT 1");
$stmtOrder->bind_param("s", $order_no);
$stmtOrder->execute();
$orderRes = $stmtOrder->get_result();
$order = $orderRes->fetch_assoc();
if (!$order) die('Order not found.');

// Get product details
$productId = $order['product_id'];
$stmtProduct = $conn->prepare("SELECT cp.product_title, cp.advance_amount, cc.category_name 
                               FROM customized_products cp 
                               LEFT JOIN customized_category cc ON cp.category_id = cc.id 
                               WHERE cp.id = ? LIMIT 1");
$stmtProduct->bind_param("i", $productId);
$stmtProduct->execute();
$productRes = $stmtProduct->get_result();
$product = $productRes->fetch_assoc();

// Website info
$webInfoRow = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM website_info WHERE id=1"));
$websiteName    = $webInfoRow['name'] ?? 'Easy Tech';
$websiteLogo    = $webInfoRow['logo'] ?? '';
$websitePhone   = $webInfoRow['phone'] ?? 'N/A';
$websiteEmail   = $webInfoRow['email'] ?? 'N/A';
$websiteAddress = $webInfoRow['address'] ?? 'N/A';

// Calculate amount
$advance_amount = (float)($product['advance_amount'] ?? 0);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Invoice <?php echo htmlspecialchars($order_no); ?></title>
<link href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="assets/vendors/mdi/css/materialdesignicons.min.css">
<style>
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap');
* { font-family: 'Poppins', sans-serif; }
body { background:#f7f8fa; }
.container { max-width: 900px; margin: 20px auto; padding:20px; }
.invoice-block { padding: 30px; border:1px solid #ddd; background:#fff; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.08); }
.invoice-block h2 { color: #1e293b; font-weight: 700; }
.invoice-block h4 { color: #475569; }
.table th, .table td { vertical-align: middle !important; }
.table thead th { background: #1e293b; color: white; }
.btn-dark { font-size: 16px; padding: 10px 25px; color:#fff; background-color:#000; border:none; margin-top:10px; border-radius: 6px; }
.btn-dark:hover { background:#222; }
.divider { margin: 20px 0; border-top: 1px solid #e2e8f0; }
.info-section { margin-bottom: 15px; }
.info-section strong { color: #1e293b; }
.status-badge { display: inline-block; padding: 6px 12px; border-radius: 20px; font-size: 12px; font-weight: 600; }
.status-pending { background: #fef3c7; color: #92400e; }
.status-processing { background: #dbeafe; color: #1e40af; }
.status-completed { background: #d1fae5; color: #065f46; }
.status-cancelled { background: #fee2e2; color: #991b1b; }
@media print {
    body { background: white; }
    .btn-dark { display: none; }
    .action-buttons { display: none; }
}
</style>
</head>
<body>

<div class="container">
    <div class="invoice-block">
        <!-- Header -->
        <div style="text-align:center; margin-bottom: 30px;">
            <?php if(!empty($websiteLogo)) echo '<img src="'.htmlspecialchars($websiteLogo).'" style="width:80px; margin-bottom: 10px;">'; ?>
            <h2 style="margin:8px 0 4px;">INVOICE</h2>
            <h4 style="margin:0 0 6px; color: #3b82f6;">Order #<?php echo htmlspecialchars($order['order_no']); ?></h4>
            <?php 
            $status_class = 'status-' . strtolower(str_replace(' ', '_', $order['order_status']));
            echo '<span class="status-badge ' . $status_class . '">' . htmlspecialchars($order['order_status']) . '</span>';
            ?>
        </div>
        <div class="divider"></div>

        <!-- Business & Customer Info -->
        <div class="row">
            <div class="col-xs-6">
                <div class="info-section">
                    <strong>FROM:</strong><br>
                    <?php echo htmlspecialchars($websiteName); ?><br>
                    <small><?php echo htmlspecialchars($websitePhone); ?></small><br>
                    <small><?php echo htmlspecialchars($websiteEmail); ?></small><br>
                    <small><?php echo nl2br(htmlspecialchars($websiteAddress)); ?></small>
                </div>
            </div>
            <div class="col-xs-6 text-right">
                <div class="info-section">
                    <strong>BILLED TO:</strong><br>
                    <?php echo htmlspecialchars($order['user_full_name']); ?><br>
                    <small><?php echo htmlspecialchars($order['user_phone']); ?></small><br>
                    <small><?php echo htmlspecialchars($order['user_email']); ?></small><br>
                    <small><?php echo nl2br(htmlspecialchars($order['user_address'])); ?></small><br>
                    <small><strong>City:</strong> <?php echo htmlspecialchars($order['city_address']); ?></small>
                </div>
            </div>
        </div>
        <div class="divider"></div>

        <!-- Order Info -->
        <div class="row">
            <div class="col-xs-6">
                <strong>PAYMENT METHOD:</strong><br>
                <span><?php echo htmlspecialchars($order['payment_method']); ?></span>
                <?php if(!empty($order['transaction_id'])) echo '<br><small>Transaction ID: ' . htmlspecialchars($order['transaction_id']) . '</small>'; ?>
                <?php if(!empty($order['acc_number'])) echo '<br><small>Account: ' . htmlspecialchars($order['acc_number']) . '</small>'; ?>
            </div>
            <div class="col-xs-6 text-right">
                <strong>ORDER DATE:</strong><br>
                <span><?php echo date("F j, Y h:i A", strtotime($order['order_date'])); ?></span>
            </div>
        </div>
        <div class="divider"></div>

        <!-- Items Table -->
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th class="text-center">Category</th>
                        <th class="text-right">Advance Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <strong><?php echo htmlspecialchars($product['product_title'] ?? 'Customized Product'); ?></strong>
                            <?php if(!empty($order['order_note'])) echo '<br><small style="color: #64748b;">Note: ' . htmlspecialchars($order['order_note']) . '</small>'; ?>
                        </td>
                        <td class="text-center"><?php echo htmlspecialchars($product['category_name'] ?? 'N/A'); ?></td>
                        <td class="text-right"><strong>৳ <?php echo number_format($advance_amount, 2); ?></strong></td>
                    </tr>
                    <tr style="background: #1e293b; color: white;">
                        <td colspan="2" class="text-right"><strong>TOTAL AMOUNT</strong></td>
                        <td class="text-right"><strong>৳ <?php echo number_format($advance_amount, 2); ?></strong></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Footer -->
        <div style="margin-top: 30px; padding-top: 20px; border-top: 1px solid #e2e8f0; text-align: center; color: #64748b; font-size: 12px;">
            <p>Thank you for your business!</p>
            <p style="margin: 0;">This is an electronically generated invoice.</p>
        </div>
    </div>

    <div class="action-buttons" style="text-align: center;">
        <button class="btn btn-dark" onclick="downloadPDF()"><span class="mdi mdi-download"></span> Download PDF</button>
        <button class="btn btn-dark" style="background-color: #3b82f6;" onclick="window.print()"><span class="mdi mdi-printer"></span> Print</button>
    </div>
</div>

<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script>
async function downloadPDF() {
    const { jsPDF } = window.jspdf;
    const pdf = new jsPDF('p', 'mm', 'a4');
    const element = document.querySelector('.invoice-block');
    
    try {
        const canvas = await html2canvas(element, { scale: 2, useCORS: true });
        const imgData = canvas.toDataURL('image/png');
        const pdfWidth = 190;
        const pdfHeight = (canvas.height * pdfWidth) / canvas.width;
        
        pdf.addImage(imgData, 'PNG', 10, 10, pdfWidth, pdfHeight);
        pdf.save('Invoice_<?php echo htmlspecialchars($order_no); ?>.pdf');
    } catch(e) {
        alert('Error generating PDF. Please try again.');
        console.error(e);
    }
}
</script>

</body>
</html>