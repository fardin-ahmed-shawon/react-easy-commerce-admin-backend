<?php
$current_page = basename($_SERVER['PHP_SELF']);
$page_title = 'Create Mockup Product';
require 'header.php';

// ---------- Helpers ----------
/**
 * Compress and save uploaded image on server.
 * Supports jpeg, png, gif, webp (if supported by PHP).
 * Returns destination path (relative) on success, false on failure.
 */
function compressImageServer($source, $destination, $quality = 75)
{
    $info = @getimagesize($source);
    if (!$info) return false;

    $mime = $info['mime'];

    // Create image resource depending on mime
    switch ($mime) {
        case 'image/jpeg':
        case 'image/jpg':
            $image = @imagecreatefromjpeg($source);
            break;
        case 'image/png':
            $image = @imagecreatefrompng($source);
            // preserve alpha for PNG
            if ($image) {
                imagealphablending($image, true);
                imagesavealpha($image, true);
            }
            break;
        case 'image/gif':
            $image = @imagecreatefromgif($source);
            break;
        case 'image/webp':
            if (function_exists('imagecreatefromwebp')) {
                $image = @imagecreatefromwebp($source);
            } else {
                // if webp not supported, fallback to returning false to let move_uploaded_file happen
                return false;
            }
            break;
        default:
            return false;
    }

    if (!$image) return false;

    // If PNG keep transparency properly, otherwise use jpeg/webp output
    $outExt = strtolower(pathinfo($destination, PATHINFO_EXTENSION));
    if ($outExt === 'png') {
        // use PNG output (no quality param)
        $saved = imagepng($image, $destination);
    } elseif ($outExt === 'webp' && function_exists('imagewebp')) {
        $saved = imagewebp($image, $destination, $quality);
    } else {
        // fallback to jpeg
        $saved = imagejpeg($image, $destination, $quality);
    }

    imagedestroy($image);
    return $saved ? $destination : false;
}

function generateSlug($string)
{
    $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $string)));
    $slug = preg_replace('/-+/', '-', $slug);
    return rtrim($slug, '-');
}

/**
 * Handle single image upload (compress client-side file already replaced file input if provided)
 * Returns relative path like 'uploads/mockup_products/xxx.jpg' or '' if no file uploaded.
 * On error adds string to $errors array.
 */
function handleImageUpload($fileInputName, &$errors)
{
    $img_path = '';
    if (!isset($_FILES[$fileInputName]) || $_FILES[$fileInputName]['error'] === UPLOAD_ERR_NO_FILE) {
        return $img_path;
    }

    if ($_FILES[$fileInputName]['error'] !== UPLOAD_ERR_OK) {
        $errors[] = "Image upload error for {$fileInputName}.";
        return $img_path;
    }

    $tmp_name = $_FILES[$fileInputName]['tmp_name'];
    $orig_name = $_FILES[$fileInputName]['name'];
    $ext = strtolower(pathinfo($orig_name, PATHINFO_EXTENSION));
    $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
    if (!in_array($ext, $allowed)) {
        $errors[] = "Unsupported image type for {$fileInputName}. Use jpg, png, gif or webp.";
        return $img_path;
    }

    $dir = __DIR__ . '/uploads/mockup_products/';
    if (!file_exists($dir)) {
        mkdir($dir, 0777, true);
    }

    $new_name = uniqid('mockup_', true) . '.' . $ext;
    $destination = $dir . $new_name;
    $relative = 'uploads/mockup_products/' . $new_name;

    // Attempt server-side compression/save
    // If file is already processed client-side, the file is still in tmp and compressImageServer will handle.
    $saved = compressImageServer($tmp_name, $destination, 75);
    if (!$saved) {
        // fallback: try move_uploaded_file (no compression)
        if (!move_uploaded_file($tmp_name, $destination)) {
            $errors[] = "Failed to save uploaded image for {$fileInputName}.";
            return '';
        }
    }

    // Final file exists?
    if (!file_exists($destination)) {
        $errors[] = "Failed to store image for {$fileInputName}.";
        return '';
    }

    return $relative;
}

