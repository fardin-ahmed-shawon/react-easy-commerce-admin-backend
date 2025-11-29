<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

include 'database/dbConnection.php';
require_once 'functions.php'; // your helper functions

// Optional selected invoices
$selectedInvoices = [];
if (isset($_GET['invoice'])) {
    $raw = $_GET['invoice'];
    if (is_array($raw)) $arr = $raw;
    else $arr = explode(',', (string)$raw);
    foreach ($arr as $inv) {
        $inv = trim($inv);
        if ($inv === '') continue;
        if (preg_match('/^[A-Za-z0-9_\-]+$/', $inv)) $selectedInvoices[] = $inv;
    }
    $selectedInvoices = array_values(array_unique($selectedInvoices));
}

// Website info
$webInfoRow = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM website_info WHERE id=1"));
$websiteName   = $webInfoRow['name'] ?? 'Easy Tech';
$websiteLogo   = $webInfoRow['logo'] ?? '';
$websitePhone  = $webInfoRow['phone'] ?? 'N/A';
$websiteEmail  = $webInfoRow['email'] ?? 'N/A';
$websiteAddress= $webInfoRow['address'] ?? 'N/A';

// Fetch invoices
if (!empty($selectedInvoices)) {
    $placeholders = implode(',', array_fill(0, count($selectedInvoices), '?'));
    $sql = "SELECT DISTINCT invoice_no FROM order_info WHERE invoice_no IN ($placeholders) AND order_status != 'Pending' AND order_visibility = 'Show' ORDER BY invoice_no DESC";
    $stmt = $conn->prepare($sql);
    $types = str_repeat('s', count($selectedInvoices));
    $stmt->bind_param($types, ...$selectedInvoices);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $sql = "SELECT DISTINCT invoice_no FROM order_info WHERE order_status != 'Pending' AND order_visibility = 'Show' ORDER BY invoice_no DESC";
    $result = mysqli_query($conn, $sql);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>All Invoices</title>
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
    page-break-after: always;
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
    margin-bottom: 20px;
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
        page-break-after: always;
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

    .signature-section {
        page-break-inside: avoid;
    }
}
</style>
</head>
<body>

<div class="btn-area">
    <button class="btn btn-dark btn-custom" onclick="downloadPDF()">
        <i class="mdi mdi-download"></i> Download PDF
    </button>
    <button class="btn btn-outline-dark btn-custom" onclick="window.print()">
        <i class="mdi mdi-printer"></i> Print Invoices
    </button>
</div>

<div id="invoiceArea">
<?php
if ($result && ($result->num_rows ?? 0) > 0) {
    $stmtOrderHeader = $conn->prepare("SELECT * FROM order_info WHERE invoice_no = ? LIMIT 1");
    $stmtItems = $conn->prepare("SELECT * FROM order_info WHERE invoice_no = ?");
    $stmtDiscount = $conn->prepare("SELECT total_discount_amount FROM order_discount_list WHERE invoice_no = ? LIMIT 1");

    while ($r = $result->fetch_assoc()) {
        $invoice_no = $r['invoice_no'];

        $stmtOrderHeader->bind_param("s", $invoice_no);
        $stmtOrderHeader->execute();
        $hdrRes = $stmtOrderHeader->get_result();
        $order = $hdrRes->fetch_assoc();
        if (!$order) continue;

        $discount_amount = 0.0;
        $stmtDiscount->bind_param("s", $invoice_no);
        $stmtDiscount->execute();
        $dres = $stmtDiscount->get_result();
        if ($dres && $dres->num_rows > 0) {
            $drow = $dres->fetch_assoc();
            $discount_amount = (float)$drow['total_discount_amount'];
        }

        $stmtItems->bind_param("s", $invoice_no);
        $stmtItems->execute();
        $prodRes = $stmtItems->get_result();
?>
<div class="invoice-container">
    
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
                    <th>Unit</th>
                    <th class="text-center">Qty</th>
                    <th class="text-end">Price(Tk.)</th>
                    <th class="text-end">Total(Tk.)</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $subtotal = 0;
                while($item = $prodRes->fetch_assoc()) {
                    $qty = max(1,(int)$item['product_quantity']);
                    $unit_price = (float)$item['total_price'] / $qty;
                    $subtotal += (float)$item['total_price'];
                    echo '<tr>
                            <td>'.htmlspecialchars($item['product_title']).'</td>
                            <td>'.htmlspecialchars($item['product_size']).'</td>
                            
                            <td class="text-center">'.intval($qty).'</td>
                            <td class="text-end">'.number_format($unit_price,2).'</td>
                            <td class="text-end">'.number_format((float)$item['total_price'],2).'</td>
                          </tr>';
                }
                $shipping = (float)find_shipping_charge($invoice_no);
                $total = $subtotal + $shipping - $discount_amount;
                ?>
                <tr><td colspan="4" class="text-end"><strong>Subtotal(Tk.)</strong></td><td class="text-end"><strong><?php echo number_format($subtotal,2); ?></strong></td></tr>
                <tr><td colspan="4" class="text-end"><strong>Shipping Cost(Tk.)</strong></td><td class="text-end"><strong><?php echo number_format($shipping,2); ?></strong></td></tr>
                <tr><td colspan="4" class="text-end"><strong>Discount(Tk.)</strong></td><td class="text-end"><strong><?php echo number_format($discount_amount,2); ?></strong></td></tr>
                <tr><td colspan="4" class="text-end"><strong>Grand Total(Tk.)</strong></td><td class="text-end"><strong><?php echo number_format($total,2); ?></strong></td></tr>
                
                <tr>
                    <td colspan="5" class="text-center">
                        <strong>In Word(Tk.): </strong>
                            <?php
                                echo number_formatter_to_text($total);
                            ?>
                    </td>
                </tr>
                
            </tbody>
        </table>
    </div>

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
<?php
    } // end while
    $stmtOrderHeader->close();
    $stmtItems->close();
    $stmtDiscount->close();
} else {
    echo '<p class="text-center">No invoices found.</p>';
}
?>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script>
async function downloadPDF() {
    const { jsPDF } = window.jspdf;
    const blocks = document.querySelectorAll(".invoice-container");
    if (!blocks.length) { alert("No invoices to download"); return; }

    const pdf = new jsPDF("p", "mm", "a4");
    const pageWidth = 210;
    const pageHeight = 297;

    for (let i = 0; i < blocks.length; i++) {
        try {
            const canvas = await html2canvas(blocks[i], { 
                scale: 2,
                useCORS: true,
                logging: false
            });

            const pdfWidth = 210;
            const pdfHeight = (canvas.height * pdfWidth) / canvas.width;

            const imgData = canvas.toDataURL("image/png");
            
            if (i > 0) pdf.addPage();
            pdf.addImage(imgData, "PNG", 0, 0, pdfWidth, pdfHeight);
        } catch (error) {
            console.error("Error generating PDF for invoice " + i, error);
        }
    }
    
    pdf.save("All_Invoices.pdf");
}
</script>

</body>
</html>