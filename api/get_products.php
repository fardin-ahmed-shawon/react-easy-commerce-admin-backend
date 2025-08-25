<?php
header('Content-Type: application/json');
header('Cache-Control: no-cache, no-store, must-revalidate'); // Prevent caching
header('Pragma: no-cache'); // HTTP 1.0
header('Expires: 0'); // Proxies

include 'database/dbConnection.php';

$sql = "
    SELECT 
        p.*, 
        mc.main_ctg_name, 
        sc.sub_ctg_name 
    FROM 
        product_info p
    JOIN 
        main_category mc ON p.main_ctg_id = mc.main_ctg_id
    JOIN 
        sub_category sc ON p.sub_ctg_id = sc.sub_ctg_id
";
$result = mysqli_query($conn, $sql);

$products = array();
while ($row = mysqli_fetch_assoc($result)) {
    $products[] = array(
        "id" => $row['product_id'],
        "title" => $row['product_title'],
        "description" => $row['product_description'],
        "price" => $row['product_price'],
        "main_category" => $row['main_ctg_name'],
        "sub_category" => $row['sub_ctg_name'],
        "available_stock" => $row['available_stock'],
        "size_option" => $row['size_option'],
        "keyword" => $row['product_keyword'],
        "image" => 'img/' . $row['product_img1'],
        "image2" => 'img/' . $row['product_img2'],
        "image3" => 'img/' . $row['product_img3'],
        "image4" => 'img/' . $row['product_img4'],
        "slug" => $row['product_slug']
    );
}

echo json_encode($products);
mysqli_close($conn);
?>