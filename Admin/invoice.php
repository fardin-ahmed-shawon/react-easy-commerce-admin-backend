<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

include 'database/dbConnection.php';
require_once 'functions.php'; // Make sure your helper functions are loaded

$invoice_no = $_GET['inv'] ?? '';
if (!$invoice_no) die('Invoice number missing.');

// Fetch order header
$stmtOrder = $conn->prepare("SELECT * FROM order_info WHERE invoice_no = ? LIMIT 1");
$stmtOrder->bind_param("s", $invoice_no);
$stmtOrder->execute();
$orderRes = $stmtOrder->get_result();
$order = $orderRes->fetch_assoc();
if (!$order) die('Order not found.');

// Fetch discount
$stmtDiscount = $conn->prepare("SELECT total_discount_amount FROM order_discount_list WHERE invoice_no = ? LIMIT 1");
$stmtDiscount->bind_param("s", $invoice_no);
$stmtDiscount->execute();
$dres = $stmtDiscount->get_result();
$discount_amount = 0.0;
if ($dres && $dres->num_rows > 0) {
    $drow = $dres->fetch_assoc();
    $discount_amount = (float)$drow['total_discount_amount'];
}

// Fetch items
$stmtItems = $conn->prepare("SELECT o.*, p.product_code 
FROM order_info o
LEFT JOIN product_info p ON p.product_id = o.product_id
WHERE invoice_no = ?
");
$stmtItems->bind_param("s", $invoice_no);
$stmtItems->execute();
$itemsRes = $stmtItems->get_result();

// Website info
$webInfoRow = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM website_info WHERE id=1"));
$websiteName   = $webInfoRow['name'] ?? 'Easy Tech';
$websiteLogo   = $webInfoRow['logo'] ?? '';
$websitePhone  = $webInfoRow['phone'] ?? 'N/A';
$websiteEmail  = $webInfoRow['email'] ?? 'N/A';
$websiteAddress= $webInfoRow['address'] ?? 'N/A';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Invoice <?php echo htmlspecialchars($invoice_no); ?></title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/@mdi/font/css/materialdesignicons.min.css" rel="stylesheet">
<style>
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap');

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    background: #f5f6fa;
    font-family: 'Poppins', sans-serif;
    font-size: 14px;
}

.invoice-container {
    max-width: 900px;
    margin: 20px auto;
    background: #fff;
    border: 1px solid #ddd;
    padding: 15px;
    border-radius: 8px;
    font-size: 11px;
}

/* Header Section */
.header-logo-section {
    text-align: center;
    margin-bottom: 30px;
}

.header-logo-section img {
    width: 120px;
    object-fit: contain;
}

.header-top {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 15px;
    gap: 15px;
}

.company-info {
    flex: 1;
}

.company-info h3 {
    margin: 0 0 5px 0;
    font-size: 14px;
    font-weight: 700;
    color: #000;
}

.company-info p {
    margin: 3px 0;
    font-size: 10px;
    /*color: #666;*/
    line-height: 1.4;
}

.invoice-details-table {
    flex: 1;
    min-width: 250px;
}

.invoice-details-table table {
    width: 100%;
    border-collapse: collapse;
    border: 1px solid #ccc;
}

.invoice-details-table th {
    background: #f8f9fa;
    padding: 4px 8px;
    font-weight: 600;
    font-size: 10px;
    color: #000;
    border: 1px solid #ccc;
    text-align: left;
}

.invoice-details-table td {
    padding: 4px 8px;
    font-size: 10px;
    color: #000;
    border: 1px solid #ccc;
}

/* Invoice Info Section */
.invoice-info-section {
    margin-bottom: 12px;
}

.customer-info {
    padding: 10px;
    background: #fafafa;
    border-radius: 4px;
    border: 1px solid #eee;
}

.customer-info strong {
    display: block;
    margin-bottom: 5px;
    font-size: 10px;
    color: #000;
    font-weight: 600;
}

.customer-info p {
    margin: 0;
    font-size: 10px;
    color: #000;
    line-height: 1.4;
    word-break: break-word;
}

/* Items Table */
.table-responsive {
    margin-bottom: 12px;
}

.table {
    margin: 0;
    font-size: 10px;
}

.table thead {
    background: #f8f9fa;
}

.table th {
    padding: 6px 8px;
    font-weight: 600;
    border: 1px solid #ccc;
    font-size: 10px;
    color: #000;
}

.table td {
    padding: 5px 8px;
    border: 1px solid #ccc;
    color: #000;
}

.text-end { text-align: right; }
.text-center { text-align: center; }

/* Terms Section */
.terms-section {
    padding: 10px 0;
    margin: 12px 0;
    /*border-top: 1px solid #ddd;*/
    /*border-bottom: 1px solid #ddd;*/
}

