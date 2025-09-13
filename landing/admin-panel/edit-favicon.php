<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

// database connection
include('../dbConnection.php');

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Handle favicon file upload
    $fav = $info['fav'] ?? null;
    if (!empty($_FILES['fav']['name'])) {
        $fav = 'uploads/' . basename($_FILES['fav']['name']);
        if (!move_uploaded_file($_FILES['fav']['tmp_name'], $fav)) {
            $fav = $info['fav']; // Revert to the existing favicon if upload fails
        }
    }

    // Check if a record exists
    $checkQuery = "SELECT * FROM website_info WHERE id=1";
    $result = $conn->query($checkQuery);

    if ($result->num_rows > 0) {
        // Update existing record
        $updateQuery = "UPDATE website_info SET fav='$fav' WHERE id=1";
        $conn->query($updateQuery);
    } else {
        // Insert new record
        $insertQuery = "INSERT INTO website_info (id, fav) VALUES (1, '$fav')";
        $conn->query($insertQuery);
    }
}

// Fetch data to display in the sidebar
$infoQuery = "SELECT * FROM website_info WHERE id=1";
$infoResult = $conn->query($infoQuery);
$info = $infoResult->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Admin</title>

    <!-- plugins:css -->
    <link rel="stylesheet" href="assets/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="assets/vendors/ti-icons/css/themify-icons.css">
    <!-- Layout styles -->
    <link rel="stylesheet" href="assets/css/style.css">
    <!-- End layout styles -->
    <link rel="shortcut icon" href="assets/images/favicon.png" />

    <!-- Custom CSS-->
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="container-scroller">
    <!-- partial:partials/_navbar.php -->
    <?php include('navbar.php'); ?>
    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
        <!-- partial:partials/_sidebar.php -->
        <?php include('sidebar.php'); ?>
        <div class="main-panel">
            <!--------------------------->
            <!-- START SETTINGS AREA -->
            <!--------------------------->
            <div class="content-wrapper">
                <div class="row">
                    <div class="col-md-8">
                        <div class="card card-body p-5">
                        <h4>Update Favicon</h4><br><br>
                        <form method="POST" action="" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="fav">Favicon</label>
                                <input type="file" class="form-control" id="fav" name="fav">
                            </div>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </form>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card card-body p-5">
                        <h4>Preview</h4><br><br>
                        <p><strong>Favicon:</strong> <img src="<?= $info['fav'] ?? '#' ?>" alt="Favicon" style="max-width: 50px;"></p>
                        </div>
                    </div>
                </div>
            </div>
            <!--------------------------->
            <!-- END SETTINGS AREA -->
            <!--------------------------->
            <!-- partial:partials/_footer.php -->
            <?php include('footer.php'); ?>
        </div>
    </div>
    <!-- page-body-wrapper ends -->
</div>
<!-- container-scroller -->

<!-- JS FILES  -->
<script src="assets/vendors/js/vendor.bundle.base.js"></script>
<script src="assets/js/off-canvas.js"></script>
<script src="assets/js/misc.js"></script>
<script src="js/main.js"></script>
</body>
</html>