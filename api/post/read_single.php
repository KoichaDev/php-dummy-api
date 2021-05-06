<?php

// REST API Headers to access through HTTP. 
// The astrix is to show it's public API. 
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once('../../config/Database.php');
include_once('../../models/Post.php');

// Instantiate the Database class to connect it
$database = new Database();
$db = $database->connect();

// Instantiate blog post object
$post = new Post($db);

// Get ID
$post->id = isset($_GET['id']) ? $_GET['id'] : die();

// Get Single Post
$post->read_post();

$post_arr = [
    'id'                => $post->id,
    'title'             => $post->title,
    'body'              => $post->body,
    'author'            => $post->author,
    'category_id'       => $post->category_id,
    'category_name'     => $post->category_name
];

// Make JSON 
echo json_encode($post_arr);
