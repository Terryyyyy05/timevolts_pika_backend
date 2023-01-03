<?php
header('Access-Control-Allow-Origin:*');
header("Content-Type:application/json;charset=utf-8");

require_once("./php_connect_books/connectBooks.php");
require_once("./img_path.php");
const MY_DIR = img_path;

// 判斷有沒有傳圖片
$test = isset($_FILES["story_cover"]);

if ($test) {
   switch ($_FILES["story_cover"]["error"]) {
      case UPLOAD_ERR_OK:

         if (file_exists(MY_DIR) == false) {
            mkdir(MY_DIR); //make directory
         }
         $from = $_FILES["story_cover"]["tmp_name"];

         //$_FILES["image"]["name"]; //smile.gif,  sara.smile.gif, a313feexrer.gif
         $fileExt = pathinfo($_FILES["story_cover"]["name"], PATHINFO_EXTENSION); //取得副檔名
         $fileName = uniqid() . "." . $fileExt; //決定檔案名稱, 如a313feexrer.gif
         $to = MY_DIR . "/" . $fileName; //決定路徑名稱
         if (copy($from, $to)) {
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
   if ($_FILES["story_cover"]["error"] === 0) {

      try {
         // 刪除原本圖片
         $checkImgSql = "SELECT story_cover 
                         FROM story 
                         WHERE story_id = :story_id";
         $stories = $pdo->prepare($checkImgSql);
         $stories->bindValue(":story_id", $_POST["story_id"]);
         $stories->execute();
         $storyRows = $stories->fetchAll(PDO::FETCH_ASSOC);
         unlink(MY_DIR . '/' . $storyRows[0]["story_cover"]);


         $sql = "UPDATE story 
                 SET story_name = :story_name,
                     story_intro = :story_intro,
                     story_age = :story_age,
                     story_cover = :story_cover,
                     itinerary_number_of_years = :itinerary_number_of_years,
                     story_classification = :story_classification, 
                     story_risk = :story_risk,
                     story_spot = :story_spot,
                     story_specialty = :story_specialty
                     story_status = :story_status
                 WHERE story_id = :story_id";
         //編譯, 執行
         $stories = $pdo->prepare($sql);
         $stories->bindValue(":story_id", $_POST["story_id"]);
         $stories->bindValue(":story_name", $_POST["story_name"]);
         $stories->bindValue(":story_intro", $_POST["story_intro"]);
         $stories->bindValue(":story_age", $_POST["story_age"]);
         $stories->bindValue(":itinerary_number_of_years", $_POST["itinerary_number_of_years"]);
         $stories->bindValue(":story_classification", $_POST["story_classification"]);
         $stories->bindValue(":story_risk", $_POST["story_risk"]);
         $stories->bindValue(":story_spot", $_POST["story_spot"]);
         $stories->bindValue(":story_specialty", $_POST["story_specialty"]);
         $stories->bindValue(":story_status", $_POST["story_status"] ? 1 : 0);
         $stories->bindValue(":story_cover", $fileName);
         $stories->execute();

         $msg = "更新成功";
      } catch (PDOException $e) {
         $msg = "錯誤行號 : " . $e->getLine() . ", 錯誤訊息 : " . $e->getMessage();
      }
   }
   //輸出結果
   $result = ["msg" => $msg, "story_cover" => $fileName];
   echo json_encode($result);
} else {
   try {
      $sql = "UPDATE story 
              SET story_name = :story_name,
                  story_intro = :story_intro,
                  story_age = :story_age,
                  itinerary_number_of_years = :itinerary_number_of_years,
                  story_classification = :story_classification, 
                  story_risk = :story_risk,
                  story_spot = :story_spot,
                  story_specialty = :story_specialty
            WHERE story_id = :story_id";

      //編譯, 執行
      $stories = $pdo->prepare($sql);
      $stories->bindValue(":story_id", $_POST["story_id"]);
      $stories->bindValue(":story_name", $_POST["story_name"]);
      $stories->bindValue(":story_intro", $_POST["story_intro"]);
      $stories->bindValue(":story_age", $_POST["story_age"]);
      $stories->bindValue(":itinerary_number_of_years", $_POST["itinerary_number_of_years"]);
      $stories->bindValue(":story_classification", $_POST["story_classification"]);
      $stories->bindValue(":story_risk", $_POST["story_risk"]);
      $stories->bindValue(":story_spot", $_POST["story_spot"]);
      $stories->bindValue(":story_specialty", $_POST["story_specialty"]);
      $stories->execute();

      $msg = "更新成功";
   } catch (PDOException $e) {
      $msg = "錯誤行號 : " . $e->getLine() . ", 錯誤訊息 : " . $e->getMessage();
   }

   //輸出結果
   $result = ["msg" => $msg];
   echo json_encode($result);
}
