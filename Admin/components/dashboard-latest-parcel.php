<?php
if ($_SESSION['role'] == 'Admin' || (isset($access['courier']) && $access['courier'] == 1)) {
?>

  <div class="col-lg-4 mt-4 mt-md-0">
    <!-- Latest parcel Card -->
    <div class="card p-3">
      <div class="card-body">
        <h1 class="chart-title mb-1">Latest Parcel</h1>
        <p>
          List of latest parcels
        </p><br>
        <div class="table-responsive">
          <table class="table table-bordered">
            <tr>
              <th>Invoice No</th>
              <th>Status</th>
            </tr>
            <tbody>
              <?php
              // Fetch data from parcel_info table
              $sql = "SELECT parcel_info.* 
                                      FROM parcel_info
                                      JOIN order_info ON parcel_info.invoice_no = order_info.invoice_no
                                      WHERE order_info.order_status != 'Pending' 
                                        AND order_info.order_visibility = 'Show'
                                      GROUP BY order_info.invoice_no
                                      ORDER BY parcel_info.parcel_id DESC 
                                      LIMIT 10
                                      ";

              $result = $conn->query($sql);

              if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {

                  $status = track_parcel($row['tracking_code']);


                  echo "
                                      <tr>
                                        <td>{$row['invoice_no']}</td>
                                        <td class='text-primary'>{$status}</td>
                                      </tr>";
                }
              }
              ?>
            </tbody>
          </table>
        </div>

      </div>
      <a href="courier.php" class="p-3">
        <button class="btn btn-dark">See All Parcel</button>
      </a>
    </div>
  </div>

<?php
}
?>