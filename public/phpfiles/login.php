<?php
header('Access-Control-Allow-Origin:*');
header("Content-Type:application/json;charset=utf-8");

$json = file_get_contents("php://input");
$datas = json_decode($json, true); //轉為關聯性陣列

try {
   require_once("./php_connect_books/connectBooks.php");

   $sql = "SELECT * from admin_panel WHERE admin_account = :admin_account and admin_psw = :admin_psw";

   $admin = $pdo->prepare($sql); //先編譯好
   $admin->bindValue(":admin_account", $datas['account']); //代入資料
   $admin->bindValue(":admin_psw", $datas['password']);
   $admin->execute(); //執行之

   $msg = '';
   $errMsg = '';
   $errMsg1 = '';
   // if ($admin->rowCount() == 0) { //找不到
   //    $errMsg .= "帳密錯誤,請重新登入";
   //    echo json_encode(["errMsg" => $errMsg]);
      
   // } else {
   //    $msg .= "登入成功";
   //    $adminRow = $admin->fetch(PDO::FETCH_ASSOC);
   //    echo json_encode(["adminName" => $adminRow["admin_name"], "msg" => $msg]);

   //    if ($adminRow["admin_status"]===0) {
   //       $errMsg1 .= "你已離職囉，請離開";
   //       echo json_encode(["errMsg1" => $errMsg1]);
   //    }
   // }

   if ($admin->rowCount() == 0) { 
      $errMsg .= "帳密錯誤,請重新登入";
      echo json_encode(["errMsg" => $errMsg]);
   } else {
      $adminRow = $admin->fetch(PDO::FETCH_ASSOC);
   
      if ($adminRow["admin_status"] === 0) {
         $errMsg1 .= "你已離職囉，請離開";
         echo json_encode(["errMsg1" => $errMsg1]);
      } else {
         $msg .= "登入成功";
         echo json_encode(["adminName" => $adminRow["admin_name"], "msg" => $msg]);
      }
   }
} catch (PDOException $e) {
   $errMsg .= "錯誤 : " . $e->getMessage() . "<br>";
   $errMsg .= "行號 : " . $e->getLine() . "<br>";
}

