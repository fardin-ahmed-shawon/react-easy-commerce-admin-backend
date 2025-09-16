<?php
require '../database/dbConnection.php';

$invoice_no = $_GET['invoice_no'] ?? '';

$labels = [];
$brand_name = "";

// Fetch Brand Name
$sql = "SELECT name FROM website_info LIMIT 1";
$result = $conn->query($sql);
if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $brand_name = $row['name'];
}

// If invoice_no=all → fetch all orders grouped by invoice
if ($invoice_no === "all") {
    $sql = "SELECT invoice_no, user_full_name, user_phone 
            FROM order_info 
            GROUP BY invoice_no, user_full_name, user_phone";
    $result = $conn->query($sql);
    while ($row = $result->fetch_assoc()) {
        $labels[] = [
            'invoice_no' => $row['invoice_no'],
            'customer_name' => $row['user_full_name'],
            'customer_phone' => $row['user_phone']
        ];
    }
} elseif (!empty($invoice_no)) {
    // Fetch single order
    $stmt = $conn->prepare("SELECT user_full_name, user_phone 
                            FROM order_info 
                            WHERE invoice_no = ? 
                            LIMIT 1");
    $stmt->bind_param("s", $invoice_no);
    $stmt->execute();
    $stmt->bind_result($customer_name, $customer_phone);
    if ($stmt->fetch()) {
        $labels[] = [
            'invoice_no' => $invoice_no,
            'customer_name' => $customer_name,
            'customer_phone' => $customer_phone
        ];
    }
    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Order Labels</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #f8f9fa;
      padding: 20px;
      display: flex;
      flex-wrap: wrap;
      gap: 10px;
    }

    .label {
      width: 1.5in;
      height: 1in;
      border: 1px solid #000;
      padding: 2px;
      box-sizing: border-box;
      text-align: center;
      font-size: 10px;
      background: #fff;
    }

    .brand {
      font-weight: bold;
      font-size: 11px;
    }

    @media print {
      body {
        background: none;
        padding: 0;
        gap: 0;
        display: block;
      }
      .label {
        margin: 2px;
        border: 1px solid #000;
        page-break-inside: avoid;
        display: inline-block;
      }
      .no-print {
        display: none;
      }
    }
  </style>
</head>
<body>
  <?php if (!empty($labels)): ?>
      <?php foreach ($labels as $lbl): ?>
        <div class="label">
          <div class="brand"><?php echo htmlspecialchars($brand_name); ?></div>
          <div>Invoice: <?php echo htmlspecialchars($lbl['invoice_no']); ?></div>
          <br>
          <div>Name: <?php echo htmlspecialchars($lbl['customer_name']); ?></div>
          <div>Phone: <?php echo htmlspecialchars($lbl['customer_phone']); ?></div>
        </div>
      <?php endforeach; ?>
  <?php else: ?>
      <p>No labels found.</p>
  <?php endif; ?>

  <div class="no-print" style="width:100%; text-align:center; margin-top:20px;">
    <button onclick="window.print()">Print / Download PDF</button>
  </div>
</body>
</html>
