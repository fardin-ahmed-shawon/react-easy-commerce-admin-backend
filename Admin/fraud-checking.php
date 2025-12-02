<?php
$current_page = basename($_SERVER['PHP_SELF']);
$page_title = 'Fraud Checking';

// Initialize variables
$api_data = [
    'Pathao' => ['total' => 0, 'success' => 0, 'cancel' => 0],
    'Steadfast' => ['total' => 0, 'success' => 0, 'cancel' => 0],
    'Redx' => ['total' => 0, 'success' => 0, 'cancel' => 0],
    'Paperfly' => ['total' => 0, 'success' => 0, 'cancel' => 0],
];
$total = $success = $cancel = 0;
$error_msg = '';
$success_msg = '';
$searched_phone = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['bd_phone'])) {
    $phone = trim($_POST['bd_phone']);
    $searched_phone = $phone;
    
    // Validate Bangladesh phone number (starts with 01, 11 digits)
    if (preg_match('/^01[3-9]\d{8}$/', $phone)) {
        // API Configuration
        $api_key = "d60df7da58cfc35acb87f5af58323e0f"; // Consider moving to config file
        $url = "https://fraudchecker.link/api/v1/qc/";
        $data = ['phone' => $phone];

        $options = [
            'http' => [
                'header' => "Authorization: Bearer " . $api_key . "\r\n" .
                            "Content-type: application/x-www-form-urlencoded\r\n",
                'method' => 'POST',
                'content' => http_build_query($data),
                'timeout' => 15,
                'ignore_errors' => true
            ]
        ];

        $context = stream_context_create($options);
        $response = @file_get_contents($url, false, $context);

        if ($response !== false) {
            $result = json_decode($response, true);
            
            if ($result && isset($result['apis'])) {
                // Extract totals
                $total = isset($result['total_parcels']) ? (int)$result['total_parcels'] : 0;
                $success = isset($result['total_delivered']) ? (int)$result['total_delivered'] : 0;
                $cancel = isset($result['total_cancel']) ? (int)$result['total_cancel'] : 0;

                // Extract per-courier data
                foreach ($api_data as $courier => &$info) {
                    $api_key_name = $courier === 'Paperfly' ? 'PaperFly' : $courier;
                    
                    if (isset($result['apis'][$api_key_name])) {
                        $courier_data = $result['apis'][$api_key_name];
                        $info['total'] = isset($courier_data['total_parcels']) ? (int)$courier_data['total_parcels'] : 0;
                        $info['success'] = isset($courier_data['total_delivered_parcels']) ? (int)$courier_data['total_delivered_parcels'] : 0;
                        $info['cancel'] = isset($courier_data['total_cancelled_parcels']) ? (int)$courier_data['total_cancelled_parcels'] : 0;
                    }
                }
                unset($info);
                
                $success_msg = "Data retrieved successfully for: <strong>" . htmlspecialchars($phone) . "</strong>";
            } else {
                $error_msg = "No data found for this phone number. The customer may not have any courier history.";
            }
        } else {
            $error_msg = "Unable to connect to the fraud checking service. Please try again later.";
        }
    } else {
        $error_msg = "Invalid Bangladesh phone number. Please enter a valid 11-digit number starting with 01.";
    }
}
?>
<?php require 'header.php'; ?>

<style>
.fraud-card {
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}
.stat-card {
    border-radius: 6px;
    transition: transform 0.2s;
}
.stat-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.2);
}
.courier-badge {
    font-size: 0.9rem;
    font-weight: 600;
}
</style>

