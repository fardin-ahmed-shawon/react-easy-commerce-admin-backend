<?php
$current_page = basename($_SERVER['PHP_SELF']);
$page_title = 'Mockup Categories';
require 'header.php';

// ===== CREATE / UPDATE CATEGORY =====
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // ===== ADD CATEGORY =====
    if (isset($_POST['insert_category'])) {
        $category_name = trim($_POST['category_name']);
        $category_slug = make_title_to_slug($category_name);

        // Ensure unique slug
        $check_slug = $conn->prepare("SELECT * FROM mockup_category WHERE category_slug = ?");
        $check_slug->bind_param("s", $category_slug);
        $check_slug->execute();
        $check_result = $check_slug->get_result();
        while ($check_result->num_rows > 0) {
            $category_slug .= '-' . rand(1, 999);
            $check_slug = $conn->prepare("SELECT * FROM mockup_category WHERE category_slug = ?");
            $check_slug->bind_param("s", $category_slug);
            $check_slug->execute();
            $check_result = $check_slug->get_result();
        }

        $stmt = $conn->prepare("INSERT INTO mockup_category (category_name, category_slug) VALUES (?, ?)");
        $stmt->bind_param("ss", $category_name, $category_slug);

        if ($stmt->execute()) {
            $msg = "<div class='alert alert-success'>Category added successfully!</div>";
        } else {
            $msg = "<div class='alert alert-danger'>Error adding category: {$stmt->error}</div>";
        }
    }

    // ===== UPDATE CATEGORY =====
    if (isset($_POST['update_category'])) {
        $id = intval($_POST['category_id']);
        $category_name = trim($_POST['category_name']);
        $category_slug = make_title_to_slug($category_name);

        $stmt = $conn->prepare("UPDATE mockup_category SET category_name=?, category_slug=? WHERE id=?");
        $stmt->bind_param("ssi", $category_name, $category_slug, $id);

        if ($stmt->execute()) {
            $msg = "<div class='alert alert-success'>Category updated successfully!</div>";
        } else {
            $msg = "<div class='alert alert-danger'>Error updating category: {$stmt->error}</div>";
        }
    }
}

// ===== DELETE CATEGORY =====
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $stmt = $conn->prepare("DELETE FROM mockup_category WHERE id = ?");
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        $msg = "<div class='alert alert-danger'>Category deleted successfully!</div>";
    }
}

// ===== FETCH ALL CATEGORIES =====
$categories = $conn->query("SELECT * FROM mockup_category ORDER BY id DESC");
?>

<!-- START MAIN AREA -->
<div class="content-wrapper">
    <div class="page-header d-flex justify-content-between align-items-center flex-wrap">
        <h3 class="page-title">
            <span class="page-title-icon bg-gradient-primary text-white me-2">
                <i class="mdi mdi-shape-plus"></i>
            </span> Mockup Categories
        </h3>
    </div>
    <br>

    <?php if (isset($msg)) echo $msg; ?>

    <div class="row">
        <!-- Add/Edit Form -->
        <div class="col-md-4">
            <div class="card shadow p-3">
                <h5 class="card-title text-center mb-3">
                    <?php echo isset($_GET['edit']) ? 'Edit Category' : 'Add New Category'; ?>
                </h5>

                <?php
                $editData = null;
                if (isset($_GET['edit'])) {
                    $id = intval($_GET['edit']);
                    $result = $conn->query("SELECT * FROM mockup_category WHERE id=$id");
                    $editData = $result->fetch_assoc();
                }
                ?>

                <form method="post">
                    <?php if (isset($_GET['edit'])): ?>
                        <input type="hidden" name="category_id" value="<?= $editData['id']; ?>">
                    <?php endif; ?>

                    <div class="form-group mb-3">
                        <label>Category Name</label>
                        <input type="text" name="category_name" class="form-control" placeholder="Enter category name"
                               value="<?= $editData['category_name'] ?? ''; ?>" required>
                    </div>

                    <div class="d-grid">
                        <?php if (isset($_GET['edit'])): ?>
                            <button type="submit" name="update_category" class="btn btn-warning">Update Category</button>
                            <a href="mockup-categories.php" class="btn btn-secondary mt-2">Cancel</a>
                        <?php else: ?>
                            <button type="submit" name="insert_category" class="btn btn-primary">Add Category</button>
                        <?php endif; ?>
                    </div>
                </form>
            </div>
        </div>

        <!-- Category Table -->
        <div class="col-md-8">
            <div class="card shadow p-3">
                <h5 class="card-title text-center mb-3">All Mockup Categories</h5>
                <div class="table-responsive">
                    <table class="table table-bordered text-center align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Category Name</th>
                                <th>Slug</th>
                                <th>Created At</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($categories->num_rows > 0): ?>
                                <?php $i = 1; while ($row = $categories->fetch_assoc()): ?>
                                    <tr>
                                        <td><?= $i++; ?></td>
                                        <td><?= htmlspecialchars($row['category_name']); ?></td>
                                        <td><?= htmlspecialchars($row['category_slug']); ?></td>
                                        <td><?= $row['created_at']; ?></td>
                                        <td>
                                            <a href="?edit=<?= $row['id']; ?>" class="btn btn-sm btn-warning"><i class="mdi mdi-pencil"></i></a>
                                            <a href="?delete=<?= $row['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure to delete this category?');"><i class="mdi mdi-delete"></i></a>
                                            <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#viewModal<?= $row['id']; ?>"><i class="mdi mdi-eye"></i></button>
                                        </td>
                                    </tr>

                                    <!-- View Modal -->
                                    <div class="modal fade" id="viewModal<?= $row['id']; ?>" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header bg-primary text-white">
                                                    <h5 class="modal-title">Mockup Category Details</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <p><strong>ID:</strong> <?= $row['id']; ?></p>
                                                    <p><strong>Name:</strong> <?= htmlspecialchars($row['category_name']); ?></p>
                                                    <p><strong>Slug:</strong> <?= htmlspecialchars($row['category_slug']); ?></p>
                                                    <p><strong>Created:</strong> <?= $row['created_at']; ?></p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr><td colspan="5">No categories found.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END MAIN AREA -->

<?php require 'footer.php'; ?>