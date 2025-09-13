<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
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
    <link rel="stylesheet" href="css/productList.css">

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
          <!-- START VIEW PRODUCT AREA -->
          <!--------------------------->
          <div class="content-wrapper">
            <div class="page-header">
              <h3 class="page-title">
                <span class="page-title-icon bg-gradient-primary text-white me-2">
                  <i class="mdi mdi-home"></i>
                </span> Product
              </h3>
            </div>
            <div class="row">
              <h1>Product List</h1>
              <!-- <form class="form-group" action="#">
                <input type="search" name="search" id="search" placeholder="Search Product" class="form-control">
              </form> -->
              <div class="container grid-container products">
                <!-- All Product Card Will Add Here Dynamically -->
                <?php
                    include('../dbConnection.php');

                    $sql = "SELECT * FROM product_info";

                    $result = mysqli_query($conn, $sql);
                    
                    $products = array();
                    while ($item = mysqli_fetch_array($result)) {
                        echo "<div class='card'>
                                <img src='../img/{$item['product_img1']}' class='card-img-top' alt='img'>
                                <div class='card-body'>
                                  <h6>{$item['product_title']}</h6>
                                  <h4>ID: {$item['product_id']}</h4>
                                  <h4>Product Code: {$item['product_code']}</h4>
                                  <p>Keyword: {$item['product_keyword']}</p>
                                  <p>Available Quantity: {$item['available_stock']}</p>

                                  <h6>Regular Price: BDT {$item['product_regular_price']}</h6>
                                  <h6>Sale Price: BDT {$item['product_price']}</h6>

                                  <button class='btn btn-dark' onclick='confirmEdit({$item['product_id']})'><span>Edit</span> <span class='mdi mdi-square-edit-outline'></span></button>
                                  
                                  <button class='btn btn-dark' onclick='confirmDelete({$item['product_id']})'><span>Delete</span> <span class='mdi mdi-trash-can-outline'></span></button>

                                  </div>
                              </div>";            
                          }
                ?>
            </div>
            </div>

          </div>
          <!--------------------------->
          <!-- END VIEW PRODUCT AREA -->
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
    <script src="js/mens.js"></script>

    <script>
      function confirmEdit(productId) {
        window.location.href = `editProduct.php?id=${productId}`;
      }

      function confirmDelete(productId) {
        if (confirm("Are you sure you want to delete this product?")) {
          window.location.href = `deleteProduct.php?id=${productId}`;
        }
      }

    </script>

  </body>
</html>