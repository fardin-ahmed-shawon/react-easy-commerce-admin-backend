<?php
$current_page = basename($_SERVER['PHP_SELF']); 
$page_title = 'Colors'; 
?>
<?php require 'header.php'; ?>

<?php
// ADD OR UPDATE COLOR
if ($_SERVER['REQUEST_METHOD'] == 'POST' && !isset($_POST['delete_id'])) {
    $color_label = trim($_POST['color_label']);
    $color_hex = isset($_POST['color_hex']) ? trim($_POST['color_hex']) : '';
    $edit_id = isset($_POST['edit_id']) ? intval($_POST['edit_id']) : 0;

    if (empty($color_label)) {
        $error_message = "Color label is required.";
    } elseif (empty($color_hex)) {
        $error_message = "Color hex code is required.";
    } else {
        if ($edit_id > 0) {
            // Update existing color
            $sql = "UPDATE color_labels SET color_label=?, color_hex=? WHERE id=?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssi", $color_label, $color_hex, $edit_id);
            if ($stmt->execute()) {
                $success_message = "Color updated successfully!";
            } else {
                $error_message = "Error: " . $stmt->error;
            }
            $stmt->close();
        } else {
            // Insert new color
            $sql = "INSERT INTO color_labels (color_label, color_hex) VALUES (?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ss", $color_label, $color_hex);
            if ($stmt->execute()) {
                $success_message = "Color added successfully!";
            } else {
                $error_message = "Error: " . $stmt->error;
            }
            $stmt->close();
        }
    }
}

// DELETE COLOR
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_id'])) {
    $delete_id = intval($_POST['delete_id']);
    $sql = "DELETE FROM color_labels WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $delete_id);
    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Color deleted successfully!']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to delete color.']);
    }
    $stmt->close();
    exit;
}
?>

<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title">
            <span class="page-title-icon bg-gradient-primary text-white me-2">
                <i class="mdi mdi-home"></i>
            </span> Colors
        </h3>
    </div>
    <br>
    <div class="row">
        <!-- Add / Edit Color Form -->
        <div class="col-md-4 mx-auto mt-5">
            <div class="card card-body p-4">
                <div class="row mb-2">
                    <div class="col mt-3">
                        <h6 id="form-title">Add Color</h6>
                    </div>
                </div><hr>

                <?php if (isset($success_message)): ?>
                    <div class="alert alert-success"><?php echo $success_message; ?></div>
                <?php endif; ?>
                <?php if (isset($error_message)): ?>
                    <div class="alert alert-danger"><?php echo $error_message; ?></div>
                <?php endif; ?>

                <form action="" method="POST" id="color-form">
                    <input type="hidden" name="edit_id" id="edit_id">
                    <div class="form-group">
                        <label style="font-size: 17px" for="colorinput">Color Label *</label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="colorinput" name="color_label" placeholder="Enter custom color name or pick color" required>
                            <button type="button" class="btn btn-outline-secondary" id="reset-label" title="Reset to custom name">✎</button>
                        </div>
                        <small class="form-text text-muted">Type a custom name or pick a color below.</small>
                    </div>
                    <div class="form-group mt-3">
                        <label style="font-size: 17px" for="colorpicker">Pick Color *</label>
                        <input type="color" class="form-control form-control-color" id="colorpicker" name="color_hex" value="#000000" required>
                    </div>
                    <button type="submit" class="btn btn-primary" id="submit-btn">Add Color</button>
                    <button type="button" class="btn btn-secondary d-none" id="cancel-edit">Cancel</button>
                </form>
            </div>
        </div>

        <!-- Color List -->
        <div class="col-md-7 mx-auto mt-5">
            <div class="card card-body">
                <div class="row mb-2">
                    <div class="col mt-3">
                        <h6 class="text-center">Color List</h6>
                    </div>
                </div><hr>

                <div class="table-responsive">
                    <table class="table table-bordered" id="colors-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Color Label</th>
                                <th>Hex</th>
                                <th>Preview</th>
                                <th colspan="2">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $result = $conn->query("SELECT * FROM color_labels ORDER BY id DESC");
                            if ($result && $result->num_rows > 0):
                                $i = 1;
                                while ($row = $result->fetch_assoc()):
                            ?>
                            <tr data-id="<?php echo $row['id']; ?>" data-label="<?php echo htmlspecialchars($row['color_label']); ?>" data-hex="<?php echo htmlspecialchars($row['color_hex']); ?>">
                                <td><?php echo $i++; ?></td>
                                <td class="color-label"><?php echo htmlspecialchars($row['color_label']); ?></td>
                                <td><?php echo htmlspecialchars($row['color_hex']); ?></td>
                                <td><span style="display:inline-block;width:30px;height:30px;background:<?php echo htmlspecialchars($row['color_hex']); ?>;border:1px solid #ccc;"></span></td>
                                <td>
                                    <button class="btn btn-sm btn-info edit-btn">Edit</button>
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-danger delete-btn">Delete</button>
                                </td>
                            </tr>
                            <?php endwhile; else: ?>
                            <tr>
                                <td colspan="6" class="text-center">No colors found.</td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Edit color
document.querySelectorAll('.edit-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        const row = this.closest('tr');
        const id = row.getAttribute('data-id');
        const label = row.getAttribute('data-label');
        const hex = row.getAttribute('data-hex');

        document.getElementById('edit_id').value = id;
        document.getElementById('colorinput').value = label;
        document.getElementById('colorpicker').value = hex || "#000000";
        document.getElementById('form-title').innerText = "Edit Color";
        document.getElementById('submit-btn').innerText = "Update Color";
        document.getElementById('cancel-edit').classList.remove('d-none');
    });
});

// Cancel edit
document.getElementById('cancel-edit').addEventListener('click', function() {
    document.getElementById('edit_id').value = '';
    document.getElementById('colorinput').value = '';
    document.getElementById('colorpicker').value = "#000000";
    document.getElementById('form-title').innerText = "Add Color";
    document.getElementById('submit-btn').innerText = "Add Color";
    this.classList.add('d-none');
});

// Delete color
document.querySelectorAll('.delete-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        const row = this.closest('tr');
        const id = row.getAttribute('data-id');

        Swal.fire({
            title: 'Are you sure?',
            text: "This color will be deleted!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                fetch("delete-color-label.php", {
                    method: "POST",
                    headers: { "Content-Type": "application/x-www-form-urlencoded" },
                    body: "delete_id=" + id
                })
                .then(res => res.json())
                .then(data => {
                    if (data.status === "success") {
                        Swal.fire("Deleted!", data.message, "success");
                        row.remove();
                    } else {
                        Swal.fire("Error!", data.message, "error");
                    }
                })
                .catch(() => Swal.fire("Error!", "Something went wrong.", "error"));
            }
        });
    });
});

// Color picker changes label to hex code
document.getElementById('colorpicker').addEventListener('input', function() {
    document.getElementById('colorinput').value = this.value;
});

// Reset label to custom name
document.getElementById('reset-label').addEventListener('click', function() {
    document.getElementById('colorinput').value = '';
    document.getElementById('colorinput').focus();
});
</script>