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
    $post->id = isset($_POST['id']) ? htmlspecialchars(strip_tags($_POST['id'])) : die("error");
    
    $result = $post->delete_post();
    if ($result){
        echo json_encode(array('message' => 'post Deleted'));
    }
}
?>