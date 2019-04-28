<?php

ini_set('display_errors', 1);
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

require_once('../../config/Database.php');
require_once('../../model/Post.php');


$database = new Database();
$connection = $database->connect();

$post = new Post($connection);
$result = array();

$result = $post->get();

if (count($result) > 0){
    $posts = array();
    $posts['data'] = array();

    foreach($result as $post){
        extract($post);
        $post_item = array(
            'id' => $id,
            'title' => $title,
            'category_id' => $category_id,
            'category' => $name,
            'body' => html_entity_decode($body),
            'author' => $author,
            'created_at' => $created_at
        );
        array_push($posts['data'] , $post_item);
    }
    echo json_encode($posts);
}
else{
    echo json_encode(array(
        'message' => 'no posts found'
    ));
}
?>