<?php
$current_page = basename($_SERVER['PHP_SELF']); // Get the current page name
$page_title = 'Customized Product List'; // Set the page title
?>
<?php require 'header.php'; ?>

<!--------------------------->
<!-- START MAIN AREA -->
<!--------------------------->
<div class="content-wrapper">
  <div class="container-fluid">
    <!-- Page Heading -->
    <div class="page-header">
        <h3 class="page-title">
            <span class="page-title-icon bg-gradient-primary text-white me-2">
                <i class="mdi mdi-tshirt-crew-outline"></i>
            </span> Customized Product List
        </h3>
    </div>

    <!-- Product Cards -->
    <div class="row">
      <?php
      // Dummy product data
      $products = [
        [
          'id' => 1,
          'name' => 'Wireless Headphones',
          'description' => 'Premium noise-canceling headphones with 30-hour battery life',
          'price' => 149.99,
          'image' => 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=400&h=400&fit=crop',
          'category' => 'Electronics',
          'stock' => 45
        ],
        [
          'id' => 2,
          'name' => 'Smart Watch',
          'description' => 'Fitness tracking smartwatch with heart rate monitor',
          'price' => 299.99,
          'image' => 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=400&h=400&fit=crop',
          'category' => 'Electronics',
          'stock' => 32
        ],
        [
          'id' => 3,
          'name' => 'Leather Backpack',
          'description' => 'Stylish genuine leather backpack with laptop compartment',
          'price' => 89.99,
          'image' => 'https://images.unsplash.com/photo-1553062407-98eeb64c6a62?w=400&h=400&fit=crop',
          'category' => 'Accessories',
          'stock' => 18
        ],
        [
          'id' => 4,
          'name' => 'Running Shoes',
          'description' => 'Lightweight running shoes with superior cushioning',
          'price' => 129.99,
          'image' => 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?w=400&h=400&fit=crop',
          'category' => 'Footwear',
          'stock' => 67
        ],
        [
          'id' => 5,
          'name' => 'Portable Speaker',
          'description' => 'Waterproof Bluetooth speaker with 360° sound',
          'price' => 79.99,
          'image' => 'https://images.unsplash.com/photo-1608043152269-423dbba4e7e1?w=400&h=400&fit=crop',
          'category' => 'Electronics',
          'stock' => 54
        ],
        [
          'id' => 6,
          'name' => 'Sunglasses',
          'description' => 'UV protection polarized sunglasses',
          'price' => 59.99,
          'image' => 'https://images.unsplash.com/photo-1572635196237-14b3f281503f?w=400&h=400&fit=crop',
          'category' => 'Accessories',
          'stock' => 89
        ],
        [
          'id' => 7,
          'name' => 'Coffee Maker',
          'description' => 'Programmable coffee maker with thermal carafe',
          'price' => 119.99,
          'image' => 'https://images.unsplash.com/photo-1517668808822-9ebb02f2a0e6?w=400&h=400&fit=crop',
          'category' => 'Home & Kitchen',
          'stock' => 23
        ],
        [
          'id' => 8,
          'name' => 'Yoga Mat',
          'description' => 'Non-slip eco-friendly yoga mat with carrying strap',
          'price' => 34.99,
          'image' => 'https://images.unsplash.com/photo-1601925260368-ae2f83cf8b7f?w=400&h=400&fit=crop',
          'category' => 'Sports',
          'stock' => 41
        ]
      ];

      // Loop through products and display them
      foreach ($products as $product):
      ?>
        <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
          <div class="card h-100 shadow-sm">
            <img src="<?php echo $product['image']; ?>" class="card-img-top" alt="<?php echo $product['name']; ?>" style="height: 250px; object-fit: cover;">
            <div class="card-body d-flex flex-column">
              <span class="badge badge-primary mb-2" style="width: fit-content;">Customized</span>
              <h5 class="card-title"><?php echo $product['name']; ?></h5>
              <p class="card-text text-muted"><?php echo $product['description']; ?></p>
              <div class="mt-auto">
                <div class="d-flex justify-content-between align-items-center mb-3">
                  <h4 class="text-primary mb-0">৳ <?php echo number_format($product['price'], 2); ?></h4>
                </div>
                <div class="btn-group d-flex gap-2" role="group">
                  <button type="button" class="btn btn-sm btn-dark mb-0 rounded" onclick="viewProduct(<?php echo $product['id']; ?>)">
                    Edit
                  </button>
                  <button type="button" class="btn btn-sm btn-danger rounded">
                    Delete
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</div>

<script>
function viewProduct(productId) {
  alert('Viewing product #' + productId);
  // Add your view product logic here
}

function addToCart(productId) {
  alert('Product #' + productId + ' added to cart!');
  // Add your add to cart logic here
}
</script>

<style>
.card {
  transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.card:hover {
  transform: translateY(-5px);
  box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
}

.btn-group {
  gap: 5px;
}
</style>

<!--------------------------->
<!-- END MAIN AREA -->
<!--------------------------->

<?php require 'footer.php'; ?>