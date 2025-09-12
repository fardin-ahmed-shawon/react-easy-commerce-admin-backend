<?php
$current_page = basename($_SERVER['PHP_SELF']);
$page_title = 'View Products';
?>
<?php require 'header.php'; ?>

<style>
  /* Modal Overlay */
  .custom-modal {
    display: none;
    position: fixed;
    z-index: 99999;
    left: 0; top: 0;
    width: 100%; height: 100%;
    background: rgba(0,0,0,0.6);
    align-items: center;
    justify-content: center;
  }

  .custom-modal.open { display: flex; }

  .custom-modal-content {
    background: #fff;
    padding: 18px;
    border-radius: 10px;
    width: 340px;
    max-width: calc(100% - 32px);
    box-shadow: 0 8px 30px rgba(0,0,0,0.3);
    animation: fadeIn .18s ease;
    text-align: center;
    position: relative;
  }

  .custom-modal-close {
    position: absolute;
    right: 10px;
    top: 8px;
    font-size: 20px;
    cursor: pointer;
    color: #444;
  }
  .custom-modal-close:hover { color: #d33; }

  /* Label box */
  #labelArea {
    width: 144px; 
    height: 96px; /* 1.5" x 1" @96dpi */
    border: 1px solid #111;
    display:flex; flex-direction:column;
    justify-content:center; align-items:center;
    margin: 8px auto;
    font-size:10px;
    background: #fff;
  }
  /* Label box */
#labelArea {
  width: min(90vw, 320px);   /* responsive: max 320px, 90% of screen */
  aspect-ratio: 1.5 / 1;     /* maintain proportion (1.5:1) */
  border: 1px solid #111;
  display:flex;
  flex-direction:column;
  justify-content:center;
  align-items:center;
  margin: 8px auto;
  font-size: clamp(8px, 2vw, 12px); /* scale text */
  background: #fff;
  box-sizing: border-box;
}


  /* Download Button */
  .btn-download {
    background: #28a745;
    color: #fff;
    border: none;
    padding: 8px 14px;
    border-radius: 6px;
    cursor: pointer;
  }
  .btn-download:hover { filter: brightness(.95); }

  @keyframes fadeIn {
    from { opacity: 0; transform: translateY(-8px); } 
    to { opacity: 1; transform: translateY(0); }
  }
</style>

<!--------------------------->
<!-- START MAIN AREA -->
<!--------------------------->
<div class="content-wrapper">
  <div class="page-header">
    <h3 class="page-title">
      <span class="page-title-icon bg-gradient-primary text-white me-2">
        <i class="mdi mdi-home"></i>
      </span>
      Product
    </h3>
  </div>

  <div class="row">
    <h1>Product List</h1>
    <div class="container">
      <!-- Search Form -->
      <form method="GET" class="mb-4">
        <div class="row">
          <div class="col-md-6">
            <label for="search"><b>Search Your Product:</b></label>
            <div class="d-flex">
              <input type="text" name="search" id="search" class="form-control me-2"
                placeholder="Enter product title or code"
                value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
              <button type="submit" class="btn btn-primary me-2">Search</button>
              <?php if (isset($_GET['search']) && $_GET['search'] !== ''): ?>
                <a href="<?php echo strtok($_SERVER["REQUEST_URI"], '?'); ?>" class="btn btn-dark d-flex align-items-center" title="Reset Search">Reset</a>
              <?php endif; ?>
            </div>
          </div>
        </div>
      </form>

      <!-- Table -->
      <div class="table-responsive">
        <table class="table table-bordered table-hover">
          <thead class="thead-dark">
            <tr>
              <td>ID</td>
              <td>Image</td>
              <td>Title</td>
              <td>Code</td>
              <td>Main Category</td>
              <td>Sub Category</td>
              <td>Available Quantity</td>
              <td>Regular Price</td>
              <td>Selling Price</td>
              <td>Actions</td>
            </tr>
          </thead>
          <tbody>
            <?php
            $search = isset($_GET['search']) ? trim($_GET['search']) : '';

            $sql = "SELECT p.*, mc.main_ctg_name, sc.sub_ctg_name 
                    FROM product_info p
                    LEFT JOIN main_category mc ON p.main_ctg_id = mc.main_ctg_id
                    LEFT JOIN sub_category sc ON p.sub_ctg_id = sc.sub_ctg_id";

            if (!empty($search)) {
                $search_safe = mysqli_real_escape_string($conn, $search);
                $sql .= " WHERE p.product_title LIKE '%$search_safe%' OR p.product_code LIKE '%$search_safe%'";
            }

            $sql .= " ORDER BY p.product_id DESC";
            $result = mysqli_query($conn, $sql);

            if ($result && mysqli_num_rows($result) > 0) {
              while ($item = mysqli_fetch_assoc($result)) {
                $title = htmlspecialchars($item['product_title'], ENT_QUOTES);
                $code  = htmlspecialchars($item['product_code'], ENT_QUOTES);
                $price = htmlspecialchars($item['product_price'], ENT_QUOTES);
                $id    = (int)$item['product_id'];

                echo '<tr>';
                echo '<td>'. $id .'</td>';
                echo '<td><img src="../img/'. htmlspecialchars($item['product_img1']) .'" alt="img" style="width:50px;height:50px;"></td>';
                echo '<td>'. $title .'</td>';
                echo '<td>'. $code .'</td>';
                echo '<td>'. htmlspecialchars($item['main_ctg_name']) .'</td>';
                echo '<td>'. htmlspecialchars($item['sub_ctg_name']) .'</td>';
                echo '<td>'. htmlspecialchars($item['available_stock']) .'</td>';
                echo '<td>৳ '. htmlspecialchars($item['product_regular_price']) .'</td>';
                echo '<td>৳ '. $price .'</td>';
                echo '<td>';
                echo '<button class="btn btn-dark btn-sm" onclick="confirmEdit('. $id .')">Edit <span class="mdi mdi-square-edit-outline"></span></button> ';
                echo '<button class="btn btn-dark btn-sm" onclick="confirmDelete('. $id .')">Delete <span class="mdi mdi-trash-can-outline"></span></button> ';
                echo '<button class="btn btn-primary btn-sm btn-print-label"'
                    .' data-id="'. $id .'"'
                    .' data-title="'. $title .'"'
                    .' data-price="'. $price .'">'
                    .'Print Label <span class="mdi mdi-qrcode"></span></button>';
                echo '</td>';
                echo '</tr>';
              }
            } else {
              echo "<tr><td colspan='10' class='text-center text-danger'>No matching products found.</td></tr>";
            }
            ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<!-- Custom Modal -->
