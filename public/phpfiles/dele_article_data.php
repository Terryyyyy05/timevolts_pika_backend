<?php
header('Access-Control-Allow-Origin:*');
header("Content-Type:application/json;charset=utf-8");

require_once("./php_connect_books/connectBooks.php");
require_once("./img_path.php");
$imgPath = img_path;

try {
   $imgFile1 = $_POST["story_img_1"];
   $imgFile2 = $_POST["story_img_2"];
   $imgFile3 = $_POST["story_img_3"];
   $imgFile4 = $_POST["story_img_4"];
   $imgFile5 = $_POST["story_img_5"];

   if (
      file_exists("$imgPath/$imgFile1") == false &&
      file_exists("$imgPath/$imgFile2") == false &&
      file_exists("$imgPath/$imgFile3") == false &&
      file_exists("$imgPath/$imgFile4") == false &&
      file_exists("$imgPath/$imgFile5") == false
   ) {
      echo "NONO圖片沒刪掉";
      exit();
   } else {
      unlink("$imgPath/$imgFile1");
      unlink("$imgPath/$imgFile2");
      unlink("$imgPath/$imgFile3");
      unlink("$imgPath/$imgFile4");
      unlink("$imgPath/$imgFile5");
   }

   $sql = "DELETE FROM story_article WHERE story_id = :story_id";

   $stories = $pdo->prepare($sql);
   $stories->bindValue(":story_id", $_POST["story_id"]);
   $stories->execute();

   $msg = "刪除成功";
} catch (PDOException $e) {
   $msg = "錯誤行號 : " . $e->getLine() . ", 錯誤訊息 : " . $e->getMessage();
}

$result = ["msg" => $msg];
echo json_encode($result);
