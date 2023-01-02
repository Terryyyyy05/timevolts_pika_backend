<?php
header('Access-Control-Allow-Origin:*');
header("Content-Type:application/json;charset=utf-8");

require_once("./img_path.php");
const MY_DIR = img_path;

switch ($_FILES["story_cover"]["error"]) {
   case UPLOAD_ERR_OK:

      if (file_exists(MY_DIR) == false) {
         mkdir(MY_DIR); //make directory
      }
      $from = $_FILES["story_cover"]["tmp_name"];

      //$_FILES["image"]["name"]; //smile.gif,  sara.smile.gif, a313feexrer.gif
      $fileExt = pathinfo($_FILES["story_cover"]["name"], PATHINFO_EXTENSION); //取得副檔名
      $banner = uniqid() . "." . $fileExt; //決定檔案名稱, 如a313feexrer.gif
      $to = MY_DIR . "/" . $banner; //決定路徑名稱
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

if (
   $_FILES["story_cover"]["error"] === 0
) {

   try {
      require_once("./php_connect_books/connectBooks.php");
      //sql 指令
      $checkSql = "SELECT story_id
                   FROM story 
                   WHERE story_name = :story_name";
      $checkStory = $pdo->prepare($checkSql);
      $checkStory->bindValue(":story_name", $_POST["story_name"]);
      $checkStoryRows = $checkStory->fetchAll(PDO::FETCH_ASSOC);

      if ($checkStory->rowCount() > 0) {
         echo json_encode('wrong');
         exit();
      }

      // 新增story
      $sql = "INSERT INTO story (story_classification, story_name, story_risk, story_specialty, story_spot, story_intro, story_age, itinerary_number_of_years, story_status, story_cover)
              VALUES (:story_classification, :story_name, :story_risk, :story_specialty, :story_spot, :story_intro, :story_age, :itinerary_number_of_years, 0, :story_cover)";
      //編譯, 執行
      $stories = $pdo->prepare($sql);
      $stories->bindValue(":story_classification", $_POST["story_classification"]);
      $stories->bindValue(":story_name", $_POST["story_name"]);
      $stories->bindValue(":story_risk", $_POST["story_risk"]);
      $stories->bindValue(":story_specialty", $_POST["story_specialty"]);
      $stories->bindValue(":story_spot", $_POST["story_spot"]);
      $stories->bindValue(":story_intro", $_POST["story_intro"]);
      $stories->bindValue(":story_age", $_POST["story_age"]);
      $stories->bindValue(":itinerary_number_of_years", $_POST["itinerary_number_of_years"]);
      $stories->bindValue(":story_cover", $banner);
      $stories->execute();

   } catch (PDOException $e) {
      $msg = "錯誤行號 : " . $e->getLine() . ", 錯誤訊息 : " . $e->getMessage();
   }
}
//輸出結果
// $result = array_merge($result, ["msg"=>$msg, "pro_img"=> $fileName]);
$result = [
   "msg" => $msg,
   "story_cover" => $banner,
   "story_id" => $storyId,
];
echo json_encode($result);
