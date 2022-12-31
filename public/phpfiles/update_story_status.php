<?php
header('Access-Control-Allow-Origin:*');
header("Content-Type:application/json;charset=utf-8");

require_once("./php_connect_books/connectBooks.php");

try {
   $sql = "UPDATE story 
            set story_status = :story_status       
            where story_id = :story_id";
   //編譯, 執行
   $stories = $pdo->prepare($sql);
   $stories->bindValue(":story_id", $_POST["story_id"]);
   $stories->bindValue(":story_status", $_POST["story_status"]);

   $stories->execute();

   $msg = "狀態更新成功";
} catch (PDOException $e) {
   $msg = "錯誤行號 : " . $e->getLine() . ", 錯誤訊息 : " . $e->getMessage();
}
//輸出結果
$result = ["msg" => $msg];
echo json_encode($result);
