<?php 
header('Access-Control-Allow-Origin:*');
header("Content-Type:application/json;charset=utf-8");

require_once("./php_connect_books/connectBooks.php");
require_once("./img_path.php");
$imgPath = img_path;

try{
  $imgFile = $_POST["pro_img"];

  if (file_exists("$imgPath/$imgFile") == false) {
    echo "NONO圖片沒刪掉";
    exit();
  }
  $imgFile = $_POST["pro_img"];
  unlink("$imgPath/$imgFile");

  $sql = "delete FROM product where pro_id = :pro_id";
  
  $products = $pdo->prepare($sql);	
  $products->bindValue(":pro_id", $_POST["pro_id"]);
  $products->execute();

  $msg = "刪除成功";

  
} catch (PDOException $e) {
  $msg = "錯誤行號 : ".$e->getLine().", 錯誤訊息 : ".$e->getMessage();
}

$result = ["msg"=>$msg];
echo json_encode($result);

?>