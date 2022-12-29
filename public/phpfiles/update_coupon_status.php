<?php
header('Access-Control-Allow-Origin:*');
header("Content-Type:application/json;charset=utf-8");

require_once("./php_connect_books/connectBooks.php");

// echo json_encode("AAA");
// exit();

try {
  $sql = "update coupon set coupon_status = :coupon_status       
                              where coupon_id = :coupon_id";
  //編譯, 執行
  $couponducts = $pdo->prepare($sql);
  $couponducts->bindValue(":coupon_id", $_POST["coupon_id"]);
  $couponducts->bindValue(":coupon_status", $_POST["coupon_status"]);

  $couponducts->execute();

  $msg = "更新成功";
} catch (PDOException $e) {
  $msg = "錯誤行號 : " . $e->getLine() . ", 錯誤訊息 : " . $e->getMessage();
}
//輸出結果
$result = ["msg" => $msg];
echo json_encode($result);
