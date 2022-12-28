<?php 
header('Access-Control-Allow-Origin:*');
header("Content-Type:application/json;charset=utf-8");

require_once("./php_connect_books/connectBooks.php");
require_once("./img_path.php");
const MY_DIR = img_path;

switch($_FILES["pro_img"]["error"] ){
	case UPLOAD_ERR_OK : 
		
		if( file_exists(MY_DIR) == false){
			mkdir(MY_DIR); //make directory
		}
		$from = $_FILES["pro_img"]["tmp_name"];

		//$_FILES["image"]["name"]; //smile.gif,  sara.smile.gif, a313feexrer.gif
		$fileExt = pathinfo($_FILES["pro_img"]["name"],PATHINFO_EXTENSION); //取得副檔名
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
if( $_FILES["pro_img"]["error"] === 0){
  	
	try{

		//sql 指令
    $checkSql = "SELECT `pro_id` FROM `product` where `pro_name` = '{$_POST["pro_name"]}'";
    $products = $pdo->query($checkSql);
    $prodRows = $products->fetchAll(PDO::FETCH_ASSOC);
    
    if($products->rowCount() > 0 ){
      echo json_encode('wrong');
      exit();
    }
    
		$sql = "insert into product values (null, :pro_name, :pro_info,:pro_price,:pro_img,:pro_status,:pro_onshelf_date, :pro_class_name,:pro_onshelf_amount,:pro_rest_amount)";
		//編譯, 執行
		$products = $pdo->prepare($sql);	
		// $products->bindValue(":pro_id", $_POST["pro_id"]);
		$products->bindValue(":pro_name", $_POST["pro_name"]);
		$products->bindValue(":pro_class_name", $_POST["pro_class_name"]);
		$products->bindValue(":pro_onshelf_date", $_POST["pro_onshelf_date"]);
		$products->bindValue(":pro_info", $_POST["pro_info"]);
		$products->bindValue(":pro_price", $_POST["pro_price"]);
		$products->bindValue(":pro_onshelf_amount", $_POST["pro_onshelf_amount"]);
		$products->bindValue(":pro_rest_amount", $_POST["pro_rest_amount"]);
		$products->bindValue(":pro_status", $_POST["pro_status"]? 1:0);
		$products->bindValue(":pro_img", $fileName);
		$products->execute();

    $sql = "SELECT `pro_id` FROM `product` where `pro_name` = '{$_POST["pro_name"]}'";
    $products = $pdo->query($sql);
    $prodRows = $products->fetchAll(PDO::FETCH_ASSOC);
    $msg = "新增成功";
    // if($prodRows->rowCount() == 0 ){
    //   $result = ["pro_id"=>$prodRows];
    // } else {
    //   $msg = "新增失敗";
    // }
	} catch (PDOException $e) {
		$msg = "錯誤行號 : ".$e->getLine().", 錯誤訊息 : ".$e->getMessage();
	}	
}
//輸出結果
// $result = array_merge($result, ["msg"=>$msg, "pro_img"=> $fileName]);
$result = ["msg"=>$msg, "pro_img"=> $fileName, "pro_id"=>$prodRows];
echo json_encode($result);

?>