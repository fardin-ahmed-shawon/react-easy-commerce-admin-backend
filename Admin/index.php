<?php
$current_page = basename($_SERVER['PHP_SELF']); // Get the current page name
$page_title = 'Dashboard'; // Set the page title
?>
<?php require 'header.php'; ?>

<style>
  /* Modern Table Styles */
  .modern-table-container {
    background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
    border-radius: 24px;
    padding: 30px;
    box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
    overflow: hidden;
    transition: all 0.3s ease;
  }

  .modern-table-container:hover {
    box-shadow: 0 20px 45px rgba(0, 0, 0, 0.15);
    transform: translateY(-3px);
  }

  .table-header {
    margin-bottom: 25px;
    padding-bottom: 20px;
    border-bottom: 2px solid #e2e8f0;
  }

  .table-header h1 {
    font-size: 28px;
    font-weight: 800;
    background: linear-gradient(135deg, #1e293b 0%, #475569 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    margin-bottom: 8px;
  }

  .table-header p {
    color: #64748b;
    font-size: 15px;
    margin: 0;
  }

  .modern-table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
  }

  .modern-table thead th {
    background: linear-gradient(135deg, #3b82f6 0%, #8b5cf6 100%);
    color: #fff;
    padding: 16px;
    font-weight: 700;
    font-size: 13px;
    text-transform: uppercase;
    letter-spacing: 0.8px;
    border: none;
    white-space: nowrap;
  }

  .modern-table thead th:first-child {
    border-radius: 12px 0 0 0;
  }

  .modern-table thead th:last-child {
    border-radius: 0 12px 0 0;
  }

  .modern-table tbody tr {
    transition: all 0.3s ease;
    background: #fff;
  }

  .modern-table tbody tr:hover {
    background: linear-gradient(90deg, #f8fafc 0%, #f1f5f9 100%);
    transform: scale(1.01);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
  }

  .modern-table tbody td {
    padding: 16px;
    border-bottom: 1px solid #e2e8f0;
    color: #334155;
    font-size: 14px;
    font-weight: 500;
  }

  .modern-table tbody tr:last-child td {
    border-bottom: none;
  }

  .action-btn {
    padding: 10px 20px;
    border: none;
    border-radius: 10px;
    font-size: 13px;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.3s ease;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
  }

  .action-btn:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
  }

  .btn-accept {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    color: #fff;
  }

  .btn-decline {
    background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
    color: #fff;
  }

  .view-all-btn {
    width: 100%;
    padding: 16px;
    border: none;
    border-radius: 12px;
    background: linear-gradient(135deg, #1e293b 0%, #334155 100%);
    color: #fff;
    font-size: 15px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 1px;
    cursor: pointer;
    transition: all 0.3s ease;
    margin-top: 20px;
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
  }

  .view-all-btn:hover {
    transform: translateY(-3px);
    box-shadow: 0 12px 30px rgba(0, 0, 0, 0.25);
  }

  /* Status Badge */
  .status-badge {
    padding: 6px 14px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    display: inline-block;
  }

  .status-primary {
    background: linear-gradient(135deg, #3b82f6, #2563eb);
    color: #fff;
    box-shadow: 0 4px 10px rgba(59, 130, 246, 0.3);
  }

  /* Responsive */
  @media (max-width: 1199px) {
    .stats-value {
      font-size: 28px;
    }

    .stats-icon {
      width: 50px;
      height: 50px;
    }

    .stats-icon i {
      font-size: 24px;
    }
  }

  @media (max-width: 767px) {
    .stats-card {
      padding: 20px;
    }

    .stats-value {
      font-size: 24px;
    }

    .stats-icon {
      width: 46px;
      height: 46px;
      top: 16px;
      right: 16px;
    }

    .stats-icon i {
      font-size: 20px;
    }

    .chart-card,
    .modern-table-container {
      padding: 20px;
    }

    .time-filter {
      flex-wrap: wrap;
    }

    .chart-title {
      font-size: 18px;
    }

    .modern-table {
      font-size: 12px;
    }

    .modern-table thead th,
    .modern-table tbody td {
      padding: 12px 8px;
    }
  }

  /* Chart Canvas Wrapper */
  .chart-canvas-wrapper {
    position: relative;
    /* height: 350px; */
    z-index: 1;
  }

  /* Badge variants */
  .badge-warning {
    background: linear-gradient(135deg, #fef3c7, #fde68a);
    color: #92400e;
  }

  .badge-info {
    background: linear-gradient(135deg, #dbeafe, #bfdbfe);
    color: #1e40af;
  }

  .badge-success {
    background: linear-gradient(135deg, #d1fae5, #a7f3d0);
    color: #065f46;
  }

  .badge-purple {
    background: linear-gradient(135deg, #e9d5ff, #d8b4fe);
    color: #6b21a8;
  }

  .badge-dark {
    background: linear-gradient(135deg, #e2e8f0, #cbd5e1);
    color: #334155;
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
      </span> Dashboard
    </h3>
  </div>

  <!-- Dashboard Stats -->
  <?php include 'components/dashboard-stats.php' ?>
  <!-- End -->


  <!-- Dashboard Charts -->
  <?php include 'components/dashboard-charts.php' ?>
  <!-- End -->


  <!-- Latest Pending Orders & Latest Parcel Area -->
  <div class="row">
    <?php include 'components/dashboard-pending-order.php' ?>
    <?php include 'components/dashboard-latest-parcel.php' ?>
  </div>
  <!-- End -->

</div>
<!--------------------------->
<!-- END MAIN AREA -->
<!--------------------------->

<?php require 'footer.php'; ?>