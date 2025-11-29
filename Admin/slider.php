<?php
$current_page = basename($_SERVER['PHP_SELF']);
$page_title = 'Slider';
?>
<?php require 'header.php'; ?>

<?php

function compressImage($source, $destination, $quality = 95) {
  $imgInfo = getimagesize($source);
  if (!$imgInfo) return false;

  $mime = $imgInfo['mime'];
  switch ($mime) {
      case 'image/jpeg': $image = imagecreatefromjpeg($source); break;
      case 'image/png': $image = imagecreatefrompng($source); break;
      case 'image/webp': $image = imagecreatefromwebp($source); break;
      default: return false;
  }

  // Save Compressed Image without resizing
  switch ($mime) {
      case 'image/jpeg': imagejpeg($image, $destination, $quality); break;
      case 'image/png': imagepng($image, $destination, round($quality / 10)); break;
      case 'image/webp': imagewebp($image, $destination, $quality); break;
  }
  imagedestroy($image);
  return true;
}

// Slider Image Add
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['slider_img']) && $_FILES['slider_img']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['slider_img']['tmp_name'];
        $fileName = $_FILES['slider_img']['name'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));

        $allowedfileExtensions = ['jpg', 'jpeg', 'png', 'gif'];

        if (in_array($fileExtension, $allowedfileExtensions)) {
            $uploadFileDir = '../img/';
            $dest_path = $uploadFileDir . $fileName;
            $compressed_path = $uploadFileDir . 'compressed_' . $fileName;

            if (move_uploaded_file($fileTmpPath, $dest_path)) {
                if (compressImage($dest_path, $compressed_path, 60)) {
                    unlink($dest_path);

                    $query = "INSERT INTO slider (slider_img) VALUES (?)";
                    $stmt = mysqli_prepare($conn, $query);
                    mysqli_stmt_bind_param($stmt, "s", $compressed_path);

                    if (mysqli_stmt_execute($stmt)) {
                        $suc_message = "Image uploaded and saved successfully.";
                    } else {
                        $err_message = "Database error: Unable to save the image.";
                    }

                    mysqli_stmt_close($stmt);
                } else {
                    $err_message = "Image compression failed.";
                }
            } else {
                $err_message = "There was an error moving the uploaded file.";
            }
        } else {
            $err_message = "Upload failed. Allowed file types: " . implode(", ", $allowedfileExtensions);
        }
    } else {
        $err_message = "No file uploaded or there was an upload error.";
    }
}

// Fetch slider images
$query = "SELECT slider_id, slider_img FROM slider";
$result = mysqli_query($conn, $query);
?>

<style>
.slider-container {
  max-width: 100%;
  margin: 0 auto;
  padding: 2rem;
  background: #ffffff;
}

.slider-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 2rem;
  padding-bottom: 1rem;
  border-bottom: 2px solid #000;
}

.slider-header h1 {
  font-size: 1.75rem;
  font-weight: 600;
  color: #000;
  margin: 0;
  letter-spacing: -0.5px;
}

/* Alert Messages */
.alert-success {
  padding: 1rem 1.5rem;
  background: #D1E7DD;
  color: #0A3622;
  border-left: 4px solid #0A3622;
  margin-bottom: 2rem;
  font-weight: 500;
}

.alert-error {
  padding: 1rem 1.5rem;
  background: #F8D7DA;
  color: #842029;
  border-left: 4px solid #842029;
  margin-bottom: 2rem;
  font-weight: 500;
}

/* Grid Layout */
.slider-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
  gap: 2rem;
  margin-bottom: 3rem;
}

.slider-card {
  background: #fff;
  border: 1px solid #e0e0e0;
  transition: all 0.3s ease;
  overflow: hidden;
}

.slider-card:hover {
  box-shadow: 0 4px 12px rgba(0,0,0,0.1);
  transform: translateY(-2px);
}

.slider-image-wrapper {
  position: relative;
  width: 100%;
  padding-top: 56.25%; /* 16:9 Aspect Ratio */
  background: #f8f8f8;
  overflow: hidden;
}

.slider-image-wrapper img {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.slider-card-content {
  padding: 1rem;
  border-top: 1px solid #e0e0e0;
}

.slider-card-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 0.75rem;
}

.slider-number {
  font-size: 0.85rem;
  font-weight: 600;
  color: #000;
  text-transform: uppercase;
  letter-spacing: 0.5px;
}

.btn-delete {
  padding: 0.5rem 1.25rem;
  background: #fff;
  color: #000;
  border: 2px solid #000;
  font-size: 0.85rem;
  font-weight: 600;
  cursor: pointer;
  transition: all 0.2s ease;
  text-transform: uppercase;
  letter-spacing: 0.5px;
  width: 100%;
}

