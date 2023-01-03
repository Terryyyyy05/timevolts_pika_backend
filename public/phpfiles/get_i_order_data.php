<?php
header('Access-Control-Allow-Origin:*');
header("Content-Type:application/json;charset=utf-8");

require_once("./php_connect_books/connectBooks.php");
$sql = "SELECT * FROM itinerary_order";
$order = $pdo->query($sql);
$orderRows = $order->fetchAll(PDO::FETCH_ASSOC);
echo json_encode($orderRows);
