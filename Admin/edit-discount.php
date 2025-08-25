<?php
$current_page = basename($_SERVER['PHP_SELF']); // Get the current page name
$page_title = 'Edit Discount'; // Set the page title
?>
<?php require 'header.php'; ?>

<?php
if (!isset($_GET['id'])) {
    header("Location: add-discounts.php");
    exit();
}

$id = intval($_GET['id']);
$stmt = $conn->prepare("SELECT * FROM discount WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$discount = $result->fetch_assoc();
$stmt->close();

if (!$discount) {
    header("Location: add-discounts.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $purchase_amount = $_POST['purchase_amount'];
    $discount_amount = $_POST['discount_amount'];

    if (empty($purchase_amount) || empty($discount_amount)) {
        $error_message = "All fields are required.";
    } else {
        $stmt = $conn->prepare("UPDATE discount SET purchase_amount=?, discount_amount=? WHERE id=?");
        $stmt->bind_param("iii", $purchase_amount, $discount_amount, $id);
        if ($stmt->execute()) {
            $success_message = "Discount updated successfully!";
            // Refresh discount data
            $discount['purchase_amount'] = $purchase_amount;
            $discount['discount_amount'] = $discount_amount;
        } else {
            $error_message = "Error: " . $stmt->error;
        }
        $stmt->close();
    }
}
?>

<!--------------------------->
<!-- START MAIN AREA -->
<!--------------------------->
<div class="content-wrapper">
                <div class="page-header">
                    <h3 class="page-title">
                        <span class="page-title-icon bg-gradient-primary text-white me-2">
                            <i class="mdi mdi-pencil"></i>
                        </span> Edit Discount
                    </h3>
                </div>
                <div class="row">
                    <div class="col-md-4 card mx-auto mt-5">
                        <div class="card-body">
                            <br>
                            <h6>Edit Discount</h6>
                            <br><hr><br>
                            <?php if (isset($success_message)): ?>
                                <div class="alert alert-success"><?php echo $success_message; ?></div>
                            <?php endif; ?>
                            <?php if (isset($error_message)): ?>
                                <div class="alert alert-danger"><?php echo $error_message; ?></div>
                            <?php endif; ?>
                            <form action="" method="POST">
                                <div class="form-group">
                                    <label>Purchase Amount *</label>
                                    <input type="text" class="form-control" name="purchase_amount" value="<?php echo htmlspecialchars($discount['purchase_amount']); ?>" required>
                                </div>
                                <div class="form-group">
                                    <label>Discount Amount *</label>
                                    <input type="text" class="form-control" name="discount_amount" value="<?php echo htmlspecialchars($discount['discount_amount']); ?>" required>
                                </div>
                                <button type="submit" class="btn btn-primary">Update Discount</button>
                                <a href="add-discounts.php" class="btn btn-secondary">Back</a>
                            </form>
                            <br>
                        </div>
                    </div>
                </div>
</div>
<!--------------------------->
<!-- END MAIN AREA -->
<!--------------------------->

<?php require 'footer.php'; ?>