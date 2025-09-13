<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}
// database connection
include('../dbConnection.php');
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
            <section class="content-main">
                
                <div class="card">
                    <div class="card-body">
                        
                        <div class="content-header p-4">
                            <h1 class="content-title">Settings</h1>
                            <hr><br>
                        </div>

                        <div class="row gx-5">
                            <aside class="col-lg-3 border-end">
                                <nav class="nav nav-pills flex-lg-column mb-4 alert alert-success">
                                    <a class="nav-link text-dark" aria-current="page" href="">Change Content & Settings </a>
                                </nav>
                            </aside>
                            <div class="col-lg-9">
                                <section class="content-body p-xl-4">
                                    <h2><?php echo $websiteName; ?></h2>
                                    
                                    <hr class="my-5">
                                    <div class="row" style="max-width: 920px">

                                        <div class="col-md-4">
                                            <article class="box mb-3 bg-light p-3" style="border: 1px solid #ddd;">
                                                <h6>Admin Password</h6>
                                                <small class="text-muted d-block" style="width: 70%">You can reset or change your password by clicking here</small>
                                                <br>
                                                <a class="btn btn-dark" href="change-password.php">Change</a>
                                            </article>
                                        </div>


                                        <div class="col-md-4">
                                            <article class="box mb-3 bg-light p-3" style="border: 1px solid #ddd;">
                                                <h6>Website Info</h6>
                                                <small class="text-muted d-block" style="width: 70%">You can reset or change your all of your web info</small>
                                                <br>
                                                <a class="btn btn-dark" href="edit-web-info.php">Change</a>
                                            </article>
                                        </div>

                                        <div class="col-md-4">
                                            <article class="box mb-3 bg-light p-3" style="border: 1px solid #ddd;">
                                                <h6>Logo</h6>
                                                <small class="text-muted d-block" style="width: 70%">You can reset or change your logo</small>
                                                <br>
                                                <a class="btn btn-dark" href="edit-logo.php">Change</a>
                                            </article>
                                        </div>

                                        <div class="col-md-4">
                                            <article class="box mb-3 bg-light p-3" style="border: 1px solid #ddd;">
                                                <h6>Favicon</h6>
                                                <small class="text-muted d-block" style="width: 70%">You can reset or change your favicon</small>
                                                <br>
                                                <a class="btn btn-dark" href="edit-favicon.php">Change</a>
                                            </article>
                                        </div>

                                    </div>    
                                    <br><hr><br>
                                    <div class="row" style="max-width: 920px">

                                        <div class="col-md-4">
                                            <article class="box mb-3 bg-light p-3" style="border: 1px solid #ddd;">
                                                <h6>Change Images</h6>
                                                <small class="text-muted d-block" style="width: 70%">You can change all of your images by clicking here</small>
                                                <br>
                                                <a class="btn btn-dark" href="change-images.php">Edit</a>
                                            </article>
                                        </div>

                                        <div class="col-md-4">
                                            <article class="box mb-3 bg-light p-3" style="border: 1px solid #ddd;">
                                                <h6>Video</h6>
                                                <small class="text-muted d-block" style="width: 70%">You can reset or change your video</small>
                                                <br>
                                                <a class="btn btn-dark" href="add-video.php">Change</a>
                                            </article>
                                        </div>

                                        <div class="col-md-4">
                                            <article class="box mb-3 bg-light p-3" style="border: 1px solid #ddd;">
                                                <h6>Change Text Content</h6>
                                                <small class="text-muted d-block" style="width: 70%">You can update all of your page text content by clicking here</small>
                                                <br>
                                                <a class="btn btn-dark" href="change-text.php">Edit</a>
                                            </article>
                                        </div>

                                        <div class="col-md-4">
                                            <article class="box mb-3 bg-light p-3" style="border: 1px solid #ddd;">
                                                <h6>Product Features</h6>
                                                <small class="text-muted d-block" style="width: 70%">You can update all of your product features by clicking here</small>
                                                <br>
                                                <a class="btn btn-dark" href="features.php">Edit</a>
                                            </article>
                                        </div>

                                        <div class="col-md-4">
                                            <article class="box mb-3 bg-light p-3" style="border: 1px solid #ddd;">
                                                <h6>Product Reviews</h6>
                                                <small class="text-muted d-block" style="width: 70%">You can add all of your reviews by clicking here</small>
                                                <br>
                                                <a class="btn btn-dark" href="reviews.php">Edit</a>
                                            </article>
                                        </div>

                                    </div>
                                    <!-- row.// -->
                                </section>
                                <!-- content-body .// -->
                            </div>
                            <!-- col.// -->
                        </div>
                        <!-- row.// -->
                    </div>
                    <!-- card body end// -->
                </div>
                <!-- card end// -->
            </section>
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
    <!-- plugins:js -->
    <script src="assets/vendors/js/vendor.bundle.base.js"></script>
    <script src="assets/js/off-canvas.js"></script>
    <script src="assets/js/misc.js"></script>
    <script src="js/main.js"></script>

  </body>
</html>