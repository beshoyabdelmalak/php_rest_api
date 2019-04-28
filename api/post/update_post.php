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
    $post->id = isset($_POST['id']) ? htmlspecialchars(strip_tags($_POST['id'])) : die();
    $post->body = isset($_POST['body']) ? htmlspecialchars(strip_tags($_POST['body'])) : die();
    $post->title = isset($_POST['title']) ? htmlspecialchars(strip_tags($_POST['title'])) : die();
    $post->author = isset($_POST['author']) ? htmlspecialchars(strip_tags($_POST['author'])) : die();
    $post->category_id = isset($_POST['category_id']) ? htmlspecialchars(strip_tags($_POST['category_id'])) : die();

    $result = $post->update_post();

    if (!empty($result))
        echo json_encode($result);
    else       
        echo json_encode(array(
            "message" => "could not find this item"
        ));
}
?>