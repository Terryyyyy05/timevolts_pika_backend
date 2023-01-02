<?php
header('Access-Control-Allow-Origin:*');
header("Content-Type:application/json;charset=utf-8");

try {
    require_once("./php_connect_books/connectBooks.php");
    //sql 指令
    $checkSql = "SELECT `qa_id` FROM `faq` where `qa_title` = '{$_POST["qa_title"]}'";
    $products = $pdo->query($checkSql);
    $prodRows = $products->fetchAll(PDO::FETCH_ASSOC);

    if ($products->rowCount() > 0) {
        echo json_encode('wrong');
        exit();
    }
    // Set Auto Increment to 1 each time
    $sqlAutoIncrement = "ALTER TABLE faq AUTO_INCREMENT=1";
    
    $productsAutoIncrement = $pdo->prepare($sqlAutoIncrement);
    $productsAutoIncrement->execute();

    // Insert new data
    $sql = "INSERT INTO faq VALUES (null, :qa_type, :qa_title, :qa_answer, :qa_status)";
    //編譯, 執行
    $products = $pdo->prepare($sql);
    // $products->bindValue(":qa_id", $_POST["qa_id"]);
    $products->bindValue(":qa_type", $_POST["qa_type"]);
    $products->bindValue(":qa_title", $_POST["qa_title"]);
    $products->bindValue(":qa_answer", $_POST["qa_answer"]);
    $products->bindValue(":qa_status", $_POST["qa_status"] ? 1 : 0);
    $products->execute();

    $sql = "SELECT `qa_id` FROM `faq` where `qa_title` = '{$_POST["qa_title"]}'";
    $products = $pdo->query($sql);
    $prodRows = $products->fetchAll(PDO::FETCH_ASSOC);
    $msg = "新增成功";
} catch (PDOException $e) {
    $msg = "錯誤行號 : " . $e->getLine() . ", 錯誤訊息 : " . $e->getMessage();
}
// 輸出結果
$result = ["msg" => $msg, "qa_id" => $prodRows];
echo json_encode($result);
