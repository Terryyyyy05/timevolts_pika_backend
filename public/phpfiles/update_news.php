<?php 
header('Access-Control-Allow-Origin:*');
header("Content-Type:application/json;charset=utf-8");

require_once("./php_connect_books/connectBooks.php");
require_once("./img_path.php");
const MY_DIR = img_path;

switch($_FILES["news_img"]["error"] ){
	case UPLOAD_ERR_OK : 
		
		if( file_exists(MY_DIR) == false){
			mkdir(MY_DIR); //make directory
		}
		$from = $_FILES["news_img"]["tmp_name"];

		//$_FILES["image"]["name"]; //smile.gif,  sara.smile.gif, a313feexrer.gif
		$fileExt = pathinfo($_FILES["news_img"]["name"],PATHINFO_EXTENSION); //取得副檔名
		$fileName = uniqid() . ".". $fileExt; //決定檔案名稱, 如a313feexrer.gif
		$to = MY_DIR . "/". $fileName; //決定路徑名稱
		if(copy( $from, $to)){
			$msg = "上傳成功";
		}else{
			$msg = "上傳失敗";
		}
		break;
	case UPLOAD_ERR_INI_SIZE:
	    $msg = "上傳檔案太大,不能超過 ". ini_get("upload_max_filesize") ;	
	    break;
	case UPLOAD_ERR_FORM_SIZE:
	    $msg = "上傳檔案太大,不能超過 ".$_POST["MAX_FILE_SIZE"];			    
	    break;
    case UPLOAD_ERR_PARTIAL:
    	$msg = "上傳檔案不完整";
    	break;
    case UPLOAD_ERR_NO_FILE:
        $msg = "没有上傳檔案";
        break;
    default:
        $msg = "上傳檔案失敗，錯誤代碼: ".$_FILES["error"]."請通知系統開發人員";
}
if( $_FILES["news_img"]["error"] === 0){
  	
	try{
		require_once("./connectBooks.php");

		//sql 指令
    $checkSql = "SELECT `news_id` FROM `news` where `news_id` = '{$_POST["news_id"]}'";
    $products = $pdo->query($checkSql);
    $prodRows = $products->fetchAll(PDO::FETCH_ASSOC);
    
    if($products->rowCount() > 0 ){
      echo json_encode('wrong');
      exit();
    }
    
		$sql = "update news set 
							new_id=:news_id, 			
							news_title=:news_title, 			
							news_img=:news_img, 		
							news_content=:news_content, 
							news_add_date=:news_add_date, 
							news_status=:news_status, 
							news_item_id=:news_item_id, 
							news_category=:news_category, 
							news_hashtag=:news_hashtag
                            where news_id = :news_id";
		//編譯, 執行
		$products = $pdo->prepare($sql);	
		$products->bindValue(":news_id", $_POST["news_id"]);
		$products->bindValue(":news_title", $_POST["news_title"]);
		$products->bindValue(":news_img", $fileName);
		$products->bindValue(":news_content", $_POST["news_content"]);
		$products->bindValue(":news_add_date", $_POST["news_add_date"]);
		$products->bindValue(":news_status", $_POST["news_status"] ? 1:0);
		$products->bindValue(":news_item_id", $_POST["news_item_id"]);
		$products->bindValue(":news_category", $_POST["news_category"]);
		$products->bindValue(":news_hashtag", $_POST["news_hashtag"]);
		$products->execute();	

    
    $msg = "更新成功";
    
	} catch (PDOException $e) {
		$msg = "錯誤行號 : ".$e->getLine().", 錯誤訊息 : ".$e->getMessage();
	}	
}
//輸出結果

$result = ["msg"=>$msg, "news_img"=> $fileName];
echo json_encode($result);

?>