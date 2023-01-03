<?php 
header('Access-Control-Allow-Origin:*');
header("Content-Type:application/json;charset=utf-8");

require_once("./php_connect_books/connectBooks.php");
require_once("./img_path.php");

// echo json_encode($_POST["pro_status"]);
// exit();

try{
    $sql = "update news set news_status = :news_status       
                              where news_id = :news_id";
    //編譯, 執行
    $products = $pdo->prepare($sql);	
    $products->bindValue(":news_id", $_POST["news_id"]);
    $products->bindValue(":news_status", $_POST["news_status"]);

    $products->execute();

    $msg = "更新成功";
    
  } catch (PDOException $e) {
    $msg = "錯誤行號 : ".$e->getLine().", 錯誤訊息 : ".$e->getMessage();
  }	
  //輸出結果
    $result = ["msg"=>$msg];
    echo json_encode($result);


?>