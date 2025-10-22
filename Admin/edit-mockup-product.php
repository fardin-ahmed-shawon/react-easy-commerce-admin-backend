<?php
$current_page = basename($_SERVER['PHP_SELF']);
$page_title = 'Edit Mockup Product';
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

function handleImageUpload($fileInputName, $oldImagePath, &$errors) {
    $img_path = $oldImagePath; // keep existing by default
    
    if (isset($_FILES[$fileInputName]) && $_FILES[$fileInputName]['error'] === UPLOAD_ERR_OK) {
        $tmp_name = $_FILES[$fileInputName]['tmp_name'];
        $orig_name = $_FILES[$fileInputName]['name'];
        $ext = strtolower(pathinfo($orig_name, PATHINFO_EXTENSION));
        $allowed = ['jpg','jpeg','png','gif','webp'];
        
        if (!in_array($ext, $allowed)) {
            $errors[] = "Unsupported image type for $fileInputName. Use jpg, png, gif or webp.";
        } else {
            $dir = __DIR__ . '/uploads/mockup_products/';
            if (!file_exists($dir)) mkdir($dir, 0777, true);
            
            $new_name = uniqid('prod_', true) . '.' . $ext;
            $destination = $dir . $new_name;

            if (!compressImageServer($tmp_name, $destination, 75)) {
                if (!move_uploaded_file($tmp_name, $destination)) {
                    $errors[] = "Failed to save uploaded image: $fileInputName.";
                } else {
                    if ($oldImagePath && file_exists(__DIR__ . '/' . $oldImagePath)) @unlink(__DIR__ . '/' . $oldImagePath);
                    $img_path = 'uploads/mockup_products/' . $new_name;
                }
            } else {
                if ($oldImagePath && file_exists(__DIR__ . '/' . $oldImagePath)) @unlink(__DIR__ . '/' . $oldImagePath);
                $img_path = 'uploads/mockup_products/' . $new_name;
            }
        }
    }
    
    return $img_path;
}

// ---------- Fetch existing product ----------
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "<script>Swal.fire('Error','Invalid Product ID','error').then(()=>window.location='mockup-list.php');</script>";
    exit;
}

$id = intval($_GET['id']);
$res = mysqli_query($conn, "SELECT * FROM mockup_products WHERE id = $id LIMIT 1");
if (!$res || mysqli_num_rows($res) === 0) {
    echo "<script>Swal.fire('Error','Product not found','error').then(()=>window.location='mockup-list.php');</script>";
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
    $description = $_POST['description'] ?? '';

    if ($product_title === '') $errors[] = 'Product title is required.';
    if ($category_id <= 0) $errors[] = 'Please choose a main category.';

    // Handle 4 image uploads
    $product_img_path = handleImageUpload('product_img', $product['product_img'], $errors);
    $product_img2_path = handleImageUpload('product_img2', $product['product_img2'] ?? '', $errors);
    $product_img3_path = handleImageUpload('product_img3', $product['product_img3'] ?? '', $errors);
    $product_img4_path = handleImageUpload('product_img4', $product['product_img4'] ?? '', $errors);

    if (empty($errors)) {
        $product_title_db = mysqli_real_escape_string($conn, $product_title);
        $product_code_db = mysqli_real_escape_string($conn, $product_code);
        $description_db = mysqli_real_escape_string($conn, $description);

        // regenerate slug if title changed
        $slug = $product['product_slug'];
        if ($product_title !== $product['product_title']) {
            $slug = generateSlug($product_title);
            $base_slug = $slug;
            $i = 1;
            while (true) {
                $check = mysqli_query($conn, "SELECT id FROM mockup_products WHERE product_slug = '" . mysqli_real_escape_string($conn, $slug) . "' AND id != $id LIMIT 1");
                if (mysqli_num_rows($check) > 0) {
                    $slug = $base_slug . '-' . $i;
                    $i++;
                } else break;
            }
        }

        $sql = "UPDATE mockup_products SET 
            product_title='$product_title_db',
            category_id='$category_id',
            product_code='$product_code_db',
            product_description='$description_db',
            product_img='$product_img_path',
            product_img2='$product_img2_path',
            product_img3='$product_img3_path',
            product_img4='$product_img4_path',
            product_slug='$slug'
            WHERE id=$id";

        if (mysqli_query($conn, $sql)) {
            $status_msg = "Product updated successfully!";
            $product = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM mockup_products WHERE id=$id"));
        } else {
            $status_msg = "Error: " . mysqli_error($conn);
        }
    } else {
        $status_msg = "Error: " . implode(' | ', $errors);
    }
}
?>