.btn-delete:hover {
  background: #000;
  color: #fff;
}

/* Upload Section */
.upload-section {
  background: #f8f8f8;
  border: 2px dashed #000;
  padding: 3rem 2rem;
  /* text-align: center; */
  margin-bottom: 2rem;
}

.upload-section h2 {
  font-size: 1.5rem;
  font-weight: 600;
  color: #000;
  margin-bottom: 2rem;
  letter-spacing: -0.5px;
}

.upload-area {
  max-width: 500px;
  /* margin: 0 auto; */
}

.custum-file-upload {
  display: block;
  cursor: pointer;
  background: #fff;
  border: 2px solid #000;
  padding: 2rem;
  transition: all 0.3s ease;
  margin-bottom: 1.5rem;
}

.custum-file-upload:hover {
  background: #000;
  color: #fff;
}

.custum-file-upload:hover .icon svg {
  fill: #fff;
}

.custum-file-upload:hover .text span {
  color: #fff;
}

.custum-file-upload input[type="file"] {
  display: none;
}

.icon {
  margin-bottom: 1rem;
}

.icon svg {
  width: 60px;
  height: 60px;
  fill: #000;
  transition: fill 0.3s ease;
}

.text span {
  font-size: 1rem;
  font-weight: 600;
  color: #000;
  text-transform: uppercase;
  letter-spacing: 0.5px;
  transition: color 0.3s ease;
}

/* File Preview */
.file-preview {
  margin-top: 1.5rem;
  display: none;
}

.file-preview.active {
  display: block;
}

.preview-container {
  background: #fff;
  border: 2px solid #000;
  padding: 1rem;
  margin-bottom: 1rem;
}

.preview-image {
  width: 100%;
  max-height: 300px;
  object-fit: contain;
  margin-bottom: 0.75rem;
}

.file-info {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 0.75rem;
  background: #f8f8f8;
  border-top: 1px solid #e0e0e0;
}

.file-name {
  font-size: 0.9rem;
  font-weight: 600;
  color: #000;
  word-break: break-all;
}

.btn-clear {
  padding: 0.4rem 1rem;
  background: #fff;
  color: #000;
  border: 2px solid #000;
  font-size: 0.8rem;
  font-weight: 600;
  cursor: pointer;
  transition: all 0.2s ease;
  text-transform: uppercase;
  letter-spacing: 0.5px;
}

.btn-clear:hover {
  background: #000;
  color: #fff;
}

.btn-submit {
  padding: 0.75rem 2.5rem;
  background: #000;
  color: #fff;
  border: none;
  font-size: 0.9rem;
  font-weight: 600;
  cursor: pointer;
  transition: all 0.2s ease;
  text-transform: uppercase;
  letter-spacing: 0.5px;
  width: 100%;
  max-width: 500px;
}

.btn-submit:hover {
  background: #333;
  transform: translateY(-1px);
}

.empty-state {
  text-align: center;
  padding: 4rem 2rem;
  color: #999;
  grid-column: 1 / -1;
}

.empty-state i {
  font-size: 3rem;
  margin-bottom: 1rem;
  opacity: 0.5;
}

/* Responsive */
@media (max-width: 768px) {
  .slider-container {
    padding: 1rem;
  }
  
  .slider-header h1 {
    font-size: 1.5rem;
  }
  
  .slider-grid {
    grid-template-columns: 1fr;
    gap: 1.5rem;
  }
  
  .upload-section {
    padding: 2rem 1rem;
  }
  
  .upload-section h2 {
    font-size: 1.25rem;
  }
}
</style>

