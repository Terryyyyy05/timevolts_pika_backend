<?php
header('Access-Control-Allow-Origin:*');
header("Content-Type:application/json;charset=utf-8");

require_once("./php_connect_books/connectBooks.php");
require_once("./img_path.php");
const MY_DIR = img_path;

for ($i = 1; $i < 6; $i++) {
   switch ($_FILES[`story_img_${i}`]["error"]) {
      case UPLOAD_ERR_OK:

         if (file_exists(MY_DIR) == false) {
            mkdir(MY_DIR); //make directory
         }
         $from = $_FILES[`story_img_${i}`]["tmp_name"];

         //$_FILES["image"]["name"]; //smile.gif,  sara.smile.gif, a313feexrer.gif
         $fileExt = pathinfo($_FILES[`story_img_${i}`]["name"], PATHINFO_EXTENSION); //取得副檔名
         ${'fileName' . $i} = uniqid() . "." . $fileExt; //決定檔案名稱, 如a313feexrer.gif
         $to = MY_DIR . "/" . ${'fileName' . $i}; //決定路徑名稱
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
}

switch ($_FILES["story_banner"]["error"]) {
   case UPLOAD_ERR_OK:

      if (file_exists(MY_DIR) == false) {
         mkdir(MY_DIR); //make directory
      }
      $from = $_FILES["story_banner"]["tmp_name"];

      //$_FILES["image"]["name"]; //smile.gif,  sara.smile.gif, a313feexrer.gif
      $fileExt = pathinfo($_FILES["story_banner"]["name"], PATHINFO_EXTENSION); //取得副檔名
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
   $_FILES["story_banner"]["error"] === 0
   // $_FILES["story_img_1"]["error"] === 0 &&
   // $_FILES["story_img_2"]["error"] === 0 &&
   // $_FILES["story_img_3"]["error"] === 0 &&
   // $_FILES["story_img_4"]["error"] === 0 &&
   // $_FILES["story_img_5"]["error"] === 0
) {

   try {

      //sql 指令
      $checkSql = "SELECT story_id
                   FROM story 
                   WHERE story_name = {$_POST["story_name"]}";
      $stories = $pdo->query($checkSql);
      $storyRows = $stories->fetchAll(PDO::FETCH_ASSOC);

      if ($stories->rowCount() > 0) {
         echo json_encode('wrong');
         exit();
      }

      // 新增story
      $sql = "INSERT INTO story (story_id, story_classification, story_name, story_risk, story_specialty, story_spot, story_intro, story_age, itinerary_number_of_years, story_status, story_cover)
              VALUES (null, :story_classification, :story_name, :story_risk, :story_specialty, :story_spot, :story_intro, :story_age, :itinerary_number_of_years, :story_status, :story_cover)";
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
      $stories->bindValue(":story_status", $_POST["story_status"] ? 1 : 0);
      $stories->bindValue(":story_cover", $banner);
      $stories->execute();

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
      $articles = $pdo->prepare($sql2);
      $articles->bindValue(":story_id", $_POST["story_id"]);
      $articles->bindValue(":story_title", $_POST["story_title_02"]);
      $articles->bindValue(":story_img", $fileName2);
      $articles->bindValue(":story_content", $_POST["story_content_02"]);
      $articles->execute();

      $sql3 = "INSERT INTO story_article
              VALUES (3, :story_id, :story_title, :story_img, :story_content)";
      //編譯, 執行
      $articles = $pdo->prepare($sql3);
      $articles->bindValue(":story_id", $_POST["story_id"]);
      $articles->bindValue(":story_title", $_POST["story_title_03"]);
      $articles->bindValue(":story_img", $fileName3);
      $articles->bindValue(":story_content", $_POST["story_content_03"]);
      $articles->execute();

      $sql4 = "INSERT INTO story_article
              VALUES (4, :story_id, :story_title, :story_img, :story_content)";
      //編譯, 執行
      $articles = $pdo->prepare($sql4);
      $articles->bindValue(":story_id", $_POST["story_id"]);
      $articles->bindValue(":story_title", $_POST["story_title_04"]);
      $articles->bindValue(":story_img", $fileName4);
      $articles->bindValue(":story_content", $_POST["story_content_04"]);
      $articles->execute();

      $sql5 = "INSERT INTO story_article
              VALUES (5, :story_id, :story_title, :story_img, :story_content)";
      //編譯, 執行
      $articles = $pdo->prepare($sql5);
      $articles->bindValue(":story_id", $_POST["story_id"]);
      $articles->bindValue(":story_title", $_POST["story_title_05"]);
      $articles->bindValue(":story_img", $fileName5);
      $articles->bindValue(":story_content", $_POST["story_content_05"]);
      $articles->execute();


      $sqlFind = "SELECT story_id FROM story where story_name = {$_POST["story_name"]}";
      $newStory = $pdo->query($sqlFind);
      $newStoryRows = $newStory->fetchAll(PDO::FETCH_ASSOC);
      $msg = "新增成功";
      // if($prodRows->rowCount() == 0 ){
      //   $result = ["pro_id"=>$prodRows];
      // } else {
      //   $msg = "新增失敗";
      // }
   } catch (PDOException $e) {
      $msg = "錯誤行號 : " . $e->getLine() . ", 錯誤訊息 : " . $e->getMessage();
   }
}
//輸出結果
// $result = array_merge($result, ["msg"=>$msg, "pro_img"=> $fileName]);
$result = [
   "msg" => $msg,
   "story_banner" => $banner,
   "story_img_1" => $fileName1,
   "story_img_2" => $fileName2,
   "story_img_3" => $fileName3,
   "story_img_4" => $fileName4,
   "story_img_5" => $fileName5,
   "story_id" => $newStoryRows
];
echo json_encode($result);
