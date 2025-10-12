<?php
$current_page = basename($_SERVER['PHP_SELF']); // Get the current page name
$page_title = 'All Blogs'; // Set the page title
require 'header.php';
?>

<style>
/* --- Page Styling --- */
.content-wrapper {
  padding: 30px;
  background: #f8f9fa;
  min-height: 100vh;
}

.page-header {
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin-bottom: 25px;
}

.page-header h2 {
  font-size: 28px;
  font-weight: 700;
  color: #333;
}

.add-btn {
  background: linear-gradient(90deg, #4f46e5, #06b6d4);
  color: #fff;
  font-weight: 600;
  border: none;
  border-radius: 8px;
  padding: 10px 20px;
  transition: all 0.3s ease;
  text-decoration: none;
}
.add-btn:hover {
  transform: scale(1.05);
  box-shadow: 0 5px 15px rgba(79, 70, 229, 0.3);
}

/* --- Blog Grid --- */
.blog-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
  gap: 25px;
}

.blog-card {
  background: #fff;
  border-radius: 12px;
  box-shadow: 0 2px 10px rgba(0,0,0,0.08);
  overflow: hidden;
  transition: transform 0.2s ease, box-shadow 0.2s ease;
}
.blog-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 5px 20px rgba(0,0,0,0.1);
}

.blog-img {
  width: 100%;
  height: 200px;
  object-fit: cover;
}

.blog-content {
  padding: 18px;
}

.blog-title {
  font-size: 18px;
  font-weight: 600;
  color: #222;
  margin-bottom: 8px;
}

.blog-desc {
  font-size: 14px;
  color: #555;
  margin-bottom: 12px;
  line-height: 1.5;
  height: 60px;
  overflow: hidden;
}

.blog-footer {
  display: flex;
  justify-content: space-between;
  align-items: center;
  border-top: 1px solid #eee;
  padding: 12px 18px;
  background: #fafafa;
}

.blog-date {
  font-size: 13px;
  color: #777;
}

.blog-actions a {
  text-decoration: none;
  padding: 6px 10px;
  border-radius: 6px;
  font-size: 13px;
  font-weight: 600;
  transition: 0.3s ease;
}

.blog-actions .edit-btn {
  background: #4f46e5;
  color: #fff;
}
.blog-actions .edit-btn:hover {
  background: #4338ca;
}

.blog-actions .delete-btn {
  background: #dc2626;
  color: #fff;
  margin-left: 5px;
}
.blog-actions .delete-btn:hover {
  background: #b91c1c;
}
</style>

<div class="content-wrapper">
  <div class="page-header">
    <h2>All Blogs</h2>
    <a href="add-blog.php" class="add-btn">+ Add New Blog</a>
  </div>

  <div class="blog-grid">
    <?php
    // Fetch all blogs from the database
    $query = "SELECT * FROM blogs ORDER BY id DESC";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
      while ($row = mysqli_fetch_assoc($result)) {
        $blog_id = $row['id'];
        $blog_title = htmlspecialchars($row['blog_title']);
        $blog_desc = substr(nl2br(($row['blog_description'])), 0, 120) . '...';
        $blog_img = !empty($row['blog_img']) ? 'uploads/' . $row['blog_img'] : 'assets/img/default-blog.jpg';
        $created_at = date('M d, Y', strtotime($row['created_at']));
        ?>
        
        <div class="blog-card">
          <img src="<?php echo $blog_img; ?>" alt="<?php echo $blog_title; ?>" class="blog-img">
          <div class="blog-content">
            <h3 class="blog-title"><?php echo $blog_title; ?></h3>
            <p class="blog-desc"><?php echo $blog_desc; ?></p>
          </div>
          <div class="blog-footer">
            <span class="blog-date"><?php echo $created_at; ?></span>
            <div class="blog-actions">
              <a href="edit-blog.php?id=<?php echo $blog_id; ?>" class="edit-btn">Edit</a>
              <a href="delete-blog.php?id=<?php echo $blog_id; ?>" class="delete-btn" onclick="return confirm('Are you sure you want to delete this blog?');">Delete</a>
            </div>
          </div>
        </div>
        
        <?php
      }
    } else {
      echo "<p>No blogs found.</p>";
    }
    ?>
  </div>
</div>

<?php require 'footer.php'; ?>