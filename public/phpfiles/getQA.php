<?php 
header('Access-Control-Allow-Origin:*');
header("Content-Type:application/json;charset=utf-8");
require_once("./connectBooks.php");
$sql = "SELECT a.pro_id, a.pro_name, a.pro_info, a.pro_price, a.pro_img, concat(a.pro_status, '') as pro_status, date(a.pro_onshelf_date) as pro_onshelf_date, a.pro_onshelf_amount, a.pro_rest_amount, b.pro_class_name FROM product a JOIN product_class b ON a.pro_class_id = b.pro_class_id order by a.pro_id";
$products = $pdo->query($sql);
$prodRows = $products->fetchAll(PDO::FETCH_ASSOC);
echo json_encode($prodRows);
?>