.terms-section h5 {
    font-weight: 600;
    font-size: 11px;
    margin-bottom: 6px;
}

.terms-list {
    list-style: none;
    padding: 0;
    margin: 0;
}

.terms-list li {
    padding: 3px 0 3px 15px;
    position: relative;
    font-size: 9px;
    line-height: 1.3;
    color: #000;
}

.terms-list li:before {
    content: "•";
    position: absolute;
    left: 5px;
    font-weight: bold;
    color: #000;
}

/* Signature Section */
.signature-section {
    padding: 15px 0;
    margin-top: 12px;
}

.row {
    display: flex;
    gap: 20px;
}

.col-sm-6 {
    flex: 1;
}

.col-sm-6.text-end {
    text-align: right;
}

.signature-box {
    padding: 5px 0;
}

.signature-line {
    border-bottom: 1px solid #000;
    width: 150px;
    height: 40px;
    margin-bottom: 5px;
}

.col-sm-6.text-end .signature-line {
    margin-left: auto;
}

.signature-label {
    font-weight: 600;
    font-size: 10px;
    margin: 3px 0;
    color: #000;
}

.signature-date {
    font-size: 9px;
    color: #666;
    margin: 3px 0 0 0;
}

/* Footer */
.invoice-footer {
    border-top: 1px solid #ddd;
    padding-top: 10px;
    text-align: center;
}

.invoice-footer p {
    font-size: 9px;
    color: #666;
    margin: 3px 0;
}

/* Button Area */
.btn-area {
    display: flex;
    justify-content: center;
    gap: 10px;
    margin-top: 20px;
}

.btn-custom {
    font-size: 13px;
    padding: 8px 20px;
    border-radius: 5px;
    transition: 0.3s;
    border: none;
    cursor: pointer;
    font-weight: 500;
}

.btn-dark {
    background: #000;
    color: #fff;
}

.btn-dark:hover {
    background: #333;
}

.btn-outline-dark {
    border: 1px solid #000;
    color: #000;
    background: #fff;
}

.btn-outline-dark:hover {
    background: #000;
    color: #fff;
}

/* Print Styling */
@media print {
    body {
        background: #fff;
        margin: 0;
        padding: 0;
    }

    .btn-area {
        display: none !important;
    }

    .invoice-container {
        max-width: 100%;
        margin: 0;
        border: none;
        padding: 0;
        box-shadow: none;
        border-radius: 0;
        page-break-after: avoid;
    }

    .invoice-container * {
        page-break-inside: avoid;
    }

    .table-responsive {
        page-break-inside: avoid;
    }

    .table {
        page-break-inside: avoid;
    }

    .terms-section {
        page-break-inside: avoid;
    }

    .signature-section {
        page-break-inside: avoid;
    }
}
</style>
</head>
<body>