<!--------------------------->
<!-- START MAIN AREA -->
<!--------------------------->
<div class="content-wrapper">
    <div class="row">
        <div class="card col-md-8 mx-auto p-4 fraud-card">
            <h1 class="text-center mb-3">
                <i class="fas fa-shield-alt"></i> Fraud Checker
            </h1>
            <p class="text-center text-muted mb-4">Check customer delivery history across multiple courier services</p>
            
            <div class="card-body">
                <!-- Search Form -->
                <form method="POST" id="fraudForm">
                    <div class="form-group">
                        <label for="bd_phone"><b>Customer Phone Number</b></label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fas fa-phone"></i>
                                </span>
                            </div>
                            <input 
                                class="form-control" 
                                id="bd_phone" 
                                type="tel" 
                                name="bd_phone" 
                                placeholder="e.g. 01712345678" 
                                pattern="01[3-9][0-9]{8}" 
                                maxlength="11" 
                                value="<?php echo htmlspecialchars($searched_phone); ?>"
                                required>
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-search"></i> Search
                                </button>
                            </div>
                        </div>
                        <small class="form-text text-muted">Enter 11-digit Bangladesh phone number (e.g., 017XXXXXXXX)</small>
                    </div>
                </form>

                <!-- Messages -->
                <?php if (!empty($error_msg)): ?>
                    <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
                        <i class="fas fa-exclamation-circle"></i> <?php echo $error_msg; ?>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                <?php endif; ?>
                
                <?php if (!empty($success_msg)): ?>
                    <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                        <i class="fas fa-check-circle"></i> <?php echo $success_msg; ?>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                <?php endif; ?>

                <!-- Summary Cards -->
                <?php if ($total > 0 || !empty($success_msg)): ?>
                <div class="row mt-4 mb-4">
                    <div class="col-12 col-md-4 mb-3">
                        <div class="card text-center bg-info stat-card">
                            <div class="card-body p-3">
                                <h5 class="mb-1 text-white"><i class="fas fa-box"></i> Total Parcels</h5>
                                <h2 class="mb-0 text-white font-weight-bold"><?php echo $total; ?></h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-4 mb-3">
                        <div class="card text-center bg-success stat-card">
                            <div class="card-body p-3">
                                <h5 class="mb-1 text-white"><i class="fas fa-check-circle"></i> Delivered</h5>
                                <h2 class="mb-0 text-white font-weight-bold"><?php echo $success; ?></h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-4 mb-3">
                        <div class="card text-center bg-danger stat-card">
                            <div class="card-body p-3">
                                <h5 class="mb-1 text-white"><i class="fas fa-times-circle"></i> Cancelled</h5>
                                <h2 class="mb-0 text-white font-weight-bold"><?php echo $cancel; ?></h2>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endif; ?>

                <!-- Courier Details Table -->
                <div class="mt-4">
                    <h5 class="mb-3"><i class="fas fa-truck"></i> Courier-wise Breakdown</h5>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="thead-dark">
                                <tr>
                                    <th><i class="fas fa-shipping-fast"></i> Courier Service</th>
                                    <th class="text-center">Total</th>
                                    <th class="text-center">Delivered</th>
                                    <th class="text-center">Cancelled</th>
                                    <th class="text-center">Success Rate</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($api_data as $courier => $data): 
                                    $success_rate = $data['total'] > 0 ? round(($data['success'] / $data['total']) * 100, 1) : 0;
                                    $rate_class = $success_rate >= 70 ? 'success' : ($success_rate >= 40 ? 'warning' : 'danger');
                                ?>
                                <tr>
                                    <td><span class="courier-badge"><?php echo $courier; ?></span></td>
                                    <td class="text-center"><?php echo $data['total']; ?></td>
                                    <td class="text-center text-success font-weight-bold"><?php echo $data['success']; ?></td>
                                    <td class="text-center text-danger font-weight-bold"><?php echo $data['cancel']; ?></td>
                                    <td class="text-center">
                                        <span class="badge badge-<?php echo $rate_class; ?>">
                                            <?php echo $success_rate; ?>%
                                        </span>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                            <?php if ($total > 0): ?>
                            <tfoot class="thead-light">
                                <tr class="font-weight-bold">
                                    <td>TOTAL</td>
                                    <td class="text-center"><?php echo $total; ?></td>
                                    <td class="text-center text-success"><?php echo $success; ?></td>
                                    <td class="text-center text-danger"><?php echo $cancel; ?></td>
                                    <td class="text-center">
                                        <?php 
                                        $overall_rate = $total > 0 ? round(($success / $total) * 100, 1) : 0;
                                        $overall_class = $overall_rate >= 70 ? 'success' : ($overall_rate >= 40 ? 'warning' : 'danger');
                                        ?>
                                        <span class="badge badge-<?php echo $overall_class; ?>">
                                            <?php echo $overall_rate; ?>%
                                        </span>
                                    </td>
                                </tr>
                            </tfoot>
                            <?php endif; ?>
                        </table>
                    </div>
                </div>

                <?php if ($total > 0): ?>
                <!-- Risk Assessment -->
                <div class="mt-4 p-3 border rounded">
                    <h6><i class="fas fa-chart-line"></i> Risk Assessment</h6>
                    <?php
                    $overall_rate = $total > 0 ? round(($success / $total) * 100, 1) : 0;
                    $cancel_rate = $total > 0 ? round(($cancel / $total) * 100, 1) : 0;
                    
                    if ($cancel_rate >= 50) {
                        echo '<p class="text-danger mb-0"><i class="fas fa-exclamation-triangle"></i> <strong>High Risk:</strong> This customer has a high cancellation rate (' . $cancel_rate . '%). Proceed with caution.</p>';
                    } elseif ($cancel_rate >= 30) {
                        echo '<p class="text-warning mb-0"><i class="fas fa-exclamation-circle"></i> <strong>Moderate Risk:</strong> Customer has a moderate cancellation rate (' . $cancel_rate . '%).</p>';
                    } else {
                        echo '<p class="text-success mb-0"><i class="fas fa-check-circle"></i> <strong>Low Risk:</strong> Customer has a good delivery record (' . $overall_rate . '% success rate).</p>';
                    }
                    ?>
                </div>
                <?php endif; ?>

            </div>
        </div>
    </div>
</div>
<!--------------------------->
<!-- END MAIN AREA -->
<!--------------------------->

<?php require 'footer.php'; ?>