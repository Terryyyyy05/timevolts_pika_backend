<?php 
header('Access-Control-Allow-Origin:*');
header("Content-Type:application/json;charset=utf-8");

require_once("./php_connect_books/connectBooks.php");
require_once("./img_path.php");

// echo json_encode($_POST["pro_status"]);
// exit();

try{
    $sql = "update product set pro_status = :pro_status       
                              where pro_id = :pro_id";
    //編譯, 執行
    $products = $pdo->prepare($sql);	
    $products->bindValue(":pro_id", $_POST["pro_id"]);
    $products->bindValue(":pro_status", $_POST["pro_status"]);

    $products->execute();

    $msg = "更新成功";
    
  } catch (PDOException $e) {
    $msg = "錯誤行號 : ".$e->getLine().", 錯誤訊息 : ".$e->getMessage();
  }	
  //輸出結果
    $result = ["msg"=>$msg];
    echo json_encode($result);


?>