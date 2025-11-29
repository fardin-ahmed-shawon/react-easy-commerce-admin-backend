<?php
$current_page = basename($_SERVER['PHP_SELF']);
$page_title = 'Banner';
?>
<?php require 'header.php'; ?>

<?php
// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $infoQuery = "SELECT * FROM website_info WHERE id=1";
    $infoResult = $conn->query($infoQuery);
    $info = $infoResult->fetch_assoc();

    $updates = [];

    // Process banner_one
    if (!empty($_FILES['banner_one']['name'])) {
        $banner_one = 'uploads/' . basename($_FILES['banner_one']['name']);
        if (move_uploaded_file($_FILES['banner_one']['tmp_name'], $banner_one)) {
            $updates[] = "banner_one='$banner_one'";
        }
    }

    // Process banner_two
    if (!empty($_FILES['banner_two']['name'])) {
        $banner_two = 'uploads/' . basename($_FILES['banner_two']['name']);
        if (move_uploaded_file($_FILES['banner_two']['tmp_name'], $banner_two)) {
            $updates[] = "banner_two='$banner_two'";
        }
    }

    // Only update if any field was changed
    if (!empty($updates)) {
        $checkQuery = "SELECT * FROM website_info WHERE id=1";
        $result = $conn->query($checkQuery);

        if ($result->num_rows > 0) {
            $updateQuery = "UPDATE website_info SET " . implode(', ', $updates) . " WHERE id=1";
            $conn->query($updateQuery);
            $suc_message = "Banners updated successfully!";
        } else {
            $columns = ['id'];
            $values = [1];

            if (!empty($banner_one)) {
                $columns[] = 'banner_one';
                $values[] = "'$banner_one'";
            }

            if (!empty($banner_two)) {
                $columns[] = 'banner_two';
                $values[] = "'$banner_two'";
            }

            $insertQuery = "INSERT INTO website_info (" . implode(',', $columns) . ") VALUES (" . implode(',', $values) . ")";
            $conn->query($insertQuery);
            $suc_message = "Banners saved successfully!";
        }
    }
}

// Fetch updated data
$infoQuery = "SELECT * FROM website_info WHERE id=1";
$infoResult = $conn->query($infoQuery);
$info = $infoResult->fetch_assoc();
?>

<style>
.banner-container {
  max-width: 100%;
  margin: 0 auto;
  padding: 2rem;
  background: #ffffff;
}

.banner-header {
  margin-bottom: 2rem;
  padding-bottom: 1rem;
  border-bottom: 1px solid #ccc;
}

