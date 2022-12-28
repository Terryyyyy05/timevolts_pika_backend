<?php
header('Access-Control-Allow-Origin:*');
header("Content-Type:application/json;charset=utf-8");

try {
    require_once("./php_connect_books/connectBooks.php");
    $sql = "delete FROM faq where qa_id = :qa_id";

    $products = $pdo->prepare($sql);
    $products->bindValue(":qa_id", $_POST["qa_id"]);
    $products->execute();

    $msg = "刪除成功";
} catch (PDOException $e) {
    $msg = "錯誤行號 : " . $e->getLine() . ", 錯誤訊息 : " . $e->getMessage();
}

$result = ["msg" => $msg];
echo json_encode($result);