<div class="content-wrapper">

  <div class="page-header">
    <h3 class="page-title">
      <span class="page-title-icon bg-gradient-primary text-white me-2">
        <i class="mdi mdi-view-carousel"></i>
      </span> Slider Management
    </h3>
  </div>

  <div class="slider-container">
    
    <!-- Alert Messages -->
    <?php
      if (isset($_GET['suc_msg'])) {
        echo '<div class="alert-success">'.$_GET['suc_msg'].'</div>';
      } else if (isset($_GET['unsuc_msg'])) {
        echo '<div class="alert-error">'.$_GET['unsuc_msg'].'</div>';
      } else if (isset($suc_message)) {
        echo '<div class="alert-success">'.$suc_message.'</div>';
      } else if (isset($err_message)) {
        echo '<div class="alert-error">'.$err_message.'</div>';
      }
    ?>

    <!-- Upload Section -->
    <div class="upload-section">
      <h2>Add New Slider Image</h2>
      <form action="" method="POST" enctype="multipart/form-data">
        <div class="upload-area">
          <label class="custum-file-upload" for="file">
            <div class="icon">
              <svg xmlns="http://www.w3.org/2000/svg" fill="" viewBox="0 0 24 24">
                <g stroke-width="0" id="SVGRepo_bgCarrier"></g>
                <g stroke-linejoin="round" stroke-linecap="round" id="SVGRepo_tracerCarrier"></g>
                <g id="SVGRepo_iconCarrier">
                  <path fill="" d="M10 1C9.73478 1 9.48043 1.10536 9.29289 1.29289L3.29289 7.29289C3.10536 7.48043 3 7.73478 3 8V20C3 21.6569 4.34315 23 6 23H7C7.55228 23 8 22.5523 8 22C8 21.4477 7.55228 21 7 21H6C5.44772 21 5 20.5523 5 20V9H10C10.5523 9 11 8.55228 11 8V3H18C18.5523 3 19 3.44772 19 4V9C19 9.55228 19.4477 10 20 10C20.5523 10 21 9.55228 21 9V4C21 2.34315 19.6569 1 18 1H10ZM9 7H6.41421L9 4.41421V7ZM14 15.5C14 14.1193 15.1193 13 16.5 13C17.8807 13 19 14.1193 19 15.5V16V17H20C21.1046 17 22 17.8954 22 19C22 20.1046 21.1046 21 20 21H13C11.8954 21 11 20.1046 11 19C11 17.8954 11.8954 17 13 17H14V16V15.5ZM16.5 11C14.142 11 12.2076 12.8136 12.0156 15.122C10.2825 15.5606 9 17.1305 9 19C9 21.2091 10.7909 23 13 23H20C22.2091 23 24 21.2091 24 19C24 17.1305 22.7175 15.5606 20.9844 15.122C20.7924 12.8136 18.858 11 16.5 11Z" clip-rule="evenodd" fill-rule="evenodd"></path>
                </g>
              </svg>
            </div>
            <div class="text">
              <span>Click to upload image</span>
            </div>
            <input type="file" id="file" name="slider_img" accept="image/*" required onchange="previewFile(this)">
          </label>

          <div class="file-preview" id="filePreview">
            <div class="preview-container">
              <img id="previewImage" class="preview-image" src="" alt="Preview">
              <div class="file-info">
                <span class="file-name" id="fileName"></span>
                <button type="button" class="btn-clear" onclick="clearFile()">Clear</button>
              </div>
            </div>
          </div>

          <button class="btn-submit" type="submit">Upload Image</button>
        </div>
      </form>
    </div>

    <!-- Slider Images Grid -->
    <div class="slider-header">
      <h1>Active Slider Images</h1>
    </div>

    <div class="slider-grid">
      <?php
      if (mysqli_num_rows($result) > 0) {
          $count = 1;
          while ($row = mysqli_fetch_assoc($result)) {
              echo '<div class="slider-card">
                      <div class="slider-image-wrapper">
                        <img src="' . htmlspecialchars($row['slider_img']) . '" alt="Slider Image ' . $count . '">
                      </div>
                      <div class="slider-card-content">
                        <div class="slider-card-header">
                          <span class="slider-number">Image #' . $count . '</span>
                        </div>
                        <button onclick="confirmDelete('.$row['slider_id'].')" class="btn-delete">Remove</button>
                      </div>
                    </div>';
              $count++;
          }
      } else {
          echo '<div class="empty-state">
                  <i class="mdi mdi-image-off"></i>
                  <p>No slider images found. Upload your first image above.</p>
                </div>';
      }
      ?>
    </div>

  </div>
</div>

<script>
function previewFile(input) {
  const file = input.files[0];
  if (file) {
    const reader = new FileReader();
    
    reader.onload = function(e) {
      document.getElementById('previewImage').src = e.target.result;
      document.getElementById('fileName').textContent = file.name;
      document.getElementById('filePreview').classList.add('active');
    }
    
    reader.readAsDataURL(file);
  }
}

function clearFile() {
  document.getElementById('file').value = '';
  document.getElementById('previewImage').src = '';
  document.getElementById('fileName').textContent = '';
  document.getElementById('filePreview').classList.remove('active');
}

function confirmDelete(slider_id) {
  event.preventDefault();
  Swal.fire({
    title: 'Remove Slider Image?',
    text: "This action cannot be undone",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#000',
    cancelButtonColor: '#999',
    confirmButtonText: 'Yes, Remove',
    cancelButtonText: 'Cancel',
    customClass: {
      popup: 'swal-minimal',
      confirmButton: 'swal-btn-confirm',
      cancelButton: 'swal-btn-cancel'
    }
  }).then((result) => {
    if (result.isConfirmed) {
      window.location.href = `deleteSlider.php?si=${slider_id}`;
    }
  });
  return false;
}
</script>

<?php require 'footer.php'; ?>