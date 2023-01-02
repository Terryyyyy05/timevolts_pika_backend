<?php 
header('Access-Control-Allow-Origin:*');
header("Content-Type:application/json;charset=utf-8");
require_once("./php_connect_books/connectBooks.php");

    try{
        $sql = "UPDATE member SET mem_status = :mem_status
                            
                                  WHERE mem_id = :mem_id";
        //編譯, 執行
        $member = $pdo->prepare($sql);
        $member->bindValue(":mem_id", $_POST["mem_id"]);	
        $member->bindValue(":mem_status", $_POST["mem_status"]);
        
  
        $member->execute();
  
        $msg = "更新成功";
        
      } catch (PDOException $e) {
        $msg = "錯誤行號 : ".$e->getLine().", 錯誤訊息 : ".$e->getMessage();
      }	
      //輸出結果
        $result = ["msg"=>$msg];
        echo json_encode($result);
  
  
  ?>