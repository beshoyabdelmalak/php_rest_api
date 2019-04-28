<?php

ini_set('display_errors', 1);
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

require_once('../../config/Database.php');
require_once('../../model/Post.php');


$database = new Database();
$connection = $database->connect();

$post = new Post($connection);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $post->body = isset($_POST['body']) ? htmlspecialchars(strip_tags($_POST['body'])) : die();
    $post->title = isset($_POST['title']) ? htmlspecialchars(strip_tags($_POST['title'])) : die();
    $post->author = isset($_POST['author']) ? htmlspecialchars(strip_tags($_POST['author'])) : die();
    $post->category = isset($_POST['category']) ? htmlspecialchars(strip_tags($_POST['category'])) : die();

    $result = $post->create_post();

    if (!empty($result))
        echo json_encode($result);
    else       
        echo json_encode(array(
            "message" => "could not find this item"
        ));
}
?>