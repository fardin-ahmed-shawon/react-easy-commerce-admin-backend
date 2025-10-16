<?php
$current_page = basename($_SERVER['PHP_SELF']);
$page_title = 'Edit Customize Product';
require 'header.php';

// ---------- Helpers ----------
function compressImageServer($source, $destination, $quality = 70)
{
    $info = @getimagesize($source);
    if (!$info) return false;

    $mime = $info['mime'];
    if ($mime == 'image/jpeg' || $mime == 'image/jpg') {
        $image = imagecreatefromjpeg($source);
    } elseif ($mime == 'image/png') {
        $image = imagecreatefrompng($source);
    } elseif ($mime == 'image/gif') {
        $image = imagecreatefromgif($source);
    } else {
        return move_uploaded_file($source, $destination) ? $destination : false;
    }
    if ($mime == 'image/png') {
        imagepng($image, $destination);
    } else {
        imagejpeg($image, $destination, $quality);
    }
    imagedestroy($image);
    return $destination;
}

function generateSlug($string)
{
    $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $string)));
    $slug = preg_replace('/-+/', '-', $slug);
    return rtrim($slug, '-');
}

// ---------- Fetch existing product ----------
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "<script>Swal.fire('Error','Invalid Product ID','error').then(()=>window.location='customized-products.php');</script>";
    exit;
}

$id = intval($_GET['id']);
$res = mysqli_query($conn, "SELECT * FROM customized_products WHERE id = $id LIMIT 1");
if (!$res || mysqli_num_rows($res) === 0) {
    echo "<script>Swal.fire('Error','Product not found','error').then(()=>window.location='customized-product-list.php');</script>";
    exit;
}
$product = mysqli_fetch_assoc($res);

// ---------- Handle update ----------
$status_msg = null;
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_title = trim($_POST['product_title'] ?? '');
    $category_id = intval($_POST['product_main_ctg'] ?? 0);
    $product_code = trim($_POST['product_code'] ?? '');
    $advance_amount = trim($_POST['advance_amount'] ?? '');
    $description = $_POST['description'] ?? '';

    if ($product_title === '') $errors[] = 'Product title is required.';
    if ($category_id <= 0) $errors[] = 'Please choose a main category.';
    if ($advance_amount !== '' && !is_numeric($advance_amount)) $errors[] = 'Advance amount must be a number.';

    $product_img_path = $product['product_img']; // keep existing

    // handle image upload (optional)
    if (isset($_FILES['product_img']) && $_FILES['product_img']['error'] === UPLOAD_ERR_OK) {
        $tmp_name = $_FILES['product_img']['tmp_name'];
        $orig_name = $_FILES['product_img']['name'];
        $ext = strtolower(pathinfo($orig_name, PATHINFO_EXTENSION));
        $allowed = ['jpg','jpeg','png','gif','webp'];
        if (!in_array($ext, $allowed)) {
            $errors[] = 'Unsupported image type. Use jpg, png, gif or webp.';
        } else {
            $dir = __DIR__ . '/uploads/customized_products/';
            if (!file_exists($dir)) mkdir($dir, 0777, true);
            $new_name = uniqid('prod_', true) . '.' . $ext;
            $destination = $dir . $new_name;

            if (!compressImageServer($tmp_name, $destination, 75)) {
                if (!move_uploaded_file($tmp_name, $destination)) {
                    $errors[] = 'Failed to save uploaded image.';
                }
            }
            // delete old image if exists
            if ($product['product_img'] && file_exists(__DIR__ . '/' . $product['product_img'])) {
                @unlink(__DIR__ . '/' . $product['product_img']);
            }
            $product_img_path = 'uploads/customized_products/' . $new_name;
        }
    }

    if (empty($errors)) {
        $product_title_db = mysqli_real_escape_string($conn, $product_title);
        $product_code_db = mysqli_real_escape_string($conn, $product_code);
        $advance_amount_db = ($advance_amount === '') ? 0 : intval($advance_amount);
        $description_db = mysqli_real_escape_string($conn, $description);

        // regenerate slug only if title changed
        $slug = $product['product_slug'];
        if ($product_title !== $product['product_title']) {
            $slug = generateSlug($product_title);
            $base_slug = $slug;
            $i = 1;
            while (true) {
                $check = mysqli_query($conn, "SELECT id FROM customized_products WHERE product_slug = '" . mysqli_real_escape_string($conn, $slug) . "' AND id != $id LIMIT 1");
                if (mysqli_num_rows($check) > 0) {
                    $slug = $base_slug . '-' . $i;
                    $i++;
                } else break;
            }
        }

        $sql = "UPDATE customized_products SET 
            product_title='$product_title_db',
            category_id='$category_id',
            advance_amount='$advance_amount_db',
            product_code='$product_code_db',
            product_description='$description_db',
            product_img='$product_img_path',
            product_slug='$slug'
            WHERE id=$id";

        if (mysqli_query($conn, $sql)) {
            $status_msg = "Product updated successfully!";
            $product = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM customized_products WHERE id=$id"));
        } else {
            $status_msg = "Error: " . mysqli_error($conn);
        }
    } else {
        $status_msg = "Error: " . implode(' | ', $errors);
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
        padding: 1.5rem;
        text-align: center;
        background: #f9fafb;
    }
    .img-preview {
        width: 100%;
        height: 220px;
        object-fit: cover;
        border-radius: 8px;
        margin-top: 10px;
        border: 1px solid #e2e8f0;
    }
