<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

// Database connection
include '../dbConnection.php';

// Fetch order data
$invoice_no = $_GET['inv']; // Assuming order_no is passed as a query parameter
$sql = "SELECT * FROM order_info WHERE invoice_no = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $invoice_no);
$stmt->execute();
$result = $stmt->get_result();
$order = $result->fetch_assoc();

if (!$order) {
    die("Order not found.");
}
?>

<?php
	$websiteInfoQuery = "SELECT * FROM website_info WHERE id=1";
	$websiteInfoResult = mysqli_query($conn, $websiteInfoQuery);
	$websiteInfo = mysqli_fetch_assoc($websiteInfoResult);

	$websiteName = $websiteInfo['name'] ?? 'Easy Tech';
	$websiteLogo = $websiteInfo['logo'] ?? '';

	$websiteAddress = $websiteInfo['address'] ?? 'N/A';
	$websitePhone = $websiteInfo['phone'] ?? 'N/A';
	$websiteEmail = $websiteInfo['email'] ?? 'N/A';


	$inside_delivery_charge = $websiteInfo['inside_delivery_charge'] ?? '80';
	$outside_delivery_charge = $websiteInfo['outside_delivery_charge'] ?? '150';

	
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
	<link rel="stylesheet" href="assets/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="style.css">
    <style>
		@import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');
		* {
			font-family: "Poppins", serif;
		}

        .invoice-title h2, .invoice-title h3 {
        display: inline-block;
        }

        .table > tbody > tr > .no-line {
            border-top: none;
        }

        .table > thead > tr > .no-line {
            border-bottom: none;
        }

        .table > tbody > tr > .thick-line {
            border-top: 2px solid;
        }

		.btn-dark {
			font-size: 16px;
			padding: 10px 25px;
			color: #fff;
			background-color: #000;
		}
		.btn-dark:hover {
			color: #fff;
			background-color: #1f1e1e;
		}
    </style>
</head>
<body>

<div id="printArea" class="container">
	<div class="row text-center">
		<br><br>
        <!-- <a href="index.php">
			<h2><?php include '../logo.php'; ?></h2>
		</a> -->
    </div><br><hr><br>
    <div class="row">
        <div class="col-xs-12">
    		<div class="invoice-title">
    			<h2>Invoice</h2><h3 class="pull-right">NO: <?php echo htmlspecialchars($order['invoice_no']); ?></h3>
    		</div>
    		<hr>
    		<div class="row">
    			<div class="col-xs-6">
    				<address>
    				<strong>FROM:</strong><br>
    					<?php echo $websiteName; ?><br>
    					<?php echo $websitePhone; ?><br>
    					<?php echo $websiteEmail; ?><br>
    					<?php echo $websiteAddress; ?>
    				</address>
    			</div>
    			<div class="col-xs-6 text-right">
				<address>
                        <strong>Billed To:</strong><br>
                        <?php echo htmlspecialchars($order['user_first_name'] . ' ' . $order['user_last_name']); ?><br>
                        <?php echo htmlspecialchars($order['user_phone']); ?><br>
                        <?php echo htmlspecialchars($order['user_email']); ?><br>
                        <?php echo htmlspecialchars($order['user_address']); ?>
                    </address>
    			</div>
    		</div>
    		<div class="row">
    			<div class="col-xs-6">
    				<address>
    					<strong>Payment Method:</strong><br>
    					bKash<br>
    				</address>
    			</div>
    			<div class="col-xs-6 text-right">
					<address>
                        <strong>Order Date:</strong><br>
                        <?php echo date("F j, Y", strtotime($order['order_date'])); ?><br><br>
                    </address>
    			</div>
    		</div>
    	</div>
    </div>
    <div class="row">
    	<div class="col-md-12">
    		<div class="panel panel-default">
    			<div class="panel-heading">
    				<h3 class="panel-title"><strong>Order summary</strong></h3>
    			</div>
    			<div class="panel-body">
    				<div class="table-responsive">
    					<table class="table table-condensed">
    						<thead>
                                <tr>
        							<td><strong>Item</strong></td>
        							<td class="text-center"><strong>Price</strong></td>
        							<td class="text-center"><strong>Quantity</strong></td>
        							<td class="text-right"><strong>Totals</strong></td>
                                </tr>
    						</thead>
    						<tbody>
    							<!-- foreach ($order->lineItems as $line) or some such thing here -->
								<?php 
									$sql = "SELECT * FROM order_info WHERE invoice_no = ?";
									$stmt = $conn->prepare($sql);
									$stmt->bind_param("s", $invoice_no);
									$stmt->execute();
									$result = $stmt->get_result();
									$row = mysqli_num_rows($result);

									$subtotals = 0;
									$total = 0;

									if($row > 0){
										while($product = mysqli_fetch_assoc($result)){
											echo '<tr>
												<td>'.$product['product_title'].'</td>
												<td class="text-center">BDT '.$product['total_price'] / $product['product_quantity'].'</td>
												<td class="text-center">'.$product['product_quantity'].'</td>
												<td class="text-right">BDT '.$product['total_price'].'</td>
											</tr>';
											$subtotals += $product['total_price'];
										}
									}
								?>

    							<tr>
    								<td class="thick-line"></td>
    								<td class="thick-line"></td>
    								<td class="thick-line text-center"><strong>Subtotal</strong></td>
    								<td class="thick-line text-right">BDT <?php echo $subtotals; ?></td>
    							</tr>
    							<tr>
    								<td class="no-line"></td>
    								<td class="no-line"></td>
    								<td class="no-line text-center"><strong>Shipping</strong></td>
    								<td class="no-line text-right">BDT <?php 
									if ($order['city_address'] == "Inside Dhaka") {
										$shipping = $inside_delivery_charge;
										echo $shipping;
									} else {
										$shipping = $outside_delivery_charge;
										echo $shipping;
									}
									?></td>
    							</tr>
    							<tr>
    								<td class="no-line"></td>
    								<td class="no-line"></td>
    								<td class="no-line text-center"><strong>Total</strong></td>
    								<td class="no-line text-right">BDT <?php echo $subtotals+$shipping; ?></td>
    							</tr>
    						</tbody>
    					</table>
    				</div>
    			</div>
    		</div>
    	</div>
    </div>
</div>

<div class="container">
	<button onclick="printPDF()" class="btn btn-dark">Download & Print <span class="mdi mdi-tray-arrow-down"></span></button>
</div>

<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<!---->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>

<script>
    async function printPDF() {
        const { jsPDF } = window.jspdf;
        const pdf = new jsPDF('p', 'mm', 'a4');

        // Select the area to print
        const element = document.getElementById("printArea");

        // Convert the HTML area to canvas
        const canvas = await html2canvas(element, { scale: 2 });
        const imgData = canvas.toDataURL("image/png");

        // Add the image to the PDF
        const imgWidth = 190; // Adjust for A4 width
        const imgHeight = (canvas.height * imgWidth) / canvas.width;
        pdf.addImage(imgData, 'PNG', 10, 10, imgWidth, imgHeight);

        // Save the PDF
        pdf.save("invoice.pdf");
    }
</script>

</body>
</html>