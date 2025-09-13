<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

// Database connection
include('../dbConnection.php');

// Fetch existing images
$query = "SELECT * FROM images LIMIT 1";
$result = mysqli_query($conn, $query);

if (!$result) {
    die("Error fetching images: " . mysqli_error($conn));
}

$images = mysqli_fetch_assoc($result);

// Handle image upload
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $targetDir = "../uploads/";
    $column = '';
    $fileName = '';

    if (isset($_FILES['background_image'])) {
        $column = 'background_image';
        $fileName = basename($_FILES['background_image']['name']);
    } elseif (isset($_FILES['home_image'])) {
        $column = 'home_image';
        $fileName = basename($_FILES['home_image']['name']);
    } elseif (isset($_FILES['feature_image'])) {
        $column = 'feature_image';
        $fileName = basename($_FILES['feature_image']['name']);
    }

    if ($column && $fileName) {
        $targetFilePath = $targetDir . $fileName;

        // Validate file type
        $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
        $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

        if (!in_array(strtolower($fileType), $allowedTypes)) {
            echo "Invalid file type. Only JPG, JPEG, PNG, and GIF are allowed.";
            exit();
        }

        if (move_uploaded_file($_FILES[$column]['tmp_name'], $targetFilePath)) {
            // Check if the row exists
            $checkQuery = "SELECT * FROM images LIMIT 1";
            $checkResult = mysqli_query($conn, $checkQuery);

            if (mysqli_num_rows($checkResult) > 0) {
                // Update existing row
                $query = "UPDATE images SET $column = '" . mysqli_real_escape_string($conn, $fileName) . "'";
            } else {
                // Insert new row
                $query = "INSERT INTO images ($column) VALUES ('" . mysqli_real_escape_string($conn, $fileName) . "')";
            }

            if (!mysqli_query($conn, $query)) {
                echo "Error updating database: " . mysqli_error($conn);
                exit();
            }

            header("Location: change-images.php");
            exit();
        } else {
            echo "Error uploading file.";
        }
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
        <?php include('navbar.php'); ?>
        <div class="container-fluid page-body-wrapper">
            <?php include('sidebar.php'); ?>
            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="page-header">
                        <h3 class="page-title">
                            <span class="page-title-icon bg-gradient-primary text-white me-2">
                                <i class="mdi mdi-home"></i>
                            </span>Change Images
                        </h3>
                    </div>
                    <br>

                    <!-- Display Existing Slider Images -->
                    <div class="row">
                        <div class="col-md-7">
                            <div class="card rounded-0 p-5">
                                <div class="slider-images">
                                    <div class="slider-item">
                                        <h1>Background Image</h1>
                                        <img style="width: 300px;" src="../uploads/<?php echo htmlspecialchars($images['background_image'] ?? ''); ?>" alt="Background Image" class="slider-img">
                                    </div>
                                    <br><hr>
                                    <div class="slider-item">
                                        <h1>Home Image</h1>
                                        <img style="width: 300px;" src="../uploads/<?php echo htmlspecialchars($images['home_image'] ?? ''); ?>" alt="Home Image" class="slider-img">
                                    </div>
                                    <br><hr>
                                    <div class="slider-item">
                                        <h1>Feature Image</h1>
                                        <img style="width: 300px;" src="../uploads/<?php echo htmlspecialchars($images['feature_image'] ?? ''); ?>" alt="Feature Image" class="slider-img">
                                    </div>
                                    <br><hr>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <!-- Add Background Image -->
                            <div class="card card-body p-5 rounded-0">
                                <form action="" method="POST" enctype="multipart/form-data">
                                    <h1>Add Background Image</h1>
                                    <input type="file" name="background_image" required>
                                    <br><br>
                                    <input class="btn btn-dark" type="submit" value="Submit">
                                </form>
                            </div>
                            <hr>

                            <!-- Add Home Image -->
                            <div class="card card-body p-5 rounded-0">
                                <form action="" method="POST" enctype="multipart/form-data">
                                    <h1>Add Home Image</h1>
                                    <input type="file" name="home_image" required>
                                    <br><br>
                                    <input class="btn btn-dark" type="submit" value="Submit">
                                </form>
                            </div>
                            <hr>

                            <!-- Add Feature Image -->
                            <div class="card card-body p-5 rounded-0">
                                <form action="" method="POST" enctype="multipart/form-data">
                                    <h1>Add Feature Image</h1>
                                    <input type="file" name="feature_image" required>
                                    <br><br>
                                    <input class="btn btn-dark" type="submit" value="Submit">
                                </form>
                            </div>
                            <hr>
                        </div>
                    </div>
                    <br>
                </div>
                <?php include('footer.php'); ?>
            </div>
        </div>
    </div>
    <!-- JS Files -->
</body>
</html>