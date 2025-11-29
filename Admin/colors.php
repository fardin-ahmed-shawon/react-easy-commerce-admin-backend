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

// Fetch colors with search and sort
$whereClause = "1=1";
$orderBy = "id DESC";

if (isset($_GET['search']) && !empty($_GET['search'])) {
    $searchQuery = $conn->real_escape_string($_GET['search']);
    $whereClause .= " AND color_label LIKE '%$searchQuery%'";
}

if (isset($_GET['sort_order']) && !empty($_GET['sort_order'])) {
    $sortOrder = $_GET['sort_order'];
    $orderBy = "color_label $sortOrder";
}

$result = $conn->query("SELECT * FROM color_labels WHERE $whereClause ORDER BY $orderBy");
?>

<style>
    .colors-container {
        max-width: 100%;
        margin: 0 auto;
        padding: 2rem;
        background: #ffffff;
    }

    .colors-header {
        margin-bottom: 2rem;
        padding-bottom: 1rem;
        border-bottom: 2px solid #000;
    }

    .colors-header h1 {
        font-size: 1.75rem;
        font-weight: 600;
        color: #000;
        margin: 0;
        letter-spacing: -0.5px;
    }

    .content-grid {
        display: grid;
        grid-template-columns: 1fr 2fr;
        gap: 2rem;
    }

    .form-section {
        background: #f8f8f8;
        padding: 2rem;
        border: 1px solid #e0e0e0;
        height: fit-content;
    }

    .form-section h2 {
        font-size: 1.25rem;
        font-weight: 600;
        color: #000;
        margin: 0 0 1.5rem 0;
        padding-bottom: 1rem;
        border-bottom: 2px solid #000;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-group label {
        display: block;
        font-size: 0.85rem;
        font-weight: 600;
        color: #000;
        margin-bottom: 0.5rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .form-input {
        width: 100%;
        padding: 0.75rem;
        border: 1px solid #ccc;
        font-size: 0.95rem;
        background: #fff;
        transition: border-color 0.2s ease;
    }

    .form-input:focus {
        outline: none;
        border-color: #000;
    }

    .input-group {
        display: flex;
        gap: 0.5rem;
    }

    .input-group .form-input {
        flex: 1;
    }

    .btn-reset-label {
        padding: 0.75rem 1rem;
        background: #fff;
        border: 1px solid #ccc;
        cursor: pointer;
        transition: all 0.2s ease;
        font-size: 1rem;
    }

    .btn-reset-label:hover {
        background: #000;
        color: #fff;
        border-color: #000;
    }

    .form-hint {
        font-size: 0.8rem;
        color: #666;
        margin-top: 0.5rem;
    }

    .color-picker-wrapper {
        display: flex;
        gap: 1rem;
        align-items: center;
    }

    .color-picker {
        width: 80px;
        height: 50px;
        border: 1px solid #ccc;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .color-picker:hover {
        border-color: #000;
    }

    .color-preview {
        flex: 1;
        padding: 0.75rem;
        background: #fff;
        border: 1px solid #ccc;
        font-size: 0.9rem;
        font-family: monospace;
        font-weight: 600;
    }

    .form-actions {
        display: flex;
        gap: 0.75rem;
    }

    .btn-submit,
    .btn-cancel {
        padding: 0.75rem 1.5rem;
        font-size: 0.9rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s ease;
        border: none;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        flex: 1;
    }

    .btn-submit {
        background: #000;
        color: #fff;
    }

    .btn-submit:hover {
        background: #333;
    }

    .btn-cancel {
        background: #fff;
        color: #000;
        border: 2px solid #000;
    }

    .btn-cancel:hover {
        background: #000;
        color: #fff;
    }

    .alert {
        padding: 0.75rem 1rem;
        margin-bottom: 1rem;
        border: 2px solid;
        font-size: 0.9rem;
        font-weight: 500;
    }

    .alert-success {
        background: #fff;
        color: #000;
        border-color: #000;
    }

    .alert-danger {
        background: #fff;
        color: #f44336;
        border-color: #f44336;
    }

    .list-section {
        background: #fff;
        border: 1px solid #e0e0e0;
    }

    .list-header {
        background: #f8f8f8;
        padding: 1.5rem;
        border-bottom: 1px solid #e0e0e0;
    }

    .list-header h2 {
        font-size: 1.25rem;
        font-weight: 600;
        color: #000;
        margin: 0;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .search-filters {
        background: #f8f8f8;
        padding: 1rem 1.5rem;
        border-bottom: 1px solid #e0e0e0;
    }

    .filter-row {
        display: grid;
        grid-template-columns: 2fr 1fr auto;
        gap: 1rem;
        align-items: end;
    }

    .filter-group {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }

    .filter-group label {
        font-size: 0.75rem;
        font-weight: 600;
        color: #000;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .filter-input,
    .filter-select {
        padding: 0.65rem;
        border: 1px solid #ccc;
        font-size: 0.9rem;
        background: #fff;
    }

    .btn-search,
    .btn-reset {
        padding: 0.65rem 1.25rem;
        font-size: 0.85rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s ease;
        border: none;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        white-space: nowrap;
    }

    .btn-search {
        background: #000;
        color: #fff;
    }

    .btn-search:hover {
        background: #333;
    }

    .btn-reset {
        background: #fff;
        color: #000;
        border: 2px solid #000;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .btn-reset:hover {
        background: #000;
        color: #fff;
    }

    .table-info {
        padding: 1rem 1.5rem;
        background: #f8f8f8;
        border-bottom: 1px solid #e0e0e0;
        font-size: 0.9rem;
        font-weight: 600;
        color: #000;
    }

    .table-container {
        overflow-x: auto;
        max-height: 500px;
        overflow-y: auto;
    }

    .colors-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 0.9rem;
    }

    .colors-table thead {
        background: #000;
        color: #fff;
        position: sticky;
        top: 0;
        z-index: 10;
    }

    .colors-table thead th {
        padding: 1rem 0.75rem;
        text-align: left;
        font-weight: 600;
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border-right: 1px solid #333;
    }

    .colors-table thead th:last-child {
        border-right: none;
    }

    .colors-table tbody tr {
        border-bottom: 1px solid #e0e0e0;
        transition: background 0.2s ease;
    }

    .colors-table tbody tr:hover {
        background: #f8f8f8;
    }

    .colors-table tbody td {
        padding: 1rem 0.75rem;
        vertical-align: middle;
        color: #333;
    }

    .colors-table tbody td:first-child {
        font-weight: 600;
        color: #000;
        width: 80px;
    }

    .color-label-cell {
        font-weight: 600;
        color: #000;
        font-size: 1rem;
    }

    .color-hex-cell {
        font-family: monospace;
        font-weight: 600;
        color: #666;
    }

    .color-preview-cell {
        width: 100px;
    }

    .color-swatch {
        display: inline-block;
        width: 60px;
        height: 40px;
        border: 2px solid #000;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .action-buttons {
        display: flex;
        gap: 0.5rem;
    }

    .btn-edit,
    .btn-delete {
        padding: 0.45rem 1rem;
        font-size: 0.8rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s ease;
        border: none;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .btn-edit {
        background: #000;
        color: #fff;
    }

    .btn-edit:hover {
        background: #333;
    }

    .btn-delete {
        background: #fff;
        color: #000;
        border: 2px solid #000;
    }

    .btn-delete:hover {
        background: #000;
        color: #fff;
    }

    .empty-state {
        text-align: center;
        padding: 3rem 2rem;
        color: #999;
    }

    .empty-state i {
        font-size: 2.5rem;
        margin-bottom: 1rem;
        opacity: 0.5;
    }

    @media (max-width: 1024px) {
        .content-grid {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 768px) {
        .colors-container {
            padding: 1rem;
        }

        .filter-row {
            grid-template-columns: 1fr;
        }

        .form-actions {
            flex-direction: column;
        }

        .action-buttons {
            flex-direction: column;
        }

        .color-picker-wrapper {
            flex-direction: column;
            align-items: stretch;
        }
    }
</style>

<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title">
            <span class="page-title-icon bg-gradient-primary text-white me-2">
                <i class="mdi mdi-package-variant"></i>
            </span> Product
        </h3>
    </div>
    <div class="colors-container">
        <div class="colors-header">
            <h1>Color Management</h1>
        </div>

        <div class="content-grid">
            <!-- Add/Edit Form -->
            <div class="form-section">
                <h2 id="form-title">Add Color</h2>

                <?php if (isset($success_message)): ?>
                    <div class="alert alert-success">
                        <span class="mdi mdi-check-circle"></span> <?php echo $success_message; ?>
                    </div>
                <?php endif; ?>
                <?php if (isset($error_message)): ?>
                    <div class="alert alert-danger">
                        <span class="mdi mdi-alert-circle"></span> <?php echo $error_message; ?>
                    </div>
                <?php endif; ?>

                <form action="" method="POST" id="color-form">
                    <input type="hidden" name="edit_id" id="edit_id">

                    <div class="form-group">
                        <label for="colorinput">Color Label *</label>
                        <div class="input-group">
                            <input type="text" class="form-input" id="colorinput" name="color_label"
                                placeholder="e.g., Red, Blue, Navy..." required>
                            <button type="button" class="btn-reset-label" id="reset-label" title="Reset to custom name">
                                <span class="mdi mdi-pencil"></span>
                            </button>
                        </div>
                        <div class="form-hint">Type a custom name or pick a color below to auto-fill</div>
                    </div>

                    <div class="form-group">
                        <label for="colorpicker">Pick Color *</label>
                        <div class="color-picker-wrapper">
                            <input type="color" class="color-picker" id="colorpicker" name="color_hex" value="#000000" required>
                            <div class="color-preview" id="hex-preview">#000000</div>
                        </div>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn-submit" id="submit-btn">
                            <span class="mdi mdi-plus-circle"></span> Add Color
                        </button>
                        <button type="button" class="btn-cancel d-none" id="cancel-edit">
                            <span class="mdi mdi-close"></span> Cancel
                        </button>
                    </div>
                </form>
            </div>

            <!-- Color List -->
            <div class="list-section">
                <div class="list-header">
                    <h2>Color List</h2>
                </div>

                <!-- Search & Sort Filters -->
                <div class="search-filters">
                    <form method="GET" action="">
                        <div class="filter-row">
                            <div class="filter-group">
                                <label>Search Color</label>
                                <input type="text" name="search" class="filter-input"
                                    placeholder="Enter color name..."
                                    value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
                            </div>

                            <div class="filter-group">
                                <label>Sort Order</label>
                                <select name="sort_order" class="filter-select">
                                    <option value="ASC" <?php echo (isset($_GET['sort_order']) && $_GET['sort_order'] == 'ASC') ? 'selected' : ''; ?>>A-Z</option>
                                    <option value="DESC" <?php echo (isset($_GET['sort_order']) && $_GET['sort_order'] == 'DESC') ? 'selected' : ''; ?>>Z-A</option>
                                </select>
                            </div>

                            <div style="display: flex; gap: 0.5rem; align-items: end;">
                                <button type="submit" class="btn-search">
                                    <span class="mdi mdi-magnify"></span> Search
                                </button>
                                <a href="<?php echo basename($_SERVER['PHP_SELF']); ?>" class="btn-reset">
                                    <span class="mdi mdi-refresh"></span> Reset
                                </a>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="table-info">
                    <span class="mdi mdi-palette"></span>
                    Total Colors: <?php echo $result ? $result->num_rows : 0; ?>
                </div>

                <div class="table-container">
                    <table class="colors-table" id="colorsTable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Color Name</th>
                                <th>Hex Code</th>
                                <th>Preview</th>
                                <th style="width: 200px;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($result && $result->num_rows > 0):
                                $i = 1;
                                while ($row = $result->fetch_assoc()):
                            ?>
                                    <tr data-id="<?php echo $row['id']; ?>"
                                        data-label="<?php echo htmlspecialchars($row['color_label']); ?>"
                                        data-hex="<?php echo htmlspecialchars($row['color_hex']); ?>">
                                        <td><?php echo $i++; ?></td>
                                        <td class="color-label-cell"><?php echo htmlspecialchars($row['color_label']); ?></td>
                                        <td class="color-hex-cell"><?php echo htmlspecialchars($row['color_hex']); ?></td>
                                        <td class="color-preview-cell">
                                            <span class="color-swatch" style="background: <?php echo htmlspecialchars($row['color_hex']); ?>;"></span>
                                        </td>
                                        <td>
                                            <div class="action-buttons">
                                                <button class="btn-edit edit-btn">
                                                    <span class="mdi mdi-pencil"></span> Edit
                                                </button>
                                                <button class="btn-delete delete-btn">
                                                    <span class="mdi mdi-delete"></span> Delete
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                <?php
                                endwhile;
                            else:
                                ?>
                                <tr>
                                    <td colspan="5" class="empty-state">
                                        <i class="mdi mdi-palette-outline"></i>
                                        <p>No colors found</p>
                                    </td>
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
    // Color picker updates hex preview and label
    document.getElementById('colorpicker').addEventListener('input', function() {
        const hexValue = this.value;
        document.getElementById('hex-preview').textContent = hexValue;
        document.getElementById('colorinput').value = hexValue;
    });

    // Reset label to custom name
    document.getElementById('reset-label').addEventListener('click', function() {
        document.getElementById('colorinput').value = '';
        document.getElementById('colorinput').focus();
    });

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
            document.getElementById('hex-preview').textContent = hex || "#000000";
            document.getElementById('form-title').innerText = "Edit Color";
            document.getElementById('submit-btn').innerHTML = '<span class="mdi mdi-check"></span> Update Color';
            document.getElementById('cancel-edit').classList.remove('d-none');

            // Scroll to form
            document.querySelector('.form-section').scrollIntoView({
                behavior: 'smooth'
            });
        });
    });

    // Cancel edit
    document.getElementById('cancel-edit').addEventListener('click', function() {
        document.getElementById('edit_id').value = '';
        document.getElementById('colorinput').value = '';
        document.getElementById('colorpicker').value = "#000000";
        document.getElementById('hex-preview').textContent = "#000000";
        document.getElementById('form-title').innerText = "Add Color";
        document.getElementById('submit-btn').innerHTML = '<span class="mdi mdi-plus-circle"></span> Add Color';
        this.classList.add('d-none');
    });

    // Delete color
    document.querySelectorAll('.delete-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const row = this.closest('tr');
            const id = row.getAttribute('data-id');

            Swal.fire({
                title: 'Delete Color?',
                text: "This action cannot be undone",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#000',
                cancelButtonColor: '#999',
                confirmButtonText: 'Yes, Delete',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch("delete-color-label.php", {
                            method: "POST",
                            headers: {
                                "Content-Type": "application/x-www-form-urlencoded"
                            },
                            body: "delete_id=" + id
                        })
                        .then(res => res.json())
                        .then(data => {
                            if (data.status === "success") {
                                Swal.fire("Deleted!", data.message, "success");
                                row.remove();

                                // Update count
                                const totalCount = document.querySelector('.table-info');
                                const currentCount = parseInt(totalCount.textContent.match(/\d+/)[0]);
                                totalCount.innerHTML = `<span class="mdi mdi-palette"></span> Total Colors: ${currentCount - 1}`;
                            } else {
                                Swal.fire("Error!", data.message, "error");
                            }
                        })
                        .catch(() => Swal.fire("Error!", "Something went wrong.", "error"));
                }
            });
        });
    });
</script>

<?php require 'footer.php'; ?>