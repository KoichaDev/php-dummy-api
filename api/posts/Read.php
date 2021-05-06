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

// Blog Posts query
$result = $post->read();

// Get row count;
$num = $result->rowCount();

// Check if there is any post(s)
if ($num > 0) {
    $posts_arr = [];
    $posts_arr['data'] = [];

    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $post_item = [
            'id'            => $id,
            'title'         => $title,
            'body'          => html_entity_decode($body), // This allows to have have HTML on the body
            'author'        => $author,
            'category_id'   => $category_id,
            'category_name' => $category_name,
        ];

        // Push to the data
        array_push($posts_arr['data'], $post_item);
    }

    // Turn it to a json, since it's just PHP array above
    echo json_encode($posts_arr);
} else {
    // No Posts 
    echo json_encode([
        'message'   => 'No Posts found'
    ]);
}
