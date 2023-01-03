<?php 
header('Access-Control-Allow-Origin:*');
header("Content-Type:application/json;charset=utf-8");

try{
    require_once("./php_connect_books/connectBooks.php");
    //sql 指令
    $checkSql = "SELECT `admin_id` FROM `admin_panel` where `admin_name` = '{$_POST["admin_name"]}'";
    $products = $pdo->query($checkSql);
    $prodRows = $products->fetchAll(PDO::FETCH_ASSOC);
    
    if($products->rowCount() > 0 ){
      echo json_encode('wrong');
      exit();
    }

    $sql = "insert into admin_panel values (null , :admin_account, :admin_name, :admin_authority, :admin_status, :admin_psw )";
    //編譯, 執行
    $products = $pdo->prepare($sql);

    $products->bindValue(":admin_account", $_POST["admin_account"]);
    $products->bindValue(":admin_name", $_POST["admin_name"]);
    $products->bindValue(":admin_authority", $_POST["admin_authority"]);
    $products->bindValue(":admin_status", $_POST["admin_status"]? 1:0);
    $products->bindValue(":admin_psw", $_POST["admin_psw"]);
    $products->execute();	

    $sql = "SELECT `admin_id` FROM `admin_panel` where `admin_name` = '{$_POST["admin_name"]}'";
    $products = $pdo->query($sql);
    $prodRows = $products->fetchAll(PDO::FETCH_ASSOC);
    $msg = "新增成功";
} catch (PDOException $e) {
    $msg = "錯誤行號 : ".$e->getLine().", 錯誤訊息 : ".$e->getMessage();
}	

//輸出結果

$result = ["msg"=>$msg, "admin_id"=>$prodRows];
echo json_encode($result);

?>