</style>

<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title">
            <span class="page-title-icon bg-gradient-primary text-white me-2">
                <i class="mdi mdi-tshirt-crew-outline"></i>
            </span> Edit Customize Product
        </h3>
    </div>
    <div class="row">
        <div class="p-4" style="background: #fff; max-width: 1200px; margin: auto; border-radius: 10px;">
            <div class="content">
                <?php
                if (isset($status_msg)) {
                    $icon = (strpos($status_msg, 'Error') === false) ? 'success' : 'error';
                    $title = (strpos($status_msg, 'Error') === false) ? 'Success!' : 'Error!';
                    echo "<script>
                        Swal.fire({
                            icon: '" . $icon . "',
                            title: '" . addslashes($title) . "',
                            text: '" . addslashes($status_msg) . "',
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'OK'
                        }).then(function(){";
                    if ($icon === 'success') echo "window.location='customized-products.php';";
                    echo "});
                    </script>";
                }
                ?>

                <h1 class="text-center mb-4">Edit Customize Product</h1>

                <form action="" method="post" enctype="multipart/form-data">
                    <div class="user-details full-input-box">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="input-box">
                                    <label class="details">Product Title *</label>
                                    <input name="product_title" type="text" value="<?php echo htmlspecialchars($product['product_title']); ?>" required>
                                </div>

                                <div class="input-box">
                                    <label class="details">Choose Main Category *</label>
                                    <select id="main_ctg_name" name="product_main_ctg" required>
                                        <option value="">Select Main Category</option>
                                        <?php
                                        $cats = mysqli_query($conn, "SELECT id, category_name FROM customized_category ORDER BY category_name ASC");
                                        while ($row = mysqli_fetch_assoc($cats)) {
                                            $selected = ($product['category_id'] == $row['id']) ? 'selected' : '';
                                            echo "<option value='{$row['id']}' $selected>{$row['category_name']}</option>";
                                        }
                                        ?>
                                    </select>
                                </div>

                                <div class="input-box">
                                    <label class="details">Product Code</label>
                                    <input name="product_code" type="text" value="<?php echo htmlspecialchars($product['product_code']); ?>">
                                </div>

                                <div class="input-box">
                                    <label class="details">Advance Amount</label>
                                    <input name="advance_amount" type="text" value="<?php echo htmlspecialchars($product['advance_amount']); ?>">
                                </div>

                                <div class="mb-3">
                                    <label for="description" class="form-label">Description *</label>
                                    <textarea name="description" id="description" class="form-control" rows="10"><?php echo htmlspecialchars($product['product_description']); ?></textarea>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="upload-box">
                                    <label for="product_img">Change Product Image (optional)</label>
                                    <small>(Leave empty to keep current)</small>
                                    <input type="file" name="product_img" id="product_img" class="form-control" accept="image/*">

                                    <?php if ($product['product_img']) { ?>
                                        <img id="previewImage" src="<?php echo htmlspecialchars($product['product_img']); ?>" class="img-preview" alt="Current Image">
                                    <?php } else { ?>
                                        <img id="previewImage" src="" class="img-preview d-none" alt="Preview">
                                    <?php } ?>
                                    <small id="imgNote" class="form-text text-muted"></small>
                                </div>

                                <!-- Client-side preview compression (same as add page) -->
                                <script>
                                    const fileInput = document.getElementById('product_img');
                                    const preview = document.getElementById('previewImage');
                                    const imgNote = document.getElementById('imgNote');
                                    function dataURLtoFile(dataurl, filename) {
                                        const arr = dataurl.split(','), mime = arr[0].match(/:(.*?);/)[1];
                                        const bstr = atob(arr[1]); let n = bstr.length;
                                        const u8arr = new Uint8Array(n); while (n--) u8arr[n] = bstr.charCodeAt(n);
                                        return new File([u8arr], filename, {type: mime});
                                    }
                                    function compressAndPreview(file, maxW = 1200, maxH = 1200, quality = 0.8) {
                                        return new Promise((resolve, reject) => {
                                            const img = new Image();
                                            const reader = new FileReader();
                                            reader.onload = function(e) {
                                                img.onload = function() {
                                                    let canvas = document.createElement('canvas');
                                                    let w = img.width, h = img.height;
                                                    if (w > maxW || h > maxH) {
                                                        const ratio = Math.min(maxW / w, maxH / h);
                                                        w = Math.round(w * ratio); h = Math.round(h * ratio);
                                                    }
                                                    canvas.width = w; canvas.height = h;
                                                    const ctx = canvas.getContext('2d');
                                                    ctx.drawImage(img, 0, 0, w, h);
                                                    const mime = (file.type === 'image/png') ? 'image/png' : 'image/jpeg';
                                                    const dataURL = canvas.toDataURL(mime, quality);
                                                    const newFile = dataURLtoFile(dataURL, file.name);
                                                    resolve({dataURL, newFile});
                                                };
                                                img.onerror = reject; img.src = e.target.result;
                                            };
                                            reader.onerror = reject; reader.readAsDataURL(file);
                                        });
                                    }
                                    fileInput.addEventListener('change', async function(e) {
                                        const file = e.target.files[0];
                                        if (!file) return;
                                        try {
                                            imgNote.textContent = 'Processing image...';
                                            const {dataURL, newFile} = await compressAndPreview(file);
                                            preview.src = dataURL;
                                            preview.classList.remove('d-none');
                                            imgNote.textContent = 'Preview generated. Image will be uploaded in compressed form.';
                                            const dt = new DataTransfer();
                                            dt.items.add(newFile);
                                            fileInput.files = dt.files;
                                        } catch (err) {
                                            imgNote.textContent = 'Preview failed. Original file will be uploaded.';
                                            preview.src = URL.createObjectURL(file);
                                            preview.classList.remove('d-none');
                                        }
                                    });
                                </script>
                            </div>
                        </div>
                    </div>

                    <div class="button mb-0">
                        <input type="submit" value="Update Product" class="btn btn-primary">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- TinyMCE (original full plugin list) -->
<script src="https://cdn.tiny.cloud/1/sdr5uoo5rpy0lj4pgi7slnbboispfgfuzed4bmb4ivrvyiqq/tinymce/8/tinymce.min.js" referrerpolicy="origin" crossorigin="anonymous"></script>
<script>
  tinymce.init({
    selector: 'textarea',
    plugins: [
      'anchor', 'autolink', 'charmap', 'codesample', 'emoticons', 'link', 'lists', 'media', 'searchreplace', 'table', 'visualblocks', 'wordcount',
      'checklist', 'mediaembed', 'casechange', 'formatpainter', 'pageembed', 'a11ychecker', 'tinymcespellchecker', 'permanentpen', 'powerpaste', 'advtable', 'advcode', 'advtemplate', 'ai', 'uploadcare', 'mentions', 'tinycomments', 'tableofcontents', 'footnotes', 'mergetags', 'autocorrect', 'typography', 'inlinecss', 'markdown','importword', 'exportword', 'exportpdf'
    ],
    toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link media table mergetags | addcomment showcomments | spellcheckdialog a11ycheck typography uploadcare | align lineheight | checklist numlist bullist indent outdent | emoticons charmap | removeformat',
    tinycomments_mode: 'embedded',
    tinycomments_author: 'Author name',
    mergetags_list: [
      { value: 'First.Name', title: 'First Name' },
      { value: 'Email', title: 'Email' },
    ],
    ai_request: (request, respondWith) => respondWith.string(() => Promise.reject('See docs to implement AI Assistant')),
    uploadcare_public_key: 'd7e5639eab9525d12cbc',
  });
</script>

<?php require 'footer.php'; ?>