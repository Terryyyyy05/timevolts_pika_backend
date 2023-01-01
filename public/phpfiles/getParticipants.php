<?php
header('Access-Control-Allow-Origin:*');
header("Content-Type:application/json;charset=utf-8");

$json = file_get_contents("php://input");
$datas = json_decode($json, true); //轉為關聯性陣列

require_once("./php_connect_books/connectBooks.php");
$sql = "SELECT *
        FROM participant_info
        WHERE itinerary_order_id = :itinerary_order_id
        ORDER BY participant_id;";

$participants = $pdo->prepare($sql);
$participants->bindValue(":itinerary_order_id", $datas['itinerary_order_id']); //代入資料
$participants->execute(); //執行之

$participantRows = $participants->fetchAll(PDO::FETCH_ASSOC);
echo json_encode($participantRows);
