<?php 
header('Access-Control-Allow-Origin:*');
header("Content-Type:application/json;charset=utf-8");

require_once("./img_path.php");
$imgPath = img_path;
// $imgPath = "../../../timevolts_pika/public/news";

try{
  $imgFile = $_POST["news_img"];

  if (file_exists("$imgPath/$imgFile") == false) {
    echo "NONO圖片梅刪掉";
    exit();
  }
  $imgFile = $_POST["news_img"];
  unlink("$imgPath/$imgFile");

  require_once("./php_connect_books/connectBooks.php");
  $sql = "delete FROM news where news_id = :news_id";
  
  $products = $pdo->prepare($sql);	
  $products->bindValue(":news_id", $_POST["news_id"]);
  $products->execute();

  $msg = "刪除成功";

  
} catch (PDOException $e) {
  $msg = "錯誤行號 : ".$e->getLine().", 錯誤訊息 : ".$e->getMessage();
}

$result = ["msg"=>$msg];
echo json_encode($result);

?>