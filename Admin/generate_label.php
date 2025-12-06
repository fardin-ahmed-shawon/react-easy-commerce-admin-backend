<?php
// error_reporting(0);
require '../database/dbConnection.php';
require_once 'functions.php';

$invoice_no = $_GET['invoice_no'] ?? '';

$labels = [];
$brand_name = "";
$brand_phone = "";
$brand_address = "";
$shipping_charge = find_shipping_charge($invoice_no);

// Fetch Brand Info
$sql = "SELECT name, phone, address FROM website_info LIMIT 1";
$result = $conn->query($sql);
if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $brand_name = $row['name'];
    $brand_phone = $row['phone'] ?? '';
    $brand_address = $row['address'] ?? '';
}

if (!empty($invoice_no)) {
    if ($invoice_no === "all") {
        $sql = "SELECT oi.invoice_no, 
                  oi.user_full_name, 
                  oi.user_phone, 
                  oi.user_address,
                  oi.city_address,
                  oi.order_date,
                  GROUP_CONCAT(
                    CONCAT(
                      CAST(oi.product_title AS CHAR CHARACTER SET utf8mb4),
                      CASE 
                        WHEN oi.product_size IS NOT NULL AND oi.product_size <> '' 
                        THEN CONCAT(' - (', CAST(oi.product_size AS CHAR CHARACTER SET utf8mb4), ')') 
                        ELSE '' 
                      END,
                      ' x', oi.product_quantity,
                      ' @ ৳', FORMAT((CAST(oi.total_price AS DECIMAL) / CAST(oi.product_quantity AS DECIMAL)), 2)
                    ) SEPARATOR ', '
                  ) AS products
            FROM order_info oi
            WHERE oi.order_visibility = 'Show'
            GROUP BY oi.invoice_no";
        $result = $conn->query($sql);
        while ($row = $result->fetch_assoc()) {
            // Calculate totals
            $stmtTotals = $conn->prepare("SELECT SUM(total_price) as subtotal FROM order_info WHERE invoice_no = ?");
            $stmtTotals->bind_param("s", $row['invoice_no']);
            $stmtTotals->execute();
            $totalsRes = $stmtTotals->get_result();
            $totalsRow = $totalsRes->fetch_assoc();
            $subtotal = (float)$totalsRow['subtotal'];
            
            // Get discount
            $stmtDiscount = $conn->prepare("SELECT total_discount_amount FROM order_discount_list WHERE invoice_no = ? LIMIT 1");
            $stmtDiscount->bind_param("s", $row['invoice_no']);
            $stmtDiscount->execute();
            $discountRes = $stmtDiscount->get_result();
            $discount = 0;
            if ($discountRes && $discountRes->num_rows > 0) {
                $discountRow = $discountRes->fetch_assoc();
                $discount = (float)$discountRow['total_discount_amount'];
            }
            
            // Get order note
            $stmtNote = $conn->prepare("SELECT order_note FROM order_info WHERE invoice_no = ? LIMIT 1");
            $stmtNote->bind_param("s", $row['invoice_no']);
            $stmtNote->execute();
            $noteRes = $stmtNote->get_result();
            $order_note = '';
            if ($noteRes && $noteRes->num_rows > 0) {
                $noteRow = $noteRes->fetch_assoc();
                $order_note = $noteRow['order_note'] ?? '';
            }
            
            $labels[] = [
                'invoice_no' => $row['invoice_no'],
                'customer_name' => $row['user_full_name'],
                'customer_phone' => $row['user_phone'],
                'customer_address' => $row['user_address'],
                'city_address' => $row['city_address'],
                'order_date' => $row['order_date'],
                'products' => $row['products'],
                'subtotal' => $subtotal,
                'discount' => $discount,
                'order_note' => $order_note
            ];
        }
    } else {
        $invoice_array = explode(",", $invoice_no);
        $placeholders = implode(",", array_fill(0, count($invoice_array), "?"));
        $stmt = $conn->prepare("SELECT oi.invoice_no, 
                                       oi.user_full_name, 
                                       oi.user_phone, 
                                       oi.user_address, 
                                       oi.city_address, 
                                       oi.order_date,
                                       GROUP_CONCAT(
                                         CONCAT(
                                           CAST(oi.product_title AS CHAR CHARACTER SET utf8mb4), 
                                           CASE 
                                             WHEN oi.product_size IS NOT NULL AND oi.product_size <> '' 
                                             THEN CONCAT(' - (', CAST(oi.product_size AS CHAR CHARACTER SET utf8mb4), ')') 
                                             ELSE '' 
                                           END,
                                           ' x', oi.product_quantity,
                                           ' @ ৳', FORMAT((CAST(oi.total_price AS DECIMAL) / CAST(oi.product_quantity AS DECIMAL)), 2)
                                         ) SEPARATOR ', '
                                       ) AS products
                                FROM order_info oi
                                WHERE oi.invoice_no IN ($placeholders)
                                GROUP BY oi.invoice_no");
        $types = str_repeat("s", count($invoice_array));
        $stmt->bind_param($types, ...$invoice_array);
        $stmt->execute();
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            // Calculate totals
            $stmtTotals = $conn->prepare("SELECT SUM(total_price) as subtotal FROM order_info WHERE invoice_no = ?");
            $stmtTotals->bind_param("s", $row['invoice_no']);
            $stmtTotals->execute();
            $totalsRes = $stmtTotals->get_result();
            $totalsRow = $totalsRes->fetch_assoc();
            $subtotal = (float)$totalsRow['subtotal'];
            
            // Get discount
            $stmtDiscount = $conn->prepare("SELECT total_discount_amount FROM order_discount_list WHERE invoice_no = ? LIMIT 1");
            $stmtDiscount->bind_param("s", $row['invoice_no']);
            $stmtDiscount->execute();
            $discountRes = $stmtDiscount->get_result();
            $discount = 0;
            if ($discountRes && $discountRes->num_rows > 0) {
                $discountRow = $discountRes->fetch_assoc();
                $discount = (float)$discountRow['total_discount_amount'];
            }
            
            // Get order note
            $stmtNote = $conn->prepare("SELECT order_note FROM order_info WHERE invoice_no = ? LIMIT 1");
            $stmtNote->bind_param("s", $row['invoice_no']);
            $stmtNote->execute();
            $noteRes = $stmtNote->get_result();
            $order_note = '';
            if ($noteRes && $noteRes->num_rows > 0) {
                $noteRow = $noteRes->fetch_assoc();
                $order_note = $noteRow['order_note'] ?? '';
            }
            
            $labels[] = [
                'invoice_no' => $row['invoice_no'],
                'customer_name' => $row['user_full_name'],
                'customer_phone' => $row['user_phone'],
                'customer_address' => $row['user_address'],
                'city_address' => $row['city_address'],
                'order_date' => $row['order_date'],
                'products' => $row['products'],
                'subtotal' => $subtotal,
                'discount' => $discount,
                'order_note' => $order_note
            ];
        }
        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Shipping Labels</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.5/dist/JsBarcode.all.min.css">
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap');
    
    * { margin: 0; padding: 0; box-sizing: border-box; }
    
    body {
      font-family: 'Roboto', Arial, sans-serif;
      background: #f5f5f5;
      padding: 20px;
      display: flex;
      flex-wrap: wrap;
      gap: 15px;
      justify-content: center;
    }
    
    .label {
      width: 4in;
      height: 6in;
      background: #fff;
      border: 1px solid #ddd;
      padding: 0;
      font-size: 14px;
      position: relative;
      overflow: hidden;
      page-break-inside: avoid;
      box-shadow: 0 2px 8px rgba(0,0,0,0.1);
      display: flex;
      flex-direction: column;
    }
    
    .label-top {
      display: flex;
      justify-content: space-between;
      align-items: flex-start;
      padding: 10px;
      border-bottom: 1px solid #ddd;
      gap: 10px;
    }
    
    .brand-section {
      flex: 1;
    }
    
    .brand-name {
      font-size: 18px;
      font-weight: 700;
      color: #000;
      line-height: 1.2;
    }
    
    .brand-phone {
      font-size: 11px;
      color: #666;
      margin-top: 3px;
    }
    
    .barcode-section {
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      gap: 3px;
    }
    
    .barcode-image {
      width: 100px;
      height: 50px;
    }
    
    .label-body {
      flex: 1;
      padding: 10px;
      display: flex;
      flex-direction: column;
      gap: 8px;
      overflow: hidden;
      font-size: 12px;
    }
    
    .invoice-row {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 5px 0;
    }
    
    .invoice-label {
      font-size: 10px;
      font-weight: 600;
      color: #666;
      text-transform: uppercase;
    }
    
    .invoice-number {
      font-size: 18px;
      font-weight: 700;
      color: #000;
      letter-spacing: 1px;
    }
    
    .order-date {
      font-size: 11px;
      color: #000;
      font-weight: 500;
    }
    
    .customer-row {
      display: flex;
      justify-content: space-between;
      gap: 10px;
      padding: 5px 0;
    }
    
    .customer-name {
      font-size: 14px;
      font-weight: 700;
      color: #000;
    }
    
    .customer-phone {
      font-size: 13px;
      font-weight: 600;
      color: #000;
      text-align: right;
    }
    
    .address-row {
      padding: 5px 0;
      font-size: 12px;
      line-height: 1.4;
      color: #333;
    }
    
    .note-row {
      padding: 6px;
      background: #fff9e6;
      border-left: 3px solid #ffc107;
      font-size: 11px;
      line-height: 1.4;
      color: #333;
    }
    
    .products-section {
      flex: 1;
      overflow-y: auto;
      font-size: 11px;
      line-height: 1.4;
      padding: 6px;
      border: 1px solid #eee;
    }
    
    .products-title {
      font-size: 10px;
      font-weight: 700;
      text-transform: uppercase;
      color: #000;
      margin-bottom: 4px;
      padding-bottom: 3px;
      border-bottom: 1px solid #ddd;
    }
    
    .products-table {
      width: 100%;
      border-collapse: collapse;
      font-size: 10px;
    }
    
    .products-table thead {
      background: transparent;
    }
    
    .products-table th {
      padding: 3px 4px;
      text-align: left;
      font-weight: 700;
      border-bottom: 1px solid #999;
      font-size: 9px;
    }
    
    .products-table td {
      padding: 3px 4px;
      border-bottom: 1px solid #ddd;
      word-break: break-word;
    }
    
    .products-table tbody tr:last-child td {
      border-bottom: none;
    }
    
    .totals-section {
      font-size: 11px;
      padding: 6px;
      border-top: 1px solid #ddd;
    }
    
    .total-row {
      display: flex;
      justify-content: space-between;
      padding: 3px 0;
      font-weight: 600;
    }
    
    .label-footer {
      background: #f9f9f9;
      padding: 6px 10px;
      border-top: 1px solid #ddd;
      display: flex;
      justify-content: space-between;
      align-items: center;
      font-size: 10px;
      color: #666;
      font-weight: 500;
    }
    
    .button-group {
      position: fixed;
      bottom: 30px;
      right: 30px;
      display: flex;
      gap: 12px;
      z-index: 1000;
    }
    
    .btn {
      background: #000;
      color: #fff;
      border: none;
      padding: 12px 24px;
      font-size: 14px;
      font-weight: 600;
      cursor: pointer;
      border-radius: 4px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.2);
      transition: all 0.3s;
      display: flex;
      align-items: center;
      gap: 8px;
    }
    
    .btn:hover {
      background: #333;
      transform: translateY(-2px);
      box-shadow: 0 6px 16px rgba(0,0,0,0.3);
    }
    
    .btn-pdf {
      background: #007bff;
    }
    
    .btn-pdf:hover {
      background: #0056b3;
    }
    
    @media print {
      body { background: none; padding: 0; gap: 0; }
      .label { margin: 0; box-shadow: none; page-break-after: always; }
      .button-group { display: none !important; }
      @page { margin: 0; size: 4in 6in; }
    }
  </style>
</head>
<body>
  <?php if (!empty($labels)): ?>
      <?php foreach ($labels as $lbl): ?>
        <div class="label">
          <div class="label-top">
            <div class="brand-section">
              <div class="brand-name"><?php echo htmlspecialchars($brand_name); ?></div>
              <?php if(!empty($brand_phone)): ?>
                <div class="brand-phone">Help Line: <?php echo htmlspecialchars($brand_phone); ?></div>
              <?php endif; ?>
            </div>
            <div class="barcode-section">
              <svg id="barcode-<?php echo htmlspecialchars($lbl['invoice_no']); ?>" class="barcode-image"></svg>
            </div>
          </div>

          <div class="label-body">
            <div class="invoice-row">
              <div>
                <div class="invoice-label">Invoice No:</div>
                <div class="invoice-number">#<?php echo htmlspecialchars($lbl['invoice_no']); ?></div>
              </div>
              <div>
                  <div class="invoice-label">Date:</div>
                  <div class="order-date"><?php echo date('Y-m-d', strtotime($lbl['order_date'])); ?></div>
              </div>
            </div>

            <div class="customer-row">
                <div>
                    <div class="invoice-label">Name:</div>
                    <div class="customer-name"><?php echo htmlspecialchars($lbl['customer_name']); ?></div>
                </div>
                
                <div>
                    <div class="invoice-label">Cell No:</div>
                    <div class="customer-phone"><?php echo htmlspecialchars($lbl['customer_phone']); ?></div>
                </div>
              
              
            </div>


            <div class="invoice-label">Address:</div>
            <div class="address-row">
              <?php echo nl2br(htmlspecialchars($lbl['customer_address'])); ?>
            </div>

            <?php if(!empty($lbl['order_note'])): ?>
              <div class="note-row">
                <strong>Customer Note:</strong> <?php echo htmlspecialchars($lbl['order_note']); ?>
              </div>
            <?php endif; ?>

            <div class="products-section">
              <div class="products-title">Items</div>
              <table class="products-table">
                <thead>
                  <tr>
                    <th>Product</th>
                    <th>Qty</th>
                    <th style="text-align: right;">Price(Tk.)</th>
                  </tr>
                </thead>
                <tbody>
                  <?php 
                    $stmtItems = $conn->prepare("SELECT product_title, product_size, product_color, product_quantity, total_price FROM order_info WHERE invoice_no = ?");
                    $stmtItems->bind_param("s", $lbl['invoice_no']);
                    $stmtItems->execute();
                    $itemsRes = $stmtItems->get_result();
                    
                    while ($item = $itemsRes->fetch_assoc()) {
                        $qty = (int)$item['product_quantity'];
                        $price = (float)$item['total_price'] / $qty;
                        $size = !empty($item['product_size']) ? ' (' . htmlspecialchars($item['product_size']) . ')' : '';
                        $color = !empty($item['product_color']) ? ' (' . htmlspecialchars($item['product_color']) . ')' : '';
                        echo '<tr>
                                <td>' . htmlspecialchars($item['product_title']) . $size . $color . '</td>
                                <td style="text-align: center;">' . $qty . '</td>
                                <td style="text-align: right;">' . number_format($price, 0) . '</td>
                              </tr>';
                    }
                  ?>
                </tbody>
              </table>
            </div>

            <div class="totals-section">
              <div class="total-row">
                <span>Subtotal(Tk.):</span>
                <span><?php echo number_format($lbl['subtotal'], 2); ?></span>
              </div>
              <div class="total-row">
                <span>Shipping Charge(Tk.):</span>
                <span><?php echo number_format($shipping_charge, 2); ?></span>
              </div>
              
              <?php if ($lbl['discount'] > 0): ?>
                <div class="total-row">
                  <span>Discount(Tk.):</span>
                  <span><?php echo number_format($lbl['discount'], 2); ?></span>
                </div>
              <?php endif; ?>
              <div class="total-row" style="border-top: 1px dashed #999; padding-top: 3px; margin-top: 2px;">
                <span>Total(Tk.):</span>
                <span><?php echo number_format($lbl['subtotal'] + $shipping_charge - $lbl['discount'], 2); ?></span>
              </div>
            </div>
          </div>

          <div class="label-footer">
            <span><?php echo date('d M Y', strtotime($lbl['order_date'])); ?></span>
            <span>Order: <?php echo htmlspecialchars($lbl['invoice_no']); ?></span>
          </div>
        </div>
      <?php endforeach; ?>
  <?php else: ?>
      <div style="width: 100%; text-align: center; padding: 40px; background: #fff; border-radius: 8px;">
        <h2>No labels found</h2>
        <p>Please provide a valid invoice number.</p>
      </div>
  <?php endif; ?>

  <div class="button-group">
    <button class="btn btn-pdf" id="downloadPDF">
      <i class="fas fa-file-pdf"></i> Download PDF
    </button>
    <button class="btn" onclick="window.print()">
      <i class="fas fa-print"></i> Print
    </button>
  </div>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.5/dist/JsBarcode.all.min.js"></script>

  <script>
    // Generate barcodes for all invoices
    <?php foreach ($labels as $lbl): ?>
      JsBarcode("#barcode-<?php echo htmlspecialchars($lbl['invoice_no']); ?>", "<?php echo htmlspecialchars($lbl['invoice_no']); ?>", {
        format: "CODE128",
        width: 2.5,
        height: 50,
        displayValue: false
      });
    <?php endforeach; ?>

    // PDF Download
    document.getElementById('downloadPDF').addEventListener('click', async () => {
      const { jsPDF } = window.jspdf;
      const labels = document.querySelectorAll('.label');
      const pdf = new jsPDF({ orientation: 'portrait', unit: 'in', format: [4, 6] });

      for (let i = 0; i < labels.length; i++) {
        const canvas = await html2canvas(labels[i], { scale: 2 });
        const imgData = canvas.toDataURL('image/png');
        if (i > 0) pdf.addPage();
        pdf.addImage(imgData, 'PNG', 0, 0, 4, 6);
      }

      pdf.save('Shipping_Labels.pdf');
    });
  </script>
</body>
</html>