.banner-header h1 {
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
.banner-grid {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 2rem;
}

/* Upload Section */
.upload-section {
  background: #f8f8f8;
  border: 1px solid #ccc;
  padding: 2rem;
}

.upload-section h2 {
  font-size: 1.25rem;
  font-weight: 600;
  color: #000;
  margin-bottom: 2rem;
  letter-spacing: -0.5px;
  text-transform: uppercase;
}

.upload-group {
  margin-bottom: 2rem;
}

.upload-label {
  display: block;
  font-size: 0.9rem;
  font-weight: 600;
  color: #000;
  margin-bottom: 0.75rem;
  text-transform: uppercase;
  letter-spacing: 0.5px;
}

.custum-file-upload {
  display: block;
  cursor: pointer;
  background: #fff;
  border: 1px dashed #ccc;
  padding: 1.5rem;
  transition: all 0.3s ease;
  text-align: center;
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
  margin-bottom: 0.75rem;
}

.icon svg {
  width: 40px;
  height: 40px;
  fill: #000;
  transition: fill 0.3s ease;
}

.text span {
  font-size: 0.85rem;
  font-weight: 500;
  color: #000;
  text-transform: uppercase;
  letter-spacing: 0.5px;
  transition: color 0.3s ease;
}

/* File Preview */
.file-preview {
  margin-top: 1rem;
  display: none;
}

.file-preview.active {
  display: block;
}

.preview-container {
  background: #fff;
  border: 1px solid #ccc;
  padding: 0.75rem;
}

.preview-image {
  width: 100%;
  max-height: 200px;
  object-fit: contain;
  margin-bottom: 0.5rem;
}

.file-info {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 0.5rem;
  background: #f8f8f8;
  border-top: 1px solid #e0e0e0;
}

.file-name {
  font-size: 0.8rem;
  font-weight: 600;
  color: #000;
  word-break: break-all;
  flex: 1;
  margin-right: 1rem;
}

.btn-clear {
  padding: 0.35rem 0.85rem;
  background: #fff;
  color: #000;
  border: 1px solid #ccc;
  font-size: 0.75rem;
  font-weight: 600;
  cursor: pointer;
  transition: all 0.2s ease;
  text-transform: uppercase;
  letter-spacing: 0.5px;
  white-space: nowrap;
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
  margin-top: 1rem;
}

.btn-submit:hover {
  background: #333;
  transform: translateY(-1px);
}

/* Preview Section */
.preview-section {
  background: #fff;
  border: 1px solid #ccc;
  padding: 2rem;
}

.preview-section h2 {
  font-size: 1.25rem;
  font-weight: 600;
  color: #000;
  margin-bottom: 2rem;
  letter-spacing: -0.5px;
  text-transform: uppercase;
}

.banner-preview-item {
  margin-bottom: 2rem;
}

.banner-preview-item:last-child {
  margin-bottom: 0;
}

.banner-preview-label {
  font-size: 0.9rem;
  font-weight: 600;
  color: #000;
  margin-bottom: 0.75rem;
  text-transform: uppercase;
  letter-spacing: 0.5px;
  display: block;
}

.banner-preview-wrapper {
  background: #f8f8f8;
  border: 2px solid #e0e0e0;
  padding: 1rem;
  min-height: 200px;
  display: flex;
  align-items: center;
  justify-content: center;
}

.banner-preview-wrapper img {
  max-width: 100%;
  height: auto;
  display: block;
}

.no-image {
  color: #999;
  font-size: 0.9rem;
  font-weight: 500;
  text-align: center;
}

.no-image i {
  display: block;
  font-size: 2.5rem;
  margin-bottom: 0.5rem;
  opacity: 0.3;
}

/* Responsive */
@media (max-width: 992px) {
  .banner-grid {
    grid-template-columns: 1fr;
  }
  
  .upload-section {
    order: 1;
  }
  
  .preview-section {
    order: 2;
  }
}

@media (max-width: 768px) {
  .banner-container {
    padding: 1rem;
  }
  
  .banner-header h1 {
    font-size: 1.5rem;
  }
  
  .upload-section,
  .preview-section {
    padding: 1.5rem;
  }
}
</style>

<div class="content-wrapper">

  <div class="page-header">
    <h3 class="page-title">
      <span class="page-title-icon bg-gradient-primary text-white me-2">
        <i class="mdi mdi-image-multiple"></i>
      </span> Banner Management
    </h3>
  </div>

  <div class="banner-container">
    
    <!-- Alert Messages -->
    <?php
      if (isset($suc_message)) {
        echo '<div class="alert-success">'.$suc_message.'</div>';
      } else if (isset($err_message)) {
        echo '<div class="alert-error">'.$err_message.'</div>';
      }
    ?>

    <div class="banner-header">
      <h1>Update Website Banners</h1>
    </div>

    <div class="banner-grid">
      
      <!-- Upload Section -->
      <div class="upload-section">
        <h2>Upload Banners</h2>
        
        <form method="POST" action="" enctype="multipart/form-data">
          
          <!-- Banner One -->
          <div class="upload-group">
            <label class="upload-label">Banner One</label>
            <label class="custum-file-upload" for="banner_one">
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
                <span>Click to upload</span>
              </div>
              <input type="file" id="banner_one" name="banner_one" accept="image/*" onchange="previewFile(this, 'preview1')">
            </label>

            <div class="file-preview" id="preview1">
              <div class="preview-container">
                <img id="previewImage1" class="preview-image" src="" alt="Preview">
                <div class="file-info">
                  <span class="file-name" id="fileName1"></span>
                  <button type="button" class="btn-clear" onclick="clearFile('banner_one', 'preview1')">Clear</button>
                </div>
              </div>
            </div>
          </div>

          <!-- Banner Two -->
          <div class="upload-group">
            <label class="upload-label">Banner Two</label>
            <label class="custum-file-upload" for="banner_two">
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
                <span>Click to upload</span>
              </div>
              <input type="file" id="banner_two" name="banner_two" accept="image/*" onchange="previewFile(this, 'preview2')">
            </label>

            <div class="file-preview" id="preview2">
              <div class="preview-container">
                <img id="previewImage2" class="preview-image" src="" alt="Preview">
                <div class="file-info">
                  <span class="file-name" id="fileName2"></span>
                  <button type="button" class="btn-clear" onclick="clearFile('banner_two', 'preview2')">Clear</button>
                </div>
              </div>
            </div>
          </div>

          <button class="btn-submit" type="submit">Save Banners</button>
        </form>
      </div>

      <!-- Preview Section -->
      <div class="preview-section">
        <h2>Current Banners</h2>
        
        <!-- Banner One Preview -->
        <div class="banner-preview-item">
          <span class="banner-preview-label">Banner One</span>
          <div class="banner-preview-wrapper">
            <?php if (!empty($info['banner_one'])): ?>
              <img src="<?= htmlspecialchars($info['banner_one']) ?>" alt="Banner One">
            <?php else: ?>
              <div class="no-image">
                <i class="mdi mdi-image-off"></i>
                No banner uploaded
              </div>
            <?php endif; ?>
          </div>
        </div>

        <!-- Banner Two Preview -->
        <div class="banner-preview-item">
          <span class="banner-preview-label">Banner Two</span>
          <div class="banner-preview-wrapper">
            <?php if (!empty($info['banner_two'])): ?>
              <img src="<?= htmlspecialchars($info['banner_two']) ?>" alt="Banner Two">
            <?php else: ?>
              <div class="no-image">
                <i class="mdi mdi-image-off"></i>
                No banner uploaded
              </div>
            <?php endif; ?>
          </div>
        </div>

      </div>

    </div>
  </div>
</div>

<script>
function previewFile(input, previewId) {
  const file = input.files[0];
  if (file) {
    const reader = new FileReader();
    const previewNum = previewId.replace('preview', '');
    
    reader.onload = function(e) {
      document.getElementById('previewImage' + previewNum).src = e.target.result;
      document.getElementById('fileName' + previewNum).textContent = file.name;
      document.getElementById(previewId).classList.add('active');
    }
    
    reader.readAsDataURL(file);
  }
}

function clearFile(inputId, previewId) {
  const previewNum = previewId.replace('preview', '');
  document.getElementById(inputId).value = '';
  document.getElementById('previewImage' + previewNum).src = '';
  document.getElementById('fileName' + previewNum).textContent = '';
  document.getElementById(previewId).classList.remove('active');
}
</script>

<?php require 'footer.php'; ?>