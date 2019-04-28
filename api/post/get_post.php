<?php

ini_set('display_errors', 1);
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

require_once('../../config/Database.php');
require_once('../../model/Post.php');


$database = new Database();
$connection = $database->connect();

$post = new Post($connection);

$post->id = isset($_GET['id']) ? $_GET['id'] : null;
$result = $post->get_post();

if (!empty($result))
    echo json_encode($result);
else
    echo json_encode(array(
        "message" => "could not find this item"
    ));
?>