<?php
header('Access-Control-Allow-Origin:*');
header("Content-Type:application/json;charset=utf-8");

try {
    require_once("./php_connect_books/connectBooks.php");

    $sql = "update faq set  qa_type = :qa_type,
                            qa_title = :qa_title,
                            qa_answer = :qa_answer,
                            qa_status = :qa_status

                            where qa_id = :qa_id";
    //編譯, 執行
    $products = $pdo->prepare($sql);
    $products->bindValue(":qa_id", $_POST["qa_id"]);
    $products->bindValue(":qa_type", $_POST["qa_type"]);
    $products->bindValue(":qa_title", $_POST["qa_title"]);
    $products->bindValue(":qa_answer", $_POST["qa_answer"]);
    $products->bindValue(":qa_status", $_POST["qa_status"] ? 1 : 0);
    $products->execute();
    $msg = "更新成功";
} catch (PDOException $e) {
    $msg = "錯誤行號 : " . $e->getLine() . ", 錯誤訊息 : " . $e->getMessage();
}
$result = ["msg" => $msg];
echo json_encode($result);
