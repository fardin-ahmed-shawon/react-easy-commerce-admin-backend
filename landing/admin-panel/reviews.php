<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}
// database connection
include('../dbConnection.php');

// Handle form submission for adding a new review image
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['slider_img'])) {
    $imageName = $_FILES['slider_img']['name'];
    $imageTmpName = $_FILES['slider_img']['tmp_name'];
    $uploadDir = '../uploads/';
    $uploadFile = $uploadDir . basename($imageName);

    // Move the uploaded file to the target directory
    if (move_uploaded_file($imageTmpName, $uploadFile)) {
        // Insert the image into the database
        $query = "INSERT INTO reviews (review_image) VALUES (?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $imageName);
        if ($stmt->execute()) {
            echo "<script>alert('Image uploaded successfully!');</script>";
        } else {
            echo "<script>alert('Failed to upload image.');</script>";
        }
        $stmt->close();
    } else {
        echo "<script>alert('Failed to move uploaded file.');</script>";
    }
}

// Handle image deletion
if (isset($_GET['delete_id'])) {
    $deleteId = $_GET['delete_id'];

    // Fetch the image name to delete the file from the server
    $query = "SELECT review_image FROM reviews WHERE review_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $deleteId);
    $stmt->execute();
    $stmt->bind_result($imageName);
    $stmt->fetch();
    $stmt->close();

    // Delete the image file from the server
    if ($imageName && file_exists("../uploads/" . $imageName)) {
        unlink("../uploads/" . $imageName);
    }

    // Delete the image record from the database
    $query = "DELETE FROM reviews WHERE review_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $deleteId);
    if ($stmt->execute()) {
        echo "<script>alert('Image deleted successfully!');</script>";
        echo "<script>window.location.href='reviews.php';</script>";
    } else {
        echo "<script>alert('Failed to delete image.');</script>";
    }
    $stmt->close();
}

// Fetch all review images from the database
$query = "SELECT * FROM reviews";
$result = $conn->query($query);
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
            <br>

            <!-- Display Existing Slider Images -->
            <div class="row">
              <div class="col-md-7">
                <div class="card rounded-0 p-5">
                <h1>Existing Review Images</h1>
                    <div class="slider-images">
                      <?php
                      $count = 1;
                       while ($row = $result->fetch_assoc()): ?>
                        <div class="slider-item">
                          <h4>Review No: <?php echo $count; ?></h4>
                          <img style="width: 300px;" src="../uploads/<?php echo $row['review_image']; ?>" alt="Slider Image" class="slider-img">
                          <br><br>
                          <a href="reviews.php?delete_id=<?php echo $row['review_id']; ?>">
                            <button class="btn btn-danger">Delete</button>
                          </a>
                        </div>
                        <br><hr>
                      <?php $count++; endwhile; ?>
                    </div>
                </div>
              </div>
              <div class="col-md-5 card card-body p-5 rounded-0">
                  <!-- Add New Image -->
                  <form action="" method="POST" enctype="multipart/form-data">
                    <div class="row">
                      <h1>Add Review Image</h1>
                      <div>
                          <label class="custum-file-upload" for="file">
                            <div class="icon" style="width: 50px; height: 50px; display: flex; justify-content: center; align-items: center;">
                              <!-- SVG Icon -->
                              <svg xmlns="http://www.w3.org/2000/svg" fill="" viewBox="0 0 24 24"><g stroke-width="0" id="SVGRepo_bgCarrier"></g><g stroke-linejoin="round" stroke-linecap="round" id="SVGRepo_tracerCarrier"></g><g id="SVGRepo_iconCarrier"> <path fill="" d="M10 1C9.73478 1 9.48043 1.10536 9.29289 1.29289L3.29289 7.29289C3.10536 7.48043 3 7.73478 3 8V20C3 21.6569 4.34315 23 6 23H7C7.55228 23 8 22.5523 8 22C8 21.4477 7.55228 21 7 21H6C5.44772 21 5 20.5523 5 20V9H10C10.5523 9 11 8.55228 11 8V3H18C18.5523 3 19 3.44772 19 4V9C19 9.55228 19.4477 10 20 10C20.5523 10 21 9.55228 21 9V4C21 2.34315 19.6569 1 18 1H10ZM9 7H6.41421L9 4.41421V7ZM14 15.5C14 14.1193 15.1193 13 16.5 13C17.8807 13 19 14.1193 19 15.5V16V17H20C21.1046 17 22 17.8954 22 19C22 20.1046 21.1046 21 20 21H13C11.8954 21 11 20.1046 11 19C11 17.8954 11.8954 17 13 17H14V16V15.5ZM16.5 11C14.142 11 12.2076 12.8136 12.0156 15.122C10.2825 15.5606 9 17.1305 9 19C9 21.2091 10.7909 23 13 23H20C22.2091 23 24 21.2091 24 19C24 17.1305 22.7175 15.5606 20.9844 15.122C20.7924 12.8136 18.858 11 16.5 11Z" clip-rule="evenodd" fill-rule="evenodd"></path> </g></svg>
                            </div>
                            <div class="text">
                              <span>Click to upload image</span>
                              </div>
                              <input type="file" id="file" name="slider_img" required="">
                            </label>
                      </div>
                    </div>
                    <br>
                    <input class="btn btn-dark" type="submit" value="Submit">
                  </form>
              </div>
              
            </div>
            <br>

            
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