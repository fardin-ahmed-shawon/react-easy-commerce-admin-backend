<?php
$current_page = basename($_SERVER['PHP_SELF']);
$page_title = 'Edit Landing Page';
require 'header.php';



// Get product_id from GET
$product_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if (!$product_id) die("Invalid product ID");

// Fetch product_slug
$product_slug = '';
$stmt = $conn->prepare("SELECT product_slug FROM product_info WHERE product_id = ?");
$stmt->bind_param("i", $product_id);
$stmt->execute();
$stmt->bind_result($product_slug);
$stmt->fetch();
$stmt->close();

if (!$product_slug) die("Product not found");

// Helper: Compress image
function compressImage($source, $destination, $quality = 70) {
    $info = getimagesize($source);
    if ($info['mime'] == 'image/jpeg') {
        $image = imagecreatefromjpeg($source);
        imagejpeg($image, $destination, $quality);
    } elseif ($info['mime'] == 'image/png') {
        $image = imagecreatefrompng($source);
        imagepng($image, $destination, round($quality / 10));
    } else {
        move_uploaded_file($source, $destination); // fallback
    }
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Landing page fields
    $home_title = $_POST['home_title'];
    $home_description = $_POST['home_description'];

    // Handle images
    $home_img = '';
    $feature_img = '';
    $upload_dir = 'uploads/';
    if (!is_dir($upload_dir)) mkdir($upload_dir);

    if (!empty($_FILES['home_img']['tmp_name'])) {
        $home_img = $upload_dir . uniqid() . '_' . $_FILES['home_img']['name'];
        compressImage($_FILES['home_img']['tmp_name'], $home_img, 70);
    }
    if (!empty($_FILES['feature_img']['tmp_name'])) {
        $feature_img = $upload_dir . uniqid() . '_' . $_FILES['feature_img']['name'];
        compressImage($_FILES['feature_img']['tmp_name'], $feature_img, 70);
    }

    // Insert/Update landing_pages
    $stmt = $conn->prepare("SELECT id FROM landing_pages WHERE product_id = ?");
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows) {
        // Update
        $stmt->close();
        $stmt = $conn->prepare("UPDATE landing_pages SET product_slug=?, home_title=?, home_description=?, home_img=?, feature_img=? WHERE product_id=?");
        $stmt->bind_param("sssssi", $product_slug, $home_title, $home_description, $home_img, $feature_img, $product_id);
        $stmt->execute();
    } else {
        // Insert
        $stmt->close();
        $stmt = $conn->prepare("INSERT INTO landing_pages (product_id, product_slug, home_title, home_description, home_img, feature_img) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("isssss", $product_id, $product_slug, $home_title, $home_description, $home_img, $feature_img);
        $stmt->execute();
    }
    $stmt->close();

    // Features
    if (!empty($_POST['feature_title'])) {
        foreach ($_POST['feature_title'] as $i => $ftitle) {
            $fdesc = $_POST['feature_description'][$i];
            if ($ftitle && $fdesc) {
                $stmt = $conn->prepare("INSERT INTO features (product_id, feature_title, feature_description) VALUES (?, ?, ?)");
                $stmt->bind_param("iss", $product_id, $ftitle, $fdesc);
                $stmt->execute();
                $stmt->close();
            }
        }
    }

    // Reviews
    if (!empty($_FILES['review_image']['name'][0])) {
        foreach ($_FILES['review_image']['tmp_name'] as $i => $tmp_name) {
            if ($tmp_name) {
                $review_img = $upload_dir . uniqid() . '_' . $_FILES['review_image']['name'][$i];
                compressImage($tmp_name, $review_img, 70);
                $stmt = $conn->prepare("INSERT INTO reviews (product_id, review_image) VALUES (?, ?)");
                $stmt->bind_param("is", $product_id, $review_img);
                $stmt->execute();
                $stmt->close();
            }
        }
    }

    // Gallery
    if (!empty($_FILES['gallery_image']['name'][0])) {
        foreach ($_FILES['gallery_image']['tmp_name'] as $i => $tmp_name) {
            if ($tmp_name) {
                $gallery_img = $upload_dir . uniqid() . '_' . $_FILES['gallery_image']['name'][$i];
                compressImage($tmp_name, $gallery_img, 70);
                $stmt = $conn->prepare("INSERT INTO gallery (product_id, gallery_image) VALUES (?, ?)");
                $stmt->bind_param("is", $product_id, $gallery_img);
                $stmt->execute();
                $stmt->close();
            }
        }
    }

    echo '<div class="alert alert-success">Landing page updated successfully!</div>';
}
?>