<div class="invoice-container" id="invoice">
    
    <!-- Header Section -->
    <div class="invoice-header">
        <!-- Logo Row -->
        <div class="header-logo-section">
            <?php if (!empty($websiteLogo)): ?>
                <img src="<?php echo htmlspecialchars($websiteLogo); ?>" alt="Logo">
            <?php endif; ?>
        </div>

        <!-- Company Info & Invoice Details Row -->
        <div class="header-top">
            <div class="company-info">
                <h3><?php echo htmlspecialchars($websiteName); ?></h3>
                <p><?php echo htmlspecialchars($websitePhone); ?></p>
                <p><?php echo htmlspecialchars($websiteEmail); ?></p>
                <p><?php echo nl2br(htmlspecialchars($websiteAddress)); ?></p>
            </div>

            <div class="invoice-details-table">
                <table>
                    <thead>
                        <tr>
                            <th colspan="2" style="text-align: center">Invoice / Bill</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><strong>Invoice No:</strong></td>
                            <td><?php echo htmlspecialchars($order['invoice_no']); ?></td>
                        </tr>
                        <tr>
                            <td><strong>Date:</strong></td>
                            <td><?php echo date("F j, Y", strtotime($order['order_date'])); ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Customer Information Section -->
    <div class="invoice-info-section">
        <div class="customer-info">
            <strong>BILL TO:</strong>
            <p>
                <b>Name:</b> <?php echo htmlspecialchars($order['user_full_name']); ?>, 
                <b>Phone:</b> <?php echo htmlspecialchars($order['user_phone']); ?>, 
                <b>Email:</b> <?php echo htmlspecialchars($order['user_email']); ?>, 
                <b>Address:</b> <?php echo htmlspecialchars($order['user_address']); ?>
            </p>
        </div>
    </div>

    <!-- Items Table -->
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Item</th>
                    <th>SKU</th>
                    <th>Size</th>
                    <th>Color</th>
                    <th class="text-center">Qty</th>
                    <th class="text-end">Price(Tk.)</th>
                    <th class="text-end">Total(Tk.)</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $subtotal = 0;
                while($item = $itemsRes->fetch_assoc()) {
                    $qty = max(1,(int)$item['product_quantity']);
                    $unit_price = (float)$item['total_price'] / $qty;
                    $subtotal += (float)$item['total_price'];
                    echo '<tr>
                            <td>'.htmlspecialchars($item['product_title']).'</td>
                            <td>'.htmlspecialchars($item['product_code']).'</td>
                            <td>' . (!empty($item['product_size']) && $item['product_size'] !== "N/A" ? htmlspecialchars($item['product_size']) : "N/A") . '</td>
                            <td>' . (!empty($item['product_color']) && $item['product_color'] !== "N/A" ? htmlspecialchars($item['product_color']) : "N/A") . '</td>
                            <td class="text-center">'.intval($qty).'</td>
                            <td class="text-end">'.number_format($unit_price,2).'</td>
                            <td class="text-end">'.number_format((float)$item['total_price'],2).'</td>
                          </tr>';
                }
                $shipping = (float)find_shipping_charge($invoice_no);
                $total = $subtotal + $shipping - $discount_amount;
                ?>
                <tr><td colspan="6" class="text-end"><strong>Subtotal(Tk.)</strong></td><td class="text-end"><strong><?php echo number_format($subtotal,2); ?></strong></td></tr>
                <tr><td colspan="6" class="text-end"><strong>Shipping Cost(Tk.)</strong></td><td class="text-end"><strong><?php echo number_format($shipping,2); ?></strong></td></tr>
                <tr><td colspan="6" class="text-end"><strong>Discount(Tk.)</strong></td><td class="text-end"><strong><?php echo number_format($discount_amount,2); ?></strong></td></tr>
                <tr><td colspan="6" class="text-end"><strong>Grand Total(Tk.)</strong></td><td class="text-end"><strong><?php echo number_format($total,2); ?></strong></td></tr>
                
                <tr>
                    <td colspan="7" class="text-center">
                        <strong>In Word(Tk.): </strong>
                            <?php
                                echo number_formatter_to_text($total);
                            ?>
                    </td>
                </tr>
                
            </tbody>
        </table>
    </div>

    <!-- Terms & Conditions Section -->
    <!-- <div class="terms-section">
        <h5>Terms & Conditions</h5>
        <ul class="terms-list">
            <li>All payments must be made within the specified time mentioned in the invoice.</li>
            <li>Products that are damaged, defective, or incorrect are eligible for return within 2–3 business days.</li>
            <li>Courier/transport charges must be borne by the buyer unless otherwise stated.</li>
            <li>Prices may change without prior notice due to market price fluctuations.</li>
            <li>Special terms regarding payment, delivery, and discounts may apply to bulk orders.</li>
        </ul>
    </div> -->


    <!-- Signature Section -->
    <div class="signature-section">
        <div class="row">
            <div class="col-sm-6">
                <div class="signature-box">
                    <p class="signature-label">Goods received in good Condition.</p>
                    <div class="signature-line"></div>
                    <p class="signature-label">Customer Signature</p>
                    <p class="signature-date">Date: _________________</p>
                </div>
            </div>
            <div class="col-sm-6 text-end">
                <div class="signature-box">
                    <div class="signature-line"></div>
                    <p class="signature-label">Authorized Signature</p>
                    <p class="signature-date">Date: _________________</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer Note -->
    <div class="invoice-footer">
        <p>Thank you for your business!</p>
        <p>This is a computer-generated invoice and does not require a physical signature unless specified.</p>
    </div>
</div>

<div class="btn-area">
    <button class="btn btn-dark btn-custom" onclick="downloadPDF()">
        <i class="mdi mdi-download"></i> Download PDF
    </button>
    <button class="btn btn-outline-dark btn-custom" onclick="window.print()">
        <i class="mdi mdi-printer"></i> Print Invoice
    </button>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script>
async function downloadPDF() {
    const { jsPDF } = window.jspdf;
    const invoice = document.querySelector("#invoice");

    try {
        const canvas = await html2canvas(invoice, { 
            scale: 2,
            useCORS: true,
            logging: false
        });

        const pdf = new jsPDF("p", "mm", "a4");
        const pdfWidth = 210;
        const pdfHeight = (canvas.height * pdfWidth) / canvas.width;

        const imgData = canvas.toDataURL("image/png");
        pdf.addImage(imgData, "PNG", 0, 0, pdfWidth, pdfHeight);
        pdf.save("Invoice_<?php echo htmlspecialchars($invoice_no); ?>.pdf");
    } catch (error) {
        alert("Error generating PDF. Please try again.");
        console.error(error);
    }
}
</script>

</body>
</html>