<!-- HTML Form & Styles -->
<style>
.upload-box { border: 1px dashed #cbd5e1; border-radius: 10px; padding: 1.5rem; text-align: center; background: #f9fafb; margin-bottom: 20px; }
.img-preview { width: 100%; height: 200px; object-fit: cover; border-radius: 8px; margin-top: 10px; border: 1px solid #e2e8f0; }
</style>

<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title">
            <span class="page-title-icon bg-gradient-primary text-white me-2">
                <i class="mdi mdi-tshirt-crew-outline"></i>
            </span> Edit Mockup Product
        </h3>
    </div>
    <div class="row">
        <div class="p-4" style="background: #fff; max-width: 1200px; margin: auto; border-radius: 10px;">
            <?php if ($status_msg) { 
                $icon = (strpos($status_msg,'Error')===false)?'success':'error';
                $title = (strpos($status_msg,'Error')===false)?'Success!':'Error!';
            ?>
            <script>
            Swal.fire({icon:'<?php echo $icon; ?>', title:'<?php echo addslashes($title); ?>', text:'<?php echo addslashes($status_msg); ?>', confirmButtonColor:'#3085d6', confirmButtonText:'OK'}).then(function(){
                <?php if($icon==='success') echo "window.location='mockup-list.php';"; ?>
            });
            </script>
            <?php } ?>

            <form action="" method="post" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-8">
                        <div class="mb-3">
                            <label>Product Title *</label>
                            <input type="text" name="product_title" class="form-control" value="<?php echo htmlspecialchars($product['product_title']); ?>" required>
                        </div>

                        <div class="mb-3">
                            <label>Main Category *</label>
                            <select name="product_main_ctg" class="form-control" required>
                                <option value="">Select Category</option>
                                <?php
                                $cats = mysqli_query($conn,"SELECT id, category_name FROM mockup_category ORDER BY category_name ASC");
                                while($row=mysqli_fetch_assoc($cats)){
                                    $selected = ($product['category_id']==$row['id'])?'selected':'';
                                    echo "<option value='{$row['id']}' $selected>{$row['category_name']}</option>";
                                }
                                ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label>Product Code</label>
                            <input type="text" name="product_code" class="form-control" value="<?php echo htmlspecialchars($product['product_code']); ?>">
                        </div>

                        <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
                        <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
                        <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
                        <div class="mb-3">
                            <label>Description *</label>
                            <textarea id="summernote" name="description" class="form-control" rows="10"><?php echo htmlspecialchars($product['product_description']); ?></textarea>
                        </div>
                        <script>
                                $('#summernote').summernote({
                                    placeholder: 'Write description here',
                                    tabsize: 2,
                                    height: 200
                                });
                                </script>
                    </div>

                    <div class="col-md-4">
                        <h5 class="mb-3">Product Images</h5>
                        <?php for($i=1;$i<=4;$i++){
                            $img_field = 'product_img'.($i==1?'':''.$i);
                            $preview_id = 'previewImage'.$i;
                            $note_id = 'imgNote'.$i;
                            $img_src = !empty($product[$img_field])?$product[$img_field]:'';
                        ?>
                        <div class="upload-box">
                            <label>Image <?php echo $i; ?></label>
                            <input type="file" name="<?php echo $img_field; ?>" class="form-control" accept="image/*">
                            <?php if($img_src){ ?>
                            <img id="<?php echo $preview_id; ?>" src="<?php echo htmlspecialchars($img_src); ?>" class="img-preview" alt="Image <?php echo $i; ?>">
                            <?php } else { ?>
                            <img id="<?php echo $preview_id; ?>" class="img-preview d-none" alt="Preview <?php echo $i; ?>">
                            <?php } ?>
                            <small id="<?php echo $note_id; ?>" class="form-text text-muted"></small>
                        </div>
                        <?php } ?>
                    </div>
                </div>

                <div class="mt-3">
                    <input type="submit" class="btn btn-primary" value="Update Product">
                </div>
            </form>
        </div>
    </div>
</div>

<?php require 'footer.php'; ?>