<?php
header('Access-Control-Allow-Origin:*');
header("Content-Type:application/json;charset=utf-8");

require_once("./php_connect_books/connectBooks.php");
require_once("./img_path.php");
const MY_DIR = img_path;

switch ($_FILES["story_img_1"]["error"]) {
   case UPLOAD_ERR_OK:

      if (file_exists(MY_DIR) == false) {
         mkdir(MY_DIR); //make directory
      }
      $from1 = $_FILES["story_img_1"]["tmp_name"];

      //$_FILES["image"]["name"]; //smile.gif,  sara.smile.gif, a313feexrer.gif
      $fileExt1 = pathinfo($_FILES["story_img_1"]["name"], PATHINFO_EXTENSION); //取得副檔名
      $fileName1 = uniqid() . "." . $fileExt1; //決定檔案名稱, 如a313feexrer.gif
      $to1 = MY_DIR . "/" . $fileName1; //決定路徑名稱
      if (copy($from1, $to1)) {
         $msg = "上傳成功";
      } else {
         $msg = "上傳失敗";
      }
      break;
   case UPLOAD_ERR_INI_SIZE:
      $msg = "上傳檔案太大,不能超過 " . ini_get("upload_max_filesize");
      break;
   case UPLOAD_ERR_FORM_SIZE:
      $msg = "上傳檔案太大,不能超過 " . $_POST["MAX_FILE_SIZE"];
      break;
   case UPLOAD_ERR_PARTIAL:
      $msg = "上傳檔案不完整";
      break;
   case UPLOAD_ERR_NO_FILE:
      $msg = "没有上傳檔案";
      break;
   default:
      $msg = "上傳檔案失敗，錯誤代碼: " . $_FILES["error"] . "請通知系統開發人員";
}

switch ($_FILES["story_img_2"]["error"]) {
   case UPLOAD_ERR_OK:

      if (file_exists(MY_DIR) == false) {
         mkdir(MY_DIR); //make directory
      }
      $from2 = $_FILES["story_img_2"]["tmp_name"];

      //$_FILES["image"]["name"]; //smile.gif,  sara.smile.gif, a313feexrer.gif
      $fileExt2 = pathinfo($_FILES["story_img_2"]["name"], PATHINFO_EXTENSION); //取得副檔名
      $fileName2 = uniqid() . "." . $fileExt2; //決定檔案名稱, 如a313feexrer.gif
      $to2 = MY_DIR . "/" . $fileName2; //決定路徑名稱
      if (copy($from2, $to2)) {
         $msg = "上傳成功";
      } else {
         $msg = "上傳失敗";
      }
      break;
   case UPLOAD_ERR_INI_SIZE:
      $msg = "上傳檔案太大,不能超過 " . ini_get("upload_max_filesize");
      break;
   case UPLOAD_ERR_FORM_SIZE:
      $msg = "上傳檔案太大,不能超過 " . $_POST["MAX_FILE_SIZE"];
      break;
   case UPLOAD_ERR_PARTIAL:
      $msg = "上傳檔案不完整";
      break;
   case UPLOAD_ERR_NO_FILE:
      $msg = "没有上傳檔案";
      break;
   default:
      $msg = "上傳檔案失敗，錯誤代碼: " . $_FILES["error"] . "請通知系統開發人員";
}

switch ($_FILES["story_img_3"]["error"]) {
   case UPLOAD_ERR_OK:

      if (file_exists(MY_DIR) == false) {
         mkdir(MY_DIR); //make directory
      }
      $from3 = $_FILES["story_img_3"]["tmp_name"];

      //$_FILES["image"]["name"]; //smile.gif,  sara.smile.gif, a313feexrer.gif
      $fileExt3 = pathinfo($_FILES["story_img_3"]["name"], PATHINFO_EXTENSION); //取得副檔名
      $fileName3 = uniqid() . "." . $fileExt3; //決定檔案名稱, 如a313feexrer.gif
      $to3 = MY_DIR . "/" . $fileName3; //決定路徑名稱
      if (copy($from3, $to3)) {
         $msg = "上傳成功";
      } else {
         $msg = "上傳失敗";
      }
      break;
   case UPLOAD_ERR_INI_SIZE:
      $msg = "上傳檔案太大,不能超過 " . ini_get("upload_max_filesize");
      break;
   case UPLOAD_ERR_FORM_SIZE:
      $msg = "上傳檔案太大,不能超過 " . $_POST["MAX_FILE_SIZE"];
      break;
   case UPLOAD_ERR_PARTIAL:
      $msg = "上傳檔案不完整";
      break;
   case UPLOAD_ERR_NO_FILE:
      $msg = "没有上傳檔案";
      break;
   default:
      $msg = "上傳檔案失敗，錯誤代碼: " . $_FILES["error"] . "請通知系統開發人員";
}

