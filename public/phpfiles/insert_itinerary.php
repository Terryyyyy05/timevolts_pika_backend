<?php
header('Access-Control-Allow-Origin:*');
header("Content-Type:application/json;charset=utf-8");

// echo json_encode($_POST["pro_status"]);
// echo json_encode($_POST["pro_status"]? 1:0);

// echo json_encode($_FILES["pro_img"]["error"]);
// exit();

require_once("./img_path.php");
const MY_DIR = img_path;

switch ($_FILES["itinerary_img"]["error"]) {
    case UPLOAD_ERR_OK:

        if (file_exists(MY_DIR) == false) {
            mkdir(MY_DIR); //make directory
        }
        $from = $_FILES["itinerary_img"]["tmp_name"];

        //$_FILES["image"]["name"]; //smile.gif,  sara.smile.gif, a313feexrer.gif
        $fileExt = pathinfo($_FILES["itinerary_img"]["name"], PATHINFO_EXTENSION); //取得副檔名
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
if ($_FILES["itinerary_img"]["error"] === 0) {

    try {
        require_once("./php_connect_books/connectBooks.php");

        //sql 指令
        $checkSql = "SELECT `itinerary_id` FROM `itinerary` where `itinerary_name` = '{$_POST["itinerary_name"]}'";
        $products = $pdo->query($checkSql);
        $prodRows = $products->fetchAll(PDO::FETCH_ASSOC);

        if ($products->rowCount() > 0) {
            echo json_encode('wrong');
            exit();
        }

        $sql = "insert into itinerary values (null, :itinerary_name, :story_id, :itinerary_price, :itinerary_people, :itinerary_start_date, :itinerary_end_date, :itinerary_signup_date, :itinerary_signup_deadline, :itinerary_status, :itinerary_img)";
        //編譯, 執行
        $products = $pdo->prepare($sql);
        // $products->bindValue(":itinerary_id", $_POST["itinerary_id"]);
        $products->bindValue(":itinerary_name", $_POST["itinerary_name"]);
        $products->bindValue(":story_id", $_POST["story_id"]);
        $products->bindValue(":itinerary_price", $_POST["itinerary_price"]);
        $products->bindValue(":itinerary_people", $_POST["itinerary_people"]);
        $products->bindValue(":itinerary_start_date", $_POST["itinerary_start_date"]);
        $products->bindValue(":itinerary_end_date", $_POST["itinerary_end_date"]);
        $products->bindValue(":itinerary_signup_date", $_POST["itinerary_signup_date"]);
        $products->bindValue(":itinerary_signup_deadline", $_POST["itinerary_signup_deadline"]);
        $products->bindValue(":itinerary_status", $_POST["itinerary_status"] ? 1 : 0);
        $products->bindValue(":itinerary_img", $fileName);
        $products->execute();

        $sql = "SELECT `itinerary_id` FROM `itinerary` where `itinerary_name` = '{$_POST["itinerary_name"]}'";
        $products = $pdo->query($sql);
        $prodRows = $products->fetchAll(PDO::FETCH_ASSOC);
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
$result = ["msg" => $msg, "itinerary_img" => $fileName, "itinerary_id" => $prodRows];
echo json_encode($result);