// ---------- Form handling ----------
$product_added_status = null;
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // collect and sanitize basic values
    $product_title = trim($_POST['product_title'] ?? '');
    $category_id = intval($_POST['product_main_ctg'] ?? 0);
    $product_code = trim($_POST['product_code'] ?? '');
    $description = $_POST['description'] ?? '';

    // validation
    if ($product_title === '') $errors[] = 'Product title is required.';
    if ($category_id <= 0) $errors[] = 'Please choose a main category.';


    // handle uploads (order matters)
    $product_img_path  = handleImageUpload('product_img', $errors);
    $product_img2_path = handleImageUpload('product_img2', $errors);
    $product_img3_path = handleImageUpload('product_img3', $errors);
    $product_img4_path = handleImageUpload('product_img4', $errors);

    // require first image
    if ($product_img_path === '') {
        $errors[] = 'First product image is required.';
    }

    if (empty($errors)) {
        // sanitize for DB
        $product_title_db = mysqli_real_escape_string($conn, $product_title);
        $product_code_db = mysqli_real_escape_string($conn, $product_code);
        // normalize price -> store integer (you can adapt to decimal if your DB uses DECIMAL)

        $description_db = mysqli_real_escape_string($conn, $description);
        $slug = generateSlug($product_title);

        // ensure slug uniqueness
        $base_slug = $slug;
        $i = 1;
        while (true) {
            $check_slug = mysqli_real_escape_string($conn, $slug);
            $check = mysqli_query($conn, "SELECT id FROM mockup_products WHERE product_slug = '{$check_slug}' LIMIT 1");
            if ($check && mysqli_num_rows($check) > 0) {
                $slug = $base_slug . '-' . $i;
                $i++;
            } else {
                break;
            }
        }

        // Insert query
        $sql = "INSERT INTO mockup_products 
            (product_title, category_id, product_code, product_description, product_img, product_img2, product_img3, product_img4, product_slug, created_at) 
            VALUES 
            ('$product_title_db', '$category_id', '$product_code_db', '$description_db', '$product_img_path', '$product_img2_path', '$product_img3_path', '$product_img4_path', '$slug', NOW())";

        if (mysqli_query($conn, $sql)) {
            $product_added_status = "Product added successfully!";
            // Clear POST to avoid re-populating form with old data
            $_POST = [];
        } else {
            // DB error - remove uploaded images to avoid orphan files
            $product_added_status = "Error: " . mysqli_error($conn);
            foreach ([$product_img_path, $product_img2_path, $product_img3_path, $product_img4_path] as $path) {
                if ($path && file_exists(__DIR__ . '/' . $path)) {
                    @unlink(__DIR__ . '/' . $path);
                }
            }
        }
    } else {
        $product_added_status = "Error: " . implode(' | ', $errors);
    }
}
?>

