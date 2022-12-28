<?php
header('Access-Control-Allow-Origin:*');
header("Content-Type:application/json;charset=utf-8");

try {
    require_once("./php_connect_books/connectBooks.php");
    //sql 指令
    $sql = "insert into faq values (:qa_id, :qa_type, :qa_title, :qa_answer, :qa_status)";
    //編譯, 執行
    $products = $pdo->prepare($sql);
    $products->bindValue(":qa_id", $_POST["qa_id"]);
    $products->bindValue(":qa_type", $_POST["qa_type"]);
    $products->bindValue(":qa_title", $_POST["qa_title"]);
    $products->bindValue(":qa_answer", $_POST["qa_answer"]);
    $products->bindValue(":qa_status", $_POST["qa_status"] ? 1 : 0);
    $products->execute();
    $msg = "success";
} catch (PDOException $e) {
    $msg = "error _line: " . $e->getLine() . ", error_msg: " .
        $e->getMessage();
}
// 輸出結果
$result = ["msg" => $msg];
echo json_encode($result);
?>