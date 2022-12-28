<?php
header('Access-Control-Allow-Origin:*');
header("Content-Type:application/json;charset=utf-8");

$json = file_get_contents("php://input");
$datas = json_decode($json, true); //轉為關聯性陣列

require_once("./php_connect_books/connectBooks.php");
$sql = "SELECT *
        FROM story_article
        WHERE story_id = :story_id
        ORDER BY story_article_id;";

$articles = $pdo->prepare($sql);
$articles->bindValue(":story_id", $datas['story_id']); //代入資料
$articles->execute(); //執行之

$articleRows = $articles->fetchAll(PDO::FETCH_ASSOC);
echo json_encode($articleRows);
