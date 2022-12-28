<?php
header('Access-Control-Allow-Origin:*');
header("Content-Type:application/json;charset=utf-8");

require_once("./php_connect_books/connectBooks.php");
$sql = "SELECT story_id, story_classification, story_name, story_risk, story_intro, story_specialty, story_spot, story_age, itinerary_number_of_years
        FROM story
        ORDER BY story_id;";
$histories = $pdo->query($sql);
$storyRows = $histories->fetchAll(PDO::FETCH_ASSOC);
echo json_encode($storyRows);
