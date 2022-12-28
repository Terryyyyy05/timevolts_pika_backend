<?php
header('Access-Control-Allow-Origin:*');
header("Content-Type:application/json;charset=utf-8");

require_once("./php_connect_books/connectBooks.php");
require_once("./img_path.php");
const MY_DIR = img_path;

// 判斷有沒有傳圖片
$test = isset($_FILES["itinerary_img"]);

if ($test) {
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
            // 刪除原本圖片
            $checkImgSql = "SELECT `itinerary_img` FROM `itinerary` where `itinerary_id` = '{$_POST["itinerary_id"]}'";
            $products = $pdo->query($checkImgSql);
            $prodRows = $products->fetchAll(PDO::FETCH_ASSOC);
            unlink(MY_DIR . '/' . $prodRows[0]["itinerary_img"]);


            $sql = "update itinerary set itinerary_name = :itinerary_name, 
                                story_id = :story_id,
                                itinerary_price = :itinerary_price,
                                itinerary_people = :itinerary_people,
                                itinerary_start_date = :itinerary_start_date,
                                itinerary_end_date = :itinerary_end_date, 
                                itinerary_signup_date = :itinerary_signup_date,
                                itinerary_signup_deadline = :pro_onshelf_amount,
                                itinerary_status = :itinerary_status,
                                itinerary_img = :itinerary_img
                                
                                where itinerary_id = :itinerary_id";
            //編譯, 執行
            $products = $pdo->prepare($sql);
            $products->bindValue(":itinerary_id", $_POST["itinerary_id"]);
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

            $msg = "更新成功";
        } catch (PDOException $e) {
            $msg = "錯誤行號 : " . $e->getLine() . ", 錯誤訊息 : " . $e->getMessage();
        }
    }
    //輸出結果
    $result = ["msg" => $msg, "pro_img" => $fileName];
    echo json_encode($result);
} else {
    try {
        $sql = "update itinerary set itinerary_name = :itinerary_name, 
        story_id = :story_id,
        itinerary_price = :itinerary_price,
        itinerary_people = :itinerary_people,
        itinerary_start_date = :itinerary_start_date,
        itinerary_end_date = :itinerary_end_date, 
        itinerary_signup_date = :itinerary_signup_date,
        itinerary_signup_deadline = :pro_onshelf_amount,
        itinerary_img = :itinerary_img
        
        where itinerary_id = :itinerary_id";
        //編譯, 執行
        $products = $pdo->prepare($sql);
        $products->bindValue(":itinerary_id", $_POST["itinerary_id"]);
        $products->bindValue(":itinerary_name", $_POST["itinerary_name"]);
        $products->bindValue(":story_id", $_POST["story_id"]);
        $products->bindValue(":itinerary_price", $_POST["itinerary_price"]);
        $products->bindValue(":itinerary_people", $_POST["itinerary_people"]);
        $products->bindValue(":itinerary_start_date", $_POST["itinerary_start_date"]);
        $products->bindValue(":itinerary_end_date", $_POST["itinerary_end_date"]);
        $products->bindValue(":itinerary_signup_date", $_POST["itinerary_signup_date"]);
        $products->bindValue(":itinerary_signup_deadline", $_POST["itinerary_signup_deadline"]);
        // $products->bindValue(":itinerary_status", $_POST["itinerary_status"] ? 1 : 0);
        $products->bindValue(":itinerary_img", $fileName);
        $products->execute();

        $msg = "更新成功";
    } catch (PDOException $e) {
        $msg = "錯誤行號 : " . $e->getLine() . ", 錯誤訊息 : " . $e->getMessage();
    }
    //輸出結果
    $result = ["msg" => $msg];
    echo json_encode($result);
}