<div class="content-wrapper">
    <div class="container mt-5">
        <h2 class="mb-4">Edit Landing Page for <span class="text-primary"><?= htmlspecialchars($product_slug) ?></span></h2>
        <form method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">Landing Page Info</div>
                <div class="card-body row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Home Title</label>
                        <input type="text" name="home_title" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Home Description</label>
                        <textarea name="home_description" class="form-control" rows="3" required></textarea>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Home Image</label>
                        <input type="file" name="home_img" accept="image/*" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Feature Image</label>
                        <input type="file" name="feature_img" accept="image/*" class="form-control" required>
                    </div>
                </div>
            </div>

            <!-- Features -->
            <div class="card mb-4">
                <div class="card-header bg-success text-white">Features</div>
                <div class="card-body" id="features-section">
                    <div class="feature-group row g-3 mb-2">
                        <div class="col-md-5">
                            <input type="text" name="feature_title[]" class="form-control" placeholder="Feature Title" required>
                        </div>
                        <div class="col-md-5">
                            <input type="text" name="feature_description[]" class="form-control" placeholder="Feature Description" required>
                        </div>
                        <div class="col-md-2">
                            <button type="button" class="btn btn-danger remove-feature">Remove</button>
                        </div>
                    </div>
                </div>
                <button type="button" class="btn btn-outline-success" id="add-feature">Add Feature</button>
            </div>

            <!-- Reviews -->
            <div class="card mb-4">
                <div class="card-header bg-info text-white">Reviews</div>
                <div class="card-body" id="reviews-section">
                    <div class="review-group row g-3 mb-2">
                        <div class="col-md-10">
                            <input type="file" name="review_image[]" accept="image/*" class="form-control" required>
                        </div>
                        <div class="col-md-2">
                            <button type="button" class="btn btn-danger remove-review">Remove</button>
                        </div>
                    </div>
                </div>
                <button type="button" class="btn btn-outline-info" id="add-review">Add Review Image</button>
            </div>

            <!-- Gallery -->
            <div class="card mb-4">
                <div class="card-header bg-warning text-white">Gallery</div>
                <div class="card-body" id="gallery-section">
                    <div class="gallery-group row g-3 mb-2">
                        <div class="col-md-10">
                            <input type="file" name="gallery_image[]" accept="image/*" class="form-control" required>
                        </div>
                        <div class="col-md-2">
                            <button type="button" class="btn btn-danger remove-gallery">Remove</button>
                        </div>
                    </div>
                </div>
                <button type="button" class="btn btn-outline-warning" id="add-gallery">Add Gallery Image</button>
            </div>

            <button type="submit" class="btn btn-primary btn-lg w-100">Save Landing Page</button>
        </form>
    </div>
</div>

<!-- Dynamic field JS -->
<script>
document.getElementById('add-feature').onclick = function() {
    let section = document.getElementById('features-section');
    let group = document.createElement('div');
    group.className = 'feature-group row g-3 mb-2';
    group.innerHTML = `
        <div class="col-md-5">
            <input type="text" name="feature_title[]" class="form-control" placeholder="Feature Title" required>
        </div>
        <div class="col-md-5">
            <input type="text" name="feature_description[]" class="form-control" placeholder="Feature Description" required>
        </div>
        <div class="col-md-2">
            <button type="button" class="btn btn-danger remove-feature">Remove</button>
        </div>
    `;
    section.appendChild(group);
};
document.getElementById('features-section').onclick = function(e) {
    if (e.target.classList.contains('remove-feature')) {
        e.target.closest('.feature-group').remove();
    }
};

document.getElementById('add-review').onclick = function() {
    let section = document.getElementById('reviews-section');
    let group = document.createElement('div');
    group.className = 'review-group row g-3 mb-2';
    group.innerHTML = `
        <div class="col-md-10">
            <input type="file" name="review_image[]" accept="image/*" class="form-control" required>
        </div>
        <div class="col-md-2">
            <button type="button" class="btn btn-danger remove-review">Remove</button>
        </div>
    `;
    section.appendChild(group);
};
document.getElementById('reviews-section').onclick = function(e) {
    if (e.target.classList.contains('remove-review')) {
        e.target.closest('.review-group').remove();
    }
};

document.getElementById('add-gallery').onclick = function() {
    let section = document.getElementById('gallery-section');
    let group = document.createElement('div');
    group.className = 'gallery-group row g-3 mb-2';
    group.innerHTML = `
        <div class="col-md-10">
            <input type="file" name="gallery_image[]" accept="image/*" class="form-control" required>
        </div>
        <div class="col-md-2">
            <button type="button" class="btn btn-danger remove-gallery">Remove</button>
        </div>
    `;
    section.appendChild(group);
};
document.getElementById('gallery-section').onclick = function(e) {
    if (e.target.classList.contains('remove-gallery')) {
        e.target.closest('.gallery-group').remove();
    }
};
</script>

<?php require 'footer.php'; ?>