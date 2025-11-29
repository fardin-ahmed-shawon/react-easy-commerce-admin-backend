<?php
$current_page = basename($_SERVER['PHP_SELF']);
$page_title = 'Sizes';
?>
<?php require 'header.php'; ?>

<?php
// ADD OR UPDATE SIZE
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $size_label = trim($_POST['size_label']);
    $edit_id = isset($_POST['edit_id']) ? intval($_POST['edit_id']) : 0;

    if (empty($size_label)) {
        $error_message = "Size label is required.";
    } else {
        if ($edit_id > 0) {
            // Update existing size
            $sql = "UPDATE size_labels SET size_label=? WHERE id=?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("si", $size_label, $edit_id);
            if ($stmt->execute()) {
                $success_message = "Size updated successfully!";
            } else {
                $error_message = "Error: " . $stmt->error;
            }
            $stmt->close();
        } else {
            // Insert new size
            $sql = "INSERT INTO size_labels (size_label) VALUES (?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $size_label);
            if ($stmt->execute()) {
                $success_message = "Size added successfully!";
            } else {
                $error_message = "Error: " . $stmt->error;
            }
            $stmt->close();
        }
    }
}

// DELETE SIZE
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_id'])) {
    $delete_id = intval($_POST['delete_id']);
    $sql = "DELETE FROM size_labels WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $delete_id);
    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Size deleted successfully!']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to delete size.']);
    }
    $stmt->close();
    exit;
}

// Fetch sizes with search and sort
$whereClause = "1=1";
$orderBy = "id DESC";

if (isset($_GET['search']) && !empty($_GET['search'])) {
    $searchQuery = $conn->real_escape_string($_GET['search']);
    $whereClause .= " AND size_label LIKE '%$searchQuery%'";
}

if (isset($_GET['sort_order']) && !empty($_GET['sort_order'])) {
    $sortOrder = $_GET['sort_order'];
    $orderBy = "size_label $sortOrder";
}

$result = $conn->query("SELECT * FROM size_labels WHERE $whereClause ORDER BY $orderBy");
?>

<style>
    .sizes-container {
        max-width: 100%;
        margin: 0 auto;
        padding: 2rem;
        background: #ffffff;
    }

    .sizes-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
        padding-bottom: 1rem;
        border-bottom: 2px solid #000;
    }

    .sizes-header h1 {
        font-size: 1.75rem;
        font-weight: 600;
        color: #000;
        margin: 0;
        letter-spacing: -0.5px;
    }

    .btn-export {
        padding: 0.65rem 1.5rem;
        background: #000;
        color: #fff;
        border: none;
        font-size: 0.9rem;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-export:hover {
        background: #333;
        color: #fff;
        transform: translateY(-1px);
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

    .sizes-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 0.9rem;
    }

    .sizes-table thead {
        background: #000;
        color: #fff;
        position: sticky;
        top: 0;
        z-index: 10;
    }

    .sizes-table thead th {
        padding: 1rem 0.75rem;
        text-align: left;
        font-weight: 600;
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border-right: 1px solid #333;
    }

    .sizes-table thead th:last-child {
        border-right: none;
    }

    .sizes-table tbody tr {
        border-bottom: 1px solid #e0e0e0;
        transition: background 0.2s ease;
    }

    .sizes-table tbody tr:hover {
        background: #f8f8f8;
    }

    .sizes-table tbody td {
        padding: 1rem 0.75rem;
        vertical-align: middle;
        color: #333;
    }

    .sizes-table tbody td:first-child {
        font-weight: 600;
        color: #000;
        width: 80px;
    }

    .size-label-cell {
        font-weight: 600;
        color: #000;
        font-size: 1rem;
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
        .sizes-container {
            padding: 1rem;
        }

        .sizes-header {
            flex-direction: column;
            gap: 1rem;
            align-items: flex-start;
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
    <div class="sizes-container">
        <div class="sizes-header">
            <h1>Size Management</h1>
        </div>

        <div class="content-grid">
            <!-- Add/Edit Form -->
            <div class="form-section">
                <h2 id="form-title">Add Size</h2>

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

                <form action="" method="POST" id="size-form">
                    <input type="hidden" name="edit_id" id="edit_id">

                    <div class="form-group">
                        <label for="sizeinput">Size Label *</label>
                        <input type="text" class="form-input" id="sizeinput" name="size_label"
                            placeholder="e.g., S, M, L, XL, 32, 34..." required>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn-submit" id="submit-btn">
                            <span class="mdi mdi-plus-circle"></span> Add Size
                        </button>
                        <button type="button" class="btn-cancel d-none" id="cancel-edit">
                            <span class="mdi mdi-close"></span> Cancel
                        </button>
                    </div>
                </form>
            </div>

            <!-- Size List -->
            <div class="list-section">
                <div class="list-header">
                    <h2>Size List</h2>
                </div>

                <!-- Search & Sort Filters -->
                <div class="search-filters">
                    <form method="GET" action="">
                        <div class="filter-row">
                            <div class="filter-group">
                                <label>Search Size</label>
                                <input type="text" name="search" class="filter-input"
                                    placeholder="Enter size label..."
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
                    <span class="mdi mdi-tag-multiple"></span>
                    Total Sizes: <?php echo $result ? $result->num_rows : 0; ?>
                </div>

                <div class="table-container">
                    <table class="sizes-table" id="sizesTable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Size Label</th>
                                <th style="width: 200px;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($result && $result->num_rows > 0):
                                $i = 1;
                                while ($row = $result->fetch_assoc()):
                            ?>
                                    <tr data-id="<?php echo $row['id']; ?>" data-label="<?php echo htmlspecialchars($row['size_label']); ?>">
                                        <td><?php echo $i++; ?></td>
                                        <td class="size-label-cell"><?php echo htmlspecialchars($row['size_label']); ?></td>
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
                                    <td colspan="3" class="empty-state">
                                        <i class="mdi mdi-tag-off"></i>
                                        <p>No sizes found</p>
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
    // Edit size
    document.querySelectorAll('.edit-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const row = this.closest('tr');
            const id = row.getAttribute('data-id');
            const label = row.getAttribute('data-label');

            document.getElementById('edit_id').value = id;
            document.getElementById('sizeinput').value = label;
            document.getElementById('form-title').innerText = "Edit Size";
            document.getElementById('submit-btn').innerHTML = '<span class="mdi mdi-check"></span> Update Size';
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
        document.getElementById('sizeinput').value = '';
        document.getElementById('form-title').innerText = "Add Size";
        document.getElementById('submit-btn').innerHTML = '<span class="mdi mdi-plus-circle"></span> Add Size';
        this.classList.add('d-none');
    });

    // Delete size
    document.querySelectorAll('.delete-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const row = this.closest('tr');
            const id = row.getAttribute('data-id');

            Swal.fire({
                title: 'Delete Size?',
                text: "This action cannot be undone",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#000',
                cancelButtonColor: '#999',
                confirmButtonText: 'Yes, Delete',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch("delete-size-label.php", {
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
                                totalCount.innerHTML = `<span class="mdi mdi-tag-multiple"></span> Total Sizes: ${currentCount - 1}`;
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