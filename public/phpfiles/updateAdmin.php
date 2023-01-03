<?php 
header('Access-Control-Allow-Origin:*');
header("Content-Type:application/json;charset=utf-8");
require_once("./php_connect_books/connectBooks.php");

try{


    $sql = "update admin_panel set admin_account = :admin_account,
                                   admin_name = :admin_name,
                                   admin_authority = :admin_authority,
                                   admin_psw = :admin_psw, 
                                   
                                   where admin_id = :admin_id";
    //編譯, 執行
    $products = $pdo->prepare($sql);	
    $products->bindValue(":admin_id", $_POST["admin_id"]);
    $products->bindValue(":admin_account", $_POST["admin_account"]);
    $products->bindValue(":admin_name", $_POST["admin_name"]);
    $products->bindValue(":admin_authority", $_POST["admin_authority"]);
    $products->bindValue(":admin_psw", $_POST["admin_psw"]);
 

    $products->execute();

    $msg = "更新成功";
    
  } catch (PDOException $e) {
    $msg = "錯誤行號 : ".$e->getLine().", 錯誤訊息 : ".$e->getMessage();
  }	
  //輸出結果
    $result = ["msg"=>$msg];
    echo json_encode($result);

?>