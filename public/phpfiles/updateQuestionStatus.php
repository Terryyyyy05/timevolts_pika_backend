<?php 
header('Access-Control-Allow-Origin:*');
header("Content-Type:application/json;charset=utf-8");

require_once("./php_connect_books/connectBooks.php");

// echo json_encode($_POST["pro_status"]);
// exit();

try{
    $sql = "update faq set qa_status = :qa_status       
                              where qa_id = :qa_id";
    //編譯, 執行
    $products = $pdo->prepare($sql);	
    $products->bindValue(":qa_id", $_POST["qa_id"]);
    $products->bindValue(":qa_status", $_POST["qa_status"]);

    $products->execute();

    $msg = "更新成功";
    
  } catch (PDOException $e) {
    $msg = "錯誤行號 : ".$e->getLine().", 錯誤訊息 : ".$e->getMessage();
  }	
  //輸出結果
    $result = ["msg"=>$msg];
    echo json_encode($result);

?>