<div id="labelModal" class="custom-modal" aria-hidden="true">
  <div class="custom-modal-content" role="dialog" aria-modal="true" aria-labelledby="labelTitleHeader">
    <span class="custom-modal-close" data-close>&times;</span>
    <h5 id="labelTitleHeader" class="mb-1">Product Label</h5>

    <div id="labelArea">
      <div id="labelTitle" style="font-weight:bold; font-size:10px; text-align:center;"></div>
      <div id="labelQRCode" style="margin:4px auto;"></div>
      <div id="labelPrice" style="font-size:10px; text-align:center;"></div>
    </div>

    <div style="margin-top:8px;">
      <button class="btn-download" id="downloadLabel">Download PDF</button>
    </div>
  </div>
</div>

<!--------------------------->
<!-- END MAIN AREA -->
<!--------------------------->

<script>
  function confirmEdit(productId) {
    window.location.href = `editProduct.php?id=${productId}`;
  }

  function confirmDelete(productId) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = `deleteProduct.php?id=${productId}`;
        }
    });
  }
</script>

<!-- QRCode.js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
<!-- html2canvas + jsPDF -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

<script>
(function(){
  document.addEventListener('DOMContentLoaded', function(){
    const modal = document.getElementById('labelModal');
    if (modal && modal.parentNode !== document.body) {
      document.body.appendChild(modal);
    }
  });

  const modalEl = document.getElementById('labelModal');
  const labelTitleEl = document.getElementById('labelTitle');
  const labelPriceEl = document.getElementById('labelPrice');
  const qrContainer = document.getElementById('labelQRCode');

  function openLabelModal(id, title, price) {
    labelTitleEl.textContent = title || '';
    labelPriceEl.textContent = price ? ('৳ ' + price) : '';

    // Clear previous QR
    qrContainer.innerHTML = "";

    // Product link (adjust to your real link)
    const productUrl = `https://yourdomain.com/product.php?id=${encodeURIComponent(id)}`;

    // Generate QR code
    new QRCode(qrContainer, {
      text: productUrl,
      width: 60,
      height: 60,
      colorDark : "#000000",
      colorLight : "#ffffff",
      correctLevel : QRCode.CorrectLevel.H
    });

    modalEl.classList.add('open');
    modalEl.setAttribute('aria-hidden', 'false');
  }

  function closeLabelModal() {
    modalEl.classList.remove('open');
    modalEl.setAttribute('aria-hidden', 'true');
  }

  document.addEventListener('click', function(e){
    const btn = e.target.closest('.btn-print-label');
    if (!btn) return;
    const id    = btn.getAttribute('data-id');
    const title = btn.getAttribute('data-title');
    const price = btn.getAttribute('data-price');
    openLabelModal(id, title, price);
  });

  document.addEventListener('click', function(e){
    if (e.target.matches('[data-close]') || e.target.closest('[data-close]')) {
      closeLabelModal();
    }
  });

  document.addEventListener('click', function(e){
    if (e.target === modalEl) closeLabelModal();
  });

  document.addEventListener('keydown', function(e){
    if (e.key === 'Escape' && modalEl.classList.contains('open')) closeLabelModal();
  });

  document.getElementById('downloadLabel').addEventListener('click', function(){
    const area = document.getElementById('labelArea');
    html2canvas(area, {scale: 2}).then(canvas => {
      const { jsPDF } = window.jspdf;
      const pdf = new jsPDF({orientation:'portrait', unit:'px', format:[144,96]});
      pdf.addImage(canvas.toDataURL('image/png'), 'PNG', 0, 0, 144, 96);
      pdf.save('label.pdf');
    }).catch(err => {
      console.error('html2canvas error', err);
      alert('Failed to create PDF. See console for details.');
    });
  });

})();
</script>

<?php require 'footer.php'; ?>