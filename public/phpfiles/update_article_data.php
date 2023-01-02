<?php
header('Access-Control-Allow-Origin:*');
header("Content-Type:application/json;charset=utf-8");

require_once("./php_connect_books/connectBooks.php");

try {
   $sql1 = "UPDATE story_article 
           SET story_title = :story_title,
               story_content = :story_content
           WHERE story_id = :story_id && story_article_id = 1";
   //編譯, 執行
   $story1 = $pdo->prepare($sql1);
   $story1->bindValue(":story_id", $_POST["story_id"]);
   $story1->bindValue(":story_title", $_POST["story_title_01"]);
   $story1->bindValue(":story_content", $_POST["story_content_01"]);

   $story1->execute();

   $sql2 = "UPDATE story_article 
           SET story_title = :story_title,
               story_content = :story_content
           WHERE story_id = :story_id && story_article_id = 2";
   //編譯, 執行
   $story2 = $pdo->prepare($sql2);
   $story2->bindValue(":story_id", $_POST["story_id"]);
   $story2->bindValue(":story_title", $_POST["story_title_02"]);
   $story2->bindValue(":story_content", $_POST["story_content_02"]);

   $story2->execute();

   $sql3 = "UPDATE story_article 
           SET story_title = :story_title,
               story_content = :story_content
           WHERE story_id = :story_id && story_article_id = 3";
   //編譯, 執行
   $story3 = $pdo->prepare($sql3);
   $story3->bindValue(":story_id", $_POST["story_id"]);
   $story3->bindValue(":story_title", $_POST["story_title_03"]);
   $story3->bindValue(":story_content", $_POST["story_content_03"]);

   $story3->execute();

   $sql4 = "UPDATE story_article 
           SET story_title = :story_title,
               story_content = :story_content
           WHERE story_id = :story_id && story_article_id = 4";
   //編譯, 執行
   $story4 = $pdo->prepare($sql4);
   $story4->bindValue(":story_id", $_POST["story_id"]);
   $story4->bindValue(":story_title", $_POST["story_title_04"]);
   $story4->bindValue(":story_content", $_POST["story_content_04"]);

   $story4->execute();

   $sql5 = "UPDATE story_article 
           SET story_title = :story_title,
               story_content = :story_content
           WHERE story_id = :story_id && story_article_id = 5";
   //編譯, 執行
   $story5 = $pdo->prepare($sql5);
   $story5->bindValue(":story_id", $_POST["story_id"]);
   $story5->bindValue(":story_title", $_POST["story_title_05"]);
   $story5->bindValue(":story_content", $_POST["story_content_05"]);

   $story5->execute();

   $msg = "更新成功";
} catch (PDOException $e) {
   $msg = "錯誤行號 : " . $e->getLine() . ", 錯誤訊息 : " . $e->getMessage();
}

//輸出結果
$result = ["msg" => $msg];
echo json_encode($result);
