<?php
header('Access-Control-Allow-Origin:*');
// header("Content-Type:application/json;charset=utf-8");

// open the file in a binary mode
$name = "./image/63a95dc816843.jpg";
$fp = fopen($name, 'rb');

// send the right headers
header("Content-Type: image/jpg");
header("Content-Length: " . filesize($name));

// dump the picture and stop the script
fpassthru($fp);
exit;
