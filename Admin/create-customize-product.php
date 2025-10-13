<?php
$current_page = basename($_SERVER['PHP_SELF']); // Get the current page name
$page_title = 'Create Customize Product'; // Set the page title
?>
<?php require 'header.php'; ?>
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
</style>
<!--------------------------->
<!-- START MAIN AREA -->
<!--------------------------->
<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title">
            <span class="page-title-icon bg-gradient-primary text-white me-2">
                <i class="mdi mdi-tshirt-crew-outline"></i>
            </span> Customize Product
        </h3>
    </div>
    <div class="row">
        <div class="p-4" style="background: #fff; max-width: 900px; margin: auto; border-radius: 10px;">
            <div class="content">
                <?php
                if (isset($product_added_status)) {
                    echo "<script>
                            Swal.fire({
                                icon: 'success',
                                title: 'Success!',
                                text: '" . addslashes($product_added_status) . "',
                                confirmButtonColor: '#3085d6',
                                confirmButtonText: 'OK'
                            });
                        </script>";
                }
                ?>
                <br>
                <h1 class="text-center">Create Customize Product</h1>
                <!-- Product Add form -->
                <form action="" method="post" enctype="multipart/form-data">
                    <div class="user-details full-input-box">
                        <div class="row">
                            <div class="col-md-8">
                                <!-- title -->
                                <div class="input-box">
                                    <label class="details">Product Title *</label>
                                    <input name="product_title" type="text" placeholder="Enter your product title" required>
                                </div>
                                <!-- Selling price -->
                                <div class="input-box">
                                    <label class="details">Product Price *</label>
                                    <input name="product_price" type="text" placeholder="Enter product price" required>
                                </div>
                                <!-- Description -->
                                <div class="input-box">
                                    <label class="details">Description *</label>
                                    <textarea name="description" id="" placeholder="Enter Product Description" cols="95"></textarea>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <!-- main image -->
                                <style>
                                    .upload-box {
                                        border: 1px dashed #cbd5e1;
                                        border-radius: 10px;
                                        padding: 1.5rem;
                                        text-align: center;
                                        background: #f9fafb;
                                    }
                                    .upload-box label {
                                        font-weight: 600;
                                        color: #1e293b;
                                    }
                                    .upload-box small {
                                        color: #64748b;
                                        display: block;
                                        margin-bottom: 8px;
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
                                <div class="upload-box">
                                    <label for="product_img">Attach Product Image *</label>
                                    <small>(Recommended size: 1000 x 1000)</small>

                                    <input type="file" name="product_img" id="product_img" class="form-control" accept="image/*" required>

                                    <img id="previewImage" src="" class="img-preview d-none" alt="Preview">
                                </div>

                                <!-- Image Preview -->
                                <script>
                                document.getElementById('product_img').addEventListener('change', function(event) {
                                    const [file] = event.target.files;
                                    if (file) {
                                    const preview = document.getElementById('previewImage');
                                    preview.src = URL.createObjectURL(file);
                                    preview.classList.remove('d-none');
                                    }
                                });
                                </script>
                            </div>
                        </div>
                    </div>
                    <!-- Submit button -->
                    <div class="button mb-0">
                        <input type="submit" value="Add Product">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!--------------------------->
<!-- END MAIN AREA -->
<!--------------------------->

<?php require 'footer.php'; ?>