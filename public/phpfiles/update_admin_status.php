<?php 
header('Access-Control-Allow-Origin:*');
header("Content-Type:application/json;charset=utf-8");
require_once("./php_connect_books/connectBooks.php");

    try{
        $sql = "UPDATE admin_panel SET admin_status = :admin_status
                            
                                  WHERE admin_id = :admin_id";
        //編譯, 執行
        $member = $pdo->prepare($sql);
        $member->bindValue(":admin_id", $_POST["admin_id"]);	
        $member->bindValue(":admin_status", $_POST["admin_status"]);
        
  
        $member->execute();
  
        $msg = "更新成功";
        
      } catch (PDOException $e) {
        $msg = "錯誤行號 : ".$e->getLine().", 錯誤訊息 : ".$e->getMessage();
      }	
      //輸出結果
        $result = ["msg"=>$msg];
        echo json_encode($result);
  
  
  ?>