switch ($_FILES["story_img_4"]["error"]) {
   case UPLOAD_ERR_OK:

      if (file_exists(MY_DIR) == false) {
         mkdir(MY_DIR); //make directory
      }
      $from4 = $_FILES["story_img_4"]["tmp_name"];

      //$_FILES["image"]["name"]; //smile.gif,  sara.smile.gif, a313feexrer.gif
      $fileExt4 = pathinfo($_FILES["story_img_4"]["name"], PATHINFO_EXTENSION); //取得副檔名
      $fileName4 = uniqid() . "." . $fileExt4; //決定檔案名稱, 如a313feexrer.gif
      $to4 = MY_DIR . "/" . $fileName4; //決定路徑名稱
      if (copy($from4, $to4)) {
         $msg = "上傳成功";
      } else {
         $msg = "上傳失敗";
      }
      break;
   case UPLOAD_ERR_INI_SIZE:
      $msg = "上傳檔案太大,不能超過 " . ini_get("upload_max_filesize");
      break;
   case UPLOAD_ERR_FORM_SIZE:
      $msg = "上傳檔案太大,不能超過 " . $_POST["MAX_FILE_SIZE"];
      break;
   case UPLOAD_ERR_PARTIAL:
      $msg = "上傳檔案不完整";
      break;
   case UPLOAD_ERR_NO_FILE:
      $msg = "没有上傳檔案";
      break;
   default:
      $msg = "上傳檔案失敗，錯誤代碼: " . $_FILES["error"] . "請通知系統開發人員";
}

switch ($_FILES["story_img_5"]["error"]) {
   case UPLOAD_ERR_OK:

      if (file_exists(MY_DIR) == false) {
         mkdir(MY_DIR); //make directory
      }
      $from5 = $_FILES["story_img_5"]["tmp_name"];

      //$_FILES["image"]["name"]; //smile.gif,  sara.smile.gif, a313feexrer.gif
      $fileExt5 = pathinfo($_FILES["story_img_5"]["name"], PATHINFO_EXTENSION); //取得副檔名
      $fileName5 = uniqid() . "." . $fileExt5; //決定檔案名稱, 如a313feexrer.gif
      $to5 = MY_DIR . "/" . $fileName5; //決定路徑名稱
      if (copy($from5, $to5)) {
         $msg = "上傳成功";
      } else {
         $msg = "上傳失敗";
      }
      break;
   case UPLOAD_ERR_INI_SIZE:
      $msg = "上傳檔案太大,不能超過 " . ini_get("upload_max_filesize");
      break;
   case UPLOAD_ERR_FORM_SIZE:
      $msg = "上傳檔案太大,不能超過 " . $_POST["MAX_FILE_SIZE"];
      break;
   case UPLOAD_ERR_PARTIAL:
      $msg = "上傳檔案不完整";
      break;
   case UPLOAD_ERR_NO_FILE:
      $msg = "没有上傳檔案";
      break;
   default:
      $msg = "上傳檔案失敗，錯誤代碼: " . $_FILES["error"] . "請通知系統開發人員";
}



try {
   //sql 指令
   // 新增story article
   $sql1 = "INSERT INTO story_article
               VALUES (1, :story_id, :story_title, :story_img, :story_content)";
   //編譯, 執行
   $article1 = $pdo->prepare($sql1);
   $article1->bindValue(":story_id", $_POST["story_id"]);
   $article1->bindValue(":story_title", $_POST["story_title_01"]);
   $article1->bindValue(":story_img", $fileName1);
   $article1->bindValue(":story_content", $_POST["story_content_01"]);
   $article1->execute();

   $sql2 = "INSERT INTO story_article
               VALUES (2, :story_id, :story_title, :story_img, :story_content)";
   //編譯, 執行
   $article2 = $pdo->prepare($sql2);
   $article2->bindValue(":story_id", $_POST["story_id"]);
   $article2->bindValue(":story_title", $_POST["story_title_02"]);
   $article2->bindValue(":story_img", $fileName2);
   $article2->bindValue(":story_content", $_POST["story_content_02"]);
   $article2->execute();

   $sql3 = "INSERT INTO story_article
               VALUES (3, :story_id, :story_title, :story_img, :story_content)";
   //編譯, 執行
   $article3 = $pdo->prepare($sql3);
   $article3->bindValue(":story_id", $_POST["story_id"]);
   $article3->bindValue(":story_title", $_POST["story_title_03"]);
   $article3->bindValue(":story_img", $fileName3);
   $article3->bindValue(":story_content", $_POST["story_content_03"]);
   $article3->execute();

   $sql4 = "INSERT INTO story_article
               VALUES (4, :story_id, :story_title, :story_img, :story_content)";
   //編譯, 執行
   $article4 = $pdo->prepare($sql4);
   $article4->bindValue(":story_id", $_POST["story_id"]);
   $article4->bindValue(":story_title", $_POST["story_title_04"]);
   $article4->bindValue(":story_img", $fileName4);
   $article4->bindValue(":story_content", $_POST["story_content_04"]);
   $article4->execute();

   $sql5 = "INSERT INTO story_article
               VALUES (5, :story_id, :story_title, :story_img, :story_content)";
   //編譯, 執行
   $article5 = $pdo->prepare($sql5);
   $article5->bindValue(":story_id", $_POST["story_id"]);
   $article5->bindValue(":story_title", $_POST["story_title_05"]);
   $article5->bindValue(":story_img", $fileName5);
   $article5->bindValue(":story_content", $_POST["story_content_05"]);
   $article5->execute();
   // }



   // if($prodRows->rowCount() == 0 ){
   //   $result = ["pro_id"=>$prodRows];
   // } else {
   //   $msg = "新增失敗";
   // }
} catch (PDOException $e) {
   $msg = "錯誤行號 : " . $e->getLine() . ", 錯誤訊息 : " . $e->getMessage();
}

//輸出結果
// $result = array_merge($result, ["msg"=>$msg, "pro_img"=> $fileName]);
$result = [
   "msg" => $msg,
   "story_img_1" => $fileName1,
   "story_img_2" => $fileName2,
   "story_img_3" => $fileName3,
   "story_img_4" => $fileName4,
   "story_img_5" => $fileName5,
];
echo json_encode($result);
