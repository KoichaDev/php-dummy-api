<?php

class Post {
    // Database 
    private $connection;
    private $table = 'posts';

    // Posts Properties
    public $id;
    public $category_id;
    public $cateogry_name;
    public $title;
    public $body;
    public $author;
    public $created_at;

    // Constructor with Database
    public function __construct($database) {
        $this->connection = $database;
    }

    // Get Posts
    public function read() {
        // Create query
        $query = 'SELECT 
                    category.name as category_name, 
                    post.id,
                    post.category_id,
                    post.title,
                    post.body,
                    post.author,
                    post.created_at
                  FROM ' . $this->table . ' post
                       LEFT JOIN categories category ON post.category_id = category.id
                  ORDER BY
                    post.created_at DESC';
        // Prepare statements
        $stmt = $this->connection->prepare($query);

        // Execute the query
        $stmt->execute();

        return $stmt;
    }
}
