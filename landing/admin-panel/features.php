<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

// database connection
include('../dbConnection.php');

// Handle delete functionality
if (isset($_GET['delete_id'])) {
    $delete_id = intval($_GET['delete_id']);
    $delete_query = "DELETE FROM features WHERE feature_id = $delete_id";
    if (mysqli_query($conn, $delete_query)) {
        echo "<script>alert('Feature deleted successfully!');</script>";
        echo "<script>window.location.href='features.php';</script>";
    } else {
        echo "<script>alert('Error deleting feature.');</script>";
    }
}

// Fetch all features
$features_query = "SELECT * FROM features";
$features_result = mysqli_query($conn, $features_query);


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // Get form data
  $feature_title = mysqli_real_escape_string($conn, $_POST['feature_title']);
  $feature_description = mysqli_real_escape_string($conn, $_POST['feature_description']);

  // Insert query
  $insert_query = "INSERT INTO features (feature_title, feature_description) VALUES ('$feature_title', '$feature_description')";

  if (mysqli_query($conn, $insert_query)) {
      echo "<script>alert('Feature added successfully!');</script>";
      echo "<script>window.location.href='features.php';</script>";
  } else {
      echo "<script>alert('Error adding feature.');</script>";
      echo "<script>window.location.href='features.php';</script>";
  }
} 

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
          <div class="content-wrapper">
            <div class="container">
              <div class="page-inner">
                <div class="sl-mainpanel">
                  <div class="col-lg-12 sl-pagebody m-auto">
                    <div class="row">
                      <div class="col-md-7">
                        <!-- Dynamically Display Features -->
                        <?php 
                        $count = 1;
                        while ($feature = mysqli_fetch_assoc($features_result)) { ?>
                          <div class="card">
                            <div class="card-body">
                              <br>
                              <h4>Feature <?php echo $count; ?></h4>
                            </div>
                            <hr>
                            <div class="card-body">
                              <h4><b>Title: </b></h4>
                              <p><?php echo htmlspecialchars($feature['feature_title']); ?></p>
                              <br>
                              <h4><b>Description: </b></h4>
                              <p><?php echo htmlspecialchars($feature['feature_description']); ?></p>
                              <br>
                              <a class="btn btn-danger" href="?delete_id=<?php echo $feature['feature_id']; ?>">Delete</a>
                            </div>
                            <br>
                          </div>
                          <br>
                        <?php $count++;}?>
                      </div>
                      <div class="col-md-5">
                        <div class="card">
                          <div class="card-body">
                            <br>
                            <h6>Add Features</h6>
                          </div>
                          <hr>
                          <div class="card-body">
                            <form action="" method="POST">
                              <div class="form-group">
                                <label><h4>Feature Title</h4></label>
                                <input type="text" class="form-control" placeholder="Feature title" name="feature_title" required="">
                              </div>
                              <div class="form-group">
                                <label><h4>Feature Description:</h4></label>
                                <textarea type="text" rows="4" class="form-control" placeholder="Feature description" name="feature_description" required=""></textarea>
                              </div>
                              <div class="form-group mt-2">
                                <button class="btn btn-dark" type="submit"><i class="far fa-paper-plane"></i> Save Feature</button>
                              </div>
                            </form>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- partial:partials/_footer.php -->
          <?php include('footer.php'); ?>
        </div>
      </div>
    </div>
    <!-- JS FILES -->
    <script src="assets/vendors/js/vendor.bundle.base.js"></script>
    <script src="assets/js/off-canvas.js"></script>
    <script src="assets/js/misc.js"></script>
    <script src="js/main.js"></script>
  </body>
</html>