<style>
    .user-details .input-box textarea {
        width: 100%;
        outline: none;
        font-size: 16px;
        border-radius: 5px;
        padding-left: 15px;
        padding-top: 10px;
        padding-bottom: 10px;
        border: 1px solid #ccc;
        transition: all 0.3s ease;
    }
    .upload-box {
        border: 1px dashed #cbd5e1;
        border-radius: 10px;
        padding: 1.2rem;
        text-align: center;
        background: #f9fafb;
        margin-bottom: 16px;
    }
    .img-preview {
        width: 100%;
        height: 200px;
        object-fit: cover;
        border-radius: 8px;
        margin-top: 10px;
        border: 1px solid #e2e8f0;
    }
    .image-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 12px;
    }
    @media (max-width: 768px) {
        .image-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title">
            <span class="page-title-icon bg-gradient-primary text-white me-2">
                <i class="mdi mdi-tshirt-crew-outline"></i>
            </span> Create Mockup Product
        </h3>
    </div>

    <div class="row">
        <div class="p-4" style="background: #fff; max-width: 1200px; margin: auto; border-radius: 10px;">
            <div class="content">
                <?php
                if (isset($product_added_status)) {
                    $icon = (strpos($product_added_status, 'Error') === false) ? 'success' : 'error';
                    $title = (strpos($product_added_status, 'Error') === false) ? 'Success!' : 'Error!';
                    echo "<script>
                        Swal.fire({
                            icon: '" . $icon . "',
                            title: '" . addslashes($title) . "',
                            text: '" . addslashes($product_added_status) . "',
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'OK'
                        }).then(function(){";
                    if ($icon === 'success') {
                        // reload to clear form and show updated list
                        echo "window.location = window.location.href;";
                    }
                    echo "});
                    </script>";
                }
                ?>

                <br>
                <h1 class="text-center">Create Mockup Product</h1>

                <form action="" method="post" enctype="multipart/form-data" id="customProdForm">
                    <div class="user-details full-input-box">
                        <div class="row">
                            <div class="col-md-8">
                                <!-- title -->
                                <div class="input-box mb-3">
                                    <label class="details">Product Title *</label>
                                    <input name="product_title" type="text" class="form-control" placeholder="Enter your product title" required
                                           value="<?php echo htmlspecialchars($_POST['product_title'] ?? '', ENT_QUOTES); ?>">
                                </div>

                                <!-- Main Category -->
                                <div class="input-box mb-3">
                                    <label class="details">Choose Main Category *</label>
                                    <select id="main_ctg_name" name="product_main_ctg" class="form-control" required>
                                        <option value="">Select Main Category</option>
                                        <?php
                                        $result = mysqli_query($conn, "SELECT id, category_name FROM mockup_category ORDER BY category_name ASC");
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            $category_id = (int)$row['id'];
                                            $category_name = htmlspecialchars($row['category_name'], ENT_QUOTES, 'UTF-8');
                                            $selected = (isset($_POST['product_main_ctg']) && intval($_POST['product_main_ctg']) === $category_id) ? 'selected' : '';
                                            echo "<option value='{$category_id}' {$selected}>{$category_name}</option>";
                                        }
                                        ?>
                                    </select>
                                </div>

                                <!-- product code -->
                                <div class="input-box mb-3">
                                    <label class="details">Product Code</label>
                                    <input name="product_code" type="text" class="form-control" placeholder="Enter your product code"
                                           value="<?php echo htmlspecialchars($_POST['product_code'] ?? '', ENT_QUOTES); ?>">
                                </div>

                                <!-- -->
                                <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
                                <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
                                <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
                                <!-- short description -->
                                <div class="input-box mb-3"> 
                                    <label class="details">Product Description *</label>
                                    <textarea id="summernote1" rows="4" name="description" cols="58" class="mytextarea"> </textarea>
                                </div>
                                <br><br>
                                <script>
                                $('#summernote1').summernote({
                                    placeholder: 'Write description here',
                                    tabsize: 2,
                                    height: 200
                                });
                                </script>
                            </div>

                            <div class="col-md-4">
                                <h5 class="mb-3">Product Images</h5>

                                <div class="upload-box">
                                    <label for="product_img">Image 1 *</label>
                                    <small class="d-block">(Recommended: 1000x1000)</small>
                                    <input type="file" name="product_img" id="product_img" class="form-control" accept="image/*" required>
                                    <img id="previewImage1" src="" class="img-preview d-none" alt="Preview 1">
                                    <small id="imgNote1" class="form-text text-muted"></small>
                                </div>

                                <div class="upload-box">
                                    <label for="product_img2">Image 2</label>
                                    <small class="d-block">(Optional)</small>
                                    <input type="file" name="product_img2" id="product_img2" class="form-control" accept="image/*">
                                    <img id="previewImage2" src="" class="img-preview d-none" alt="Preview 2">
                                    <small id="imgNote2" class="form-text text-muted"></small>
                                </div>

                                <div class="upload-box">
                                    <label for="product_img3">Image 3</label>
                                    <small class="d-block">(Optional)</small>
                                    <input type="file" name="product_img3" id="product_img3" class="form-control" accept="image/*">
                                    <img id="previewImage3" src="" class="img-preview d-none" alt="Preview 3">
                                    <small id="imgNote3" class="form-text text-muted"></small>
                                </div>

                                <div class="upload-box">
                                    <label for="product_img4">Image 4</label>
                                    <small class="d-block">(Optional)</small>
                                    <input type="file" name="product_img4" id="product_img4" class="form-control" accept="image/*">
                                    <img id="previewImage4" src="" class="img-preview d-none" alt="Preview 4">
                                    <small id="imgNote4" class="form-text text-muted"></small>
                                </div>

                            </div>
                        </div>
                    </div>

                    <!-- Submit button -->
                    <div class="button mb-0">
                        <input type="submit" value="Add Product" class="btn btn-primary">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Client-side Image Compression Script (keeps your original behavior) -->
<script>
    function dataURLtoFile(dataurl, filename) {
        const arr = dataurl.split(','), mime = arr[0].match(/:(.*?);/)[1];
        const bstr = atob(arr[1]);
        let n = bstr.length;
        const u8arr = new Uint8Array(n);
        while (n--) u8arr[n] = bstr.charCodeAt(n);
        return new File([u8arr], filename, {type: mime});
    }

    function compressAndPreview(file, maxW = 1200, maxH = 1200, quality = 0.8) {
        return new Promise((resolve, reject) => {
            const img = new Image();
            const reader = new FileReader();
            reader.onload = function(e) {
                img.onload = function() {
                    try {
                        let canvas = document.createElement('canvas');
                        let w = img.width, h = img.height;
                        if (w > maxW || h > maxH) {
                            const ratio = Math.min(maxW / w, maxH / h);
                            w = Math.round(w * ratio);
                            h = Math.round(h * ratio);
                        }
                        canvas.width = w;
                        canvas.height = h;
                        const ctx = canvas.getContext('2d');
                        ctx.drawImage(img, 0, 0, w, h);
                        const mime = (file.type === 'image/png') ? 'image/png' : 'image/jpeg';
                        const dataURL = canvas.toDataURL(mime, quality);
                        const newFile = dataURLtoFile(dataURL, file.name);
                        resolve({dataURL, newFile});
                    } catch (err) {
                        reject(err);
                    }
                };
                img.onerror = reject;
                img.src = e.target.result;
            };
            reader.onerror = reject;
            reader.readAsDataURL(file);
        });
    }

    function setupImageUpload(inputId, previewId, noteId) {
        const fileInput = document.getElementById(inputId);
        const preview = document.getElementById(previewId);
        const imgNote = document.getElementById(noteId);

        fileInput.addEventListener('change', async function(e) {
            const file = e.target.files[0];
            if (!file) return;

            try {
                imgNote.textContent = 'Processing image...';
                const {dataURL, newFile} = await compressAndPreview(file, 1200, 1200, 0.8);
                preview.src = dataURL;
                preview.classList.remove('d-none');
                imgNote.textContent = 'Preview ready';

                const dt = new DataTransfer();
                dt.items.add(newFile);
                fileInput.files = dt.files;
            } catch (err) {
                imgNote.textContent = 'Preview failed. Original will be uploaded.';
                preview.src = URL.createObjectURL(file);
                preview.classList.remove('d-none');
            }
        });
    }

    // Setup all uploads (keeps behaviour you had)
    setupImageUpload('product_img', 'previewImage1', 'imgNote1');
    setupImageUpload('product_img2', 'previewImage2', 'imgNote2');
    setupImageUpload('product_img3', 'previewImage3', 'imgNote3');
    setupImageUpload('product_img4', 'previewImage4', 'imgNote4');
</script>


<?php require 'footer.php'; ?>