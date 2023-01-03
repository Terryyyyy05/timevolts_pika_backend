<?php
header('Access-Control-Allow-Origin:*');
header("Content-Type:application/json;charset=utf-8");

$json = file_get_contents("php://input");
$datas = json_decode($json, true); //轉為關聯性陣列

require_once("./php_connect_books/connectBooks.php");
$sql = "SELECT story_id 
        FROM story
        ORDER BY story_id DESC 
        LIMIT 1";

$newStory = $pdo->query($sql);
$newStoryRows = $newStory->fetchAll(PDO::FETCH_ASSOC);
echo json_encode($newStoryRows);
