<?php 
header('Access-Control-Allow-Origin:*');
header("Content-Type:application/json;charset=utf-8");
require_once("./connectBooks.php");
$sql = "SELECT a.pro_id, a.pro_name, a.pro_info, a.pro_price, a.pro_img, concat(a.pro_status, '') as pro_status, date(a.pro_onshelf_date) as pro_onshelf_date, a.pro_onshelf_amount, a.pro_rest_amount, b.pro_class_name FROM product a JOIN product_class b ON a.pro_class_id = b.pro_class_id order by a.pro_id";
$products = $pdo->query($sql);
$prodRows = $products->fetchAll(PDO::FETCH_ASSOC);
echo json_encode($prodRows);
?>


<?php 
/*======另一個可能的範例

require_once("../connectBooks.php");
//--------取回訂單主檔的資料
$sql = "select * from orderMaster where orderNo=1";
$orderMaster = $pdo->query($sql);
$orderMasterRow = $orderMasters->fetch(PDO::FETCH_ASSOC);
//把它打包放入result中
$result["orderMasterRow"] =  $orderMasterRow;

//--------取回訂單明細的資料
$sql = "select * from orderItems where orderNo=1";
$orderItems = $pdo->query($sql);
$orderItemsRows = $orderMasters->fetchAll(PDO::FETCH_ASSOC);
//把它打包放入result中
$result["orderMasterRow"] =  $orderItemsRows;

echo json_encode($result);
*/
?>