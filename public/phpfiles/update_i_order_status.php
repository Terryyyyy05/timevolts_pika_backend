<?php
header('Access-Control-Allow-Origin:*');
header("Content-Type:application/json;charset=utf-8");

require_once("./php_connect_books/connectBooks.php");

try {
   $sql = "UPDATE itinerary_order 
            SET itinerary_order_status = :itinerary_order_status       
            WHERE itinerary_order_id = :itinerary_order_id";
   //編譯, 執行
   $order = $pdo->prepare($sql);
   $order->bindValue(":itinerary_order_status", $_POST["itinerary_order_status"]);
   $order->bindValue(":itinerary_order_id", $_POST["itinerary_order_id"]);
   $order->execute();

   $msg = "更新成功";
} catch (PDOException $e) {
   $msg = "錯誤行號 : " . $e->getLine() . ", 錯誤訊息 : " . $e->getMessage();
}
//輸出結果
$result = ["msg" => $msg];
echo json_encode($result);
