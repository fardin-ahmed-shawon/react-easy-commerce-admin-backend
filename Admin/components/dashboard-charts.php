<style>
  /* Enhanced Chart Card Styles */
  .chart-card {
    background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
    border-radius: 24px;
    padding: 30px;
    box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
    margin-bottom: 24px;
    border: 1px solid rgba(255, 255, 255, 0.5);
    position: relative;
    overflow: hidden;
    transition: all 0.3s ease;
  }

  .chart-card::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -50%;
    width: 200%;
    height: 200%;
    background: radial-gradient(circle, rgba(59, 130, 246, 0.05) 0%, transparent 70%);
    pointer-events: none;
  }

  .chart-card:hover {
    box-shadow: 0 20px 45px rgba(0, 0, 0, 0.15);
    transform: translateY(-5px);
  }

  .chart-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 25px;
    position: relative;
    z-index: 1;
  }

  .chart-title {
    font-size: 22px;
    font-weight: 900;
    background: linear-gradient(135deg, #1e293b 0%, #475569 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 10px;
  }

  .chart-title::before {
    content: '';
    width: 4px;
    height: 24px;
    background: linear-gradient(180deg, #3b82f6, #8b5cf6);
    border-radius: 2px;
  }

  .time-filter {
    display: flex;
    gap: 8px;
    background: #fff;
    padding: 6px;
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
  }

  .time-btn {
    padding: 10px 20px;
    border: none;
    background: transparent;
    border-radius: 8px;
    font-size: 14px;
    font-weight: 600;
    color: #64748b;
    cursor: pointer;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    text-decoration: none;
  }

  .time-btn:hover {
    background: #f1f5f9;
    color: #3b82f6;
    transform: translateY(-2px);
  }

  .time-btn.active {
    background: linear-gradient(135deg, #3b82f6, #8b5cf6);
    color: #fff;
    box-shadow: 0 8px 16px rgba(59, 130, 246, 0.3);
  }
</style>

<?php
// Fetch sales data for charts
$timeRange = isset($_GET['range']) ? $_GET['range'] : '30';

// Daily Sales Trend
$dailySalesQuery = "SELECT 
        DATE(order_date) as date,
        SUM(total_price) as revenue,
        COUNT(DISTINCT invoice_no) as orders
    FROM order_info
    WHERE order_date >= DATE_SUB(CURDATE(), INTERVAL $timeRange DAY)
        AND order_status != 'Canceled'
    GROUP BY DATE(order_date)
    ORDER BY date";
$dailySalesResult = $conn->query($dailySalesQuery);
$dailySalesData = [];
while ($row = $dailySalesResult->fetch_assoc()) {
  $dailySalesData[] = $row;
}

// Top Selling Products
$topProductsQuery = "SELECT 
        p.product_title as name,
        SUM(o.total_price) as sales,
        SUM(o.product_quantity) as quantity
    FROM order_info o
    JOIN product_info p ON o.product_id = p.product_id
    WHERE o.order_status != 'Canceled'
    GROUP BY p.product_id, p.product_title
    ORDER BY sales DESC
    LIMIT 5";
$topProductsResult = $conn->query($topProductsQuery);
$topProductsData = [];
while ($row = $topProductsResult->fetch_assoc()) {
  $topProductsData[] = $row;
}

// Payment Methods Distribution
$paymentMethodsQuery = "SELECT 
        payment_method as name,
        COUNT(*) as value,
        SUM(total_price) as amount
    FROM order_info
    WHERE order_status != 'Canceled'
    GROUP BY payment_method
    ORDER BY amount DESC";
$paymentMethodsResult = $conn->query($paymentMethodsQuery);
$paymentMethodsData = [];
while ($row = $paymentMethodsResult->fetch_assoc()) {
  $paymentMethodsData[] = $row;
}

// City-wise Sales
$cityWiseQuery = "SELECT 
        city_address as city,
        COUNT(DISTINCT invoice_no) as orders,
        SUM(total_price) as revenue
    FROM order_info
    WHERE order_status != 'Canceled'
    GROUP BY city_address
    ORDER BY revenue DESC
    LIMIT 5";
$cityWiseResult = $conn->query($cityWiseQuery);
$cityWiseData = [];
while ($row = $cityWiseResult->fetch_assoc()) {
  $cityWiseData[] = $row;
}
?>


<!-- Sales Charts Area -->
<?php if (isset($access['accounts']) && $access['accounts'] == 1) { ?>
  <div class="row">
    <!-- Sales Trend Chart -->
    <div class="col-lg-12">
      <div class="chart-card">
        <div class="chart-header">
          <h3 class="chart-title">Sales Trend</h3>
          <div class="time-filter">
            <a href="?range=7" class="time-btn <?php echo $timeRange == 7 ? 'active' : ''; ?>">7 Days</a>
            <a href="?range=30" class="time-btn <?php echo $timeRange == 30 ? 'active' : ''; ?>">30 Days</a>
            <a href="?range=90" class="time-btn <?php echo $timeRange == 90 ? 'active' : ''; ?>">90 Days</a>
          </div>
        </div>
        <canvas id="salesTrendChart" height="100"></canvas>
      </div>
    </div>

    <!-- Payment Methods Chart -->
    <!-- <div class="col-lg-4">
                <div class="chart-card">
                  <div class="chart-header">
                    <h3 class="chart-title">Payment Methods</h3>
                  </div>
                  <div class="chart-canvas-wrapper">
                    <canvas id="paymentMethodChart" height="100"></canvas>
                  </div>
                </div>
              </div> -->

    <!-- Top Products Chart -->
    <div class="col-lg-6">
      <div class="chart-card">
        <div class="chart-header">
          <h3 class="chart-title">Top Selling Products</h3>
        </div>
        <canvas id="topProductsChart" height="150"></canvas>
      </div>
    </div>

    <!-- City-wise Sales Chart -->
    <div class="col-lg-6">
      <div class="chart-card">
        <div class="chart-header">
          <h3 class="chart-title">Sales by City</h3>
        </div>
        <canvas id="cityWiseChart" height="150"></canvas>
      </div>
    </div>
  </div>
  <br>
<?php } ?>


<!-- Chart.js Script -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
  // Sales Trend Chart
  const salesTrendCtx = document.getElementById('salesTrendChart');
  if (salesTrendCtx) {
    const salesTrendData = <?php echo json_encode($dailySalesData); ?>;

    new Chart(salesTrendCtx, {
      type: 'line',
      data: {
        labels: salesTrendData.map(item => item.date),
        datasets: [{
            label: 'Revenue (৳)',
            data: salesTrendData.map(item => item.revenue),
            borderColor: '#3b82f6',
            backgroundColor: 'rgba(59, 130, 246, 0.1)',
            borderWidth: 3,
            fill: true,
            tension: 0.4,
            yAxisID: 'y'
          },
          {
            label: 'Orders',
            data: salesTrendData.map(item => item.orders),
            borderColor: '#10b981',
            backgroundColor: 'rgba(16, 185, 129, 0.1)',
            borderWidth: 3,
            fill: true,
            tension: 0.4,
            yAxisID: 'y1'
          }
        ]
      },
      options: {
        responsive: true,
        maintainAspectRatio: true,
        interaction: {
          mode: 'index',
          intersect: false,
        },
        plugins: {
          legend: {
            position: 'top',
          },
          tooltip: {
            callbacks: {
              label: function(context) {
                let label = context.dataset.label || '';
                if (label) {
                  label += ': ';
                }
                if (context.parsed.y !== null) {
                  if (context.dataset.label === 'Revenue (৳)') {
                    label += '৳' + context.parsed.y.toLocaleString();
                  } else {
                    label += context.parsed.y;
                  }
                }
                return label;
              }
            }
          }
        },
        scales: {
          y: {
            type: 'linear',
            display: true,
            position: 'left',
            title: {
              display: true,
              text: 'Revenue (৳)'
            }
          },
          y1: {
            type: 'linear',
            display: true,
            position: 'right',
            title: {
              display: true,
              text: 'Orders'
            },
            grid: {
              drawOnChartArea: false,
            },
          },
        }
      }
    });
  }

  // Payment Methods Chart
  const paymentMethodCtx = document.getElementById('paymentMethodChart');
  if (paymentMethodCtx) {
    const paymentMethodData = <?php echo json_encode($paymentMethodsData); ?>;

    new Chart(paymentMethodCtx, {
      type: 'doughnut',
      data: {
        labels: paymentMethodData.map(item => item.name),
        datasets: [{
          data: paymentMethodData.map(item => item.amount),
          backgroundColor: [
            'rgba(59, 130, 246, 0.9)',
            'rgba(16, 185, 129, 0.9)',
            'rgba(245, 158, 11, 0.9)',
            'rgba(239, 68, 68, 0.9)',
            'rgba(139, 92, 246, 0.9)'
          ],
          borderColor: '#fff',
          borderWidth: 3,
          hoverOffset: 15
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: true,
        cutout: '65%',
        plugins: {
          legend: {
            position: 'bottom',
            labels: {
              padding: 15,
              font: {
                size: 13,
                weight: '600'
              },
              usePointStyle: true,
              pointStyle: 'circle'
            }
          },
          tooltip: {
            backgroundColor: 'rgba(0, 0, 0, 0.8)',
            padding: 12,
            titleFont: {
              size: 14,
              weight: 'bold'
            },
            bodyFont: {
              size: 13
            },
            callbacks: {
              label: function(context) {
                const value = context.parsed;
                const total = context.dataset.data.reduce((a, b) => a + b, 0);
                const percentage = ((value / total) * 100).toFixed(1);
                return context.label + ': ৳' + value.toLocaleString() + ' (' + percentage + '%)';
              }
            }
          }
        }
      }
    });
  }

  // Top Products Chart
  const topProductsCtx = document.getElementById('topProductsChart');
  if (topProductsCtx) {
    const topProductsData = <?php echo json_encode($topProductsData); ?>;

    new Chart(topProductsCtx, {
      type: 'bar',
      data: {
        labels: topProductsData.map(item => item.name.length > 20 ? item.name.substring(0, 20) + '...' : item.name),
        datasets: [{
          label: 'Sales (৳)',
          data: topProductsData.map(item => item.sales),
          backgroundColor: '#8b5cf6',
          borderColor: '#7c3aed',
          borderWidth: 1
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: true,
        plugins: {
          legend: {
            display: false
          },
          tooltip: {
            callbacks: {
              label: function(context) {
                return 'Sales: ৳' + context.parsed.y.toLocaleString();
              }
            }
          }
        },
        scales: {
          y: {
            beginAtZero: true,
            ticks: {
              callback: function(value) {
                return '৳' + value.toLocaleString();
              }
            }
          }
        }
      }
    });
  }

  // City-wise Sales Chart
  const cityWiseCtx = document.getElementById('cityWiseChart');
  if (cityWiseCtx) {
    const cityWiseData = <?php echo json_encode($cityWiseData); ?>;

    new Chart(cityWiseCtx, {
      type: 'bar',
      data: {
        labels: cityWiseData.map(item => item.city),
        datasets: [{
          label: 'Revenue (৳)',
          data: cityWiseData.map(item => item.revenue),
          backgroundColor: '#f59e0b',
          borderColor: '#d97706',
          borderWidth: 1
        }]
      },
      options: {
        indexAxis: 'y',
        responsive: true,
        maintainAspectRatio: true,
        plugins: {
          legend: {
            display: false
          },
          tooltip: {
            callbacks: {
              label: function(context) {
                return 'Revenue: ৳' + context.parsed.x.toLocaleString();
              }
            }
          }
        },
        scales: {
          x: {
            beginAtZero: true,
            ticks: {
              callback: function(value) {
                return '৳' + value.toLocaleString();
              }
            }
          }
        }
      }
    });
  }
</script>