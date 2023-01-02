<?php
header('Access-Control-Allow-Origin:*');
header("Content-Type:application/json;charset=utf-8");

// $json = file_get_contents("php://input");
// $datas = json_decode($json, true); //轉為關聯性陣列
$datas = $_POST;
$action = $datas["action"];
// var_dump($datas);
// exit();

switch ($action) {
    case "nullExpData":
        try {
            require_once("./php_connect_books/connectBooks.php");
            // 已登入可以領取的折價卷
            $sql = " INSERT INTO `coupon` (`coupon_id`, `coupon_discount_number`, `coupon_issue_date`, `coupon_valid_date`, `coupon_exp_date`, `coupon_quantity`, `coupon_given_numbers`, `coupon_pricing_condition`, `coupon_status`) VALUES (null, {$datas["coupon_discount_number"]}, '{$datas["coupon_issue_date"]}', '{$datas["coupon_valid_date"]}', null, {$datas["coupon_quantity"]}, 0 , {$datas["coupon_pricing_condition"]}, {$datas["coupon_status"]});
            ";
            $member = $pdo->prepare($sql);
            // $member->bindValue(":coupon_id", $datas["coupon_id"]);
            // $member->bindValue(":coupon_discount_number", $datas["coupon_discount_number"]);
            // $member->bindValue(":coupon_issue_date", $datas["coupon_issue_date"]);
            // $member->bindValue(":coupon_valid_date", $datas["coupon_valid_date"]);
            // $member->bindValue(":coupon_exp_date", $datas["coupon_exp_date"]);
            // $member->bindValue(":coupon_quantity", $datas["coupon_quantity"]);
            // $member->bindValue(":coupon_given_numbers", $datas["coupon_given_numbers"]);
            // $member->bindValue(":coupon_pricing_condition", $datas["coupon_pricing_condition"]);
            // $member->bindValue(":coupon_status", $datas["coupon_status"]);
            $member->execute();

            $msg = '新增成功';
            // $errMsg = '';
            // exit("111-----" . $msg);
            // $coupons = $pdo->query($sql);
            // $coupon = $coupons->fetchAll(PDO::FETCH_ASSOC);
            // echo json_encode($coupon);
        } catch (PDOException $e) {
            // 處理 PDOException
            // $result = ["msg" => "系統錯誤，請聯繫相關人員"];
            $result = ["msg" => $e->getMessage()];
            echo json_encode($result);
        }
        break;
}
