<!-- Fraud Checker Modal -->
<div class="modal fade" id="fraudModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" style="max-width: 500px;">
    <div class="modal-content shadow-lg border-0 rounded-3">
      
      <!-- Header -->
      <div class="modal-header bg-dark text-white ">
        <h5 class="modal-title fw-bold">🔊 Fraud Checker</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>

      <!-- Body -->
      <div class="modal-body bg-light">

        <!-- Phone Info -->
        <div class="alert alert-secondary py-2 mb-4">
          <strong>Phone:</strong> <span id="fraudPhone" class="fw-bold text-dark"></span>
        </div>

        <!-- Table -->
        <div class="table-responsive mb-4">
          <table class="table table-bordered align-middle text-center mb-0">
            <thead class="table-dark">
              <tr>
                <th>Courier</th>
                <th>Total</th>
                <th class="text-success">Success</th>
                <th class="text-danger">Cancel</th>
              </tr>
            </thead>
            <tbody id="fraudTableBody">
              <!-- Data injected here -->
            </tbody>
          </table>
        </div>

        <!-- Summary Cards -->
        <div class="row g-3">
          <div class="col-12 col-sm-4">
            <div class="card text-center bg-info text-white rounded-3 shadow-sm">
              <div class="card-body p-3">
                <h6 class="mb-1 fw-bold">Total</h6>
                <span class="h5 mb-0" id="fraudTotal">0</span>
              </div>
            </div>
          </div>
          <div class="col-12 col-sm-4">
            <div class="card text-center bg-success text-white rounded-3 shadow-sm">
              <div class="card-body p-3">
                <h6 class="mb-1 fw-bold">Success</h6>
                <span class="h5 mb-0" id="fraudSuccess">0</span>
              </div>
            </div>
          </div>
          <div class="col-12 col-sm-4">
            <div class="card text-center bg-danger text-white rounded-3 shadow-sm">
              <div class="card-body p-3">
                <h6 class="mb-1 fw-bold">Cancel</h6>
                <span class="h5 mb-0" id="fraudCancel">0</span>
              </div>
            </div>
          </div>
        </div>

      </div> <!-- end modal-body -->

    </div>
  </div>
</div>

<script>
  function checkFraud(phone) {
      // Reset modal
      document.getElementById("fraudPhone").textContent = phone;
      document.getElementById("fraudTableBody").innerHTML = "<tr><td colspan='4' class='text-center'>Loading...</td></tr>";
      document.getElementById("fraudTotal").textContent = "Loading...";
      document.getElementById("fraudSuccess").textContent = "Loading...";
      document.getElementById("fraudCancel").textContent = "Loading...";

      // Show modal
      var fraudModal = new bootstrap.Modal(document.getElementById('fraudModal'));
      fraudModal.show();

      // Prepare form data
      const formData = new FormData();
      formData.append('phone', phone);

      fetch('fraud_api.php', {
          method: 'POST',
          body: formData
      })
      .then(res => res.json())
      .then(data => {
          // Handle API errors
          if (data.error) {
              document.getElementById("fraudTableBody").innerHTML = `<tr><td colspan='4' class='text-danger'>${data.error}</td></tr>`;
              document.getElementById("fraudTotal").textContent = "0";
              document.getElementById("fraudSuccess").textContent = "0";
              document.getElementById("fraudCancel").textContent = "0";
              return;
          }

          // Update summary cards
          document.getElementById("fraudTotal").textContent = data.total_parcels ?? 0;
          document.getElementById("fraudSuccess").textContent = data.total_delivered ?? 0;
          document.getElementById("fraudCancel").textContent = data.total_cancel ?? 0;

          // Define fixed courier list
          const couriers = ["Pathao", "Steadfast", "Redx", "PaperFly"];
          let tbody = '';

          // Update table
          document.getElementById("fraudTableBody").innerHTML = tbody;
      })
      .catch(err => {
          document.getElementById("fraudTableBody").innerHTML = `<tr><td colspan='4' class='text-danger'>Error: ${err}</td></tr>`;
          document.getElementById("fraudTotal").textContent = "0";
          document.getElementById("fraudSuccess").textContent = "0";
          document.getElementById("fraudCancel").textContent = "0";
      });
  }
</script>