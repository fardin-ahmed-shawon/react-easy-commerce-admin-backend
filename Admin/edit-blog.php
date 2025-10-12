<?php
$current_page = basename($_SERVER['PHP_SELF']);
$page_title = 'Edit Blog';
require 'header.php';

// Get blog ID
if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "<p>Invalid blog ID.</p>";
    exit;
}
$blog_id = intval($_GET['id']);

// Fetch existing blog data
$query = "SELECT * FROM blogs WHERE id = $blog_id LIMIT 1";
$result = mysqli_query($conn, $query);
if (mysqli_num_rows($result) == 0) {
    echo "<p>Blog not found.</p>";
    exit;
}
$blog = mysqli_fetch_assoc($result);

// Create uploads folder if not exists
$upload_dir = 'uploads/';
if (!is_dir($upload_dir)) {
    mkdir($upload_dir, 0777, true);
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $blog_title = mysqli_real_escape_string($conn, $_POST['blog_title']);
    $blog_description = mysqli_real_escape_string($conn, $_POST['blog_description']);
    $blog_img = $blog['blog_img']; // keep existing image

    // Handle image upload & compression
    if (isset($_FILES['blog_img']) && $_FILES['blog_img']['error'] === UPLOAD_ERR_OK) {
        $file_tmp = $_FILES['blog_img']['tmp_name'];
        $file_name = uniqid('blog_', true) . '.jpg';
        $target_path = $upload_dir . $file_name;
        $info = getimagesize($file_tmp);
        $mime = $info['mime'];

        switch ($mime) {
            case 'image/jpeg': $image = imagecreatefromjpeg($file_tmp); break;
            case 'image/png': $image = imagecreatefrompng($file_tmp); break;
            case 'image/webp': $image = imagecreatefromwebp($file_tmp); break;
            default: $image = null;
        }

        if ($image) {
            imagejpeg($image, $target_path, 80);
            imagedestroy($image);
            // Delete old image
            if (!empty($blog['blog_img']) && file_exists($upload_dir . $blog['blog_img'])) {
                unlink($upload_dir . $blog['blog_img']);
            }
            $blog_img = $file_name;
        } else {
            echo "<script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Invalid Image Format!',
                        text: 'Only JPG, PNG, and WEBP are supported.'
                    });
                  </script>";
        }
    }

    // Update blog
    $update_query = "UPDATE blogs SET 
                        blog_title='$blog_title', 
                        blog_description='$blog_description', 
                        blog_img='$blog_img'
                     WHERE id=$blog_id";
    if (mysqli_query($conn, $update_query)) {
        echo "<script>
                Swal.fire({
                    icon: 'success',
                    title: 'Blog Updated Successfully!',
                    showConfirmButton: false,
                    timer: 1500
                }).then(() => {
                    window.location.href = 'blogs.php';
                });
              </script>";
    } else {
        echo "<script>
                Swal.fire({
                    icon: 'error',
                    title: 'Something went wrong!',
                    text: '".mysqli_error($conn)."'
                });
              </script>";
    }
}
?>

<style>
  body { background: #f9fafb; }
  .content-wrapper { min-height: 100vh; }
  .page-card { background: #fff; border-radius: 12px; padding: 2.5rem; box-shadow: 0 4px 20px rgba(0,0,0,0.05); }
  .page-title { font-weight: 700; font-size: 1.8rem; color: #1e293b; text-align: center; margin-bottom: 2rem; }
  label.form-label { font-weight: 600; color: #334155; }
  .form-control { border-radius: 8px; padding: 10px 12px; border: 1px solid #d1d5db; font-size: 0.95rem; }
  .form-control:focus { border-color: #6366f1; box-shadow: 0 0 0 0.2rem rgba(99,102,241,0.15); }
  .btn-primary { background: linear-gradient(135deg, #6366f1, #4338ca); border: none; font-weight: 600; border-radius: 8px; padding: 10px 24px; transition: all 0.3s ease; }
  .btn-primary:hover { background: linear-gradient(135deg, #4338ca, #312e81); transform: translateY(-1px); }
  .upload-box { border: 1px dashed #cbd5e1; border-radius: 10px; padding: 1.5rem; text-align: center; background: #f9fafb; }
  .upload-box label { font-weight: 600; color: #1e293b; }
  .upload-box small { color: #64748b; display: block; margin-bottom: 8px; }
  .img-preview { width: 100%; height: 220px; object-fit: cover; border-radius: 8px; margin-top: 10px; border: 1px solid #e2e8f0; }
</style>

<div class="content-wrapper py-5">
  <div class="container">
    <div class="page-card">
      <h3 class="page-title">Edit Blog</h3>

      <form action="" method="POST" enctype="multipart/form-data" id="editBlogForm">
        <div class="row g-4">
          <!-- Left Column -->
          <div class="col-lg-8">
            <div class="mb-3">
              <label for="blog_title" class="form-label">Blog Title *</label>
              <input type="text" name="blog_title" id="blog_title" class="form-control" value="<?php echo htmlspecialchars($blog['blog_title']); ?>" required>
            </div>

            <div class="mb-3">
              <label for="blog_description" class="form-label">Blog Description *</label>
              <textarea name="blog_description" id="blog_description" class="form-control" rows="10" ><?php echo htmlspecialchars($blog['blog_description']); ?></textarea>
            </div>

            <div class="mt-4">
              <button type="submit" class="btn btn-primary">
                <i class="bx bx-save me-1"></i> Update Blog
              </button>
            </div>
          </div>

          <!-- Right Column (Image Upload) -->
          <div class="col-lg-4">
            <div class="upload-box">
              <label for="blog_img">Update Blog Image</label>
              <small>(Recommended size: 1000 x 1000)</small>
              <input type="file" name="blog_img" id="blog_img" class="form-control" accept="image/*">
              <img id="previewImage" src="<?php echo !empty($blog['blog_img']) ? 'uploads/'.$blog['blog_img'] : ''; ?>" class="img-preview <?php echo !empty($blog['blog_img']) ? '' : 'd-none'; ?>" alt="Preview">
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
  document.getElementById('blog_img').addEventListener('change', function(event) {
    const [file] = event.target.files;
    if (file) {
      const preview = document.getElementById('previewImage');
      preview.src = URL.createObjectURL(file);
      preview.classList.remove('d-none');
    }
  });
</script>

<!-- TinyMCE -->
<!-- Place the first <script> tag in your HTML's <head> -->
<script src="https://cdn.tiny.cloud/1/sdr5uoo5rpy0lj4pgi7slnbboispfgfuzed4bmb4ivrvyiqq/tinymce/8/tinymce.min.js" referrerpolicy="origin" crossorigin="anonymous"></script>

<!-- Place the following <script> and <textarea> tags your HTML's <body> -->
<script>
  tinymce.init({
    selector: 'textarea',
    plugins: [
      // Core editing features
      'anchor', 'autolink', 'charmap', 'codesample', 'emoticons', 'link', 'lists', 'media', 'searchreplace', 'table', 'visualblocks', 'wordcount',
      // Your account includes a free trial of TinyMCE premium features
      // Try the most popular premium features until Oct 19, 2025:
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